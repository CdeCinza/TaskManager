<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <aside class="w-full bg-slate-900 border-b border-slate-800 flex max-h-[42dvh] flex-col justify-between flex-shrink-0 z-10 lg:h-full lg:max-h-none lg:w-80 lg:border-b-0 lg:border-r">
        <div class="p-4 sm:p-6 flex flex-col gap-4 sm:gap-6 overflow-y-auto custom-scrollbar">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_mark.svg') }}" alt="" class="w-10 h-10 flex-shrink-0">
                <div>
                    <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-200 to-white bg-clip-text text-transparent">Taskly</h1>
                    <p class="text-xs text-slate-400">{{ __('Agenda') }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <div class="text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">{{ __('Navegação') }}</div>
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Dashboard') }}</span>
                </a>
                <a href="{{ route('calendar') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                    <i data-lucide="calendar-days" class="w-4 h-4 text-indigo-200"></i>
                    <span class="flex-1">{{ __('Agenda') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                </a>
                @if($userBoards->isNotEmpty())
                    <a href="{{ route('board.show', $userBoards->first()->id) }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="flex-1">{{ __('Kanban') }}</span>
                    </a>
                @endif
                <a href="{{ route('tickets') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="inbox" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Chamados') }}</span>
                </a>
                <a href="{{ route('reports') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Relatórios') }}</span>
                </a>
            </div>

            <div class="hidden sm:flex flex-col gap-3">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 tracking-wider uppercase px-2">
                    <span>{{ __('Meus Quadros') }}</span>
                    <i data-lucide="folder" class="w-4 h-4"></i>
                </div>
                @foreach($userBoards as $ub)
                    <a href="{{ route('board.show', $ub->id) }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="truncate flex-1">{{ $ub->title }}</span>
                    </a>
                @endforeach
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
                        <h4 class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? __('Usuário') }}</h4>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
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
                    {{ __('Desenvolvido por') }} <span class="text-slate-300 font-semibold">Matheus Marques</span>
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

    <main class="min-h-0 min-w-0 flex-1 flex flex-col overflow-hidden">
        <header class="border-b border-slate-900 bg-slate-900/20 px-4 py-4 sm:px-6 lg:px-8 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                    <i data-lucide="calendar-days" class="w-5 h-5 text-indigo-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white">{{ __('Agenda') }}</h2>
                    <p class="text-xs text-slate-400">{{ __('Prazos por mês, semana e lista') }}</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button wire:click="previousPeriod" class="p-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 transition">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button wire:click="goToday" class="px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-300 hover:text-white hover:border-slate-700 transition">{{ __('Hoje') }}</button>
                <button wire:click="nextPeriod" class="p-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 transition">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </header>

        <div class="relative z-30 border-b border-slate-900/50 px-4 py-3 sm:px-6 lg:px-8 flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <h3 class="text-lg font-bold text-white">{{ $viewMode === 'week' ? $start->format('d/m') . ' - ' . $end->format('d/m/Y') : ucfirst($date->translatedFormat('F Y')) }}</h3>
                <p class="text-xs text-slate-500">{{ __('Somente tarefas com prazo definido aparecem aqui') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 overflow-visible">
                <div class="flex items-center gap-1 rounded-xl border border-slate-800 bg-slate-950/50 p-1">
                    @foreach(['month' => 'Mês', 'week' => 'Semana', 'list' => 'Lista'] as $mode => $label)
                        <button wire:click="setViewMode('{{ $mode }}')" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $viewMode === $mode ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white' }}">{{ __($label) }}</button>
                    @endforeach
                </div>
                <div class="relative flex-shrink-0" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                            class="flex min-w-[150px] items-center justify-between gap-3 rounded-xl border border-slate-800/80 bg-slate-950 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:border-indigo-500/50 hover:text-white"
                            :class="{'border-indigo-500/70 text-white': open}">
                        <span class="truncate">
                            @if($filterPriority === 'high')
                                {{ __('Alta') }}
                            @elseif($filterPriority === 'medium')
                                {{ __('Média') }}
                            @elseif($filterPriority === 'low')
                                {{ __('Baixa') }}
                            @else
                                {{ __('Todas prioridades') }}
                            @endif
                        </span>
                        <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform duration-200" :class="{'rotate-180 text-indigo-400': open}"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                         class="absolute right-0 top-full z-50 mt-1.5 w-52 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40"
                         style="display: none;">
                        @foreach([
                            '' => ['label' => __('Todas prioridades'), 'icon' => 'list-filter', 'color' => 'text-indigo-400'],
                            'high' => ['label' => __('Alta'), 'icon' => 'flame', 'color' => 'text-rose-400'],
                            'medium' => ['label' => __('Média'), 'icon' => 'minus-circle', 'color' => 'text-amber-400'],
                            'low' => ['label' => __('Baixa'), 'icon' => 'check-circle-2', 'color' => 'text-emerald-400'],
                        ] as $value => $option)
                            <button @click="$wire.set('filterPriority', '{{ $value }}'); open = false; $nextTick(() => window.lucide.createIcons())"
                                    class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $filterPriority === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <i data-lucide="{{ $option['icon'] }}" class="h-3.5 w-3.5 {{ $option['color'] }}"></i>
                                <span class="truncate">{{ $option['label'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="relative flex-shrink-0" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                            class="flex min-w-[170px] items-center justify-between gap-3 rounded-xl border border-slate-800/80 bg-slate-950 px-3 py-2 text-xs font-semibold text-slate-300 transition hover:border-indigo-500/50 hover:text-white"
                            :class="{'border-indigo-500/70 text-white': open}">
                        <span class="truncate">
                            @if($filterBoard === '')
                                {{ __('Todos os quadros') }}
                            @else
                                {{ $userBoards->firstWhere('id', (int) $filterBoard)?->title ?? __('Todos os quadros') }}
                            @endif
                        </span>
                        <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform duration-200" :class="{'rotate-180 text-indigo-400': open}"></i>
                    </button>
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                         class="absolute right-0 top-full z-50 mt-1.5 max-h-64 w-60 overflow-y-auto rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40 custom-scrollbar"
                         style="display: none;">
                        <button @click="$wire.set('filterBoard', ''); open = false; $nextTick(() => window.lucide.createIcons())"
                                class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $filterBoard === '' ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                            <i data-lucide="layout-grid" class="h-3.5 w-3.5 text-indigo-400"></i>
                            <span class="truncate">{{ __('Todos os quadros') }}</span>
                        </button>
                        <div class="my-1 h-px bg-slate-800"></div>
                        @foreach($userBoards as $ub)
                            <button @click="$wire.set('filterBoard', '{{ $ub->id }}'); open = false; $nextTick(() => window.lucide.createIcons())"
                                    class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ (string) $filterBoard === (string) $ub->id ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <i data-lucide="kanban" class="h-3.5 w-3.5 text-indigo-400"></i>
                                <span class="truncate">{{ $ub->title }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar">
            @php
                $priorityClasses = [
                    'high' => 'border-rose-500/30 bg-rose-500/10 text-rose-200',
                    'medium' => 'border-amber-500/30 bg-amber-500/10 text-amber-200',
                    'low' => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-200',
                ];
            @endphp

            @if($viewMode === 'list')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    @foreach($listTickets as $ticket)
                        <button wire:click="openTicket({{ $ticket->id }})" class="text-left rounded-xl border border-sky-500/20 bg-sky-500/10 p-4 hover:border-sky-400/40 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-100 truncate">{{ $ticket->title }}</p>
                                    <p class="text-xs text-sky-200/70 truncate">{{ __('Chamado') }} · {{ $ticket->requester_name ?: __('Sem solicitante') }}</p>
                                </div>
                                <span class="text-xs font-bold text-sky-300">{{ ($ticket->due_date ?? $ticket->sla_due_at)?->format('d/m') }}</span>
                            </div>
                        </button>
                    @endforeach
                    @foreach($listTasks as $task)
                        <button wire:click="openTask({{ $task->id }})" class="text-left rounded-xl border border-slate-800 bg-slate-900/60 p-4 hover:border-indigo-500/40 transition">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-100 truncate">{{ $task->title }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $task->column->board->title }} / {{ $task->column->title }}</p>
                                </div>
                                <span class="text-xs font-bold {{ $task->due_date->isPast() && !$task->due_date->isToday() ? 'text-rose-400' : 'text-indigo-300' }}">{{ $task->due_date->format('d/m') }}</span>
                            </div>
                        </button>
                    @endforeach
                    @if($listTasks->isEmpty() && $listTickets->isEmpty())
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-8 text-center text-sm text-slate-500">{{ __('Nenhum prazo encontrado.') }}</div>
                    @endif
                </div>
            @else
                <div class="grid grid-cols-7 gap-px overflow-hidden rounded-2xl border border-slate-800 bg-slate-800">
                    @foreach(['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'] as $dayName)
                        <div class="bg-slate-900 px-2 py-3 text-center text-[10px] font-bold uppercase tracking-wider text-slate-500">{{ __($dayName) }}</div>
                    @endforeach

                    @for($day = $start->copy(); $day->lte($end); $day->addDay())
                        @php
                            $key = $day->toDateString();
                            $dayTasks = $tasksByDay->get($key, collect());
                            $dayTickets = $ticketsByDay->get($key, collect());
                            $isMuted = $viewMode === 'month' && !$day->isSameMonth($date);
                        @endphp
                        <div class="min-h-32 bg-slate-950/70 p-2 {{ $isMuted ? 'opacity-45' : '' }} {{ $day->isToday() ? 'ring-1 ring-inset ring-indigo-500/60' : '' }}">
                            <div class="mb-2 flex items-center justify-between">
                                <span class="text-xs font-bold {{ $day->isToday() ? 'text-indigo-300' : 'text-slate-400' }}">{{ $day->format('d') }}</span>
                                @if($dayTasks->isNotEmpty() || $dayTickets->isNotEmpty())
                                    <span class="rounded-full bg-slate-800 px-1.5 py-0.5 text-[9px] font-bold text-slate-400">{{ $dayTasks->count() + $dayTickets->count() }}</span>
                                @endif
                            </div>
                            <div class="flex flex-col gap-1.5">
                                @foreach($dayTickets->take(2) as $ticket)
                                    <button wire:click="openTicket({{ $ticket->id }})" class="truncate rounded-lg border border-sky-500/30 bg-sky-500/10 px-2 py-1.5 text-left text-[10px] font-semibold text-sky-200">
                                        {{ $ticket->title }}
                                    </button>
                                @endforeach
                                @foreach($dayTasks->take(4) as $task)
                                    <button wire:click="openTask({{ $task->id }})" class="truncate rounded-lg border px-2 py-1.5 text-left text-[10px] font-semibold {{ $priorityClasses[$task->priority ?? 'medium'] ?? $priorityClasses['medium'] }}">
                                        {{ $task->title }}
                                    </button>
                                @endforeach
                                @if(($dayTasks->count() + $dayTickets->count()) > 6)
                                    <span class="text-[10px] text-slate-500">+{{ ($dayTasks->count() + $dayTickets->count()) - 6 }} {{ __('mais') }}</span>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            @endif
        </div>
    </main>

    @if($selectedTask)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4">
            <div class="w-full max-w-lg rounded-2xl border border-slate-700/70 bg-slate-900 shadow-2xl">
                <div class="flex items-start justify-between gap-4 border-b border-slate-800 p-5">
                    <div class="min-w-0">
                        <h3 class="truncate text-xl font-bold text-white">{{ $selectedTask->title }}</h3>
                        <p class="mt-1 text-xs text-slate-500">{{ $selectedTask->column->board->title }} / {{ $selectedTask->column->title }}</p>
                    </div>
                    <button wire:click="closeTask" class="rounded-xl bg-slate-800 p-2 text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="space-y-4 p-5">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                            <p class="text-[10px] font-bold uppercase text-slate-500">{{ __('Prazo') }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-200">{{ $selectedTask->due_date?->format('d/m/Y') ?? __('Sem prazo') }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                            <p class="text-[10px] font-bold uppercase text-slate-500">{{ __('Responsável') }}</p>
                            <p class="mt-1 truncate text-sm font-semibold text-slate-200">{{ $selectedTask->assignee?->name ?? __('Ninguém') }}</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">{{ $selectedTask->description ?: __('Sem descrição.') }}</p>
                    <a href="{{ route('board.show', $selectedTask->column->board_id) }}" wire:navigate class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                        <i data-lucide="kanban" class="w-4 h-4"></i>
                        {{ __('Abrir no Kanban') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($selectedTicket)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4">
            <div class="w-full max-w-lg rounded-2xl border border-slate-700/70 bg-slate-900 shadow-2xl">
                <div class="flex items-start justify-between gap-4 border-b border-slate-800 p-5">
                    <div class="min-w-0">
                        <h3 class="truncate text-xl font-bold text-white">{{ $selectedTicket->title }}</h3>
                        <p class="mt-1 text-xs text-slate-500">{{ __('Chamado') }} #{{ $selectedTicket->id }} · {{ $selectedTicket->requester_name ?: __('Sem solicitante') }}</p>
                    </div>
                    <button wire:click="closeTicket" class="rounded-xl bg-slate-800 p-2 text-slate-400 hover:text-white">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                <div class="space-y-4 p-5">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                            <p class="text-[10px] font-bold uppercase text-slate-500">{{ __('Prazo') }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-200">{{ $selectedTicket->due_date?->format('d/m/Y') ?? __('Sem prazo') }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                            <p class="text-[10px] font-bold uppercase text-slate-500">SLA</p>
                            <p class="mt-1 text-sm font-semibold {{ $selectedTicket->sla_due_at && $selectedTicket->sla_due_at->isPast() ? 'text-rose-400' : 'text-slate-200' }}">{{ $selectedTicket->sla_due_at?->format('d/m H:i') ?? __('Sem SLA') }}</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">{{ $selectedTicket->description ?: __('Sem descrição.') }}</p>
                    <div class="flex items-center justify-between rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                        <span class="text-xs font-semibold text-slate-400">{{ __('Checklist') }}</span>
                        <span class="text-sm font-bold text-indigo-300">{{ $selectedTicket->checklist_progress }}%</span>
                    </div>
                    <a href="{{ route('tickets') }}" wire:navigate class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition">
                        <i data-lucide="inbox" class="w-4 h-4"></i>
                        {{ __('Abrir chamados') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
