# Olijfboom van Licht

Laravel + Blade version of the Olijfboom van Licht MVP. The frontend and backend now live in one Laravel app (Blade views + API endpoints).

## Quick Start

See `SETUP.md` for full setup instructions.

## Structure

- `routes/web.php` - Blade pages (home, login, dashboard, team details, invite)
- `routes/api.php` - JSON endpoints used by the interactive olive tree + stats
- `resources/views` - Blade templates
- `resources/js/app.js` - UI interactions (nav highlighting, donate form, olive tree lights)
- `database/migrations` - MySQL schema for users, teams, team members, donations, invites

## Legacy

The original React + Express implementation has been preserved in `legacy/`.

