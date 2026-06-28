<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <x-sidebar :userBoards="$userBoards" activePage="calendar" />

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

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar animate-fade-in-up">
            @php
                $priorityClasses = [
                    'high' => 'border-rose-500/40 bg-rose-500/20 text-rose-400 hover:border-rose-400/60 hover:bg-rose-500/25',
                    'medium' => 'border-amber-500/40 bg-amber-500/20 text-amber-400 hover:border-amber-400/60 hover:bg-amber-500/25',
                    'low' => 'border-emerald-500/40 bg-emerald-500/20 text-emerald-400 hover:border-emerald-400/60 hover:bg-emerald-500/25',
                ];
            @endphp

            @if($viewMode === 'list')
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                    @foreach($listTickets as $ticket)
                        <button wire:click="openTicket({{ $ticket->id }})" class="text-left rounded-xl border border-sky-500/40 bg-sky-500/20 p-4 shadow-sm transition hover:border-sky-400/60 hover:bg-sky-500/25">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-bold text-sky-300 truncate">{{ $ticket->title }}</p>
                                    <p class="text-xs font-medium text-slate-400 truncate">{{ __('Chamado') }} · {{ $ticket->requester_name ?: __('Sem solicitante') }}</p>
                                </div>
                                <span class="text-xs font-bold text-sky-400">{{ ($ticket->due_date ?? $ticket->sla_due_at)?->format('d/m') }}</span>
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
                <div class="-mx-4 overflow-x-auto px-4 pb-2 sm:-mx-6 sm:px-6 md:mx-0 md:px-0 custom-scrollbar">
                    <div class="agenda-calendar-grid grid grid-cols-7 gap-px overflow-hidden rounded-2xl border border-slate-800 bg-slate-800">
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
                            <div class="min-h-28 p-2 sm:min-h-32 {{ $isMuted ? 'bg-slate-900/20' : 'bg-slate-950/70' }} {{ $day->isToday() ? 'ring-1 ring-inset ring-indigo-500/60' : '' }}">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-xs font-bold {{ $day->isToday() ? 'text-indigo-300' : ($isMuted ? 'text-slate-600' : 'text-slate-400') }}">{{ $day->format('d') }}</span>
                                    @if($dayTasks->isNotEmpty() || $dayTickets->isNotEmpty())
                                        <span class="rounded-full bg-slate-800 px-1.5 py-0.5 text-[9px] font-bold text-slate-400">{{ $dayTasks->count() + $dayTickets->count() }}</span>
                                    @endif
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    @foreach($dayTickets->take(2) as $ticket)
                                        <button wire:click="openTicket({{ $ticket->id }})" class="agenda-event-card truncate rounded-lg border border-sky-500/40 bg-sky-500/20 px-2 py-1.5 text-left text-[10px] font-bold text-sky-400 shadow-sm transition hover:border-sky-400/60 hover:bg-sky-500/25">
                                            {{ $ticket->title }}
                                        </button>
                                    @endforeach
                                    @foreach($dayTasks->take(4) as $task)
                                        <button wire:click="openTask({{ $task->id }})" class="agenda-event-card truncate rounded-lg border px-2 py-1.5 text-left text-[10px] font-bold shadow-sm transition {{ $priorityClasses[$task->priority ?? 'medium'] ?? $priorityClasses['medium'] }}">
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
