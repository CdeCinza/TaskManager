<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <x-sidebar :userBoards="$userBoards" activePage="tickets" />

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

        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar animate-fade-in-up">
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
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4">
            <div class="w-full max-w-2xl rounded-2xl border border-slate-700 bg-slate-900 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-800 p-5">
                    <h3 class="text-lg font-bold text-white">{{ __('Novo chamado') }}</h3>
                    <button type="button" wire:click="closeCreateModal" class="rounded-xl bg-slate-800 p-2 text-slate-400 hover:text-white"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
                <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2">
                    <div class="sm:col-span-2 flex flex-col gap-1">
                        <input wire:model="form.title" class="rounded-xl border @error('form.title') border-rose-500 focus:border-rose-500 @else border-slate-800 focus:border-indigo-500 @enderror bg-slate-950 px-3 py-2.5 text-sm text-white focus:outline-none" placeholder="{{ __('Título do chamado') }}">
                        @error('form.title') <span class="text-xs text-rose-500 px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <input wire:model="form.requester_name" class="rounded-xl border @error('form.requester_name') border-rose-500 focus:border-rose-500 @else border-slate-800 focus:border-indigo-500 @enderror bg-slate-950 px-3 py-2.5 text-sm text-white focus:outline-none" placeholder="{{ __('Solicitante') }}">
                        @error('form.requester_name') <span class="text-xs text-rose-500 px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <input wire:model="form.requester_email" class="rounded-xl border @error('form.requester_email') border-rose-500 focus:border-rose-500 @else border-slate-800 focus:border-indigo-500 @enderror bg-slate-950 px-3 py-2.5 text-sm text-white focus:outline-none" placeholder="{{ __('E-mail') }}">
                        @error('form.requester_email') <span class="text-xs text-rose-500 px-1">{{ $message }}</span> @enderror
                    </div>

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
                    <div class="flex flex-col gap-1">
                        <input type="date" wire:model="form.due_date" class="w-full rounded-xl border @error('form.due_date') border-rose-500 focus:border-rose-500 @else border-slate-800 focus:border-indigo-500 @enderror bg-slate-950 px-3 py-2.5 text-sm text-white focus:outline-none">
                        @error('form.due_date') <span class="text-xs text-rose-500 px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <input type="datetime-local" wire:model="form.sla_due_at" class="w-full rounded-xl border @error('form.sla_due_at') border-rose-500 focus:border-rose-500 @else border-slate-800 focus:border-indigo-500 @enderror bg-slate-950 px-3 py-2.5 text-sm text-white focus:outline-none">
                        @error('form.sla_due_at') <span class="text-xs text-rose-500 px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="sm:col-span-2 flex flex-col gap-1">
                        <textarea wire:model="form.description" class="min-h-28 rounded-xl border @error('form.description') border-rose-500 focus:border-rose-500 @else border-slate-800 focus:border-indigo-500 @enderror bg-slate-950 px-3 py-2.5 text-sm text-white focus:outline-none" placeholder="{{ __('Descrição do problema, contexto e expectativa') }}"></textarea>
                        @error('form.description') <span class="text-xs text-rose-500 px-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-slate-800 p-5">
                    <button type="button" wire:click="closeCreateModal" class="rounded-xl border border-slate-800 px-4 py-2 text-sm font-semibold text-slate-300 hover:text-white">{{ __('Cancelar') }}</button>
                    <button type="button" wire:click="createTicket" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">{{ __('Criar chamado') }}</button>
                </div>
            </div>
        </div>
    @endif

    @if($selectedTicket)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 p-4">
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

                        <!-- Attachments Section -->
                        <div class="flex flex-col gap-3 mt-4" x-data="{ isDragging: false }" wire:key="ticket-attachments-{{ $selectedTicket->id }}">
                            <div class="flex items-center gap-2 text-slate-200">
                                <i data-lucide="paperclip" class="w-4 h-4 text-slate-400" wire:ignore></i>
                                <h3 class="font-semibold text-sm">{{ __('Anexos') }}</h3>
                            </div>

                            <!-- Drag and Drop Zone -->
                            <div class="relative border-2 border-dashed rounded-xl p-5 transition-all duration-200 flex flex-col items-center justify-center text-center cursor-pointer"
                                 :class="isDragging ? 'border-indigo-500 bg-indigo-500/10' : 'border-slate-800 bg-slate-950/20 hover:border-slate-700'"
                                 x-on:dragover.prevent="isDragging = true"
                                 x-on:dragleave.prevent="isDragging = false"
                                 x-on:drop.prevent="isDragging = false; @this.uploadMultiple('newAttachments', $event.dataTransfer.files, () => { $wire.uploadAttachments(); }, () => { typeof Swal !== 'undefined' ? Swal.fire({ title: 'Erro de Upload', text: 'Não foi possível fazer o upload. Verifique se o arquivo não excede o limite de tamanho.', icon: 'error', confirmButtonColor: '#4f46e5', background: '#1e293b', color: '#f8fafc', customClass: { popup: 'border border-slate-700 shadow-xl rounded-2xl' } }) : alert('Erro ao fazer upload.'); })">
                                
                                <input type="file" multiple accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip,.rar" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       x-on:change="@this.uploadMultiple('newAttachments', $event.target.files, () => { $wire.uploadAttachments(); }, () => { typeof Swal !== 'undefined' ? Swal.fire({ title: 'Erro de Upload', text: 'Não foi possível fazer o upload. Verifique se o arquivo não excede o limite de tamanho.', icon: 'error', confirmButtonColor: '#4f46e5', background: '#1e293b', color: '#f8fafc', customClass: { popup: 'border border-slate-700 shadow-xl rounded-2xl' } }) : alert('Erro ao fazer upload.'); }); $event.target.value = ''" />

                                <i data-lucide="upload-cloud" class="w-7 h-7 text-slate-500 mb-2"></i>
                                <p class="text-xs text-slate-300 font-semibold">{{ __('Arraste arquivos aqui ou clique para fazer upload') }}</p>
                                <p class="text-[10px] text-slate-500 mt-1">{{ __('Imagem, PDF ou documento (máx. 10MB)') }}</p>
                                
                                <!-- Loading indicator -->
                                <div wire:loading wire:target="newAttachments" class="absolute inset-0 bg-slate-900/80 rounded-xl flex items-center justify-center gap-2 text-xs font-semibold text-indigo-400">
                                    <i data-lucide="loader" class="w-4 h-4 animate-spin"></i>
                                    <span>{{ __('Fazendo upload...') }}</span>
                                </div>
                            </div>

                            <!-- Attachments List -->
                            @if($selectedTicket->attachments && $selectedTicket->attachments->count() > 0)
                                <div class="flex flex-col gap-2.5 mt-1 max-h-48 overflow-y-auto custom-scrollbar pr-1">
                                    @foreach($selectedTicket->attachments as $attachment)
                                        <div class="flex items-center justify-between p-2.5 rounded-xl border border-slate-800 bg-slate-950/40 group hover:border-slate-700 transition">
                                            <div class="flex items-center gap-3 min-w-0">
                                                @if(str_starts_with($attachment->mime_type, 'image/'))
                                                    <a href="{{ $attachment->url }}" target="_blank" class="w-10 h-10 rounded-lg overflow-hidden shrink-0 border border-slate-800 flex items-center justify-center bg-slate-900">
                                                        <img src="{{ $attachment->url }}" alt="{{ $attachment->name }}" class="object-cover w-full h-full">
                                                    </a>
                                                @else
                                                    <div class="w-10 h-10 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center shrink-0">
                                                        @if(str_contains($attachment->mime_type, 'pdf'))
                                                            <i data-lucide="file-text" class="w-5 h-5 text-rose-400"></i>
                                                        @elseif(str_contains($attachment->mime_type, 'zip') || str_contains($attachment->mime_type, 'rar'))
                                                            <i data-lucide="file-archive" class="w-5 h-5 text-amber-400"></i>
                                                        @else
                                                            <i data-lucide="file" class="w-5 h-5 text-indigo-400"></i>
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                <div class="min-w-0">
                                                    <a href="{{ $attachment->url }}" target="_blank" class="text-xs font-semibold text-slate-300 hover:text-white truncate block hover:underline" title="{{ $attachment->name }}">
                                                        {{ $attachment->name }}
                                                    </a>
                                                    <span class="text-[10px] text-slate-500 block">{{ $attachment->formatted_size }}</span>
                                                </div>
                                            </div>

                                            <button x-data x-on:click.stop="confirmAction('{{ __('Excluir este anexo?') }}', () => $wire.deleteAttachment({{ $attachment->id }}), '{{ __('Atenção') }}', '{{ __('Excluir') }}', '{{ __('Cancelar') }}')"
                                                    class="text-slate-500 hover:text-rose-400 p-1.5 rounded transition hover:bg-rose-500/10 shrink-0">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
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
                                        <p class="text-sm {{ $item->is_completed ? 'text-slate-500 line-through' : 'text-slate-200' }}">{{ __($item->title) }}</p>
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
