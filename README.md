# Learnify — Modern Docker-Based Learning Management System

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Docker](https://img.shields.io/badge/Docker-Enabled-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)
[![MySQL 8.4](https://img.shields.io/badge/MySQL-8.4_LTS-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Redis 7](https://img.shields.io/badge/Redis-7_Alpine-DC382D?style=for-the-badge&logo=redis&logoColor=white)](https://redis.io)

Learnify is an enterprise-grade, modern, and high-performance Learning Management System (LMS) designed for students, instructors, corporate teams, and administrators. Built with **PHP 8.3**, **Laravel 13**, **Livewire 3**, **Alpine.js**, **Tailwind CSS 4**, and orchestrated via **Docker Desktop**.

---

## 🌟 Key Features & Capabilities

### 🎓 1. Core LMS & Course Management
- **Modular Curriculum Builder**: Hierarchical organization of courses, chapters, sections, video lectures, reading materials, and downloadable resources.
- **Multi-Role Authentication & Authorization**: Granular RBAC (Role-Based Access Control) supporting Super Administrators, Instructors, Students, and Corporate Managers.
- **Student Progress & Enrollment Tracking**: Lesson completion checkpoints, continuous playback tracking, quiz scores, and course completion metrics.
- **Dynamic Certificate Generation**: Automated issuance of tamper-proof PDF certificates with verification barcodes/hashes rendered via headless Chromium.
- **Interactive Quizzes & Assignments**: Timed quizzes, multiple-choice questions, code/text assignments, and instructor grading workflows.

### 🎥 2. Media & Video Streaming Pipeline
- **Dedicated Video Queue Worker**: High-memory (1024MB), 3600-second execution timeout queue worker configured specifically for long-running media processing.
- **FFmpeg Integration**: Automatic server-side video transcoding, resolution scaling (360p, 720p, 1080p), adaptive bitrate packaging (HLS), and thumbnail generation.
- **Secure Video Delivery**: Signed time-limited URLs preventing direct video URL leakage and unauthorized downloads.
- **Chunked & Resumable Uploads**: Large video file uploads supported up to 2GB via Nginx reverse proxy optimizations.

### ⚡ 3. Real-Time Interactions & Search
- **Instant Full-Text Search (Meilisearch & Laravel Scout)**: Blazing-fast, typo-tolerant search across courses, instructors, lessons, and tags.
- **Real-Time WebSockets (Laravel Reverb)**: Live lecture chat, real-time in-app notifications, online user presence, and live question-and-answer interactions without third-party services like Pusher.
- **Livewire 3 & Alpine.js Frontend**: Smooth single-page application feel (SPA) with reactive component state, minimal page reloads, and modern Tailwind CSS 4 styling.

### 🗄️ 4. Storage & Asset Management (MinIO S3)
- **Multi-Bucket Architecture**: Out-of-the-box automated bucket provisioning:
  - `lms-public`: Public course thumbnails, instructor profiles, marketing previews.
  - `lms-private`: Course attachments, assignment submissions, generated invoices, and PDF certificates.
  - `lms-videos`: High-definition raw video uploads and converted HLS streaming segments.
- **S3 API Compatibility**: 100% compatible with AWS S3, Cloudflare R2, or MinIO on-premise deployments.

### ⚙️ 5. Queues, Background Jobs & Scheduling
- **Laravel Horizon Dashboard**: Real-time queue metrics, worker throughput, wait times, and job failure diagnostics.
- **Redis 7 In-Memory Cache**: High-performance caching for course catalogs, user sessions, database query caching, and rate limiting.
- **Daemon Scheduler**: Continuous automated cron runner executing scheduled tasks, reminder emails, analytics aggregations, and cache cleanups.

### 🛠️ 6. Developer Experience & Quality Assurance
- **Single-Command Setup**: Rapid bootstrapping with `make install` or native Windows `.\run.ps1 install`.
- **Pest 3 Test Suite**: Clean and expressive testing framework for feature, unit, and API integration testing.
- **Static Analysis (Larastan Level 8)**: Strict static type checking to catch regressions before runtime.
- **Laravel Pint**: Automated PSR-12 code style standardization and linting.
- **Mailpit Dev Inbox**: Built-in fake SMTP server and web interface to capture and inspect outgoing emails in development.
- **Live Diagnostics UI**: Comprehensive service health check board on the welcome page verifying Database, Redis, MinIO, Horizon, Reverb, and Meilisearch connections.

---

## 🚀 Quickstart

### Prerequisites
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (WSL2 backend recommended for Windows)
- Git

### 1-Line Setup
```bash
git clone https://github.com/imranbru99/laravel-learning-management-system-lms.git learnify
cd learnify
cp .env.example .env
make install
make up
```

*(On Windows PowerShell without `make`, run `.\run.ps1 install` and `.\run.ps1 up`)*

---

## 🌐 Port Mappings & Services

| Service | Host Port | Internal Port | URL / Credentials | Description |
|---|---|---|---|---|
| **Web Application (Nginx)** | `8080` | `80` | [http://localhost:8080](http://localhost:8080) | Main LMS HTTP Application |
| **Vite HMR Server** | `5173` | `5173` | [http://localhost:5173](http://localhost:5173) | Frontend Hot Module Reloading |
| **Mailpit Dev Mail UI** | `8025` | `8025` | [http://localhost:8025](http://localhost:8025) | Local SMTP inspector (SMTP on `1025`) |
| **MinIO Console** | `9001` | `9001` | [http://localhost:9001](http://localhost:9001) | User: `learnify_admin` / Pass: `learnify_secret_password` |
| **MinIO S3 API** | `9000` | `9000` | `http://localhost:9000` | S3 API endpoint |
| **Laravel Reverb WebSockets** | `8085` | `8085` | `http://localhost:8085` | WebSockets (proxied at `/app`) |
| **Meilisearch Engine** | `7700` | `7700` | [http://localhost:7700](http://localhost:7700) | Master Key: `learnify_meili_master_key` |
| **MySQL 8.4 Database** | `3306` | `3306` | `3306` | DB: `learnify` / User: `learnify_user` |
| **Redis 7** | `6379` | `6379` | `6379` | Cache, sessions, queue backend |
| **Laravel Horizon** | — | — | [http://localhost:8080/horizon](http://localhost:8080/horizon) | Queue & worker monitoring dashboard |
| **phpMyAdmin (dev profile)** | `8081` | `80` | [http://localhost:8081](http://localhost:8081) | Optional: `docker compose --profile dev up -d` |

---

## 🛠️ Makefile & CLI Commands

```bash
make up          # Start all docker containers in background
make down        # Stop all docker containers
make restart     # Restart all docker containers
make build       # Rebuild docker images with fresh layers
make install     # Bootstrap: composer, key:generate, migrate --seed, minio:init-buckets, storage:link, npm
make fresh       # Re-run fresh migrations & database seeding
make test        # Run Pest 3 test suite
make lint        # Run Laravel Pint code styling
make stan        # Run Larastan level 8 static analysis
make shell       # Open interactive bash shell inside app container
make logs        # Tail docker compose logs across all services
make queue       # Monitor queue workers
make horizon     # Check Horizon worker status
make npm-dev     # Start Vite dev server with HMR
make npm-build   # Compile frontend assets for production
make backup      # Run backup tasks
```

---

## 📦 Container Topology & Micro-Services

```text
                                  +-------------------+
                                  |   Client Browser  |
                                  +---------+---------+
                                            |
                                  +---------v---------+
                                  |   Nginx (:8080)   |
                                  +----+---------+----+
                                       |         |
                      /app WebSockets  |         | HTTP Requests
                                       v         v
                         +---------------+     +---------------+
                         | Reverb (:8085)|     |  PHP-FPM App  |
                         +---------------+     +-------+-------+
                                                       |
        +------------------+-----------------+---------+---------+------------------+
        |                  |                 |                   |                  |
        v                  v                 v                   v                  v
+---------------+  +---------------+  +---------------+  +---------------+  +---------------+
| MySQL 8.4 LTS |  |    Redis 7    |  | MinIO S3 (:9000)| | Meilisearch   |  | Mailpit (:8025)|
|  (:3306)      |  |   (:6379)     |  |   Console:9001|  |   (:7700)     |  |   SMTP:1025   |
+---------------+  +-------+-------+  +---------------+  +---------------+  +---------------+
                           |
            +--------------+--------------+
            |                             |
            v                             v
+-----------------------+     +-----------------------+
|  Horizon Worker Pool  |     |  Video Worker (1024M) |
|  & Scheduled Cron     |     |  FFmpeg / HLS Transcode|
+-----------------------+     +-----------------------+
```

---

## 🛡️ Production Readiness & Security
- **Strict Content Security & CORS Policies**: Configured for S3 assets and WebSocket endpoints.
- **Isolated Network**: All service backends communicate internally over the private Docker bridge network (`learnify_network`).
- **Production Compose File**: Pre-configured `docker-compose.prod.yml` optimized for production deployments.
- **CI/CD Pipeline**: GitHub Actions workflow covering automated linting, static analysis, unit tests, and feature tests on every push.

---

## 📄 License
This project is open-sourced software licensed under the [MIT License](LICENSE).
