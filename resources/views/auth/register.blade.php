<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta — Taskly</title>
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
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_horizontal.svg') }}" alt="Taskly" class="h-12 w-auto">
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
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_mark.svg') }}" alt="" class="h-10 w-10">
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
                    Desenvolvido por <span class="text-slate-300 font-semibold">Matheus Marques Fernandes Vieira</span>
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
