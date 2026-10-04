# Cached identity images

These are the contributor portraits and organization logos already displayed on
the website, cached locally to avoid third-party redirects and connections.
`report.json` records each public source URL. Original SVG/JPEG/PNG files are
retained unless lossless WebP is smaller; identities are never repainted or
resized. Filenames include a content hash for safe long-lived caching.

Refresh after contributor or branding changes:

```shell
npm run images:refresh-identities
npm run build
```

Commit the images and both image and frontend manifests together. The refresh
script reads contributor handles from the homepage so there is one maintained
list. A failed download prevents manifest replacement.
Earlier fingerprinted files are retained for pages still using cached HTML.
