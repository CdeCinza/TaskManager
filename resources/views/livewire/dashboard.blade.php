<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <x-sidebar :userBoards="$userBoards" activePage="dashboard" />

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
                <x-language-selector />

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
                    <div class="flex items-center gap-3">
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
                    <div class="flex items-center gap-3">
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
                    <div class="flex items-center gap-3">
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
                    <div class="flex items-center gap-3">
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
                    <div class="flex items-center gap-3">
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
                    <div class="flex items-center gap-3">
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
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-sky-500/10 border border-sky-500/20">
                            <i data-lucide="inbox" class="w-4 h-4 text-sky-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">{{ __('Chamados') }}</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-white tracking-tight">{{ $ticketStats['open'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Em aberto') }}</p>
                    </div>
                </div>

                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-3 shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <i data-lucide="alarm-clock" class="w-4 h-4 text-rose-400"></i>
                        </div>
                        <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">SLA</span>
                    </div>
                    <div>
                        <p class="text-3xl font-bold {{ $ticketStats['slaRisk'] > 0 ? 'text-rose-400' : 'text-white' }} tracking-tight">{{ $ticketStats['slaRisk'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ __('Chamados em risco') }}</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
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
                        <i data-lucide="alarm-clock" class="w-4 h-4 text-sky-400"></i>
                        <h3 class="text-sm font-semibold text-slate-200">{{ __('Chamados próximos') }}</h3>
                    </div>
                    <div class="flex flex-col gap-2 max-h-56 overflow-y-auto custom-scrollbar pr-1">
                        @forelse($ticketsDueSoon as $ticket)
                            <a href="{{ route('tickets') }}" wire:navigate class="rounded-xl bg-slate-800/40 border border-slate-700/30 p-3 hover:border-sky-500/30 transition">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="truncate text-xs font-semibold text-slate-200">{{ $ticket->title }}</p>
                                    <span class="text-[10px] font-bold {{ $ticket->sla_due_at && $ticket->sla_due_at->isPast() ? 'text-rose-400' : 'text-sky-400' }}">
                                        {{ ($ticket->sla_due_at ?? $ticket->due_date)?->format('d/m') }}
                                    </span>
                                </div>
                                <p class="mt-1 truncate text-[10px] text-slate-500">{{ $ticket->assignee?->name ?? __('Sem responsável') }} · {{ $ticket->board?->title ?? __('Sem quadro') }}</p>
                            </a>
                        @empty
                            <p class="py-6 text-center text-xs text-slate-500">{{ __('Nenhum chamado crítico.') }}</p>
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
                            @endphp
                            <div class="rounded-xl bg-slate-800/40 border border-slate-700/30 p-3">
                                <p class="text-[11px] text-slate-300 leading-tight">
                                    <span class="font-semibold text-white">{{ $actorName }}</span>
                                    {{ $activity->formatted_description }}
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
                                    ctx.fillStyle = document.documentElement.classList.contains('theme-light') ? '#0f172a' : '#f8fafc';
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
                                            backgroundColor: '#0f172a',
                                            borderColor: '#1e293b',
                                            borderWidth: 1,
                                            titleColor: '#ffffff',
                                            bodyColor: '#cbd5e1',
                                            titleFont: { family: 'Outfit, sans-serif', size: 12, weight: 'bold' },
                                            bodyFont: { family: 'Outfit, sans-serif', size: 11 },
                                            padding: 10,
                                            cornerRadius: 8,
                                            displayColors: true,
                                            usePointStyle: true,
                                            boxWidth: 8,
                                            boxHeight: 8,
                                            boxPadding: 4,
                                            callbacks: {
                                                label: function(context) {
                                                    const total = context.dataset.data.reduce((a, b) => a + b, 0) || 1;
                                                    const value = context.parsed;
                                                    const percentage = Math.round((value / total) * 100);
                                                    return ` ${value} tarefas (${percentage}%)`;
                                                }
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
                                    $actorName = $activity->user?->name ?? __('Sistema');
                                @endphp
                                <div class="flex items-start gap-2.5 p-2.5 bg-slate-800/40 rounded-xl border border-slate-700/30">
                                    <div class="w-6 h-6 rounded-full bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center text-[8px] font-bold text-indigo-300 uppercase flex-shrink-0 mt-0.5">
                                        {{ strtoupper(substr($actorName, 0, 2)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] text-slate-300 leading-tight">
                                            <span class="font-semibold text-white">{{ $actorName }}</span>
                                            {{ $activity->formatted_description }}
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
