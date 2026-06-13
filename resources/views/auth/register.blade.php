<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — Taskly</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="{{ asset('js/layout.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-14px); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.08); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes count-up {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .float-1 { animation: float 5s ease-in-out infinite; }
        .float-2 { animation: float 7s ease-in-out infinite 1.5s; }
        .float-3 { animation: float 6s ease-in-out infinite 0.8s; }
        .pulse-slow { animation: pulse-slow 5s ease-in-out infinite; }
        .slide-up { animation: slide-up 0.5s ease-out forwards; }
        .fade-in { animation: fade-in 0.8s ease-out forwards; }
        .count-up { animation: count-up 0.6s ease-out forwards; }

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

        .glass-stat {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }

        .dot-grid {
            background-image: radial-gradient(circle, rgba(99,102,241,0.15) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        /* password strength bar */
        #strength-bar { transition: width 0.3s ease, background-color 0.3s ease; }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex overflow-hidden">

    <!-- LEFT PANEL — stats & social proof -->
    <div class="hidden lg:flex lg:w-1/2 xl:w-3/5 relative flex-col justify-between p-12 dot-grid overflow-hidden">

        <!-- Gradient blobs -->
        <div class="absolute top-[-80px] right-[-80px] w-[450px] h-[450px] bg-violet-600/20 rounded-full blur-3xl pulse-slow pointer-events-none"></div>
        <div class="absolute bottom-[-100px] left-[-60px] w-[400px] h-[400px] bg-indigo-600/15 rounded-full blur-3xl pulse-slow pointer-events-none" style="animation-delay:2.5s"></div>
        <div class="absolute top-1/3 right-1/4 w-[250px] h-[250px] bg-sky-500/10 rounded-full blur-3xl pulse-slow pointer-events-none" style="animation-delay:1.2s"></div>

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
            <div class="slide-up">
                <h1 class="text-5xl xl:text-6xl font-bold text-white leading-tight tracking-tight">
                    Comece a organizar<br>
                    seu time <span class="bg-gradient-to-r from-violet-400 via-indigo-400 to-sky-400 bg-clip-text text-transparent">hoje.</span>
                </h1>
                <p class="mt-4 text-slate-400 text-lg leading-relaxed max-w-md">
                    Crie sua conta grátis e tenha acesso completo ao Kanban, Dashboard e muito mais.
                </p>
            </div>

            <!-- Stats grid -->
            <div class="grid grid-cols-3 gap-4">
                <div class="glass-stat rounded-2xl p-4 float-1">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500/15 border border-indigo-500/20 flex items-center justify-center mb-3">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400"></i>
                    </div>
                    <p class="text-2xl font-bold text-white count-up">∞</p>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Quadros Kanban</p>
                </div>
                <div class="glass-stat rounded-2xl p-4 float-2">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/15 border border-emerald-500/20 flex items-center justify-center mb-3">
                        <i data-lucide="users" class="w-4 h-4 text-emerald-400"></i>
                    </div>
                    <p class="text-2xl font-bold text-white count-up">+5</p>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Membros por board</p>
                </div>
                <div class="glass-stat rounded-2xl p-4 float-3">
                    <div class="w-9 h-9 rounded-xl bg-violet-500/15 border border-violet-500/20 flex items-center justify-center mb-3">
                        <i data-lucide="globe" class="w-4 h-4 text-violet-400"></i>
                    </div>
                    <p class="text-2xl font-bold text-white count-up">3</p>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Idiomas suportados</p>
                </div>
            </div>

            <!-- Feature checklist -->
            <div class="flex flex-col gap-3">
                @foreach([
                    ['icon' => 'check-circle-2', 'color' => 'text-emerald-400', 'text' => 'Kanban board com drag & drop ilimitado'],
                    ['icon' => 'check-circle-2', 'color' => 'text-emerald-400', 'text' => 'Dashboard com gráficos e KPIs em tempo real'],
                    ['icon' => 'check-circle-2', 'color' => 'text-emerald-400', 'text' => 'Histórico de atividades com log detalhado'],
                    ['icon' => 'check-circle-2', 'color' => 'text-emerald-400', 'text' => 'Lixeira com restauração de tarefas excluídas'],
                ] as $feature)
                    <div class="flex items-center gap-3">
                        <i data-lucide="{{ $feature['icon'] }}" class="w-4 h-4 {{ $feature['color'] }} flex-shrink-0"></i>
                        <span class="text-sm text-slate-300 font-medium">{{ $feature['text'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10 fade-in">
            <p class="text-xs text-slate-600 font-medium">© 2025 Taskly — Gratuito para sempre, sem cartão de crédito</p>
        </div>
    </div>

    <!-- RIGHT PANEL — register form -->
    <div class="w-full lg:w-1/2 xl:w-2/5 flex items-center justify-center p-6 sm:p-10 relative bg-slate-950/80 overflow-y-auto">

        <div class="hidden lg:block absolute left-0 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-slate-700/50 to-transparent"></div>

        <div class="w-full max-w-md slide-up py-4">

            <!-- Mobile brand -->
            <div class="flex lg:hidden items-center gap-3 mb-10 justify-center">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center">
                    <i data-lucide="layout-grid" class="w-5 h-5 text-white"></i>
                </div>
                <span class="text-xl font-bold text-white">Taskly</span>
            </div>

            <!-- Heading -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-white tracking-tight">Criar sua conta</h2>
                <p class="text-slate-400 text-sm mt-2">Grátis, rápido e sem complicação</p>
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
            <form action="{{ url('/register') }}" method="POST" class="flex flex-col gap-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Nome completo</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <i data-lucide="user" class="w-4 h-4 text-slate-500"></i>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="Seu nome"
                               class="auth-input">
                    </div>
                </div>

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
                               placeholder="Mínimo 8 caracteres"
                               class="auth-input"
                               oninput="checkStrength(this.value)">
                    </div>
                    <!-- Strength bar -->
                    <div class="mt-2 h-1 bg-slate-800 rounded-full overflow-hidden">
                        <div id="strength-bar" class="h-full rounded-full w-0 bg-rose-500"></div>
                    </div>
                    <p id="strength-label" class="text-[10px] text-slate-600 mt-1"></p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Confirmar senha</label>
                    <div class="relative">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            <i data-lucide="shield-check" class="w-4 h-4 text-slate-500"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               placeholder="Repita a senha"
                               class="auth-input">
                    </div>
                </div>

                <!-- Terms -->
                <div class="flex items-start gap-2.5">
                    <input type="checkbox" id="terms" required
                           class="w-4 h-4 rounded accent-indigo-500 bg-slate-800 border-slate-600 cursor-pointer mt-0.5 flex-shrink-0">
                    <label for="terms" class="text-xs text-slate-400 cursor-pointer leading-relaxed">
                        Ao criar uma conta, você concorda com os
                        <span class="text-indigo-400 hover:text-indigo-300">Termos de Uso</span>
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full relative overflow-hidden bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-violet-600/30 hover:shadow-violet-500/40 hover:shadow-xl mt-1 group">
                    <span class="flex items-center justify-center gap-2">
                        Criar conta grátis
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

            <!-- Login link -->
            <p class="text-center text-sm text-slate-500">
                Já tem uma conta?
                <a href="{{ url('/login') }}" class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors duration-200 ml-1">
                    Fazer login
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

    <script>
        function checkStrength(val) {
            const bar = document.getElementById('strength-bar');
            const label = document.getElementById('strength-label');
            if (!val) { bar.style.width = '0'; label.textContent = ''; return; }

            let score = 0;
            if (val.length >= 8) score++;
            if (val.length >= 12) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { pct: '20%', color: '#f43f5e', text: 'Muito fraca' },
                { pct: '40%', color: '#f97316', text: 'Fraca' },
                { pct: '60%', color: '#eab308', text: 'Razoável' },
                { pct: '80%', color: '#22c55e', text: 'Forte' },
                { pct: '100%', color: '#10b981', text: 'Muito forte' },
            ];
            const lvl = levels[Math.min(score, 4)];
            bar.style.width = lvl.pct;
            bar.style.backgroundColor = lvl.color;
            label.textContent = lvl.text;
            label.style.color = lvl.color;
        }
    </script>
</body>
</html>
