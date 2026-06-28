<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — Taskly</title>
    <link rel="icon" href="{{ asset('assets/identidade-visualpack/favicon.svg') }}" type="image/svg+xml">
    <link rel="icon" href="{{ asset('assets/identidade-visualpack/favicon-32x32.png') }}" sizes="32x32" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('assets/identidade-visualpack/apple-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="{{ asset('js/layout.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-12px) rotate(1deg); }
            66% { transform: translateY(-6px) rotate(-1deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-18px) rotate(2deg); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes live-ping {
            0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.35); }
            50% { box-shadow: 0 0 0 7px rgba(16, 185, 129, 0); }
        }
        @keyframes data-glow {
            0%, 100% { border-color: rgba(51, 65, 85, 0.8); transform: translateY(0); }
            50% { border-color: rgba(99, 102, 241, 0.42); transform: translateY(-2px); }
        }
        @keyframes progress-shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(220%); }
        }
        .float-1 { animation: float 6s ease-in-out infinite; }
        .float-2 { animation: float2 8s ease-in-out infinite 1s; }
        .float-3 { animation: float 7s ease-in-out infinite 2s; }
        .pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
        .slide-up { animation: slide-up 0.5s ease-out forwards; }
        .fade-in { animation: fade-in 0.8s ease-out forwards; }
        .live-dot { animation: live-ping 1.8s ease-in-out infinite; }
        .dashboard-metric { animation: data-glow 4.5s ease-in-out infinite; }
        .dashboard-metric:nth-child(2) { animation-delay: 0.8s; }
        .dashboard-metric:nth-child(3) { animation-delay: 1.6s; }
        .live-number, .live-subtext, .live-growth, .live-time, .live-activity-title {
            transition: color 0.25s ease, opacity 0.25s ease, transform 0.25s ease;
        }
        .is-updating {
            color: #bfdbfe !important;
            transform: translateY(-1px);
        }
        .dashboard-bar, .live-progress-bar {
            transition: height 0.7s ease, width 0.7s ease;
        }
        .live-progress-bar { position: relative; overflow: hidden; }
        .live-progress-bar::after {
            content: "";
            position: absolute;
            inset: 0;
            width: 45%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.32), transparent);
            animation: progress-shine 2.4s ease-in-out infinite;
        }

        .auth-input {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(51, 65, 85, 0.8);
            border-radius: 12px;
            padding: 12px 16px 12px 44px;
            color: #f8fafc;
            font-size: 14px;
            font-family: 'Outfit', sans-serif;
            transition: all 0.2s ease;
            outline: none;
        }
        .auth-input::placeholder { color: #475569; }
        .auth-input:focus {
            border-color: rgba(99, 102, 241, 0.7);
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }

        /* Dot grid background */
        .dot-grid {
            background-image: radial-gradient(circle, rgba(99,102,241,0.15) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* Custom Checkbox Styling */
        .auth-checkbox {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 6px;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(51, 65, 85, 0.8);
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            outline: none;
            flex-shrink: 0;
        }
        .auth-checkbox:checked {
            background: #4f46e5;
            border-color: #6366f1;
        }
        .auth-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 2px;
            width: 5px;
            height: 9px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .auth-checkbox:focus {
            border-color: rgba(99, 102, 241, 0.7);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex overflow-hidden">

    <!-- LEFT PANEL — branding & features -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 relative flex-col justify-between p-12 dot-grid overflow-hidden">

        <!-- Gradient blobs -->
        <div class="absolute top-[-100px] left-[-100px] w-[500px] h-[500px] bg-indigo-600/20 rounded-full blur-3xl pulse-slow pointer-events-none"></div>
        <div class="absolute bottom-[-80px] right-[-80px] w-[400px] h-[400px] bg-violet-600/15 rounded-full blur-3xl pulse-slow pointer-events-none" style="animation-delay:2s"></div>
        <div class="absolute top-1/2 left-1/3 w-[300px] h-[300px] bg-sky-600/10 rounded-full blur-3xl pulse-slow pointer-events-none" style="animation-delay:1s"></div>

        <!-- Brand -->
        <div class="relative z-10 fade-in">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_horizontal.svg') }}" alt="Taskly" class="h-12 w-auto">
            </div>
        </div>

        <!-- Hero content -->
        <div class="relative z-10 flex flex-col gap-10">
            <!-- Main headline -->
            <div class="slide-up">
                <h1 class="text-5xl xl:text-6xl font-bold text-white leading-tight tracking-tight">
                    Organize seu<br>
                    <span class="bg-gradient-to-r from-indigo-400 via-violet-400 to-sky-400 bg-clip-text text-transparent">trabalho</span><br>
                    com clareza.
                </h1>
                <p class="mt-4 text-slate-400 text-lg leading-relaxed max-w-md">
                    Kanban visual, dashboard analítico e colaboração em tempo real — tudo em um só lugar.
                </p>
            </div>

            <!-- Floating Kanban cards mockup -->
            <div class="relative h-48 select-none" aria-hidden="true">
                <!-- Card 1 -->
                <div class="float-1 absolute left-0 top-0 glass-card rounded-2xl px-4 py-3 w-56 shadow-xl shadow-black/30">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Alta</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-200">Redesign da landing page</p>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center text-[9px] font-bold text-white">M</div>
                        <span class="text-[10px] text-slate-500">Vence amanhã</span>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="float-2 absolute left-44 top-6 glass-card rounded-2xl px-4 py-3 w-52 shadow-xl shadow-black/30 border-indigo-500/30">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Média</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-200">Implementar API de pagamentos</p>
                    <div class="w-full h-1.5 bg-slate-700 rounded-full mt-2 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-violet-500 rounded-full" style="width:65%"></div>
                    </div>
                    <p class="text-[9px] text-slate-500 mt-1">65% concluído</p>
                </div>
                <!-- Card 3 -->
                <div class="float-3 absolute left-20 top-28 glass-card rounded-2xl px-4 py-3 w-48 shadow-xl shadow-black/30">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Concluída</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-200 line-through opacity-60">Setup do ambiente</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span class="text-[10px] text-emerald-400 font-medium">Finalizado</span>
                    </div>
                </div>
            </div>

            <!-- Feature pills -->
            <div class="flex flex-wrap gap-3">
                <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 rounded-full px-4 py-2">
                    <i data-lucide="kanban" class="w-3.5 h-3.5 text-indigo-400"></i>
                    <span class="text-xs text-slate-300 font-medium">Kanban drag & drop</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 rounded-full px-4 py-2">
                    <i data-lucide="layout-dashboard" class="w-3.5 h-3.5 text-violet-400"></i>
                    <span class="text-xs text-slate-300 font-medium">Dashboard analítico</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 rounded-full px-4 py-2">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-sky-400"></i>
                    <span class="text-xs text-slate-300 font-medium">PT • EN • ES</span>
                </div>
                <div class="flex items-center gap-2 bg-slate-800/60 border border-slate-700/50 rounded-full px-4 py-2">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5 text-rose-400"></i>
                    <span class="text-xs text-slate-300 font-medium">Lixeira com restauração</span>
                </div>
            </div>
        </div>

        <!-- Dashboard preview -->
        <div data-dashboard-preview class="hidden xl:block absolute right-10 top-1/2 z-10 w-[44%] max-w-[540px] -translate-y-1/2 select-none" aria-hidden="true">
            <div class="glass-card rounded-2xl p-4 shadow-2xl shadow-black/40 border-indigo-500/20">
                <div class="flex items-center justify-between border-b border-slate-800/80 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 text-indigo-400"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">Dashboard</p>
                            <p class="text-[11px] text-slate-500">Visao geral do projeto</p>
                        </div>
                    </div>
                    <span class="flex items-center gap-2 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[10px] font-semibold text-emerald-400">
                        <span class="live-dot h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Ao vivo
                    </span>
                </div>

                <div class="grid grid-cols-3 gap-3 py-4">
                    <div class="dashboard-metric rounded-xl border border-slate-800 bg-slate-900/70 p-3">
                        <div class="flex items-center justify-between">
                            <i data-lucide="clipboard-list" class="w-4 h-4 text-sky-400"></i>
                            <span class="text-[9px] font-semibold uppercase text-slate-500">Tarefas</span>
                        </div>
                        <p class="live-number mt-3 text-2xl font-bold text-white" data-live-key="tasks">48</p>
                        <p class="live-subtext text-[10px] text-slate-500" data-live-key="progress">12 em progresso</p>
                    </div>
                    <div class="dashboard-metric rounded-xl border border-slate-800 bg-slate-900/70 p-3">
                        <div class="flex items-center justify-between">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400"></i>
                            <span class="text-[9px] font-semibold uppercase text-slate-500">Concluidas</span>
                        </div>
                        <p class="live-number mt-3 text-2xl font-bold text-emerald-400" data-live-key="done">31</p>
                        <p class="live-subtext text-[10px] text-slate-500" data-live-key="doneRate">65% do total</p>
                    </div>
                    <div class="dashboard-metric rounded-xl border border-slate-800 bg-slate-900/70 p-3">
                        <div class="flex items-center justify-between">
                            <i data-lucide="flame" class="w-4 h-4 text-amber-400"></i>
                            <span class="text-[9px] font-semibold uppercase text-slate-500">Alta</span>
                        </div>
                        <p class="live-number mt-3 text-2xl font-bold text-amber-400" data-live-key="high">7</p>
                        <p class="live-subtext text-[10px] text-slate-500">prioritarias</p>
                    </div>
                </div>

                <div class="grid grid-cols-[1.1fr_0.9fr] gap-3">
                    <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="trending-up" class="w-4 h-4 text-indigo-400"></i>
                                <span class="text-xs font-semibold text-slate-300">Progresso semanal</span>
                            </div>
                            <span class="live-growth text-xs font-bold text-indigo-300" data-live-key="growth">+18%</span>
                        </div>
                        <div class="flex h-32 items-end gap-2">
                            <div class="dashboard-bar h-[38%] flex-1 rounded-t-md bg-slate-700"></div>
                            <div class="dashboard-bar h-[54%] flex-1 rounded-t-md bg-slate-700"></div>
                            <div class="dashboard-bar h-[45%] flex-1 rounded-t-md bg-slate-700"></div>
                            <div class="dashboard-bar h-[72%] flex-1 rounded-t-md bg-indigo-500"></div>
                            <div class="dashboard-bar h-[60%] flex-1 rounded-t-md bg-violet-500"></div>
                            <div class="dashboard-bar h-[84%] flex-1 rounded-t-md bg-sky-500"></div>
                            <div class="dashboard-bar h-full flex-1 rounded-t-md bg-emerald-500"></div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4">
                        <div class="mb-4 flex items-center gap-2">
                            <i data-lucide="activity" class="w-4 h-4 text-sky-400"></i>
                            <span class="text-xs font-semibold text-slate-300">Atividade</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="live-activity-title truncate text-[11px] font-medium text-slate-300">Setup finalizado</p>
                                    <p class="live-time text-[9px] text-slate-600">agora</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="live-activity-title truncate text-[11px] font-medium text-slate-300">API movida</p>
                                    <p class="live-time text-[9px] text-slate-600">12 min</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                                <div class="min-w-0 flex-1">
                                    <p class="live-activity-title truncate text-[11px] font-medium text-slate-300">Prazo revisado</p>
                                    <p class="live-time text-[9px] text-slate-600">1 h</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 rounded-xl border border-slate-800 bg-slate-900/70 p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-300">Taxa de conclusao global</span>
                        <span class="live-number text-sm font-bold text-emerald-400" data-live-key="completion">65%</span>
                    </div>
                    <div class="h-2 overflow-hidden rounded-full bg-slate-800">
                        <div class="live-progress-bar h-full w-[65%] rounded-full bg-gradient-to-r from-indigo-500 via-violet-500 to-emerald-400"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom tagline -->
        <div class="relative z-10 fade-in">
            <p class="text-xs text-slate-600 font-medium">© 2025 Taskly — Gerenciador de tarefas profissional</p>
        </div>
    </div>

    <!-- RIGHT PANEL — login form -->
    <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 sm:p-10 relative bg-slate-950/80">

        <!-- Subtle separator line on large screens -->
        <div class="hidden lg:block absolute left-0 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-slate-700/50 to-transparent"></div>

        <div class="w-full max-w-md slide-up">

            <!-- Mobile brand -->
            <div class="flex lg:hidden items-center gap-3 mb-10 justify-center">
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_mark.svg') }}" alt="" class="h-10 w-10">
                <span class="text-xl font-bold text-white">Taskly</span>
            </div>

            <!-- Heading -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white tracking-tight">Bem-vindo de volta</h2>
                <p class="text-slate-400 text-sm mt-2">Entre com sua conta para continuar</p>
            </div>

            <!-- Error messages -->
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 bg-rose-500/10 border border-rose-500/30 rounded-xl px-4 py-3">
                    <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400 mt-0.5 flex-shrink-0"></i>
                    <ul class="text-sm text-rose-300 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ url('/login') }}" method="POST" class="flex flex-col gap-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">E-mail</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-500"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="seu@email.com"
                               class="auth-input">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Senha</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-500"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                               placeholder="••••••••"
                               class="auth-input">
                    </div>
                </div>

                <!-- Remember me -->
                <div class="flex items-center gap-2.5">
                    <input type="checkbox" name="remember" id="remember"
                           class="auth-checkbox">
                    <label for="remember" class="text-sm text-slate-400 cursor-pointer select-none">Lembrar de mim</label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full relative overflow-hidden bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-indigo-600/30 hover:shadow-indigo-500/40 hover:shadow-xl mt-1 group">
                    <span class="flex items-center justify-center gap-2">
                        Entrar
                        <i data-lucide="arrow-right" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"></i>
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-slate-800"></div>
                <span class="text-xs text-slate-600 font-medium">ou</span>
                <div class="flex-1 h-px bg-slate-800"></div>
            </div>

            <!-- Register link -->
            <p class="text-center text-sm text-slate-500">
                Não tem uma conta?
                <a href="{{ url('/register') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors duration-200 ml-1">
                    Criar conta grátis
                </a>
            </p>

            <!-- Dev Credits Footer -->
            <div class="mt-8 pt-6 border-t border-slate-900/60 text-center">
                <p class="text-xs text-slate-500">
                    Desenvolvido por <span class="text-slate-300 font-semibold">Matheus Marques</span>
                </p>
                <div class="flex items-center justify-center gap-3 mt-3">
                    <a href="https://github.com/CdeCinza" target="_blank" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-xs font-semibold shadow-sm group">
                        <svg class="w-4 h-4 text-indigo-400 group-hover:text-white transition-colors" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                                <path d="M2360 5049 c-154 -11 -357 -47 -516 -93 -902 -259 -1603 -1017 -1790 -1934 -136 -669 -8 -1355 354 -1908 255 -390 580 -686 968 -886 141 -73 341 -154 403 -164 58 -9 109 19 133 73 18 40 18 60 12 286 l-7 243 -86 -14 c-97 -15 -256 -9 -386 13 -105 19 -211 71 -278 139 -53 53 -67 76 -136 229 -63 139 -135 231 -232 297 -66 46 -121 106 -117 128 6 30 48 43 121 38 141 -10 288 -113 393 -274 72 -110 143 -179 230 -222 62 -31 79 -35 169 -38 103 -4 207 12 291 44 41 16 43 18 58 85 19 86 56 164 106 228 l39 49 -82 11 c-264 38 -452 102 -627 215 -229 148 -365 379 -431 731 -20 109 -23 389 -5 492 29 167 98 319 200 445 l45 55 -20 62 c-52 168 -42 372 28 574 18 50 22 52 103 48 118 -6 371 -108 543 -218 l71 -46 56 11 c30 6 87 18 127 27 271 58 655 58 926 0 40 -9 97 -21 127 -27 l55 -10 95 58 c226 137 484 230 575 206 26 -7 33 -17 53 -75 43 -125 55 -210 50 -351 -4 -95 -11 -148 -26 -195 l-21 -64 44 -54 c89 -109 155 -244 192 -389 22 -89 25 -417 4 -544 -32 -198 -114 -406 -210 -532 -165 -217 -464 -366 -843 -418 l-87 -12 39 -49 c47 -60 85 -137 106 -221 14 -52 17 -137 20 -503 5 -490 5 -489 72 -521 46 -21 83 -15 229 42 738 284 1320 932 1533 1703 141 513 111 1108 -80 1601 -172 440 -475 842 -848 1122 -405 303 -865 474 -1367 507 -175 12 -192 12 -375 0z"/>
                            </g>
                        </svg>
                        GitHub
                    </a>
                    <a href="https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/" target="_blank" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-xs font-semibold shadow-sm group">
                        <svg class="w-4 h-4 text-indigo-400 group-hover:text-white transition-colors" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                                <path d="M395 5110 c-176 -28 -312 -145 -371 -320 -18 -53 -19 -130 -19 -2230 0 -2100 1 -2177 19 -2230 49 -146 148 -247 294 -303 l57 -22 2185 0 2185 0 57 22 c146 56 245 157 294 303 18 53 19 130 19 2230 0 2100 -1 2177 -19 2230 -49 146 -148 247 -294 303 l-57 22 -2150 1 c-1182 1 -2172 -2 -2200 -6z m880 -565 c207 -44 382 -218 424 -423 78 -376 -262 -724 -634 -649 -200 41 -355 175 -421 366 -31 89 -35 228 -9 318 42 148 150 276 289 343 124 60 222 72 351 45z m2625 -1298 c169 -44 276 -104 383 -215 166 -170 253 -399 288 -757 9 -91 13 -353 14 -875 0 -702 -1 -747 -18 -773 -10 -16 -32 -37 -50 -47 -30 -19 -53 -20 -365 -20 -363 0 -370 1 -411 58 -19 28 -20 46 -24 763 -3 623 -6 744 -19 799 -38 154 -98 254 -188 308 -78 46 -121 57 -235 56 -131 0 -192 -23 -279 -105 -72 -67 -123 -159 -159 -287 -21 -75 -22 -97 -27 -792 -5 -668 -6 -717 -23 -742 -38 -55 -56 -58 -404 -58 -356 0 -368 2 -405 71 -17 32 -18 92 -18 1267 0 1368 -4 1281 64 1323 29 18 56 19 361 19 310 0 332 -1 362 -20 52 -31 63 -64 63 -192 l1 -113 22 30 c74 102 202 206 309 253 141 61 271 82 488 78 147 -3 190 -8 270 -29z m-2379 -30 c19 -12 42 -38 52 -57 16 -33 17 -109 15 -1272 -3 -1233 -3 -1237 -24 -1265 -45 -61 -58 -63 -402 -63 -338 0 -341 0 -392 55 l-25 27 -3 1250 c-2 1206 -2 1252 16 1280 11 16 32 38 48 49 27 18 51 19 355 19 322 0 326 0 360 -23z"/>
                            </g>
                        </svg>
                        LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const preview = document.querySelector('[data-dashboard-preview]');
            if (!preview) return;

            const snapshots = [
                { tasks: 48, progress: 12, done: 31, high: 7, completion: 65, growth: 18, bars: [38, 54, 45, 72, 60, 84, 100], activities: ['Setup finalizado', 'API movida', 'Prazo revisado'], times: ['agora', '12 min', '1 h'] },
                { tasks: 49, progress: 13, done: 32, high: 6, completion: 66, growth: 21, bars: [46, 52, 63, 68, 76, 88, 92], activities: ['Nova tarefa criada', 'Deploy aprovado', 'Checklist atualizado'], times: ['agora', '4 min', '24 min'] },
                { tasks: 51, progress: 14, done: 34, high: 8, completion: 67, growth: 24, bars: [42, 61, 58, 80, 74, 91, 96], activities: ['Card movido', 'Comentário recebido', 'Prioridade alterada'], times: ['agora', '8 min', '31 min'] },
                { tasks: 50, progress: 11, done: 35, high: 5, completion: 70, growth: 27, bars: [50, 64, 70, 78, 83, 90, 100], activities: ['Entrega concluida', 'Bug resolvido', 'Sprint revisada'], times: ['agora', '15 min', '42 min'] },
            ];

            let index = 0;
            const setText = (selector, value) => {
                const el = preview.querySelector(selector);
                if (!el) return;
                el.classList.add('is-updating');
                el.style.opacity = '0.45';
                setTimeout(() => {
                    el.textContent = value;
                    el.style.opacity = '1';
                    setTimeout(() => el.classList.remove('is-updating'), 260);
                }, 180);
            };

            const updatePreview = () => {
                index = (index + 1) % snapshots.length;
                const data = snapshots[index];

                setText('[data-live-key="tasks"]', data.tasks);
                setText('[data-live-key="progress"]', `${data.progress} em progresso`);
                setText('[data-live-key="done"]', data.done);
                setText('[data-live-key="doneRate"]', `${data.completion}% do total`);
                setText('[data-live-key="high"]', data.high);
                setText('[data-live-key="growth"]', `+${data.growth}%`);
                setText('[data-live-key="completion"]', `${data.completion}%`);

                preview.querySelectorAll('.dashboard-bar').forEach((bar, barIndex) => {
                    bar.style.height = `${data.bars[barIndex]}%`;
                });

                const progressBar = preview.querySelector('.live-progress-bar');
                if (progressBar) progressBar.style.width = `${data.completion}%`;

                preview.querySelectorAll('.live-activity-title').forEach((item, itemIndex) => {
                    item.classList.add('is-updating');
                    item.style.opacity = '0.45';
                    setTimeout(() => {
                        item.textContent = data.activities[itemIndex];
                        item.style.opacity = '1';
                        item.classList.remove('is-updating');
                    }, 180);
                });

                preview.querySelectorAll('.live-time').forEach((item, itemIndex) => {
                    item.textContent = data.times[itemIndex];
                });
            };

            setInterval(updatePreview, 2600);
        });
    </script>
</body>
</html>
