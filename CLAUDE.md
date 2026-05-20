# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

GasTrack is a gas quality monitoring dashboard for aerial drone (BPLA) sensor data. It has two components:
- **PHP web app** — custom MVC, no framework, no Composer
- **Python data generator** (`bpla/`) — sends simulated sensor readings to the API using Perlin noise

## Running the Application

**PHP web app:** Requires Apache/Nginx with PHP 7+ and MySQL. The document root is `public/`. URL rewriting is handled by `public/.htaccess`.

**Python data generator:**
```bash
cd bpla
python app.py       # starts the continuous data push loop
python test.py      # ad-hoc test run
```
Configure the API endpoint and interval in `bpla/config.py`.

## Architecture

### PHP Layer

`app/` follows a manual MVC pattern:

- `app/Config/Config.php` — app-wide constants: timezone, branding, navigation links, table/file allowlists
- `app/Config/Path.php` — path constants (defines `DIR`)
- `app/Controllers/` — business logic; `functions.php` contains shared utilities (XSS escaping, DB helpers)
- `app/Models/Database.php` — PDO wrapper; all queries go through here with prepared statements
- `app/Views/` — PHP template partials (HEAD, Header, ControlPanel, Table, etc.)

Pages in `public/` are the entry points; they instantiate controllers and include view partials.

### API

`public/api/` exposes a REST-style interface:
- `GET api/get/gasData.php` — paginated sensor readings
- `GET api/get/deviceData.php` — device metadata
- `GET api/get/gasTypes.php` — gas type definitions (Temp, SO2, CO, O3, PM10, PM25)
- `POST api/post/gasData.php` — receives data from the Python generator (token-authenticated)
- `api/API_check.php` — shared auth check included by API endpoints

### Frontend

Static assets live in `public/assets/`. No build step — plain JS files, Bootstrap 5, jQuery 3.7.1, Chart.js. Theme (dark/light) is stored in the `theme` cookie and applied at page render time.

AJAX handlers are in `public/ajax/`; JS for specific pages is in `public/assets/js/`.

### Data Model

Key database tables: `users`, `devices`, `device_statuses`, `gas_data`, `gas_types`, `user_rules`, `authorization_attempts`, `errors`.

### Python Generator

`bpla/app.py` generates a 22×15 grid of sensor readings per cycle using configurable Perlin noise (lacunarity, octaves, persistence) and POSTs the result to the API. `bpla/README.md` describes the noise algorithm in detail.

## Security Conventions

- All output must go through `htmlspecialchars()` (or the wrapper in `functions.php`) — never echo raw user input
- All DB queries use PDO prepared statements via the `Database` model
- API endpoints verify tokens via `API_check.php` before processing
