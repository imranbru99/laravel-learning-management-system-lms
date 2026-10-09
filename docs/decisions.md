# Architectural Decisions & Log

## Phase 1 Decisions

1. **PHP 8.3 & Laravel 13 on Alpine**:
   - Base image: `php:8.3-fpm-alpine`.
   - Extensions installed via `mlocati/docker-php-extension-installer` for fast, reliable, reproducible builds:
     - `pdo_mysql`, `redis`, `gd`, `intl`, `zip`, `bcmath`, `pcntl`, `exif`, `opcache`.
   - System tools included: FFmpeg (video transcoding & thumbnails), Chromium (headless PDF/browsershot rendering), Node.js 22, npm, and Composer 2.

2. **Docker Compose Service Architecture**:
   - `app`: PHP-FPM 8.3 handling backend requests with named volume mounts for `vendor` to ensure high performance on Windows/WSL2 and Docker Desktop.
   - `nginx`: Reverse proxy routing HTTP traffic to `app:9000` and proxying WebSocket connections (`/app`) to Laravel Reverb on port 8085. Supports 2GB upload size.
   - `mysql`: MySQL 8.4 LTS utf8mb4 with persistent storage.
   - `redis`: Redis 7 Alpine for cache, session, and queues.
   - `meilisearch`: Fast typo-tolerant search engine connected via Laravel Scout.
   - `minio`: S3-compatible object storage with `minio-init` provisioning the three required buckets (`lms-public`, `lms-private`, `lms-videos`).
   - `mailpit`: Dev SMTP server (1025) and Web UI (8025).
   - `horizon`: Supervised Laravel Horizon instance for queue monitoring and workers.
   - `scheduler`: Daemon running `php artisan schedule:work`.
   - `reverb`: Laravel Reverb WebSocket server running on port 8085.
   - `video-worker`: Dedicated queue worker for long-running video transcoding (`video` queue, 1GB memory limit, 3600s timeout).
   - `node`: Vite development server with HMR on port 5173.
   - `phpmyadmin`: Optional database UI under the `dev` profile on port 8081.

3. **Cross-Platform Developer Experience**:
   - Provided standard GNU `Makefile` with targets (`up`, `down`, `build`, `install`, `fresh`, `test`, `lint`, `stan`, `shell`, `logs`, etc.).
   - Provided `run.ps1` helper for native PowerShell environments on Windows.
