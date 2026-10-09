param (
    [string]$Command = "help"
)

function Show-Help {
    Write-Host "Learnify LMS — Available PowerShell Commands (run.ps1):" -ForegroundColor Cyan
    Write-Host "  .\run.ps1 up         - Start all docker containers"
    Write-Host "  .\run.ps1 down       - Stop all docker containers"
    Write-Host "  .\run.ps1 restart    - Restart all docker containers"
    Write-Host "  .\run.ps1 build      - Build docker images"
    Write-Host "  .\run.ps1 install    - Full bootstrap: composer, keys, migrate, seed, npm, link"
    Write-Host "  .\run.ps1 fresh      - Fresh migrations and seed"
    Write-Host "  .\run.ps1 test       - Run test suite"
    Write-Host "  .\run.ps1 lint       - Run Pint linter"
    Write-Host "  .\run.ps1 stan       - Run Larastan analysis"
    Write-Host "  .\run.ps1 shell      - Open shell inside app container"
    Write-Host "  .\run.ps1 logs       - Show container logs"
    Write-Host "  .\run.ps1 horizon    - Horizon status"
    Write-Host "  .\run.ps1 npm-build  - Build frontend assets"
}

switch ($Command.ToLower()) {
    "up" { docker compose up -d }
    "down" { docker compose down }
    "restart" { docker compose restart }
    "build" { docker compose build }
    "install" {
        if (-not (Test-Path .env)) { Copy-Item .env.example .env }
        docker compose up -d --build
        docker compose exec app composer install --optimize-autoloader
        docker compose exec app php artisan key:generate
        docker compose exec app php artisan storage:link
        docker compose exec app php artisan migrate --seed --force
        docker compose exec app php artisan minio:init-buckets
        docker compose exec app npm install
        docker compose exec app npm run build
        Write-Host "Learnify LMS installed successfully at http://localhost:8080" -ForegroundColor Green
    }
    "fresh" { docker compose exec app php artisan migrate:fresh --seed --force }
    "test" { docker compose exec app php artisan test }
    "lint" { docker compose exec app ./vendor/bin/pint }
    "stan" { docker compose exec app ./vendor/bin/phpstan analyse --memory-limit=2G }
    "shell" { docker compose exec app sh }
    "logs" { docker compose logs -f }
    "horizon" { docker compose exec app php artisan horizon:status }
    "npm-build" { docker compose exec app npm run build }
    default { Show-Help }
}
