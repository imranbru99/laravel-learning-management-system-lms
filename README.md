# Learnify — Modern Docker-Based Learning Management System

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)
[![MySQL 8.4](https://img.shields.io/badge/MySQL-8.4_LTS-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Redis 7](https://img.shields.io/badge/Redis-7_Alpine-DC382D?style=for-the-badge&logo=redis&logoColor=white)](https://redis.io)

Learnify is an enterprise-grade, modern, and high-performance Learning Management System (LMS) designed for students, instructors, corporate teams, and administrators. Built with **PHP 8.3**, **Laravel 13**, **Livewire 3**, **Alpine.js**, **Tailwind CSS 4**, and orchestrated via **Docker Desktop**.

---

## 🚀 Quickstart

### Prerequisites
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (WSL2 engine enabled)
- Git

### 1-Line Setup
```bash
git clone <repo-url> learnify
cd learnify
cp .env.example .env
make install
make up
```

*(On Windows PowerShell without `make`, you can run `.\run.ps1 install` and `.\run.ps1 up`)*

---

## 🌐 Port Mappings & Services

| Service | Host Port | Internal Port | URL / Notes |
|---|---|---|---|
| **Web Application (Nginx)** | `8080` | `80` | [http://localhost:8080](http://localhost:8080) |
| **Vite HMR Server** | `5173` | `5173` | [http://localhost:5173](http://localhost:5173) |
| **Mailpit Dev Mail UI** | `8025` | `8025` | [http://localhost:8025](http://localhost:8025) (SMTP on `1025`) |
| **MinIO Console** | `9001` | `9001` | [http://localhost:9001](http://localhost:9001) (`learnify_admin` / `learnify_secret_password`) |
| **MinIO S3 API** | `9000` | `9000` | S3 endpoint (`http://localhost:9000`) |
| **Laravel Reverb WebSockets** | `8085` | `8085` | Proxied also via Nginx `/app` and `/apps/` |
| **Meilisearch Search Engine** | `7700` | `7700` | Master key: `learnify_meili_master_key` |
| **MySQL 8.4 Database** | `3306` | `3306` | Database: `learnify`, User: `learnify_user` |
| **Redis 7** | `6379` | `6379` | Cache, queues & sessions |
| **Laravel Horizon** | — | — | Dashboard at [http://localhost:8080/horizon](http://localhost:8080/horizon) |
| **phpMyAdmin (dev profile)** | `8081` | `80` | Optional: `docker compose --profile dev up -d` |

---

## 🛠️ Makefile & CLI Commands

```bash
make up          # Start all docker containers
make down        # Stop all docker containers
make restart     # Restart all docker containers
make build       # Rebuild docker images
make install     # Bootstrap: composer, key:generate, migrate --seed, storage:link, npm
make fresh       # Fresh migrations & database seeding
make test        # Run Pest 3 test suite
make lint        # Run Laravel Pint code styling
make stan        # Run Larastan level 8 static analysis
make shell       # Shell into app container
make logs        # Tail docker compose logs
make queue       # Monitor queue workers
make horizon     # Check Horizon status
make npm-dev     # Start Vite dev server with HMR
make npm-build   # Compile frontend assets for production
make backup      # Run Spatie Laravel Backup
```

---

## 📦 Architecture & Storage

- **MinIO Object Storage**: Initialized automatically with three dedicated buckets:
  - `lms-public`: Public course thumbnails, avatars, previews.
  - `lms-private`: Private course attachments, invoices, certificates.
  - `lms-videos`: High-definition video uploads & HLS streams.
- **Dedicated Video Queue Worker**: High-memory (1024MB), 3600s timeout worker configured for FFmpeg transcoding and HLS packaging.
- **WebSocket Streaming**: Native integration with Laravel Reverb behind Nginx reverse proxy.
