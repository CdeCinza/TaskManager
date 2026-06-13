<div class="flex h-screen w-screen overflow-hidden bg-slate-950 text-slate-100">
    <!-- SIDEBAR -->
    <aside class="w-80 bg-slate-900 border-r border-slate-800 flex flex-col justify-between flex-shrink-0 z-10">
        <div class="p-6 flex flex-col gap-6 overflow-y-auto">
            <!-- App Brand Header -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                    <i data-lucide="layout-grid" class="w-5 h-5 text-white"></i>
                </div>
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
            <div class="flex flex-col gap-3">
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
        <div class="p-6 border-t border-slate-800 bg-slate-900/60 flex flex-col gap-4">
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
            <div class="pt-4 border-t border-slate-800 flex flex-col items-center gap-2 text-center">
                <p class="text-[10px] text-slate-500 font-medium">
                    {{ __('Desenvolvido por') }} <span class="text-slate-300 font-semibold">Matheus Marques Fernandes Vieira</span>
                </p>
                <div class="flex items-center gap-2 mt-0.5">
                    <a href="https://github.com/CdeCinza" target="_blank" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-[10px] font-semibold">
                        <i data-lucide="github" class="w-3.5 h-3.5 text-indigo-400"></i> GitHub
                    </a>
                    <a href="https://www.linkedin.com/in/matheus-marques-fernandes-vieiracln/" target="_blank" class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-slate-950 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white transition duration-200 text-[10px] font-semibold">
                        <i data-lucide="linkedin" class="w-3.5 h-3.5 text-indigo-400"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Header -->
        <header class="h-20 border-b border-slate-900 bg-slate-900/20 px-8 flex items-center justify-between flex-shrink-0">
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
        <div class="flex-1 overflow-y-auto p-8 custom-scrollbar">

            <!-- ═══ KPI CARDS ═══ -->
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
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
