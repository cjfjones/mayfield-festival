#!/usr/bin/env bash
set -euo pipefail

cd "$(dirname "$0")/.."

SITE_URL="${SITE_URL:-http://localhost:8080}"

run_wp() {
  docker compose run --rm wpcli "$@"
}

echo "[1/6] Verifying WordPress install..."
if ! run_wp core is-installed >/dev/null 2>&1; then
  echo "WordPress is not installed yet. Run ./scripts/local-setup.sh first."
  exit 1
fi

echo "[2/6] Setting useful baseline options..."
run_wp option update blogdescription "Local development environment" >/dev/null
run_wp option update permalink_structure '/%postname%/' >/dev/null
run_wp rewrite flush --hard >/dev/null

echo "[3/6] Creating core pages (idempotent-ish)..."
create_page() {
  local title="$1"
  local slug="$2"
  local content="$3"

  local existing_id
  existing_id="$(run_wp post list --post_type=page --name="$slug" --field=ID --posts_per_page=1 2>/dev/null || true)"
  if [[ -n "${existing_id}" ]]; then
    run_wp post update "$existing_id" --post_title="$title" --post_status=publish --post_content="$content" >/dev/null
    echo "Updated page: $title ($slug)"
  else
    run_wp post create --post_type=page --post_title="$title" --post_name="$slug" --post_status=publish --post_content="$content" >/dev/null
    echo "Created page: $title ($slug)"
  fi
}

create_page "Home" "home" "<h2>Mayfield Festival</h2><p>Local seeded homepage content.</p>"
create_page "About" "about" "<h2>About the Festival</h2><p>This is seeded local content for development.</p>"
create_page "Contact" "contact" "<h2>Contact</h2><p>Email: info@example.local</p>"
create_page "Events" "events" "<h2>Events</h2><p>Seeded event listing page for local testing.</p>"

home_id="$(run_wp post list --post_type=page --name=home --field=ID --posts_per_page=1)"
blog_id="$(run_wp post list --post_type=page --name=events --field=ID --posts_per_page=1)"
run_wp option update show_on_front page >/dev/null
run_wp option update page_on_front "$home_id" >/dev/null
run_wp option update page_for_posts "$blog_id" >/dev/null

echo "[4/6] Creating sample posts..."
for n in 1 2 3; do
  slug="news-item-$n"
  title="News Item $n"
  existing_id="$(run_wp post list --post_type=post --name="$slug" --field=ID --posts_per_page=1 2>/dev/null || true)"
  content="<p>This is seeded local post $n for layout/testing.</p>"
  if [[ -n "${existing_id}" ]]; then
    run_wp post update "$existing_id" --post_title="$title" --post_status=publish --post_content="$content" >/dev/null
    echo "Updated post: $title"
  else
    run_wp post create --post_type=post --post_title="$title" --post_name="$slug" --post_status=publish --post_content="$content" >/dev/null
    echo "Created post: $title"
  fi
done

echo "[5/6] Creating sample events if CPT exists..."
if run_wp post-type list --field=name | grep -qx "events"; then
  for n in 1 2 3; do
    slug="sample-event-$n"
    title="Sample Event $n"
    existing_id="$(run_wp post list --post_type=events --name="$slug" --field=ID --posts_per_page=1 2>/dev/null || true)"
    content="<p>Seeded event content $n for local UI testing.</p>"
    if [[ -n "${existing_id}" ]]; then
      run_wp post update "$existing_id" --post_title="$title" --post_status=publish --post_content="$content" >/dev/null
      echo "Updated event: $title"
    else
      run_wp post create --post_type=events --post_title="$title" --post_name="$slug" --post_status=publish --post_content="$content" >/dev/null
      echo "Created event: $title"
    fi
  done
else
  echo "CPT 'events' not found; skipping event seeds."
fi

echo "[6/6] Done"
echo "Visit: $SITE_URL"
echo "Home: $SITE_URL/home"
echo "Events: $SITE_URL/events"
