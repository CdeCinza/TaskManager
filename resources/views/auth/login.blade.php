<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — Taskly</title>
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
        .float-1 { animation: float 6s ease-in-out infinite; }
        .float-2 { animation: float2 8s ease-in-out infinite 1s; }
        .float-3 { animation: float 7s ease-in-out infinite 2s; }
        .pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
        .slide-up { animation: slide-up 0.5s ease-out forwards; }
        .fade-in { animation: fade-in 0.8s ease-out forwards; }

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
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <i data-lucide="layout-grid" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-indigo-200 to-white bg-clip-text text-transparent">Taskly</span>
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
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center">
                    <i data-lucide="layout-grid" class="w-5 h-5 text-white"></i>
                </div>
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
                           class="w-4 h-4 rounded accent-indigo-500 bg-slate-800 border-slate-600 cursor-pointer">
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
                    Desenvolvido por <span class="text-slate-350 font-medium">Matheus Marques Fernandes Vieira</span>
                </p>
                <div class="flex items-center justify-center gap-4 mt-2">
                    <a href="https://github.com/CdeCinza" target="_blank" class="text-slate-500 hover:text-indigo-400 transition-colors flex items-center gap-1.5 text-xs">
                        <i data-lucide="github" class="w-4 h-4"></i> GitHub
                    </a>
                    <a href="https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/" target="_blank" class="text-slate-500 hover:text-indigo-400 transition-colors flex items-center gap-1.5 text-xs">
                        <i data-lucide="linkedin" class="w-4 h-4"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
