<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <aside class="w-full bg-slate-900 border-b border-slate-800 flex max-h-[46dvh] flex-col justify-between flex-shrink-0 z-10 lg:h-full lg:max-h-none lg:w-80 lg:border-b-0 lg:border-r">
        <div class="p-4 sm:p-6 flex flex-col gap-4 sm:gap-6 overflow-y-auto custom-scrollbar">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/identidade-visualpack/taskly_logo_mark.svg') }}" alt="" class="w-10 h-10 flex-shrink-0">
                <div>
                    <h1 class="text-xl font-bold tracking-tight bg-gradient-to-r from-indigo-200 to-white bg-clip-text text-transparent">Taskly</h1>
                    <p class="text-xs text-slate-400">{{ __('Chamados') }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <div class="text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">{{ __('Navegação') }}</div>
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Dashboard') }}</span>
                </a>
                <a href="{{ route('calendar') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="calendar-days" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Agenda') }}</span>
                </a>
                @if($userBoards->isNotEmpty())
                    <a href="{{ route('board.show', $userBoards->first()->id) }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="flex-1">{{ __('Kanban') }}</span>
                    </a>
                @endif
                <a href="{{ route('tickets') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                    <i data-lucide="inbox" class="w-4 h-4 text-indigo-200"></i>
                    <span class="flex-1">{{ __('Chamados') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                </a>
            </div>

            <div class="hidden sm:flex flex-col gap-3">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 tracking-wider uppercase px-2">
                    <span>{{ __('Meus Quadros') }}</span>
                    <i data-lucide="folder" class="w-4 h-4"></i>
                </div>
                @foreach($userBoards as $ub)
                    <a href="{{ route('board.show', $ub->id) }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="truncate flex-1">{{ $ub->title }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="p-4 sm:p-6 border-t border-slate-800 bg-slate-900/60 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center font-bold text-sm text-white uppercase">
                    {{ substr(auth()->user()->name ?? 'A', 0, 2) }}
                </div>
                <div class="min-w-0">
                    <h4 class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Usuário' }}</h4>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-rose-400 p-2 hover:bg-rose-500/10 rounded-xl transition" title="{{ __('Sair') }}">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </aside>

    <main class="min-h-0 min-w-0 flex-1 flex flex-col overflow-hidden">
        <header class="min-h-20 border-b border-slate-900 bg-slate-900/20 px-4 py-4 sm:px-6 lg:px-8 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                    <i data-lucide="inbox" class="w-5 h-5 text-indigo-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white">{{ __('Chamados') }}</h2>
                    <p class="text-xs text-slate-400">{{ __('SLA, responsáveis, quadros e checklist operacional') }}</p>
                </div>
            </div>
            <button type="button" wire:click="openCreateModal" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500">
                <i data-lucide="plus" class="w-4 h-4"></i>
                {{ __('Novo chamado') }}
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                @foreach([
                    ['label' => __('Abertos'), 'value' => $stats['open'], 'icon' => 'circle-dot', 'color' => 'text-sky-400 bg-sky-500/10 border-sky-500/20'],
                    ['label' => __('Em atendimento'), 'value' => $stats['progress'], 'icon' => 'loader', 'color' => 'text-indigo-400 bg-indigo-500/10 border-indigo-500/20'],
                    ['label' => __('Aguardando'), 'value' => $stats['waiting'], 'icon' => 'pause-circle', 'color' => 'text-amber-400 bg-amber-500/10 border-amber-500/20'],
                    ['label' => __('Risco de SLA'), 'value' => $stats['slaRisk'], 'icon' => 'alarm-clock', 'color' => 'text-rose-400 bg-rose-500/10 border-rose-500/20'],
                ] as $stat)
                    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-4">
                        <div class="flex items-center justify-between">
                            <div class="rounded-xl border p-2 {{ $stat['color'] }}">
                                <i data-lucide="{{ $stat['icon'] }}" class="w-4 h-4"></i>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500">{{ $stat['label'] }}</span>
                        </div>
                        <p class="mt-3 text-3xl font-bold text-white">{{ $stat['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="relative z-30 mb-6 flex flex-col gap-3 rounded-2xl border border-slate-800 bg-slate-900/50 p-3 lg:flex-row lg:items-center">
                <div class="relative flex-1">
                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-500"></i>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="{{ __('Buscar por título ou solicitante') }}" class="w-full rounded-xl border border-slate-800 bg-slate-950 py-2.5 pl-9 pr-3 text-sm text-slate-100 placeholder-slate-500 focus:border-indigo-500 focus:outline-none">
                </div>
                <div class="relative flex-shrink-0" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex min-w-[170px] items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}">
                        <span class="truncate">
                            @if($filterStatus === 'open') {{ __('Aberto') }}
                            @elseif($filterStatus === 'progress') {{ __('Em atendimento') }}
                            @elseif($filterStatus === 'waiting') {{ __('Aguardando') }}
                            @elseif($filterStatus === 'resolved') {{ __('Resolvido') }}
                            @else {{ __('Todos os status') }}
                            @endif
                        </span>
                        <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 top-full z-50 mt-1.5 w-56 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40" style="display: none;">
                        @foreach(['' => 'Todos os status', 'open' => 'Aberto', 'progress' => 'Em atendimento', 'waiting' => 'Aguardando', 'resolved' => 'Resolvido'] as $value => $label)
                            <button @click="$wire.set('filterStatus', '{{ $value }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $filterStatus === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <i data-lucide="{{ $value === 'resolved' ? 'check-circle-2' : ($value === 'waiting' ? 'pause-circle' : ($value === 'progress' ? 'loader' : 'circle-dot')) }}" class="h-3.5 w-3.5 text-indigo-400"></i>
                                <span class="truncate">{{ __($label) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="relative flex-shrink-0" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex min-w-[170px] items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}">
                        <span class="truncate">
                            @if($filterPriority === 'high') {{ __('Alta') }}
                            @elseif($filterPriority === 'medium') {{ __('Média') }}
                            @elseif($filterPriority === 'low') {{ __('Baixa') }}
                            @else {{ __('Todas prioridades') }}
                            @endif
                        </span>
                        <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 top-full z-50 mt-1.5 w-52 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40" style="display: none;">
                        @foreach(['' => ['Todas prioridades', 'list-filter', 'text-indigo-400'], 'high' => ['Alta', 'flame', 'text-rose-400'], 'medium' => ['Média', 'minus-circle', 'text-amber-400'], 'low' => ['Baixa', 'check-circle-2', 'text-emerald-400']] as $value => $option)
                            <button @click="$wire.set('filterPriority', '{{ $value }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $filterPriority === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <i data-lucide="{{ $option[1] }}" class="h-3.5 w-3.5 {{ $option[2] }}"></i>
                                <span class="truncate">{{ __($option[0]) }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            @php
                $columns = [
                    'open' => ['label' => __('Aberto'), 'icon' => 'circle-dot'],
                    'progress' => ['label' => __('Em atendimento'), 'icon' => 'loader'],
                    'waiting' => ['label' => __('Aguardando'), 'icon' => 'pause-circle'],
                    'resolved' => ['label' => __('Resolvido'), 'icon' => 'check-circle-2'],
                ];
                $priorityClass = [
                    'high' => 'border-rose-500/30 bg-rose-500/10 text-rose-300',
                    'medium' => 'border-amber-500/30 bg-amber-500/10 text-amber-300',
                    'low' => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300',
                ];
            @endphp
            <div class="grid grid-cols-1 gap-4 xl:grid-cols-4">
                @foreach($columns as $status => $column)
                    @php $columnTickets = $ticketsByStatus->get($status, collect()); @endphp
                    <section class="min-h-96 rounded-2xl border border-slate-800 bg-slate-900/50">
                        <div class="flex items-center justify-between border-b border-slate-800 px-4 py-3">
                            <div class="flex items-center gap-2">
                                <i data-lucide="{{ $column['icon'] }}" class="w-4 h-4 text-indigo-400"></i>
                                <h3 class="text-sm font-bold text-slate-200">{{ $column['label'] }}</h3>
                            </div>
                            <span class="rounded-full bg-slate-800 px-2 py-0.5 text-[10px] font-bold text-slate-400">{{ $columnTickets->count() }}</span>
                        </div>
                        <div class="flex flex-col gap-3 p-3">
                            @forelse($columnTickets as $ticket)
                                @php
                                    $progress = $ticket->checklist_progress;
                                    $slaLate = $ticket->sla_due_at && $ticket->sla_due_at->isPast() && $ticket->status !== 'resolved';
                                @endphp
                                <button wire:click="openTicket({{ $ticket->id }})" class="text-left rounded-xl border border-slate-800 bg-slate-950/60 p-3 transition hover:border-indigo-500/40 hover:bg-slate-950">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-bold text-white">{{ $ticket->title }}</p>
                                            <p class="mt-1 truncate text-xs text-slate-500">{{ $ticket->requester_name ?: __('Sem solicitante') }}</p>
                                        </div>
                                        <span class="rounded-lg border px-2 py-1 text-[10px] font-bold {{ $priorityClass[$ticket->priority] ?? $priorityClass['medium'] }}">{{ __($ticket->priority === 'high' ? 'Alta' : ($ticket->priority === 'low' ? 'Baixa' : 'Média')) }}</span>
                                    </div>
                                    <div class="mt-3 flex items-center justify-between gap-2 text-[10px] text-slate-500">
                                        <span class="inline-flex items-center gap-1 truncate"><i data-lucide="user" class="w-3 h-3"></i>{{ $ticket->assignee?->name ?? __('Sem responsável') }}</span>
                                        @if($ticket->sla_due_at)
                                            <span class="{{ $slaLate ? 'text-rose-400' : 'text-slate-500' }}">{{ $ticket->sla_due_at->format('d/m H:i') }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-slate-800">
                                        <div class="h-full rounded-full bg-indigo-500 transition-all" style="width: {{ $progress }}%"></div>
                                    </div>
                                </button>
                            @empty
                                <div class="rounded-xl border border-dashed border-slate-800 p-6 text-center text-xs text-slate-500">{{ __('Nenhum chamado aqui.') }}</div>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </main>

    @if($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm">
            <div class="w-full max-w-2xl rounded-2xl border border-slate-700 bg-slate-900 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-800 p-5">
                    <h3 class="text-lg font-bold text-white">{{ __('Novo chamado') }}</h3>
                    <button type="button" wire:click="closeCreateModal" class="rounded-xl bg-slate-800 p-2 text-slate-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
                <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2">
                    <input wire:model="form.title" class="sm:col-span-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none" placeholder="{{ __('Título do chamado') }}">
                    <input wire:model="form.requester_name" class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none" placeholder="{{ __('Solicitante') }}">
                    <input wire:model="form.requester_email" class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none" placeholder="{{ __('E-mail') }}">
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}">
                            <span class="truncate">{{ ['portal' => 'Portal', 'email' => 'E-mail', 'whatsapp' => 'WhatsApp', 'phone' => __('Telefone')][$form['origin']] ?? 'Portal' }}</span>
                            <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40" style="display: none;">
                            @foreach(['portal' => 'Portal', 'email' => 'E-mail', 'whatsapp' => 'WhatsApp', 'phone' => 'Telefone'] as $value => $label)
                                <button type="button" @click="$wire.set('form.origin', '{{ $value }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $form['origin'] === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                    <i data-lucide="{{ $value === 'portal' ? 'monitor' : ($value === 'email' ? 'mail' : ($value === 'whatsapp' ? 'message-circle' : 'phone')) }}" class="h-3.5 w-3.5 text-indigo-400"></i>
                                    <span>{{ __($label) }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}">
                            <span class="truncate">{{ $form['priority'] === 'high' ? __('Alta') : ($form['priority'] === 'low' ? __('Baixa') : __('Média')) }}</span>
                            <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40" style="display: none;">
                            @foreach(['high' => ['Alta', 'flame', 'text-rose-400'], 'medium' => ['Média', 'minus-circle', 'text-amber-400'], 'low' => ['Baixa', 'check-circle-2', 'text-emerald-400']] as $value => $option)
                                <button type="button" @click="$wire.set('form.priority', '{{ $value }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $form['priority'] === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                    <i data-lucide="{{ $option[1] }}" class="h-3.5 w-3.5 {{ $option[2] }}"></i>
                                    <span>{{ __($option[0]) }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}">
                            <span class="truncate">{{ $form['assignee_id'] ? $users->firstWhere('id', (int) $form['assignee_id'])?->name : __('Sem responsável') }}</span>
                            <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 max-h-56 overflow-y-auto rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40 custom-scrollbar" style="display: none;">
                            <button type="button" @click="$wire.set('form.assignee_id', ''); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold text-slate-300 transition hover:bg-slate-800/70 hover:text-white"><i data-lucide="user-minus" class="h-3.5 w-3.5 text-slate-400"></i><span>{{ __('Sem responsável') }}</span></button>
                            @foreach($users as $user)
                                <button type="button" @click="$wire.set('form.assignee_id', '{{ $user->id }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ (string) $form['assignee_id'] === (string) $user->id ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"><span class="flex h-4 w-4 items-center justify-center rounded-full bg-slate-800 text-[8px] font-bold uppercase text-slate-300">{{ substr($user->name, 0, 2) }}</span><span class="truncate">{{ $user->name }}</span></button>
                            @endforeach
                        </div>
                    </div>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}">
                            <span class="truncate">{{ $form['board_id'] ? $boards->firstWhere('id', (int) $form['board_id'])?->title : __('Sem quadro vinculado') }}</span>
                            <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 max-h-56 overflow-y-auto rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40 custom-scrollbar" style="display: none;">
                            <button type="button" @click="$wire.set('form.board_id', ''); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold text-slate-300 transition hover:bg-slate-800/70 hover:text-white"><i data-lucide="unlink" class="h-3.5 w-3.5 text-slate-400"></i><span>{{ __('Sem quadro vinculado') }}</span></button>
                            @foreach($boards as $board)
                                <button type="button" @click="$wire.set('form.board_id', '{{ $board->id }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ (string) $form['board_id'] === (string) $board->id ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"><i data-lucide="kanban" class="h-3.5 w-3.5 text-indigo-400"></i><span class="truncate">{{ $board->title }}</span></button>
                            @endforeach
                        </div>
                    </div>
                    <input type="date" wire:model="form.due_date" class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                    <input type="datetime-local" wire:model="form.sla_due_at" class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                    <textarea wire:model="form.description" class="sm:col-span-2 min-h-28 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none" placeholder="{{ __('Descrição do problema, contexto e expectativa') }}"></textarea>
                </div>
                <div class="flex justify-end gap-2 border-t border-slate-800 p-5">
                    <button type="button" wire:click="closeCreateModal" class="rounded-xl border border-slate-800 px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white">{{ __('Cancelar') }}</button>
                    <button type="button" wire:click="createTicket" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">{{ __('Criar chamado') }}</button>
                </div>
            </div>
        </div>
    @endif

    @if($selectedTicket)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm">
            <div class="flex max-h-[90dvh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl border border-slate-700 bg-slate-900 shadow-2xl">
                <div class="flex items-start justify-between gap-4 border-b border-slate-800 p-5">
                    <div class="min-w-0">
                        <h3 class="truncate text-xl font-bold text-white">{{ $selectedTicket->title }}</h3>
                        <p class="mt-1 text-xs text-slate-500">#{{ $selectedTicket->id }} · {{ $selectedTicket->requester_name ?: __('Sem solicitante') }} · {{ ucfirst($selectedTicket->origin) }}</p>
                    </div>
                    <button type="button" wire:click="closeTicket" class="rounded-xl bg-slate-800 p-2 text-slate-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
                <div class="grid min-h-0 grid-cols-1 gap-5 overflow-y-auto p-5 custom-scrollbar lg:grid-cols-[0.9fr_1.1fr]">
                    <div class="space-y-4">
                        <p class="rounded-xl border border-slate-800 bg-slate-950/50 p-4 text-sm leading-relaxed text-slate-300">{{ $selectedTicket->description ?: __('Sem descrição.') }}</p>
                        
                        <!-- Main properties grid -->
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-xs font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}"><span class="truncate">{{ ['open' => __('Aberto'), 'progress' => __('Em atendimento'), 'waiting' => __('Aguardando'), 'resolved' => __('Resolvido')][$selectedTicket->status] ?? __('Aberto') }}</span><i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i></button>
                                <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40" style="display: none;">
                                    @foreach(['open' => 'Aberto', 'progress' => 'Em atendimento', 'waiting' => 'Aguardando', 'resolved' => 'Resolvido'] as $value => $label)
                                        <button type="button" @click="$wire.updateTicketField('status', '{{ $value }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $selectedTicket->status === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"><i data-lucide="{{ $value === 'resolved' ? 'check-circle-2' : ($value === 'waiting' ? 'pause-circle' : ($value === 'progress' ? 'loader' : 'circle-dot')) }}" class="h-3.5 w-3.5 text-indigo-400"></i><span>{{ __($label) }}</span></button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-xs font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}"><span class="truncate">{{ $selectedTicket->priority === 'high' ? __('Alta') : ($selectedTicket->priority === 'low' ? __('Baixa') : __('Média')) }}</span><i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i></button>
                                <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 overflow-hidden rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40" style="display: none;">
                                    @foreach(['high' => ['Alta', 'flame', 'text-rose-400'], 'medium' => ['Média', 'minus-circle', 'text-amber-400'], 'low' => ['Baixa', 'check-circle-2', 'text-emerald-400']] as $value => $option)
                                        <button type="button" @click="$wire.updateTicketField('priority', '{{ $value }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $selectedTicket->priority === $value ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"><i data-lucide="{{ $option[1] }}" class="h-3.5 w-3.5 {{ $option[2] }}"></i><span>{{ __($option[0]) }}</span></button>
                                    @endforeach
                                </div>
                            </div>
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-xs font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}"><span class="truncate">{{ $selectedTicket->assignee?->name ?? __('Sem responsável') }}</span><i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i></button>
                                <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 max-h-52 overflow-y-auto rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40 custom-scrollbar" style="display: none;"><button type="button" @click="$wire.updateTicketField('assignee_id', ''); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold text-slate-300 transition hover:bg-slate-800/70 hover:text-white"><i data-lucide="user-minus" class="h-3.5 w-3.5 text-slate-400"></i><span>{{ __('Sem responsável') }}</span></button>@foreach($users as $user)<button type="button" @click="$wire.updateTicketField('assignee_id', '{{ $user->id }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $selectedTicket->assignee_id === $user->id ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"><span class="truncate">{{ $user->name }}</span></button>@endforeach</div>
                            </div>
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button type="button" @click="open = !open" class="flex w-full items-center justify-between gap-3 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-xs font-semibold text-slate-200 transition hover:border-indigo-500/50" :class="{'border-indigo-500/70 text-white': open}"><span class="truncate">{{ $selectedTicket->board?->title ?? __('Sem quadro') }}</span><i data-lucide="chevron-down" class="h-3.5 w-3.5 text-slate-500 transition-transform" :class="{'rotate-180 text-indigo-400': open}"></i></button>
                                <div x-show="open" x-transition class="absolute left-0 right-0 top-full z-50 mt-1.5 max-h-52 overflow-y-auto rounded-xl border border-slate-700 bg-slate-950 py-1 shadow-2xl shadow-black/40 custom-scrollbar" style="display: none;"><button type="button" @click="$wire.updateTicketField('board_id', ''); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold text-slate-300 transition hover:bg-slate-800/70 hover:text-white"><i data-lucide="unlink" class="h-3.5 w-3.5 text-slate-400"></i><span>{{ __('Sem quadro') }}</span></button>@foreach($boards as $board)<button type="button" @click="$wire.updateTicketField('board_id', '{{ $board->id }}'); open = false" class="flex w-full items-center gap-2 px-3 py-2 text-left text-xs font-semibold transition {{ $selectedTicket->board_id === $board->id ? 'bg-indigo-500/10 text-indigo-300' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}"><i data-lucide="kanban" class="h-3.5 w-3.5 text-indigo-400"></i><span class="truncate">{{ $board->title }}</span></button>@endforeach</div>
                            </div>
                        </div> <!-- Closed the main properties grid -->

                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                                <p class="font-bold uppercase text-slate-500">{{ __('Prazo') }}</p>
                                <p class="mt-1 text-slate-200">{{ $selectedTicket->due_date?->format('d/m/Y') ?? __('Sem prazo') }}</p>
                            </div>
                            <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3">
                                <p class="font-bold uppercase text-slate-500">SLA</p>
                                <p class="mt-1 {{ $selectedTicket->sla_due_at && $selectedTicket->sla_due_at->isPast() && $selectedTicket->status !== 'resolved' ? 'text-rose-400' : 'text-slate-200' }}">{{ $selectedTicket->sla_due_at?->format('d/m/Y H:i') ?? __('Sem SLA') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i data-lucide="list-checks" class="w-4 h-4 text-indigo-400"></i>
                                <h4 class="text-sm font-bold text-white">{{ __('Checklist do atendimento') }}</h4>
                            </div>
                            <span class="rounded-lg bg-slate-800 px-2 py-1 text-xs font-bold text-slate-300">{{ $selectedTicket->checklist_progress }}%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-slate-800">
                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ $selectedTicket->checklist_progress }}%"></div>
                        </div>
                        <div class="flex gap-2">
                            <input wire:model="newChecklistItem" wire:keydown.enter="addChecklistItem" class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm text-white focus:border-indigo-500 focus:outline-none" placeholder="{{ __('Novo item do checklist') }}">
                            <button type="button" wire:click="addChecklistItem" class="rounded-xl bg-indigo-600 px-3 text-white hover:bg-indigo-500"><i data-lucide="plus" class="w-4 h-4"></i></button>
                        </div>
                        <div class="flex flex-col gap-2">
                            @forelse($selectedTicket->checklistItems as $item)
                                <div class="flex items-start gap-3 rounded-xl border {{ $item->is_completed ? 'border-emerald-500/20 bg-emerald-500/5' : 'border-slate-800 bg-slate-950/50' }} p-3">
                                    <button type="button" wire:click="toggleChecklistItem({{ $item->id }})" class="mt-0.5">
                                        <i data-lucide="{{ $item->is_completed ? 'check-circle-2' : 'circle' }}" class="w-5 h-5 {{ $item->is_completed ? 'text-emerald-400' : 'text-slate-500' }}"></i>
                                    </button>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm {{ $item->is_completed ? 'text-slate-500 line-through' : 'text-slate-200' }}">{{ $item->title }}</p>
                                        @if($item->completed_at)
                                            <p class="mt-1 text-[10px] text-slate-600">{{ __('Concluído em') }} {{ $item->completed_at->format('d/m H:i') }}</p>
                                        @endif
                                    </div>
                                    <button type="button" wire:click="deleteChecklistItem({{ $item->id }})" class="text-slate-500 hover:text-rose-400"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-slate-800 p-6 text-center text-xs text-slate-500">{{ __('Nenhum item no checklist.') }}</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
