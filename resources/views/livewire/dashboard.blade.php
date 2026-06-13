<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <!-- SIDEBAR -->
    <aside class="w-full bg-slate-900 border-b border-slate-800 flex max-h-[46dvh] flex-col justify-between flex-shrink-0 z-10 lg:h-full lg:max-h-none lg:w-80 lg:border-b-0 lg:border-r">
        <div class="p-4 sm:p-6 flex flex-col gap-4 sm:gap-6 overflow-y-auto custom-scrollbar">
            <!-- App Brand Header -->
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_mark.svg') }}" alt="" class="w-10 h-10 flex-shrink-0">
                <div>
                    <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-200 to-white bg-clip-text text-transparent">Taskly</h1>
                    <p class="text-xs text-slate-400">{{ __('Painel de Controle') }}</p>
                </div>
            </div>

            <!-- Navigation Section -->
            <div class="flex flex-col gap-1">
                <div class="text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">{{ __('Navegação') }}</div>
                
                <!-- Dashboard Link (active) -->
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-200"></i>
                    <span class="flex-1">{{ __('Dashboard') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                </a>

                <a href="{{ route('calendar') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="calendar-days" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Agenda') }}</span>
                </a>

                <!-- Kanban - first board -->
                @if($userBoards->isNotEmpty())
                    <a href="{{ route('board.show', $userBoards->first()->id) }}" wire:navigate
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="flex-1">{{ __('Kanban') }}</span>
                    </a>
                @endif
            </div>

            <!-- Boards Section -->
            <div class="hidden sm:flex flex-col gap-3">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 tracking-wider uppercase px-2">
                    <span>{{ __('Meus Quadros') }}</span>
                    <i data-lucide="folder" class="w-4 h-4"></i>
                </div>
                <div class="flex flex-col gap-1">
                    @foreach($userBoards as $ub)
                        <a href="{{ route('board.show', $ub->id) }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                            <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                            <span class="truncate flex-1">{{ $ub->title }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Logged User Profile Footer -->
        <div class="p-4 sm:p-6 border-t border-slate-800 bg-slate-900/60 flex flex-col gap-4">
            <div class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center font-bold text-sm text-white shadow-inner uppercase">
                        {{ substr(auth()->user()->name ?? 'A', 0, 2) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Usuário' }}</h4>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? 'user@teste.com' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-rose-400 p-2 hover:bg-rose-500/10 rounded-xl transition duration-200" title="{{ __('Sair') }}">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>
            
            <!-- Dev Credits -->
            <div class="hidden sm:flex pt-4 border-t border-slate-800 flex-col items-center gap-2 text-center">
                <p class="text-[10px] text-slate-500 font-medium">
                    {{ __('Desenvolvido por') }} <span class="text-slate-300 font-semibold">Matheus Marques Fernandes Vieira</span>
                </p>
                <div class="flex items-center gap-2 mt-0.5">
                    <a href="https://github.com/CdeCinza" target="_blank" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-[10px] font-semibold group">
                        <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white transition-colors animate-none" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                                <path d="M2360 5049 c-154 -11 -357 -47 -516 -93 -902 -259 -1603 -1017 -1790 -1934 -136 -669 -8 -1355 354 -1908 255 -390 580 -686 968 -886 141 -73 341 -154 403 -164 58 -9 109 19 133 73 18 40 18 60 12 286 l-7 243 -86 -14 c-97 -15 -256 -9 -386 13 -105 19 -211 71 -278 139 -53 53 -67 76 -136 229 -63 139 -135 231 -232 297 -66 46 -121 106 -117 128 6 30 48 43 121 38 141 -10 288 -113 393 -274 72 -110 143 -179 230 -222 62 -31 79 -35 169 -38 103 -4 207 12 291 44 41 16 43 18 58 85 19 86 56 164 106 228 l39 49 -82 11 c-264 38 -452 102 -627 215 -229 148 -365 379 -431 731 -20 109 -23 389 -5 492 29 167 98 319 200 445 l45 55 -20 62 c-52 168 -42 372 28 574 18 50 22 52 103 48 118 -6 371 -108 543 -218 l71 -46 56 11 c30 6 87 18 127 27 271 58 655 58 926 0 40 -9 97 -21 127 -27 l55 -10 95 58 c226 137 484 230 575 206 26 -7 33 -17 53 -75 43 -125 55 -210 50 -351 -4 -95 -11 -148 -26 -195 l-21 -64 44 -54 c89 -109 155 -244 192 -389 22 -89 25 -417 4 -544 -32 -198 -114 -406 -210 -532 -165 -217 -464 -366 -843 -418 l-87 -12 39 -49 c47 -60 85 -137 106 -221 14 -52 17 -137 20 -503 5 -490 5 -489 72 -521 46 -21 83 -15 229 42 738 284 1320 932 1533 1703 141 513 111 1108 -80 1601 -172 440 -475 842 -848 1122 -405 303 -865 474 -1367 507 -175 12 -192 12 -375 0z"/>
                            </g>
                        </svg>
                        GitHub
                    </a>
                    <a href="https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/" target="_blank" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-[10px] font-semibold group">
                        <svg class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white transition-colors animate-none" viewBox="0 0 512 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)">
                                <path d="M395 5110 c-176 -28 -312 -145 -371 -320 -18 -53 -19 -130 -19 -2230 0 -2100 1 -2177 19 -2230 49 -146 148 -247 294 -303 l57 -22 2185 0 2185 0 57 22 c146 56 245 157 294 303 18 53 19 130 19 2230 0 2100 -1 2177 -19 2230 -49 146 -148 247 -294 303 l-57 22 -2150 1 c-1182 1 -2172 -2 -2200 -6z m880 -565 c207 -44 382 -218 424 -423 78 -376 -262 -724 -634 -649 -200 41 -355 175 -421 366 -31 89 -35 228 -9 318 42 148 150 276 289 343 124 60 222 72 351 45z m2625 -1298 c169 -44 276 -104 383 -215 166 -170 253 -399 288 -757 9 -91 13 -353 14 -875 0 -702 -1 -747 -18 -773 -10 -16 -32 -37 -50 -47 -30 -19 -53 -20 -365 -20 -363 0 -370 1 -411 58 -19 28 -20 46 -24 763 -3 623 -6 744 -19 799 -38 154 -98 254 -188 308 -78 46 -121 57 -235 56 -131 0 -192 -23 -279 -105 -72 -67 -123 -159 -159 -287 -21 -75 -22 -97 -27 -792 -5 -668 -6 -717 -23 -742 -38 -55 -56 -58 -404 -58 -356 0 -368 2 -405 71 -17 32 -18 92 -18 1267 0 1368 -4 1281 64 1323 29 18 56 19 361 19 310 0 332 -1 362 -20 52 -31 63 -64 63 -192 l1 -113 22 30 c74 102 202 206 309 253 141 61 271 82 488 78 147 -3 190 -8 270 -29z m-2379 -30 c19 -12 42 -38 52 -57 16 -33 17 -109 15 -1272 -3 -1233 -3 -1237 -24 -1265 -45 -61 -58 -63 -402 -63 -338 0 -341 0 -392 55 l-25 27 -3 1250 c-2 1206 -2 1252 16 1280 11 16 32 38 48 49 27 18 51 19 355 19 322 0 326 0 360 -23z"/>
                            </g>
                        </svg>
                        LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="min-h-0 min-w-0 flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="min-h-20 border-b border-slate-900 bg-slate-900/20 px-4 py-4 sm:px-6 lg:px-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-indigo-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white">{{ __('Dashboard') }}</h2>
                    <p class="text-xs text-slate-400">{{ __('Visão geral do seu sistema') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Language Selector Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                            class="flex items-center gap-2 bg-slate-850 hover:bg-slate-850/80 text-slate-300 hover:text-white px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700/60 transition duration-200 group">
                        <i data-lucide="globe" class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white"></i>
                        <span>
                            @if(app()->getLocale() === 'en')
                                English
                            @elseif(app()->getLocale() === 'es')
                                Español
                            @else
                                Português
                            @endif
                        </span>
                        <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500 group-hover:text-indigo-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                         class="absolute top-full mt-1.5 right-0 w-36 bg-slate-800 border border-slate-700 rounded-xl shadow-xl overflow-hidden z-50 py-1"
                         style="display: none;">
                        <button wire:click="setLocale('pt_BR')" @click="open = false"
                                class="w-full text-left px-3 py-2 text-xs font-medium transition-colors hover:bg-slate-700/50 hover:text-white {{ app()->getLocale() === 'pt_BR' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300' }}">
                            Português
                        </button>
                        <button wire:click="setLocale('en')" @click="open = false"
                                class="w-full text-left px-3 py-2 text-xs font-medium transition-colors hover:bg-slate-700/50 hover:text-white {{ app()->getLocale() === 'en' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300' }}">
                            English
                        </button>
                        <button wire:click="setLocale('es')" @click="open = false"
                                class="w-full text-left px-3 py-2 text-xs font-medium transition-colors hover:bg-slate-700/50 hover:text-white {{ app()->getLocale() === 'es' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300' }}">
                            Español
                        </button>
                    </div>
                </div>

                <div class="text-xs text-slate-500 font-medium">
                    {{ now()->format('d/m/Y') }}
                </div>
            </div>
        </header>

        <!-- Scrollable body -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar">

            <!-- ═══ KPI CARDS ═══ -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
                <!-- Total Boards -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                            <i data-lucide="layout-grid" class="w-4 h-4 text-indigo-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Quadros') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white tracking-tight">{{ $totalBoards }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Total de Quadros') }}</p>
                    </div>
                </div>

                <!-- Total Tasks -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="p-2 rounded-xl bg-sky-500/10 border border-sky-500/20">
                            <i data-lucide="clipboard-list" class="w-4 h-4 text-sky-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Tarefas') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white tracking-tight">{{ $totalTasks }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Total de Tarefas') }}</p>
                    </div>
                </div>

                <!-- Completed -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="p-2 rounded-xl bg-emerald-500/10 border border-emerald-500/20">
                            <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Concluídas') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-emerald-400 tracking-tight">{{ $completedTasks }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $completionRate }}% {{ __('de conclusão') }}</p>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="p-2 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Atrasadas') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold {{ $overdueTasks > 0 ? 'text-rose-400' : 'text-white' }} tracking-tight">{{ $overdueTasks }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Com prazo vencido') }}</p>
                    </div>
                </div>

                <!-- High Priority -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="p-2 rounded-xl bg-amber-500/10 border border-amber-500/20">
                            <i data-lucide="flame" class="w-4 h-4 text-amber-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Alta Prior.') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-amber-400 tracking-tight">{{ $highPriorityTasks }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Prioridade alta') }}</p>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center justify-between">
                        <div class="p-2 rounded-xl bg-violet-500/10 border border-violet-500/20">
                            <i data-lucide="users" class="w-4 h-4 text-violet-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Membros') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white tracking-tight">{{ $totalUsers }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Usuários ativos') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actionable Dashboard -->
            <div class="grid grid-cols-1 xl:grid-cols-[1.2fr_0.8fr] gap-6 mb-6">
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-5">
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar-check" class="w-4 h-4 text-indigo-400"></i>
                            <h3 class="text-sm font-semibold text-slate-200">{{ __('Minha Semana') }}</h3>
                        </div>
                        <a href="{{ route('calendar') }}" wire:navigate class="inline-flex items-center gap-2 text-xs font-semibold text-indigo-300 hover:text-indigo-200">
                            {{ __('Abrir agenda') }}
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                        </a>
                    </div>

                    @php
                        $weekGroups = [
                            ['label' => __('Hoje'), 'items' => $myWeek['today'], 'color' => 'text-sky-400', 'icon' => 'sun'],
                            ['label' => __('Amanhã'), 'items' => $myWeek['tomorrow'], 'color' => 'text-indigo-400', 'icon' => 'calendar-plus'],
                            ['label' => __('Esta semana'), 'items' => $myWeek['week'], 'color' => 'text-amber-400', 'icon' => 'calendar-clock'],
                            ['label' => __('Atrasadas'), 'items' => $myWeek['overdue'], 'color' => 'text-rose-400', 'icon' => 'alert-circle'],
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                        @foreach($weekGroups as $group)
                            <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-3">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="{{ $group['icon'] }}" class="w-3.5 h-3.5 {{ $group['color'] }}"></i>
                                        <span class="text-xs font-bold text-slate-300">{{ $group['label'] }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold {{ $group['color'] }}">{{ $group['items']->count() }}</span>
                                </div>
                                <div class="flex flex-col gap-2">
                                    @forelse($group['items']->take(3) as $task)
                                        <a href="{{ route('board.show', $task->column->board_id) }}" wire:navigate class="rounded-lg bg-slate-900/80 border border-slate-800/80 px-2.5 py-2 hover:border-indigo-500/40 transition">
                                            <p class="truncate text-[11px] font-semibold text-slate-200">{{ $task->title }}</p>
                                            <p class="truncate text-[9px] text-slate-500">{{ $task->column->board->title }}</p>
                                        </a>
                                    @empty
                                        <p class="py-4 text-center text-[11px] text-slate-600">{{ __('Nada por aqui') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="radar" class="w-4 h-4 text-rose-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Atenção agora') }}</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 xl:grid-cols-1 gap-3">
                        <div class="rounded-xl border border-rose-500/20 bg-rose-500/10 p-3">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-rose-300">{{ __('Atrasadas') }}</p>
                            <p class="mt-1 text-2xl font-bold text-white">{{ $myWeek['overdue']->count() }}</p>
                        </div>
                        <div class="rounded-xl border border-amber-500/20 bg-amber-500/10 p-3">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-amber-300">{{ __('Sem responsável') }}</p>
                            <p class="mt-1 text-2xl font-bold text-white">{{ $unassignedTasks->count() }}</p>
                        </div>
                        <div class="rounded-xl border border-indigo-500/20 bg-indigo-500/10 p-3">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-indigo-300">{{ __('Boards em risco') }}</p>
                            <p class="mt-1 text-2xl font-bold text-white">{{ $riskyBoards->where('risk_score', '>', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="user-round-x" class="w-4 h-4 text-amber-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Tarefas sem responsável') }}</h3>
                    </div>
                    <div class="flex flex-col gap-2 max-h-56 overflow-y-auto custom-scrollbar pr-1">
                        @forelse($unassignedTasks as $task)
                            <a href="{{ route('board.show', $task->column->board_id) }}" wire:navigate class="rounded-xl bg-slate-800/40 border border-slate-700/30 p-3 hover:border-amber-500/30 transition">
                                <p class="truncate text-xs font-semibold text-slate-200">{{ $task->title }}</p>
                                <p class="truncate text-[10px] text-slate-500">{{ $task->column->board->title }} / {{ $task->column->title }}</p>
                            </a>
                        @empty
                            <p class="py-6 text-center text-xs text-slate-500">{{ __('Tudo atribuído.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="triangle-alert" class="w-4 h-4 text-rose-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Boards com mais risco') }}</h3>
                    </div>
                    <div class="flex flex-col gap-2">
                        @forelse($riskyBoards as $boardRisk)
                            <a href="{{ route('board.show', $boardRisk->id) }}" wire:navigate class="rounded-xl bg-slate-800/40 border border-slate-700/30 p-3 hover:border-rose-500/30 transition">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-xs font-semibold text-slate-200">{{ $boardRisk->title }}</p>
                                    <span class="text-[10px] font-bold text-rose-400">{{ $boardRisk->risk_score }}</span>
                                </div>
                                <p class="mt-1 text-[10px] text-slate-500">{{ $boardRisk->overdue_tasks }} {{ __('atrasadas') }} / {{ $boardRisk->total_tasks }} {{ __('tarefas') }}</p>
                            </a>
                        @empty
                            <p class="py-6 text-center text-xs text-slate-500">{{ __('Nenhum risco encontrado.') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="sparkles" class="w-4 h-4 text-sky-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Atividades relevantes') }}</h3>
                    </div>
                    <div class="flex flex-col gap-2 max-h-56 overflow-y-auto custom-scrollbar pr-1">
                        @forelse($relevantActivities as $activity)
                            @php
                                $actorName = $activity->user?->name ?? __('Sistema');
                                $description = is_string($activity->description) ? $activity->description : json_encode($activity->description);
                            @endphp
                            <div class="rounded-xl bg-slate-800/40 border border-slate-700/30 p-3">
                                <p class="text-[11px] text-slate-300 leading-tight">
                                    <span class="font-semibold text-white">{{ $actorName }}</span>
                                    {{ $description }}
                                </p>
                                <p class="mt-1 text-[9px] text-slate-600">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="py-6 text-center text-xs text-slate-500">{{ __('Nenhuma atividade recente.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ═══ COMPLETION BAR ═══ -->
            <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 mb-6 shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <i data-lucide="trending-up" class="w-4 h-4 text-indigo-400"></i>
                        <span class="text-sm font-semibold text-slate-200">{{ __('Taxa de Conclusão Global') }}</span>
                    </div>
                    <span class="text-lg font-bold {{ $completionRate >= 70 ? 'text-emerald-400' : ($completionRate >= 40 ? 'text-amber-400' : 'text-rose-400') }}">
                        {{ $completionRate }}%
                    </span>
                </div>
                <div class="w-full h-3 bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-700 {{ $completionRate >= 70 ? 'bg-gradient-to-r from-emerald-600 to-emerald-400' : ($completionRate >= 40 ? 'bg-gradient-to-r from-amber-600 to-amber-400' : 'bg-gradient-to-r from-rose-600 to-rose-400') }}"
                         style="width: {{ $completionRate }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] text-slate-500 mt-2 font-medium">
                    <span>{{ $completedTasks }} {{ __('concluídas') }}</span>
                    <span>{{ $totalTasks - $completedTasks }} {{ __('pendentes') }}</span>
                </div>
            </div>

            <!-- ═══ MIDDLE ROW: Priority Breakdown + Tasks Due This Week ═══ -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

                <!-- Priority Breakdown -->
                @php $total = array_sum($priorityBreakdown); @endphp
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg"
                     x-data="{
                        view: 'bars',
                        chart: null,
                        initChart() {
                            if (this.chart) { this.chart.destroy(); this.chart = null; }
                            const ctx = this.$refs.pieCanvas.getContext('2d');
                            // Inline plugin: draws total in the doughnut center (canvas layer, never overlaps tooltip)
                            const centerTextPlugin = {
                                id: 'centerText',
                                beforeDraw(chart) {
                                    const { width, height, ctx } = chart;
                                    const cx = width / 2;
                                    const cy = height / 2;
                                    ctx.save();
                                    ctx.font = 'bold 26px Outfit, sans-serif';
                                    ctx.fillStyle = '#f8fafc';
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'middle';
                                    ctx.fillText('{{ $total }}', cx, cy - 9);
                                    ctx.font = '500 10px Outfit, sans-serif';
                                    ctx.fillStyle = '#64748b';
                                    ctx.letterSpacing = '0.1em';
                                    ctx.fillText('{{ strtoupper(__('tarefas')) }}', cx, cy + 13);
                                    ctx.restore();
                                }
                            };
                            this.chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['{{ __('Alta') }}', '{{ __('Média') }}', '{{ __('Baixa') }}'],
                                    datasets: [{
                                        data: [{{ $priorityBreakdown['high'] }}, {{ $priorityBreakdown['medium'] }}, {{ $priorityBreakdown['low'] }}],
                                        backgroundColor: ['rgba(244,63,94,0.85)', 'rgba(251,191,36,0.85)', 'rgba(52,211,153,0.85)'],
                                        borderColor: ['#f43f5e', '#fbbf24', '#34d399'],
                                        borderWidth: 2,
                                        hoverOffset: 8,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '62%',
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            backgroundColor: '#1e293b',
                                            borderColor: '#334155',
                                            borderWidth: 1,
                                            titleColor: '#f8fafc',
                                            bodyColor: '#94a3b8',
                                            padding: 10,
                                            callbacks: {
                                                label: (ctx) => ` ${ctx.parsed} {{ __('tarefas') }} (${Math.round(ctx.parsed / {{ $total ?: 1 }} * 100)}%)`
                                            }
                                        }
                                    }
                                },
                                plugins: [centerTextPlugin]
                            });
                        },
                        switchTo(v) {
                            this.view = v;
                            if (v === 'pie') {
                                this.$nextTick(() => this.initChart());
                            } else {
                                if (this.chart) { this.chart.destroy(); this.chart = null; }
                            }
                        }
                     }">

                    <!-- Card Header -->
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2">
                            <i :data-lucide="view === 'bars' ? 'bar-chart-3' : 'pie-chart'" class="w-4 h-4 text-indigo-400"></i>
                            <h3 class="text-sm font-semibold text-slate-200">{{ __('Distribuição de Prioridade') }}</h3>
                        </div>
                        <!-- Toggle buttons -->
                        <div class="flex items-center gap-1 bg-slate-800/60 border border-slate-700/50 rounded-lg p-0.5">
                            <button @click="switchTo('bars')"
                                    :class="view === 'bars' ? 'bg-indigo-600 text-white shadow' : 'text-slate-400 hover:text-white'"
                                    class="p-1.5 rounded-md transition-all duration-200"
                                    title="{{ __('Barras') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="12" width="4" height="9"/><rect x="10" y="7" width="4" height="14"/><rect x="17" y="3" width="4" height="18"/></svg>
                            </button>
                            <button @click="switchTo('pie')"
                                    :class="view === 'pie' ? 'bg-indigo-600 text-white shadow' : 'text-slate-400 hover:text-white'"
                                    class="p-1.5 rounded-md transition-all duration-200"
                                    title="{{ __('Pizza') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- BAR VIEW -->
                    <div x-show="view === 'bars'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="flex flex-col gap-4">
                        <!-- High -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    <span class="text-xs text-slate-300 font-medium">{{ __('Alta') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-rose-400">{{ $priorityBreakdown['high'] }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $total > 0 ? round(($priorityBreakdown['high'] / $total) * 100) : 0 }}%</span>
                                </div>
                            </div>
                            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-rose-600 to-rose-400 rounded-full transition-all duration-700"
                                     style="width: {{ $total > 0 ? ($priorityBreakdown['high'] / $total) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Medium -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span class="text-xs text-slate-300 font-medium">{{ __('Média') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-amber-400">{{ $priorityBreakdown['medium'] }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $total > 0 ? round(($priorityBreakdown['medium'] / $total) * 100) : 0 }}%</span>
                                </div>
                            </div>
                            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-600 to-amber-400 rounded-full transition-all duration-700"
                                     style="width: {{ $total > 0 ? ($priorityBreakdown['medium'] / $total) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Low -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span class="text-xs text-slate-300 font-medium">{{ __('Baixa') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-emerald-400">{{ $priorityBreakdown['low'] }}</span>
                                    <span class="text-[10px] text-slate-500">{{ $total > 0 ? round(($priorityBreakdown['low'] / $total) * 100) : 0 }}%</span>
                                </div>
                            </div>
                            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-600 to-emerald-400 rounded-full transition-all duration-700"
                                     style="width: {{ $total > 0 ? ($priorityBreakdown['low'] / $total) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- PIE (DOUGHNUT) VIEW -->
                    <div x-show="view === 'pie'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display:none;">
                        <!-- Chart canvas (center text drawn via plugin, no DOM overlay) -->
                        <div class="flex justify-center items-center" style="height: 190px;">
                            <canvas x-ref="pieCanvas"></canvas>
                        </div>
                        <!-- Legend -->
                        <div class="flex items-center justify-center gap-5 mt-4">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow shadow-rose-500/40"></span>
                                <span class="text-[11px] text-slate-400">{{ __('Alta') }} <strong class="text-rose-400">{{ $priorityBreakdown['high'] }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow shadow-amber-400/40"></span>
                                <span class="text-[11px] text-slate-400">{{ __('Média') }} <strong class="text-amber-400">{{ $priorityBreakdown['medium'] }}</strong></span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 shadow shadow-emerald-400/40"></span>
                                <span class="text-[11px] text-slate-400">{{ __('Baixa') }} <strong class="text-emerald-400">{{ $priorityBreakdown['low'] }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Due This Week -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="calendar-clock" class="w-4 h-4 text-amber-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Prazos Esta Semana') }}</h3>
                        <span class="ml-auto text-xs bg-amber-500/10 text-amber-400 px-2 py-0.5 rounded-full border border-amber-500/20 font-semibold">
                            {{ $tasksDueThisWeek->count() }}
                        </span>
                    </div>
                    @if($tasksDueThisWeek->isEmpty())
                        <div class="flex flex-col items-center justify-center py-8 text-center gap-2">
                            <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                                <i data-lucide="check" class="w-5 h-5 text-emerald-400"></i>
                            </div>
                            <p class="text-xs text-slate-500">{{ __('Nenhum prazo esta semana') }}</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-2 overflow-y-auto max-h-52 custom-scrollbar pr-1">
                            @foreach($tasksDueThisWeek as $task)
                                @php
                                    $isToday = $task->due_date->isToday();
                                    $isTomorrow = $task->due_date->isTomorrow();
                                @endphp
                                <div class="flex items-center gap-3 p-2.5 bg-slate-800/50 rounded-xl border border-slate-700/30 hover:border-slate-600/50 transition">
                                    <div class="p-1.5 rounded-lg {{ $isToday ? 'bg-rose-500/10 border border-rose-500/20' : ($isTomorrow ? 'bg-amber-500/10 border border-amber-500/20' : 'bg-slate-700/50') }}">
                                        <i data-lucide="calendar" class="w-3 h-3 {{ $isToday ? 'text-rose-400' : ($isTomorrow ? 'text-amber-400' : 'text-slate-400') }}"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-200 truncate">{{ $task->title }}</p>
                                        <p class="text-[10px] text-slate-500 truncate">{{ __($task->column->title ?? '') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] font-bold {{ $isToday ? 'text-rose-400' : ($isTomorrow ? 'text-amber-400' : 'text-slate-400') }}">
                                            {{ $isToday ? __('Hoje') : ($isTomorrow ? __('Amanhã') : $task->due_date->format('d/m')) }}
                                        </span>
                                        @if($task->assignee)
                                            <p class="text-[9px] text-slate-600 mt-0.5">{{ $task->assignee->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- ═══ BOTTOM ROW: Boards Overview + Team Workload + Recent Activity ═══ -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Boards Overview -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="layout-grid" class="w-4 h-4 text-indigo-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Visão dos Quadros') }}</h3>
                    </div>
                    @if($boards->isEmpty())
                        <div class="flex flex-col items-center justify-center py-8 text-center gap-2">
                            <p class="text-xs text-slate-500">{{ __('Nenhum quadro criado.') }}</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-3 overflow-y-auto max-h-64 custom-scrollbar pr-1">
                            @php
                                $boardColors = ['from-indigo-500', 'from-violet-500', 'from-sky-500', 'from-emerald-500', 'from-amber-500', 'from-rose-500'];
                            @endphp
                            @foreach($boards as $i => $b)
                                <a href="{{ route('board.show', $b->id) }}" wire:navigate
                                   class="flex flex-col gap-2 p-3 bg-slate-800/40 rounded-xl border border-slate-700/30 hover:border-indigo-500/40 hover:bg-slate-800/70 transition group">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full bg-gradient-to-r {{ $boardColors[$i % count($boardColors)] }} to-transparent"></div>
                                            <span class="text-xs font-semibold text-slate-200 group-hover:text-white truncate max-w-[120px]">{{ $b->title }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-[10px] text-slate-500 font-medium">{{ $b->total_tasks }} {{ __('tarefas') }}</span>
                                            <i data-lucide="arrow-right" class="w-3 h-3 text-slate-600 group-hover:text-indigo-400 transition"></i>
                                        </div>
                                    </div>
                                    @if($b->total_tasks > 0)
                                        @php $pct = round(($b->completed_tasks / $b->total_tasks) * 100); @endphp
                                        <div class="w-full h-1.5 bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-indigo-600 to-indigo-400 rounded-full transition-all duration-700"
                                                 style="width: {{ $pct }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-[9px] text-slate-600">
                                            <span>{{ $pct }}% {{ __('concluído') }}</span>
                                            @if($b->overdue_tasks > 0)
                                                <span class="text-rose-500">{{ $b->overdue_tasks }} {{ __('atrasadas') }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-[10px] text-slate-600">{{ __('Nenhuma tarefa') }}</p>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Team Workload -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="users" class="w-4 h-4 text-violet-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Carga da Equipe') }}</h3>
                    </div>
                    @if($usersStats->isEmpty())
                        <div class="flex flex-col items-center justify-center py-8 text-center gap-2">
                            <p class="text-xs text-slate-500">{{ __('Nenhum membro encontrado.') }}</p>
                        </div>
                    @else
                        @php
                            $avatarColors = ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-sky-500', 'bg-violet-500'];
                        @endphp
                        <div class="flex flex-col gap-3 overflow-y-auto max-h-64 custom-scrollbar pr-1">
                            @foreach($usersStats as $u)
                                <div class="flex items-center gap-3 p-2.5 bg-slate-800/40 rounded-xl border border-slate-700/30">
                                    <div class="w-8 h-8 rounded-full {{ $avatarColors[$u->id % count($avatarColors)] }} flex items-center justify-center text-[10px] font-bold text-white uppercase flex-shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-200 truncate">{{ $u->name }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[9px] text-slate-500">{{ $u->total_tasks }} {{ __('tarefas') }}</span>
                                            @if($u->overdue_tasks > 0)
                                                <span class="text-[9px] text-rose-400 font-semibold">• {{ $u->overdue_tasks }} {{ __('atras.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                        <span class="text-[10px] bg-emerald-500/10 text-emerald-400 px-1.5 py-0.5 rounded font-semibold border border-emerald-500/20">
                                            {{ $u->completed_tasks }} ✓
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg">
                    <div class="flex items-center gap-2 mb-5">
                        <i data-lucide="activity" class="w-4 h-4 text-sky-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Atividade Recente') }}</h3>
                    </div>
                    @if($recentActivities->isEmpty())
                        <div class="flex flex-col items-center justify-center py-8 text-center gap-2">
                            <p class="text-xs text-slate-500">{{ __('Nenhuma atividade registrada.') }}</p>
                        </div>
                    @else
                        <div class="flex flex-col gap-3 overflow-y-auto max-h-64 custom-scrollbar pr-1">
                            @foreach($recentActivities as $activity)
                                @php
                                    $raw = $activity->description;
                                    try {
                                        $data = is_string($raw) ? json_decode($raw, true, 512, JSON_THROW_ON_ERROR) : null;
                                    } catch (\Exception $e) {
                                        $data = null;
                                    }
                                    $actorName = $activity->user?->name ?? __('Sistema');
                                    if ($data && isset($data['key'])) {
                                        // Sanitize: cast every replacement value to string
                                        $params = array_map(
                                            fn($v) => is_array($v) ? json_encode($v) : (string)$v,
                                            array_diff_key($data, ['key' => true])
                                        );
                                        $description = __($data['key'], $params);
                                    } else {
                                        $description = is_string($raw) ? $raw : json_encode($raw);
                                    }
                                @endphp
                                <div class="flex items-start gap-2.5 p-2.5 bg-slate-800/40 rounded-xl border border-slate-700/30">
                                    <div class="w-6 h-6 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-[8px] font-bold text-indigo-300 uppercase flex-shrink-0 mt-0.5">
                                        {{ strtoupper(substr($actorName, 0, 2)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] text-slate-300 leading-tight">
                                            <span class="font-semibold text-white">{{ $actorName }}</span>
                                            {{ $description }}
                                        </p>
                                        <p class="text-[9px] text-slate-600 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </main>
</div>
