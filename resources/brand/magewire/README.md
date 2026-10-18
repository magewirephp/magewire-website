# Magewire brand source

- `character.svg` is the editable vector master traced from the approved
  `approved-concept-v6.png`. The pupils and their inner circles look down-right.
- `wordmark.svg` contains the outlined lowercase wordmark, derived from
  `fonts/Outfit-ExtraBold.ttf` with compact letter spacing. Keep `fonts/OFL.txt`
  with the font; the outlines do not need the font at runtime.
- `palette.json` defines the shared export colors.
- `USAGE.md` and `gallery.css` are copied into the public download pack by the
  build. Edit these sources rather than the generated copies.

Run `npm run brand:build` after editing a master or changing the gallery.
Run `npm run brand:check` to validate the committed outputs. Commit both source
and generated files under `public/brand/magewire/` so PHP-only deployments can
serve the pack without a Node build.

The character SVG's `body`, `eyes`, `pupils` and `highlights` group identifiers
are used by the generator to construct compound paths with transparent cutouts. Keep those
identifiers when editing geometry. All variants derive from the same master.

The concept reference was approved during a design session using the built-in
image generation tool. This vector trace removes raster texture and makes the
selected design portable. Earlier rejected concepts are intentionally outside
this pack.

Typeface source: https://github.com/Outfitio/Outfit-Fonts, specifically
`fonts/ttf/Outfit-ExtraBold.ttf` and `OFL.txt` on the `main` branch.
