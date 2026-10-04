import sharp from 'sharp';
import { createHash } from 'node:crypto';
import { readFile, writeFile, mkdir, rename } from 'node:fs/promises';

const directory = 'public/images/identity';
await mkdir(directory, { recursive: true });
const template = await readFile('resources/views/welcome.blade.php', 'utf8');
const sources = [
    ...[...template.matchAll(/'handle'\s*=>\s*'([^']+)'/g)].map(([, handle]) => ({ key: `people/${handle}`, url: `https://github.com/${handle}.png?size=96` })),
    { key: 'organizations/hyva', url: 'https://www.hyva.io/media/favicon/stores/1/Favicon.png' },
    { key: 'organizations/vendic', url: 'https://vendic.nl/img/logo.svg' },
    { key: 'organizations/zero1', url: 'https://www.zero1.co.uk/static/version1769734989/frontend/z1/hyva/en_GB/images/logo.svg' },
];
const manifest = {};
const reports = [];
let index = 0;
await Promise.all(Array.from({ length: 4 }, async () => {
    while (index < sources.length) {
        const { key, url } = sources[index++];
        const response = await fetch(url, { signal: AbortSignal.timeout(20000) });
        if (!response.ok) throw new Error(`Cannot download ${url}: ${response.status}`);
        const original = Buffer.from(await response.arrayBuffer());
        let data = original;
        let format = 'svg';
        if (!response.headers.get('content-type')?.includes('svg')) {
            const metadata = await sharp(original).metadata();
            format = metadata.format === 'jpeg' ? 'jpg' : metadata.format;
            const lossless = await sharp(original).webp({ lossless: true, effort: 6 }).toBuffer();
            if (lossless.length < original.length) { data = lossless; format = 'webp'; }
        }
        const hash = createHash('sha256').update(data).digest('hex').slice(0, 12);
        const filename = `${key.replaceAll('/', '-')}-${hash}.${format}`;
        await writeFile(`${directory}/${filename}`, data);
        manifest[`images/identity/${key}`] = `/images/identity/${filename}`;
        reports.push({ key, source: url, resolvedSource: response.url, originalBytes: original.length, bytes: data.length, lossless: true });
        console.log(`${key}: ${original.length} → ${data.length} bytes, unchanged pixels`);
    }
}));
await writeFile(`${directory}/manifest.json.tmp`, JSON.stringify(Object.fromEntries(Object.entries(manifest).sort(([a], [b]) => a.localeCompare(b))), null, 2) + '\n');
await rename(`${directory}/manifest.json.tmp`, `${directory}/manifest.json`);
await writeFile(`${directory}/report.json`, JSON.stringify(reports.sort((a, b) => a.key.localeCompare(b.key)), null, 2) + '\n');
console.log('Identity images cached locally; run npm run build to update asset URLs.');
