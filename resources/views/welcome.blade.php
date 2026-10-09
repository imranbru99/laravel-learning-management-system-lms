<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Learnify — Modern Docker-based LMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-mesh {
            background-color: #090d16;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(168, 85, 247, 0.12) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(59, 130, 246, 0.1) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-mesh text-slate-100 min-h-screen selection:bg-indigo-500 selection:text-white antialiased">
    <!-- Navigation Bar -->
    <header class="border-b border-slate-800/80 bg-slate-900/40 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <span class="font-heading font-extrabold text-xl tracking-tight text-white">Learnify</span>
                    <span class="ml-2 text-xs font-semibold px-2 py-0.5 rounded-full bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Phase 1</span>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/horizon" target="_blank" class="text-sm font-medium text-slate-300 hover:text-white transition flex items-center space-x-1.5 px-3 py-1.5 rounded-lg hover:bg-slate-800/60">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Horizon</span>
                </a>
                <a href="http://localhost:8025" target="_blank" class="text-sm font-medium text-slate-300 hover:text-white transition px-3 py-1.5 rounded-lg hover:bg-slate-800/60">
                    Mailpit
                </a>
                <a href="http://localhost:9001" target="_blank" class="text-sm font-medium text-slate-300 hover:text-white transition px-3 py-1.5 rounded-lg hover:bg-slate-800/60">
                    MinIO
                </a>
                <a href="/health" target="_blank" class="text-xs font-mono px-3 py-1.5 rounded-lg bg-indigo-600/20 text-indigo-300 border border-indigo-500/30 hover:bg-indigo-600/30 transition">
                    GET /health
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center max-w-3xl mx-auto pt-6 pb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold uppercase tracking-wider mb-6">
                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                Docker Environment Running
            </div>
            <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                Production-Grade <span class="bg-gradient-to-r from-indigo-400 via-violet-400 to-pink-400 bg-clip-text text-transparent">LMS Platform</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-slate-400 font-normal leading-relaxed">
                Powered by Laravel 12, PHP 8.3, Livewire 3, Tailwind CSS 4, MySQL 8.4, Redis 7, Laravel Horizon, Reverb, Meilisearch & MinIO.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <span class="px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300 font-mono">PHP {{ PHP_VERSION }}</span>
                <span class="px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300 font-mono">Laravel {{ app()->version() }}</span>
                <span class="px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300 font-mono">MySQL 8.4 utf8mb4</span>
                <span class="px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300 font-mono">FFmpeg Enabled</span>
                <span class="px-3 py-1 rounded-lg bg-slate-800/80 border border-slate-700/60 text-xs text-slate-300 font-mono">Chromium Headless</span>
            </div>
        </div>

        <!-- Infrastructure & Services Grid -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-heading text-xl font-bold text-white flex items-center gap-2">
                    <span>Containerized Service Status</span>
                </h2>
                <span class="text-xs text-slate-400 font-mono">Live Diagnostics</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($services as $key => $service)
                    <div class="group relative rounded-2xl bg-slate-900/60 border border-slate-800/80 p-6 hover:border-indigo-500/40 transition duration-300 hover:shadow-xl hover:shadow-indigo-500/5">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-heading font-semibold text-base text-white group-hover:text-indigo-300 transition">
                                    {{ $service['name'] }}
                                </h3>
                                <p class="text-xs text-slate-400 mt-1 font-mono">
                                    {{ $service['message'] }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $service['status'] ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
                                {{ $service['status'] ? 'Healthy' : 'Pending' }}
                            </span>
                        </div>

                        <div class="mt-5 pt-4 border-t border-slate-800/60 flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Service Key: <code class="text-slate-400 font-mono">{{ $key }}</code></span>
                            @if(isset($service['url']))
                                <a href="{{ $service['url'] }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 font-semibold inline-flex items-center gap-1">
                                    Open
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Access Ports & Tools -->
        <div class="mt-12 rounded-2xl bg-gradient-to-r from-slate-900/90 via-slate-900/70 to-indigo-950/40 border border-slate-800 p-8">
            <h3 class="font-heading text-lg font-bold text-white mb-4">Environment Topology & Ports</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 text-center">
                <div class="p-4 rounded-xl bg-slate-950/50 border border-slate-800/80">
                    <div class="text-xs text-slate-400">Web App (Nginx)</div>
                    <div class="text-lg font-bold font-mono text-indigo-400 mt-1">:8080</div>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/50 border border-slate-800/80">
                    <div class="text-xs text-slate-400">Vite HMR</div>
                    <div class="text-lg font-bold font-mono text-indigo-400 mt-1">:5173</div>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/50 border border-slate-800/80">
                    <div class="text-xs text-slate-400">Mailpit UI</div>
                    <div class="text-lg font-bold font-mono text-indigo-400 mt-1">:8025</div>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/50 border border-slate-800/80">
                    <div class="text-xs text-slate-400">MinIO Console</div>
                    <div class="text-lg font-bold font-mono text-indigo-400 mt-1">:9001</div>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/50 border border-slate-800/80">
                    <div class="text-xs text-slate-400">Reverb WebSockets</div>
                    <div class="text-lg font-bold font-mono text-indigo-400 mt-1">:8085</div>
                </div>
                <div class="p-4 rounded-xl bg-slate-950/50 border border-slate-800/80">
                    <div class="text-xs text-slate-400">Meilisearch</div>
                    <div class="text-lg font-bold font-mono text-indigo-400 mt-1">:7700</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 py-8 text-center text-xs text-slate-500">
        <p>Learnify LMS &copy; {{ date('Y') }} — Architected for Performance & Reliability.</p>
    </footer>
</body>
</html>
