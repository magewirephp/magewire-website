# Painted card illustrations

These ten homepage illustrations were repainted with the built-in imagegen tool, using each previous image as the edit target and the existing [hero sky](header/sky.webp) and [footer landscape](footer/landscape.webp) as style references. Sponsor logos and contributor profile pictures remain their original identity assets.

The final images replace their previous WebP files, keeping their original dimensions and page layout. WebP encoding uses quality 84. No CSS filters are used to simulate paint.

## Assets

- [mage-os](compatibility/mage-os.webp) — 768 × 768
- [magento-open-source](compatibility/magento-open-source.webp) — 768 × 768
- [adobe-commerce](compatibility/adobe-commerce.webp) — 768 × 768
- [backend](compatibility/backend.webp) — 768 × 768
- [hyva](compatibility/hyva.webp) — 768 × 768
- [breeze](compatibility/breeze.webp) — 768 × 768
- [luma](compatibility/luma.webp) — 768 × 768
- [bricklayer](tools/bricklayer.webp) — 1200 × 800
- [checkout](hyva/checkout.webp) — 1536 × 1024
- [cms](hyva/cms.webp) — 1536 × 1024

## Shared prompt

```text
Use case: style-transfer
Asset type: illustration on the Magewire website, one member of a cohesive hand-painted set.
Input images: Image 1 is the EDIT TARGET; Image 2 is the existing hero sky STYLE REFERENCE; Image 3 is the existing footer landscape STYLE REFERENCE. Repaint ONLY Image 1. Do not return the style-reference scenes.
Primary request: repaint the complete original illustration in the same charming, sophisticated hand-painted gouache animation style as the two style references. Preserve the subject, symbols, recognisable branding shapes, main objects, and their spatial arrangement. Replace all glossy molded-plastic 3D-render shading with visibly brushed pigment, matte gouache surfaces, softly irregular painterly contours, layered warm washes, dry-brush texture and subtle paper grain. Keep the shapes clear at card size.
Style/medium: 2D storybook background painting, softly dimensional through painted light and shadow, warm ivory/cream background, ochre and terracotta orange accents, charcoal, sage green, pale blue and restrained lavender where appropriate. The same natural brushwork and warm light as the references, rather than a Photoshop filter over a render.
Constraints: preserve the original image aspect ratio and broadly the original composition; all important objects fully visible with breathing room; preserve existing symbols and brand marks accurately; no added text, labels, watermark, frame, birds, extra landscape or decorative objects. No photorealism, CGI, shiny plastic, glass-like specular reflections, neon glow, vector-flat icon style or heavy black comic outlines. Make connecting paths painted ochre lines instead of neon cables. Output one complete finished image.
```

## Image-specific prompt additions

### mage-os

The central symbol was corrected using the official mark from the [Mage-OS website](https://mage-os.org/) and its [media kit](https://mage-os.org/about/media-kit/). The [reference SVG](compatibility/mage-os-reference.svg) retains the original four paths and orange fills; the artwork follows its wide connected zigzag silhouette.

Correction prompt (built-in imagegen edit, with the existing artwork as Image 1 and a PNG rendering of the official reference SVG as Image 2):

```text
Use case: precise-object-edit.
Asset type: Mage-OS compatibility illustration on the Magewire website.
Input images: Image 1 is the EDIT TARGET, an existing square gouache illustration. Image 2 is the authoritative OFFICIAL MAGE-OS LOGO MARK reference, shown on transparency; use its exact shape and proportions.
Primary request: Correct ONLY the large orange symbol in Image 1. The existing tall folded cube is the wrong logo. Replace it with the actual wide Mage-OS mark from Image 2.
Logo fidelity is the highest priority: faithfully copy the entire connected horizontal zigzag silhouette, its two upper peaks and three lower points, the exact arrangement of three isometric orange faces, the notches and edges, and the width-to-height ratio of approximately 2.08:1. Keep both official orange colors. Do not invent a generic M, single cube, V, Magento hexagon, extra block, lettering, or emblem. The reference already includes its isometric geometry; do not rotate it or apply extra perspective.
Style: keep the website's hand-painted matte gouache treatment. Apply restrained brush texture to the accurately shaped logo faces while keeping the geometry crisp and unmistakable at small card size. Its outline must match Image 2, not the original symbol.
Composition: place the corrected logo prominently in the upper center of the original scene, with its naturally wider and shorter proportions. Keep it fully visible and clearly separated from the storefront and dashboard. Keep the original cream painted sky, dark foundation platform, little storefront on the left, administration dashboard on the right, orange connecting paths and green check medallion, their scale and spatial arrangement unchanged. Adjust only the logo's immediate shadow if needed.
Constraints: one finished square image; opaque background; no text, no watermark, no additional objects; preserve the existing scene and palette apart from replacing the incorrect symbol.
```

### magento-open-source

```text
Image-specific invariants: Keep the exact central orange Magento emblem silhouette, small awning storefront on the left, code window on the right, orange connecting paths and green check medallion.
Framing: square.
```

### adobe-commerce

```text
Image-specific invariants: Keep the exact central red Adobe A emblem silhouette, three linked small awning storefronts, analytics dashboard behind them and green check medallion.
Framing: square.
```

### backend

```text
Image-specific invariants: Keep the administration dashboard with sidebar, sliders, charts, database symbol, orange connecting path and the green check in the upper right.
Framing: square.
```

### hyva

```text
Image-specific invariants: Keep the storefront browser window with a lavender mountain thumbnail and three product cards, orange lightning bolt behind its right edge and sage-green check medallion.
Framing: square.
```

### breeze

```text
Image-specific invariants: Keep the central circular connection loop and puzzle piece, surrounded by connected browser, image, chart, text and component tiles. Keep the orange circular arrow.
Framing: square.
```

### luma

```text
Image-specific invariants: Keep the quiet cream awning storefront/browser panel, orange pause medallion at the lower left and disconnected orange plug on the right. Preserve the neutral inactive visual mood.
Framing: square.
```

### bricklayer

```text
Image-specific invariants: Keep the friendly tracked bricklayer robot with ivory hard hat on the left, orange articulated construction arm above, magnifying glass and laptop in the foreground, and stacked ivory/orange blocks on the right. Preserve visible runtime connection diagrams inside the blocks, painted as simple schematic insets.
Framing: 3:2 landscape.
```

### checkout

```text
Image-specific invariants: Keep four checkout-step panels flowing left to right: cart, customer, payment, confirmation. Keep the parcel in the lower right and large sage-green completion check above it. Preserve all step icons and connecting flow.
Framing: 3:2 landscape.
```

### cms

```text
Image-specific invariants: Keep the separate content blocks on the left assembling into a large desktop storefront in the middle, linked to a narrow mobile storefront on the right. Keep the lavender-and-terracotta palette and image/product/content blocks.
Framing: 3:2 landscape.
```
