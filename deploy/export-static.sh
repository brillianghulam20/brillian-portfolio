#!/usr/bin/env bash
set -euo pipefail

SOURCE_URL="${SOURCE_URL:-http://127.0.0.1:8000}"
SITE_URL="${SITE_URL:-https://brillianghulam20.github.io}"
OUTPUT_DIR="${1:-dist}"

if [[ -d "$OUTPUT_DIR/.git" ]]; then
    git -C "$OUTPUT_DIR" rm -r --ignore-unmatch . >/dev/null 2>&1 || true
    git -C "$OUTPUT_DIR" clean -fdx -e .git >/dev/null
else
    rm -rf "$OUTPUT_DIR"
    mkdir -p "$OUTPUT_DIR"
fi

curl --fail --silent --show-error "$SOURCE_URL/sitemap.xml" > "$OUTPUT_DIR/sitemap.xml"
mapfile -t pages < <(sed -n 's:.*<loc>\([^<]*\)</loc>.*:\1:p' "$OUTPUT_DIR/sitemap.xml" | sed -E 's|https?://[^/]+||')

for path in "${pages[@]}"; do
    if [[ "$path" == "/" ]]; then
        target="$OUTPUT_DIR/index.html"
    else
        target="$OUTPUT_DIR${path}/index.html"
        mkdir -p "$(dirname "$target")"
    fi

    curl --fail --silent --show-error "$SOURCE_URL$path" \
        | sed -E "s#https?://(127\.0\.0\.1|localhost)(:[0-9]+)?#$SITE_URL#g; s#href=\"$SITE_URL/resume/download\"#href=\"$SITE_URL/CV-Brillian-Ghulam.pdf\"#g" \
        > "$target"
done

curl --fail --silent --show-error "$SOURCE_URL/sitemap.xml" \
    | sed -E "s#https?://(127\.0\.0\.1|localhost)(:[0-9]+)?#$SITE_URL#g" \
    > "$OUTPUT_DIR/sitemap.xml"

cp -R public/build "$OUTPUT_DIR/build"
if [[ -d storage/app/public ]]; then
    mkdir -p "$OUTPUT_DIR/storage"
    cp -R storage/app/public/. "$OUTPUT_DIR/storage/"
    rm -f "$OUTPUT_DIR/storage/.gitignore"
fi
curl --fail --silent --show-error "$SOURCE_URL/resume/download" > "$OUTPUT_DIR/CV-Brillian-Ghulam.pdf"

find "$OUTPUT_DIR" -type f -name '*.html' -exec sed -i \
    -e "s|href=\"/|href=\"$SITE_URL/|g" \
    -e "s|src=\"/|src=\"$SITE_URL/|g" {} +

find "$OUTPUT_DIR" -type f -name '*.html' -exec sed -i \
    '/<script id="browser-logger-active">/,/<\/script>/d' {} +

cat > "$OUTPUT_DIR/robots.txt" <<EOF
User-agent: *
Allow: /
Sitemap: $SITE_URL/sitemap.xml
EOF

touch "$OUTPUT_DIR/.nojekyll"
