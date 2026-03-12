#!/usr/bin/env bash
set -euo pipefail

SITE_URL="${SITE_URL:-http://localhost:8080}"
SITE_TITLE="${SITE_TITLE:-Mayfield Festival Local}"
ADMIN_USER="${ADMIN_USER:-admin}"
ADMIN_PASSWORD="${ADMIN_PASSWORD:-admin123!}"
ADMIN_EMAIL="${ADMIN_EMAIL:-admin@local.test}"

cd "$(dirname "$0")/.."

echo "[1/4] Starting containers..."
docker compose up -d db wordpress

echo "[2/4] Waiting for WordPress to respond..."
until docker compose run --rm wpcli core is-installed >/dev/null 2>&1; do
  sleep 2
  if docker compose run --rm wpcli core is-installed >/dev/null 2>&1; then
    break
  fi
  # If not installed yet, try install when DB is reachable.
  if docker compose run --rm wpcli db check >/dev/null 2>&1; then
    echo "Installing WordPress core..."
    docker compose run --rm wpcli core install \
      --url="$SITE_URL" \
      --title="$SITE_TITLE" \
      --admin_user="$ADMIN_USER" \
      --admin_password="$ADMIN_PASSWORD" \
      --admin_email="$ADMIN_EMAIL" \
      --skip-email || true
  fi
done

echo "[3/4] Ensuring custom theme is active..."
docker compose run --rm wpcli theme activate dazzling-mf || true

echo "[4/4] Installing plugins from plugins.txt..."
while IFS='|' read -r slug _; do
  slug="$(echo "$slug" | xargs)"
  [[ -z "$slug" || "$slug" =~ ^# ]] && continue
  docker compose run --rm wpcli plugin install "$slug" --activate || true
done < plugins.txt

echo "Done. Open: $SITE_URL"
echo "Admin: $ADMIN_USER / $ADMIN_PASSWORD"
