import sharp from 'sharp';
import { readFile, writeFile, mkdir, rename } from 'node:fs/promises';
import { createHash } from 'node:crypto';

sharp.concurrency(2);
const hash = data => createHash('sha256').update(data).digest('hex').slice(0, 12);
const outputDirectory = 'public/images/responsive';
await mkdir(outputDirectory, { recursive: true });

const specifications = [
    ...['mage-os', 'magento-open-source', 'adobe-commerce', 'backend', 'hyva', 'breeze', 'luma'].map(name => [`compatibility/${name}`, [384, 576, 768]]),
    ...['install-toolkit', 'familiar-wheel', 'compiler-workshop', 'fragment-boundary'].map(name => [`sections/${name}`, [360, 576, 720, 960]]),
    ...['checkout', 'cms'].map(name => [`hyva/${name}`, [512, 1024, 1536]]),
    ['tools/bricklayer', [768, 1200]],
    ['header/sky', [1440, 2172]],
    ['header/cloud', [512, 1024]],
    ['header/canopy', [250, 420, 500]],
    ['footer/landscape', [1440, 2172]],
    ['footer/cloud', [512, 1024]],
    ['footer/foliage', [300, 360, 480, 600]],
];

const manifest = {};
const reports = [];
const srcset = variants => variants.map(item => `${item.url} ${item.width}w`).join(', ');

async function save(name, width, format, data) {
    const filename = `${name.replaceAll('/', '-')}-${width}-${hash(data)}.${format}`;
    await writeFile(`${outputDirectory}/${filename}`, data);
    return { width, url: `/images/responsive/${filename}`, bytes: data.length };
}

async function generate([name, widths]) {
    const source = `/images/${name}.webp`;
    const input = await readFile(`public${source}`);
    const metadata = await sharp(input).metadata();
    if (widths.at(-1) !== metadata.width) throw new Error(`Update ${name}'s image sizes to include its native width of ${metadata.width}px.`);
    const fallback = `${source}?v=${hash(input)}`;
    const webp = [];
    for (const width of widths) {
        if (width === metadata.width) {
            webp.push({ width, url: fallback, bytes: input.length });
            continue;
        }
        const data = await sharp(input).resize({ width, withoutEnlargement: true }).webp({ quality: 90, alphaQuality: 100, effort: 6, smartSubsample: true }).toBuffer();
        if (data.length < input.length) webp.push(await save(name, width, 'webp', data));
    }

    // Keep the original WebP whenever high-quality AVIF would cost more bytes.
    const avif = [];
    const fullAvif = await sharp(input).avif({ quality: 85, effort: 7, chromaSubsampling: '4:4:4' }).toBuffer();
    if (fullAvif.length < input.length) {
        const candidates = [];
        for (const variant of webp) {
            const data = variant.width === metadata.width ? fullAvif : await sharp(input).resize({ width: variant.width }).avif({ quality: 85, effort: 7, chromaSubsampling: '4:4:4' }).toBuffer();
            candidates.push({ width: variant.width, data });
        }
        if (candidates.every((candidate, index) => candidate.data.length < webp[index].bytes)) {
            for (const candidate of candidates) avif.push(await save(name, candidate.width, 'avif', candidate.data));
        }
    }

    manifest[source] = { fallback, width: metadata.width, height: metadata.height, webp: srcset(webp), avif: srcset(avif) };
    reports.push({ source, originalBytes: input.length, webp, avif });
    console.log(`${source}: ${webp.length} WebP sizes${avif.length ? `, ${avif.length} AVIF sizes` : ', original format retained'}`);
}

let index = 0;
await Promise.all(Array.from({ length: 2 }, async () => {
    while (index < specifications.length) await generate(specifications[index++]);
}));

const sorted = Object.fromEntries(Object.entries(manifest).sort(([a], [b]) => a.localeCompare(b)));
await writeFile('public/images/responsive/manifest.json.tmp', JSON.stringify(sorted, null, 2) + '\n');
await rename('public/images/responsive/manifest.json.tmp', 'public/images/responsive/manifest.json');
await writeFile('public/images/responsive/report.json', JSON.stringify(reports.sort((a, b) => a.source.localeCompare(b.source)), null, 2) + '\n');
console.log('Built responsive images; original WebP files are unchanged.');
