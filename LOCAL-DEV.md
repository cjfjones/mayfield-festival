# Local development (Docker)

This repo tracks custom WordPress assets (theme + config), not full WordPress core.
Use Docker to run core + DB locally and mount this repo's `wp-content`.

## Prerequisites
- Docker Desktop (or Docker Engine + Compose v2)

## Quick start
```bash
cd /Users/derek/.openclaw/workspace/projects/mayfield-festival
chmod +x scripts/local-setup.sh
./scripts/local-setup.sh
```

Then open:
- Site: http://localhost:8080
- Admin: http://localhost:8080/wp-admin
- Default creds: `admin` / `admin123!`

## Seed sample content
After setup, seed local pages/posts/events:

```bash
./scripts/seed-local-content.sh
```

Notes:
- Safe to re-run (updates existing seeded items by slug).
- Seeds `events` custom post type only if it exists.

## Useful commands
```bash
# start / stop

docker compose up -d
docker compose down

# reset all local data (DB + core files)
docker compose down -v

# run wp-cli

docker compose run --rm wpcli plugin list
docker compose run --rm wpcli theme list
docker compose run --rm wpcli option get home
```

## Notes from code review
- Custom theme is `wp-content/themes/dazzling-mf`.
- `plugins.txt` is authoritative for third-party plugins used by the site.
- Potential cleanup item: both `fluent-smtp` and `wp-mail-smtp` are listed (likely overlap; pick one in production).
- `caldera-forms` is marked deprecated in `plugins.txt` (migration candidate).
