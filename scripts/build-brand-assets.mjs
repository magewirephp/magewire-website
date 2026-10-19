import sharp from 'sharp';
import { readFile, writeFile, mkdir, stat } from 'node:fs/promises';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { deflateRawSync, inflateRawSync } from 'node:zlib';
import assert from 'node:assert/strict';

const root = fileURLToPath(new URL('../', import.meta.url));
const source = resolve(root, 'resources/brand/magewire');
const output = resolve(root, 'public/brand/magewire');
const manifestName = 'assets-manifest.json';
const archiveName = 'magewire-brand-assets.zip';
const siteIcons = {
    'favicon.svg': 'icons/favicon.svg',
    'favicon.ico': 'icons/favicon.ico',
    'apple-touch-icon.png': 'icons/apple-touch-icon.png',
};
sharp.concurrency(2);

// A small, deterministic ZIP writer keeps the asset build dependency-free apart
// from the image renderer already used by this repository.
const crcTable = Array.from({ length: 256 }, (_, value) => {
    for (let bit = 0; bit < 8; bit++) value = value & 1 ? 0xedb88320 ^ (value >>> 1) : value >>> 1;
    return value >>> 0;
});
function crc32(buffer) {
    let crc = 0xffffffff;
    for (const byte of buffer) crc = crcTable[(crc ^ byte) & 0xff] ^ (crc >>> 8);
    return (crc ^ 0xffffffff) >>> 0;
}

function zip(entries) {
    const local = [];
    const central = [];
    let offset = 0;
    for (const [filename, data] of entries) {
        const name = Buffer.from(filename);
        const compressed = deflateRawSync(data, { level: 9 });
        const header = Buffer.alloc(30);
        header.writeUInt32LE(0x04034b50);
        header.writeUInt16LE(20, 4);
        header.writeUInt16LE(0x800, 6);
        header.writeUInt16LE(8, 8);
        header.writeUInt16LE(0x5c21, 12); // 2026-01-01; stable across rebuilds.
        header.writeUInt32LE(crc32(data), 14);
        header.writeUInt32LE(compressed.length, 18);
        header.writeUInt32LE(data.length, 22);
        header.writeUInt16LE(name.length, 26);
        const directory = Buffer.alloc(46);
        directory.writeUInt32LE(0x02014b50);
        directory.writeUInt16LE(20, 4);
        directory.writeUInt16LE(20, 6);
        header.copy(directory, 8, 6, 28);
        directory.writeUInt32LE(offset, 42);
        central.push(directory, name);
        local.push(header, name, compressed);
        offset += header.length + name.length + compressed.length;
    }
    const directory = Buffer.concat(central);
    const end = Buffer.alloc(22);
    end.writeUInt32LE(0x06054b50);
    end.writeUInt16LE(entries.length, 8);
    end.writeUInt16LE(entries.length, 10);
    end.writeUInt32LE(directory.length, 12);
    end.writeUInt32LE(offset, 16);
    return Buffer.concat([...local, directory, end]);
}

async function verify() {
    const manifest = JSON.parse(await readFile(resolve(output, manifestName), 'utf8'));
    for (const filename of manifest.files) {
        assert(!filename.startsWith('/') && !filename.split('/').includes('..'), `Unsafe path: ${filename}`);
        assert((await stat(resolve(output, filename))).size > 0, `Empty file: ${filename}`);
    }
    for (const [filename, original] of Object.entries(siteIcons)) {
        assert((await readFile(resolve(root, 'public', filename))).equals(await readFile(resolve(output, original))), `Website icon is out of date: ${filename}`);
    }
    for (const asset of manifest.assets) {
        const svg = await readFile(resolve(output, asset.svg), 'utf8');
        assert(!/<(?:text|image|script|mask|filter)\b/i.test(svg), `Non-portable SVG: ${asset.svg}`);
        assert(!/\b(?:href|src)\s*=/i.test(svg), `External resource in ${asset.svg}`);
        for (const raster of [...asset.png, asset.webp]) {
            const metadata = await sharp(resolve(output, raster.path)).metadata();
            assert.equal(metadata.width, raster.width, raster.path);
            assert.equal(metadata.height, raster.height, raster.path);
            if (asset.transparent) assert(metadata.hasAlpha, `Missing transparency: ${raster.path}`);
        }
    }
    // Verify PNG frames inside the ICO, not just the file extension.
    const ico = await readFile(resolve(output, 'icons/favicon.ico'));
    assert.equal(ico.readUInt16LE(2), 1);
    assert.equal(ico.readUInt16LE(4), 4);
    for (let index = 0; index < 4; index++) {
        const entry = 6 + index * 16;
        const start = ico.readUInt32LE(entry + 12);
        const bytes = ico.readUInt32LE(entry + 8);
        const metadata = await sharp(ico.subarray(start, start + bytes)).metadata();
        assert.equal(metadata.width, ico[entry]);
        assert.equal(metadata.height, ico[entry + 1]);
    }
    // Check every ZIP member against its on-disk counterpart and CRC.
    const archive = await readFile(resolve(output, archiveName));
    let cursor = 0;
    let count = 0;
    while (archive.readUInt32LE(cursor) === 0x04034b50) {
        const nameLength = archive.readUInt16LE(cursor + 26);
        const extraLength = archive.readUInt16LE(cursor + 28);
        const compressedLength = archive.readUInt32LE(cursor + 18);
        const name = archive.toString('utf8', cursor + 30, cursor + 30 + nameLength);
        const start = cursor + 30 + nameLength + extraLength;
        const data = inflateRawSync(archive.subarray(start, start + compressedLength));
        assert.equal(crc32(data), archive.readUInt32LE(cursor + 14), name);
        assert(data.equals(await readFile(resolve(output, name))), `Stale ZIP member: ${name}`);
        count++;
        cursor = start + compressedLength;
    }
    assert.equal(count, manifest.files.length - 1, 'Archive must contain the complete pack, excluding itself');
    console.log(`Verified ${manifest.assets.length} variants and ${manifest.files.length} files, including PNG/WebP dimensions, transparency, ICO frames and ZIP contents.`);
}

if (process.argv.includes('--check')) {
    await verify();
    process.exit(0);
}

const palette = JSON.parse(await readFile(resolve(source, 'palette.json'), 'utf8'));
const characterSource = await readFile(resolve(source, 'character.svg'), 'utf8');
const wordmarkSource = await readFile(resolve(source, 'wordmark.svg'), 'utf8');
const inner = svg => svg.replace(/^[\s\S]*?<svg\b[^>]*>/, '').replace(/<\/svg>\s*$/, '').replace(/<title\b[^>]*>[\s\S]*?<\/title>/g, '').replace(/\s+id="[^"]*"/g, '').trim();
const [wordWidth, wordHeight] = wordmarkSource.match(/viewBox="0 0 ([\d.]+) ([\d.]+)"/).slice(1).map(Number);
const wordmark = inner(wordmarkSource);
const body = characterSource.match(/<path id="body"[^>]*\bd="([^"]+)"/)[1];
const group = name => characterSource.match(new RegExp(`<g id="${name}"[^>]*>([\\s\\S]*?)<\\/g>`))[1];
const colorCharacter = inner(characterSource).replace(/#(?:ff4f00|141b2a|ffffff)\b/gi, color => ({
    '#ff4f00': palette.orange,
    '#141b2a': palette.pupil,
    '#ffffff': palette.white,
})[color.toLowerCase()]);
function ovalPaths(name) {
    return [...group(name).matchAll(/<(?:ellipse|circle)\b([^>]*)\/>/g)].map(([, attributes]) => {
        const values = Object.fromEntries([...attributes.matchAll(/\b(cx|cy|rx|ry|r)="([^"]+)"/g)].map(([, key, value]) => [key, Number(value)]));
        const { cx, cy } = values;
        const rx = values.rx ?? values.r;
        const ry = values.ry ?? values.r;
        return `M${cx - rx} ${cy} A${rx} ${ry} 0 1 0 ${cx + rx} ${cy} A${rx} ${ry} 0 1 0 ${cx - rx} ${cy} Z`;
    }).join(' ');
}
const monochromePath = [body, ovalPaths('eyes'), ovalPaths('pupils'), ovalPaths('highlights')].join(' ');
const escaped = text => String(text).replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;');
const decimal = value => Number(value.toFixed(3));
const files = new Map();
const assets = [];

async function save(filename, data) {
    const buffer = Buffer.isBuffer(data) ? data : Buffer.from(data);
    const path = resolve(output, filename);
    await mkdir(dirname(path), { recursive: true });
    await writeFile(path, buffer);
    files.set(filename, buffer);
}

function character(mode = 'color') {
    if (mode === 'color') return colorCharacter;
    const fill = mode === 'white' ? palette.white : palette.ink;
    return `<path fill="${fill}" fill-rule="evenodd" d="${monochromePath}"/>`;
}

function lettering(fill) {
    return wordmark.replaceAll('#111111', fill);
}

function svg(width, height, content, title) {
    return `<svg xmlns="http://www.w3.org/2000/svg" width="${decimal(width)}" height="${decimal(height)}" viewBox="0 0 ${decimal(width)} ${decimal(height)}" role="img" aria-label="${escaped(title)}">\n${content}\n</svg>\n`;
}

function placed(content, x, y, scale) {
    return `<g transform="translate(${decimal(x)} ${decimal(y)}) scale(${decimal(scale)})">${content}</g>`;
}

async function asset(id, title, kind, theme, width, height, content, sizes, transparent = true) {
    const data = svg(width, height, content, title);
    const entry = { id, title, kind, theme, width: decimal(width), height: decimal(height), transparent, svg: `svg/${id}.svg`, png: [] };
    await save(entry.svg, data);
    for (const target of sizes) {
        const buffer = await sharp(Buffer.from(data)).resize({ width: target }).png({ compressionLevel: 9 }).toBuffer();
        const metadata = await sharp(buffer).metadata();
        const path = `png/${id}-${target}.png`;
        await save(path, buffer);
        entry.png.push({ width: metadata.width, height: metadata.height, path });
    }
    const webWidth = sizes.includes(1024) ? 1024 : sizes.at(-1);
    const buffer = await sharp(Buffer.from(data)).resize({ width: webWidth }).webp({ lossless: true, effort: 6 }).toBuffer();
    const metadata = await sharp(buffer).metadata();
    entry.webp = { width: metadata.width, height: metadata.height, path: `webp/${id}-${webWidth}.webp` };
    await save(entry.webp.path, buffer);
    assets.push(entry);
    return { ...entry, content };
}

const previews = [];
for (const [mode, title, theme] of [['color', 'Orange character', 'light'], ['black', 'Black character', 'light'], ['white', 'White character', 'dark']]) {
    const id = `character-${mode}`;
    const entry = await asset(id, title, 'character', theme, 512, 560, character(mode), [64, 128, 256, 512, 1024, 2048]);
    if (mode !== 'black') previews.push(entry);
}

for (const [mode, fill, theme] of [['black', palette.ink, 'light'], ['white', palette.white, 'dark'], ['orange', palette.orange, 'light']]) {
    await asset(`wordmark-${mode}`, `${mode[0].toUpperCase() + mode.slice(1)} wordmark`, 'wordmark', theme, wordWidth, wordHeight, lettering(fill), [512, 1024, 2048]);
}

for (const [mode, characterMode, fill, theme] of [
    ['color', 'color', palette.ink, 'light'],
    ['reverse', 'color', palette.white, 'dark'],
    ['black', 'black', palette.ink, 'light'],
    ['white', 'white', palette.white, 'dark'],
]) {
    const horizontalId = `horizontal-${mode}`;
    const textScale = 104 / wordHeight;
    const horizontalWidth = 232 + wordWidth * textScale + 32;
    const horizontalContent = placed(character(characterMode), 24, 24, 176 / 560) + placed(lettering(fill), 232, 60, textScale);
    const horizontal = await asset(horizontalId, `Horizontal logo · ${mode}`, 'horizontal', theme, horizontalWidth, 224, horizontalContent, [512, 1024, 2048]);
    if (mode === 'color' || mode === 'reverse') previews.push(horizontal);
    const stackedId = `stacked-${mode}`;
    const stackScale = 720 / wordWidth;
    const stackedHeight = 588 + wordHeight * stackScale;
    const stackedContent = placed(character(characterMode), (800 - 512 * (500 / 560)) / 2, 24, 500 / 560) + placed(lettering(fill), 40, 564, stackScale);
    const stacked = await asset(stackedId, `Stacked logo · ${mode}`, 'stacked', theme, 800, stackedHeight, stackedContent, [512, 1024, 2048]);
    if (mode === 'color') previews.push(stacked);
}

function squareCharacter(background, mode, markHeight = 400) {
    const scale = markHeight / 560;
    return `<rect width="512" height="512" fill="${background}"/>` + placed(character(mode), (512 - 512 * scale) / 2, (512 - markHeight) / 2, scale);
}

for (const [mode, background, characterMode, theme] of [['light', palette.white, 'color', 'light'], ['dark', palette.dark, 'color', 'dark'], ['orange', palette.orange, 'white', 'light']]) {
    const id = `avatar-${mode}`;
    await asset(id, `${mode[0].toUpperCase() + mode.slice(1)} avatar`, 'avatar', theme, 512, 512, squareCharacter(background, characterMode), [128, 256, 512, 1024], false);
}

for (const [mode, background, fill, theme] of [['light', palette.paper, palette.ink, 'light'], ['dark', palette.dark, palette.white, 'dark']]) {
    const id = `social-${mode}`;
    const scale = 540 / wordWidth;
    const content = `<rect width="1200" height="630" fill="${background}"/>` + placed(character('color'), 64, 65, 500 / 560) + placed(lettering(fill), 592, (630 - wordHeight * scale) / 2, scale);
    const entry = await asset(id, `${mode[0].toUpperCase() + mode.slice(1)} social card`, 'social', theme, 1200, 630, content, [1200], false);
    if (mode === 'dark') previews.push(entry);
}

// Install-ready icon files live here until the website opts into the new brand.
const iconContent = placed(character('color'), (512 - 512 * (500 / 560)) / 2, 6, 500 / 560);
const favicon = svg(512, 512, iconContent, 'Magewire');
await save('icons/favicon.svg', favicon);
const frames = [];
for (const size of [16, 32, 48, 64]) {
    const data = await sharp(Buffer.from(favicon)).resize(size, size).png().toBuffer();
    await save(`icons/favicon-${size}x${size}.png`, data);
    frames.push({ size, data });
}
const icoHeader = Buffer.alloc(6 + frames.length * 16);
icoHeader.writeUInt16LE(1, 2);
icoHeader.writeUInt16LE(frames.length, 4);
let icoOffset = icoHeader.length;
frames.forEach(({ size, data }, index) => {
    const entry = 6 + index * 16;
    icoHeader[entry] = size;
    icoHeader[entry + 1] = size;
    icoHeader.writeUInt16LE(1, entry + 4);
    icoHeader.writeUInt16LE(32, entry + 6);
    icoHeader.writeUInt32LE(data.length, entry + 8);
    icoHeader.writeUInt32LE(icoOffset, entry + 12);
    icoOffset += data.length;
});
await save('icons/favicon.ico', Buffer.concat([icoHeader, ...frames.map(frame => frame.data)]));
for (const [filename, size, markHeight] of [['apple-touch-icon.png', 180, 400], ['android-chrome-192x192.png', 192, 400], ['android-chrome-512x512.png', 512, 400], ['maskable-icon-512x512.png', 512, 300]]) {
    const data = svg(512, 512, squareCharacter(palette.white, 'color', markHeight), 'Magewire');
    await save(`icons/${filename}`, await sharp(Buffer.from(data)).resize(size, size).png().toBuffer());
}
await save('icons/site.webmanifest', JSON.stringify({ name: 'Magewire', short_name: 'Magewire', theme_color: palette.orange, background_color: palette.white, icons: [
    { src: 'android-chrome-192x192.png', sizes: '192x192', type: 'image/png', purpose: 'any' },
    { src: 'android-chrome-512x512.png', sizes: '512x512', type: 'image/png', purpose: 'any' },
    { src: 'maskable-icon-512x512.png', sizes: '512x512', type: 'image/png', purpose: 'maskable' },
] }, null, 2) + '\n');
await save('OFL-Outfit.txt', await readFile(resolve(source, 'fonts/OFL.txt')));
await save('README.md', await readFile(resolve(source, 'USAGE.md')));

// Build a portable contact sheet from the same SVG geometry as the exports.
const order = ['character-color', 'horizontal-color', 'stacked-color', 'character-white', 'horizontal-reverse', 'social-dark'];
const previewAssets = order.map(id => previews.find(item => item.id === id));
const panelWidth = (1600 - 96 - 48) / 3;
let sheet = `<rect width="1600" height="1200" fill="${palette.paper}"/><text x="48" y="74" fill="${palette.ink}" font-family="sans-serif" font-size="42" font-weight="700">Magewire brand assets</text><text x="48" y="118" fill="#5f6470" font-family="sans-serif" font-size="22">One character. Down-right gaze. Ready for every background.</text>`;
previewAssets.forEach((item, index) => {
    const x = 48 + (index % 3) * (panelWidth + 24);
    const y = 160 + Math.floor(index / 3) * 420;
    const dark = item.theme === 'dark';
    const width = panelWidth - 56;
    const height = 290;
    const scale = Math.min(width / item.width, height / item.height);
    sheet += `<rect x="${x}" y="${y}" width="${panelWidth}" height="396" rx="20" fill="${dark ? palette.dark : palette.white}"/><text x="${x + 24}" y="${y + 36}" fill="${dark ? palette.white : palette.ink}" font-family="sans-serif" font-size="18">${escaped(item.title)}</text>`;
    sheet += placed(item.content, x + (panelWidth - item.width * scale) / 2, y + 76 + (height - item.height * scale) / 2, scale);
});
sheet += `<text x="48" y="1064" fill="${palette.ink}" font-family="sans-serif" font-size="20">Small-size checks</text>`;
let sampleX = 48;
for (const height of [16, 24, 32, 48, 64, 96]) {
    sheet += placed(character('color'), sampleX, 1090, height / 560);
    sheet += `<text x="${sampleX + height + 8}" y="1110" fill="#5f6470" font-family="sans-serif" font-size="16">${height}px</text>`;
    sampleX += height + 100;
}
await save('preview.png', await sharp(Buffer.from(svg(1600, 1200, sheet, 'Magewire logo variants'))).png({ compressionLevel: 9 }).toBuffer());

const sections = [ ['character', 'Character'], ['horizontal', 'Horizontal logos'], ['stacked', 'Stacked logos'], ['wordmark', 'Wordmarks'], ['avatar', 'Avatars'], ['social', 'Social cards'] ];
const cards = kind => assets.filter(item => item.kind === kind).map(item => {
    const png = item.png.find(image => image.width === 1024) ?? item.png.at(-1);
    return `<article class="card"><div class="stage ${item.theme}" data-kind="${kind}"><img src="${item.svg}" width="${item.width}" height="${item.height}" alt="${escaped(item.title)}" loading="lazy"></div><div class="card-body"><h3>${escaped(item.title)}</h3><div class="downloads"><a href="${item.svg}" download>SVG</a><a href="${png.path}" download>PNG ${png.width}px</a><a href="${item.webp.path}" download>WebP</a></div><details><summary>More PNG sizes</summary><div class="sizes">${item.png.map(image => `<a href="${image.path}" download>${image.width}px</a>`).join('')}</div></details></div></article>`;
}).join('\n');
const gallery = `<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="color-scheme" content="light"><meta name="description" content="Download the Magewire character, logos, avatars and web icons."><title>Magewire brand assets</title><link rel="icon" href="icons/favicon.svg" type="image/svg+xml"><link rel="stylesheet" href="gallery.css"></head>
<body><a class="skip" href="#main">Skip to assets</a><header class="site-header"><a href="#main" aria-label="Magewire brand assets"><img src="svg/horizontal-color.svg" width="240" height="72" alt="Magewire"></a><a class="button" href="${archiveName}" download>Download all assets <span aria-hidden="true">↓</span></a></header>
<main id="main"><section class="intro"><p class="eyebrow">Magewire / Brand assets</p><h1>A little component.<br>A lot of character.</h1><p class="lead">The Magewire character, logos and icons, ready for light and dark backgrounds.</p><div class="intro-links"><a href="README.md">Usage guide</a><a href="preview.png" download>Download the overview</a></div></section>
<nav aria-label="Asset categories">${sections.map(([kind, title]) => `<a href="#${kind}">${title}</a>`).join('')}<a href="#icons">Web icons</a></nav>
${sections.map(([kind, title]) => `<section class="asset-section" id="${kind}"><div class="section-heading"><h2>${title}</h2><p>${kind === 'character' ? 'The orange original and transparent monochrome versions.' : kind === 'horizontal' ? 'A compact layout for headers and navigation.' : kind === 'stacked' ? 'The character above the wordmark, with room to breathe.' : kind === 'wordmark' ? 'Outlined lettering. No font installation needed.' : kind === 'avatar' ? 'Square backgrounds for profiles and community spaces.' : '1200 × 630 images for link previews and announcements.'}</p></div><div class="grid">${cards(kind)}</div></section>`).join('\n')}
<section id="icons" class="asset-section"><div class="section-heading"><h2>Web icons</h2><p>Favicons, Apple touch icons and Android icons, including a maskable version.</p></div><div class="icon-card"><div class="icon-samples">${[16, 32, 48, 64].map(size => `<figure><img src="icons/favicon-${size}x${size}.png" width="${size}" height="${size}" alt="Magewire icon at ${size} pixels"><figcaption>${size}px</figcaption></figure>`).join('')}</div><div class="downloads"><a href="icons/favicon.svg" download>SVG favicon</a><a href="icons/favicon.ico" download>ICO favicon</a><a href="icons/apple-touch-icon.png" download>Apple touch icon</a><a href="icons/site.webmanifest" download>Web manifest</a></div></div></section>
<section class="colors" aria-label="Brand colors">${[['Orange', palette.orange], ['Ink', palette.ink], ['Eye', palette.pupil], ['White', palette.white]].map(([name, color]) => `<div class="swatch"><span style="background:${color}"></span><strong>${name}</strong><code>${color.toUpperCase()}</code></div>`).join('')}</section></main>
<footer><span>Magewire</span><p>Keep the shape, proportions and down-right gaze consistent.</p><a href="OFL-Outfit.txt">Wordmark font license</a></footer></body></html>\n`;
await save('index.html', gallery);
await save('gallery.css', await readFile(resolve(source, 'gallery.css')));

const manifest = {
    schemaVersion: 1,
    name: 'Magewire character brand assets',
    gaze: 'down-right, including both pupil highlights',
    colors: palette,
    archive: archiveName,
    assets,
    files: [...files.keys(), manifestName, archiveName].sort(),
};
await save(manifestName, JSON.stringify(manifest, null, 2) + '\n');
await save(archiveName, zip([...files.entries()].sort(([a], [b]) => a.localeCompare(b))));
for (const [filename, original] of Object.entries(siteIcons)) {
    await writeFile(resolve(root, 'public', filename), files.get(original));
}
await verify();
console.log(`Built the Magewire pack at public/brand/magewire/ (${(files.get(archiveName).length / 1024).toFixed(0)} KiB ZIP).`);
