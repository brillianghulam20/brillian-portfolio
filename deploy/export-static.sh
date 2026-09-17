#!/usr/bin/env bash
set -euo pipefail

SOURCE_URL="${SOURCE_URL:-http://127.0.0.1:8000}"
SITE_URL="${SITE_URL:-https://brillianghulam20.github.io}"
OUTPUT_DIR="${1:-dist}"

rm -rf "$OUTPUT_DIR"
mkdir -p "$OUTPUT_DIR"

pages=(
    "/"
    "/about"
    "/experience"
    "/skills"
    "/projects"
    "/projects/whatsapp-finance-bot"
    "/projects/automatic-data-comparison"
    "/projects/document-tracking-system"
    "/resume"
    "/contact"
)

for path in "${pages[@]}"; do
    if [[ "$path" == "/" ]]; then
        target="$OUTPUT_DIR/index.html"
    else
        target="$OUTPUT_DIR${path}/index.html"
        mkdir -p "$(dirname "$target")"
    fi

    curl --fail --silent --show-error "$SOURCE_URL$path" \
        | sed "s|$SOURCE_URL|$SITE_URL|g; s|href=\"$SITE_URL/resume/download\"|href=\"$SITE_URL/CV-Brillian-Ghulam.pdf\"|g" \
        > "$target"
done

curl --fail --silent --show-error "$SOURCE_URL/sitemap.xml" \
    | sed "s|$SOURCE_URL|$SITE_URL|g" \
    > "$OUTPUT_DIR/sitemap.xml"

cp -R public/build "$OUTPUT_DIR/build"
cp database/seeders/assets/profile.png "$OUTPUT_DIR/profile.png"
cp database/seeders/assets/CV-Brillian-Ghulam.pdf "$OUTPUT_DIR/CV-Brillian-Ghulam.pdf"

find "$OUTPUT_DIR" -type f -name '*.html' -exec sed -i \
    -e "s|/storage/profile/brillian-ghulam.png|/profile.png|g" \
    -e "s|content=\"$SITE_URL/storage/profile/brillian-ghulam.png\"|content=\"$SITE_URL/profile.png\"|g" \
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
