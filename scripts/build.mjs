import { build, transform } from 'esbuild';
import { createHash } from 'node:crypto';
import { spawnSync } from 'node:child_process';
import { readFile, writeFile, mkdtemp, rm, rename } from 'node:fs/promises';
import { watch } from 'node:fs';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { createRequire } from 'node:module';
import { brotliCompressSync, gzipSync, constants } from 'node:zlib';

const require = createRequire(import.meta.url);
const hash = data => createHash('sha256').update(data).digest('hex').slice(0, 12);

async function compile() {
    const temporary = await mkdtemp(join(tmpdir(), 'magewire-css-'));
    try {
        const result = spawnSync(process.execPath, [require.resolve('tailwindcss/lib/cli.js'), '-i', 'resources/css/app.css', '-o', join(temporary, 'tailwind.css'), '--minify'], { stdio: 'inherit' });
        if (result.status !== 0) throw new Error('Tailwind compilation failed');

        const manifest = JSON.parse(await readFile('public/images/identity/manifest.json', 'utf8'));
        let fonts = await readFile('resources/css/fonts.css', 'utf8');
        for (const match of fonts.matchAll(/\/fonts\/([^')]+\.woff2)/g)) {
            const path = `fonts/${match[1]}`;
            const url = `/${path}?v=${hash(await readFile(`public/${path}`))}`;
            manifest[path] = url;
            fonts = fonts.replaceAll(`/${path}`, url);
        }

        const sources = await Promise.all([
            readFile(join(temporary, 'tailwind.css'), 'utf8'),
            ...['header', 'hero', 'footer', 'painted-ui', 'pages'].map(name => readFile(`public/css/${name}.css`, 'utf8')),
        ]);
        let stylesheet = [fonts, ...sources].join('\n');
        for (const path of new Set([...stylesheet.matchAll(/\/images\/ui\/[^')]+\.svg/g)].map(match => match[0]))) {
            stylesheet = stylesheet.replaceAll(path, `${path}?v=${hash(await readFile(`public${path}`))}`);
        }
        const css = (await transform(stylesheet, { loader: 'css', minify: true, target: ['chrome100', 'firefox100', 'safari15.4'], legalComments: 'none' })).code;
        const javascript = await build({ entryPoints: ['resources/js/app.js'], bundle: true, minify: true, write: false, format: 'iife', target: ['chrome100', 'firefox100', 'safari15.4'], legalComments: 'none', define: { 'process.env.NODE_ENV': '"production"' } });

        for (const [path, data] of [['css/app.css', css], ['js/app.js', javascript.outputFiles[0].contents]]) {
            await writeFile(`public/${path}`, data);
            await writeFile(`public/${path}.gz`, gzipSync(data, { level: 9 }));
            await writeFile(`public/${path}.br`, brotliCompressSync(data, { params: { [constants.BROTLI_PARAM_QUALITY]: 11 } }));
            manifest[path] = `/${path}?v=${hash(data)}`;
        }
        await writeFile('public/asset-manifest.json.tmp', JSON.stringify(manifest, null, 2) + '\n');
        await rename('public/asset-manifest.json.tmp', 'public/asset-manifest.json');
        console.log('Built versioned CSS and JavaScript with gzip and Brotli copies.');
    } finally {
        await rm(temporary, { recursive: true, force: true });
    }
}

await compile();
if (process.argv.includes('--watch')) {
    let timer;
    let pending = false;
    let running = false;
    const rebuild = async () => {
        if (running) { pending = true; return; }
        running = true;
        try { await compile(); } catch (error) { console.error(error); }
        running = false;
        if (pending) { pending = false; await rebuild(); }
    };
    const schedule = () => { clearTimeout(timer); timer = setTimeout(rebuild, 120); };
    watch('resources', { recursive: true }, schedule);
    watch('public/css', (event, filename) => { if (filename && !filename.startsWith('app.css')) schedule(); });
    watch('public/js/painted-scenes.js', schedule);
    watch('tailwind.config.js', schedule);
    console.log('Watching templates, scripts, and styles.');
}
