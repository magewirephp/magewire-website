# Magewire character logo pack

The approved character has a softly faceted body, two short feet, and two eyes
looking down and to the right. The small white circle inside each dark pupil
also sits at the lower-right. Keep this gaze consistent.

Open [the gallery](index.html) to compare every version and download individual
files, or download [the complete ZIP](magewire-brand-assets.zip).

## Choose a version

| Use | File |
| --- | --- |
| Standalone orange character | [character-color.svg](svg/character-color.svg) |
| Logo on a light background | [horizontal-color.svg](svg/horizontal-color.svg) |
| Logo on a dark background | [horizontal-reverse.svg](svg/horizontal-reverse.svg) |
| Character above the wordmark | [stacked-color.svg](svg/stacked-color.svg) |
| One-color artwork | `character-black.svg`, `character-white.svg`, and the black/white layouts |
| Wordmark alone | `wordmark-black.svg`, `wordmark-white.svg`, or `wordmark-orange.svg` |
| Community/profile picture | `avatar-light.svg`, `avatar-dark.svg`, or `avatar-orange.svg` |
| Link preview | `social-light.svg` or `social-dark.svg`, also exported at 1200 × 630 PNG |
| Browser/app icons | `icons/` |

SVG files contain actual vector paths and shapes, including outlined lettering.
They need no font installation or external resource. PNG and lossless WebP
exports use the same vector masters. Character, wordmark and logo-layout
backgrounds are transparent. Avatars, social cards and touch/app icons have
intentional solid backgrounds.

The black and white versions are true one-color artwork: eye surrounds and
highlights are transparent cutouts. Their contrast reverses with the background.
For the original white-eye/dark-pupil appearance on a dark background, use the
orange character or a `reverse` layout.

## Colors and spacing

- Orange: `#FF4F00`
- Ink: `#111111`
- Eye/dark background: `#141B2A`
- White: `#FFFFFF`

Keep the aspect ratio and leave clear space around the mark. The supplied
exports include optical padding. Do not mirror the character, stretch it, add
effects, or move the eyes or their inner circles independently. Prefer SVG for
web use; choose a PNG at least twice the displayed width when SVG is unavailable.
At favicon sizes the body and eyes carry recognition; the tiny highlights may
become subpixel details.

## Using the files on the website

These paths work once this asset pack is deployed with the website:

```html
<img src="/brand/magewire/svg/horizontal-color.svg"
     alt="Magewire" width="240" height="72">

<link rel="icon" type="image/svg+xml"
      href="/brand/magewire/icons/favicon.svg">
<link rel="icon" type="image/x-icon"
      href="/brand/magewire/icons/favicon.ico">
<link rel="apple-touch-icon"
      href="/brand/magewire/icons/apple-touch-icon.png">
<link rel="manifest"
      href="/brand/magewire/icons/site.webmanifest">
```

The web manifest includes 192px and 512px icons and a separate maskable icon
with a larger safe area. The website uses the horizontal color logo in its
shared header and footer, with the light social card for link previews on all
public pages. The footer links to this gallery. The brand build synchronizes
the root favicons and Apple touch icon with this pack; the frontend build adds
content hashes to the URLs used by the templates.

## Source and typeface

Editable SVG masters, the approved concept reference and the source font live
in `resources/brand/magewire/` in the website repository. The character is a
clean vector trace of the selected concept, not a bitmap embedded in an SVG.
The wordmark is set in Outfit ExtraBold with compact spacing and converted to
outlines, matching the geometric lowercase treatment in the concept.

Outfit is by Rodrigo Fuenzalida and the Outfit project authors. Its SIL Open
Font License is included as [OFL-Outfit.txt](OFL-Outfit.txt). The exact font
file and license are retained with the source masters.

Rebuild from the repository root with `npm run brand:build`; validate existing
exports with `npm run brand:check`. The build writes an asset manifest, the
gallery, a contact sheet and a deterministic download archive. It does not
fetch fonts or call an image generation API.
