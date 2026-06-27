<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row print:bg-white print:text-black">
    <!-- SIDEBAR (hidden on print) -->
    <aside class="w-full bg-slate-900 border-b border-slate-800 flex max-h-[46dvh] flex-col justify-between flex-shrink-0 z-10 lg:h-full lg:max-h-none lg:w-80 lg:border-b-0 lg:border-r print:hidden">
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
                
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Dashboard') }}</span>
                </a>

                <a href="{{ route('calendar') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="calendar-days" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Agenda') }}</span>
                </a>

                @if($userBoards->isNotEmpty())
                    <a href="{{ route('board.show', $userBoards->first()->id) }}" wire:navigate
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                        <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                        <span class="flex-1">{{ __('Kanban') }}</span>
                    </a>
                @endif

                <a href="{{ route('tickets') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 text-slate-300 hover:bg-slate-800/60 hover:text-white group">
                    <i data-lucide="inbox" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                    <span class="flex-1">{{ __('Chamados') }}</span>
                </a>

                <!-- Relatórios (Ativo) -->
                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 text-indigo-200"></i>
                    <span class="flex-1">{{ __('Relatórios') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                </a>
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
                        <h4 class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? __('Usuário') }}</h4>
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
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="min-h-0 min-w-0 flex-1 flex flex-col overflow-hidden print:overflow-visible print:h-auto print:w-full">
        <!-- Header -->
        <header class="min-h-20 border-b border-slate-900 bg-slate-900/20 px-4 py-4 sm:px-6 lg:px-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between flex-shrink-0 print:border-b-0 print:bg-white print:px-0 print:py-2">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 print:hidden">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-400"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight text-white print:text-black">{{ __('Relatórios Analíticos') }}</h2>
                    <p class="text-xs text-slate-400 print:text-slate-600">{{ __('Desempenho operacional, tarefas e controle de SLA') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3 print:hidden">
                <!-- Action Button for PDF Print -->
                <button onclick="window.print()" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-lg shadow-indigo-600/20 transition duration-200">
                    <i data-lucide="printer" class="w-4 h-4"></i>
                    {{ __('Exportar PDF / Imprimir') }}
                </button>

                <!-- Language Selector -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open"
                            class="flex items-center gap-2 bg-slate-850 hover:bg-slate-850/80 text-slate-300 hover:text-white px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700/60 transition duration-200 group">
                        <i data-lucide="globe" class="w-3.5 h-3.5 text-indigo-400 group-hover:text-white"></i>
                        <span>
                            @if(app()->getLocale() === 'en') English @elseif(app()->getLocale() === 'es') Español @else Português @endif
                        </span>
                        <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500 group-hover:text-indigo-400 transition-transform" :class="{'rotate-180': open}"></i>
                    </button>
                    <div x-show="open" class="absolute top-full mt-1.5 right-0 w-36 bg-slate-800 border border-slate-700 rounded-xl shadow-xl overflow-hidden z-50 py-1" style="display: none;">
                        <button wire:click="setLocale('pt_BR')" @click="open = false" class="w-full text-left px-3 py-2 text-xs text-slate-300 hover:bg-slate-750">Português</button>
                        <button wire:click="setLocale('en')" @click="open = false" class="w-full text-left px-3 py-2 text-xs text-slate-300 hover:bg-slate-750">English</button>
                        <button wire:click="setLocale('es')" @click="open = false" class="w-full text-left px-3 py-2 text-xs text-slate-300 hover:bg-slate-750">Español</button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Filters sub-header (hidden on print) -->
        <div class="bg-slate-900/10 border-b border-slate-900/50 px-4 py-3.5 sm:px-6 lg:px-8 flex flex-col sm:flex-row gap-3 items-center justify-between flex-shrink-0 print:hidden">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-medium">{{ __('Período') }}:</span>
                <div class="flex items-center gap-1 bg-slate-950/40 p-1 border border-slate-800/80 rounded-xl">
                    <button wire:click="setPreset('7')" class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition {{ $filterPreset === '7' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">{{ __('7 dias') }}</button>
                    <button wire:click="setPreset('30')" class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition {{ $filterPreset === '30' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">{{ __('30 dias') }}</button>
                    <button wire:click="setPreset('this_month')" class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition {{ $filterPreset === 'this_month' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">{{ __('Este Mês') }}</button>
                    <button wire:click="setPreset('all')" class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition {{ $filterPreset === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">{{ __('Tudo') }}</button>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="date" wire:model.live="startDate" class="bg-slate-950 border border-slate-850 rounded-xl px-3 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
                <span class="text-slate-500 text-xs">{{ __('até') }}</span>
                <input type="date" wire:model.live="endDate" class="bg-slate-950 border border-slate-850 rounded-xl px-3 py-1.5 text-xs text-slate-200 focus:outline-none focus:border-indigo-500">
            </div>
        </div>

        <!-- Scrollable content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 custom-scrollbar print:overflow-visible print:p-0 print:h-auto">
            <!-- Printing Header Info -->
            <div class="hidden print:block mb-8 border-b pb-4">
                <h1 class="text-2xl font-bold">{{ __('Taskly - Relatório Operacional') }}</h1>
                <p class="text-sm text-slate-600 mt-1">{{ __('Período selecionado:') }} {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} {{ __('até') }} {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                <p class="text-xs text-slate-500">{{ __('Gerado em:') }} {{ now()->format('d/m/Y H:i') }} {{ __('por') }} {{ auth()->user()->name }}</p>
            </div>

            <!-- ═══ KPI CARDS ═══ -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8 print:grid-cols-4 print:gap-2">
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-2 shadow-lg print:border print:bg-white print:p-3">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ __('Total de Tarefas') }}</span>
                    <p class="text-3xl font-bold text-white print:text-black">{{ $totalTasks }}</p>
                    <p class="text-xs text-slate-500">{{ __('Criadas no período') }}</p>
                </div>
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-2 shadow-lg print:border print:bg-white print:p-3">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ __('Tarefas Entregues no Prazo') }}</span>
                    <p class="text-3xl font-bold text-emerald-400">{{ $completedOnTime }}</p>
                    <p class="text-xs text-slate-500">{{ __('Taxa de pontualidade: ') }}{{ $totalTasks > 0 ? round(($completedOnTime / ($completedOnTime + $completedLate ?: 1)) * 100) : 0 }}%</p>
                </div>
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-2 shadow-lg print:border print:bg-white print:p-3">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ __('Total de Chamados') }}</span>
                    <p class="text-3xl font-bold text-white print:text-black">{{ $totalTickets }}</p>
                    <p class="text-xs text-slate-500">{{ __('Abertos no período') }}</p>
                </div>
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col gap-2 shadow-lg print:border print:bg-white print:p-3">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ __('Chamados Resolvidos no Prazo SLA') }}</span>
                    <p class="text-3xl font-bold text-indigo-400">{{ $resolvedOnTime }}</p>
                    <p class="text-xs text-slate-500">{{ __('Meta de conformidade SLA') }}</p>
                </div>
            </div>

            <!-- ═══ GRAPHS ROW ═══ -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8 print:grid-cols-2 print:gap-4 print:page-break-inside-avoid">
                <!-- Task Efficiency Chart Container -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg print:border print:bg-white"
                     x-data="{
                        chart: null,
                        init() {
                            if (this.chart) this.chart.destroy();
                            const ctx = this.$refs.taskChart.getContext('2d');
                            this.chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['{{ __('No Prazo') }}', '{{ __('Com Atraso') }}', '{{ __('Pendente Ativo') }}', '{{ __('Pendente Atrasado') }}'],
                                    datasets: [{
                                        data: [{{ $completedOnTime }}, {{ $completedLate }}, {{ $pendingActive }}, {{ $pendingOverdue }}],
                                        backgroundColor: ['#10b981', '#ef4444', '#6366f1', '#f59e0b'],
                                        borderWidth: 0
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'right',
                                            labels: {
                                                color: document.documentElement.classList.contains('theme-light') ? '#0f172a' : '#f8fafc',
                                                font: { family: 'Outfit, sans-serif', size: 11 }
                                            }
                                        },
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
                                }
                            });
                        }
                     }" @theme-changed.window="init()" wire:ignore>
                    <h3 class="text-sm font-semibold text-slate-200 mb-4 print:text-black">{{ __('Status de Entrega das Tarefas') }}</h3>
                    <div class="relative h-60">
                        <canvas x-ref="taskChart"></canvas>
                    </div>
                </div>

                <!-- Ticket SLA Resolution Chart -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg print:border print:bg-white"
                     x-data="{
                        chart: null,
                        init() {
                            if (this.chart) this.chart.destroy();
                            const ctx = this.$refs.ticketChart.getContext('2d');
                            this.chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['{{ __('SLA Atendido') }}', '{{ __('SLA Atrasado') }}', '{{ __('Aberto no Prazo') }}', '{{ __('Aberto Atrasado') }}'],
                                    datasets: [{
                                        data: [{{ $resolvedOnTime }}, {{ $resolvedLate }}, {{ $unresolvedActive }}, {{ $unresolvedOverdue }}],
                                        backgroundColor: ['#10b981', '#f43f5e', '#6366f1', '#fbbf24'],
                                        borderWidth: 0
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'right',
                                            labels: {
                                                color: document.documentElement.classList.contains('theme-light') ? '#0f172a' : '#f8fafc',
                                                font: { family: 'Outfit, sans-serif', size: 11 }
                                            }
                                        },
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
                                                    return ` ${value} chamados (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                     }" @theme-changed.window="init()" wire:ignore>
                    <h3 class="text-sm font-semibold text-slate-200 mb-4 print:text-black">{{ __('Desempenho de SLA dos Chamados') }}</h3>
                    <div class="relative h-60">
                        <canvas x-ref="ticketChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- ═══ TEAM PERFORMANCE TABLE ═══ -->
            <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg mb-8 print:border print:bg-white print:page-break-inside-avoid">
                <div class="flex items-center gap-2 mb-4">
                    <i data-lucide="users" class="w-4 h-4 text-indigo-400 print:hidden"></i>
                    <h3 class="text-sm font-semibold text-slate-200 print:text-black">{{ __('Produtividade da Equipe (Chamados)') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="border-b border-slate-800 text-slate-500 font-bold uppercase print:border-b print:text-slate-700">
                                <th class="pb-3">{{ __('Membro') }}</th>
                                <th class="pb-3 text-center">{{ __('Chamados Atribuídos') }}</th>
                                <th class="pb-3 text-center">{{ __('Resolvidos') }}</th>
                                <th class="pb-3 text-center">{{ __('Conformidade SLA') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 print:divide-y">
                            @forelse($members as $member)
                                <tr class="text-slate-300 print:text-slate-800">
                                    <td class="py-3.5 flex items-center gap-2">
                                        <span class="w-6 h-6 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-[10px] text-white print:hidden">
                                            {{ strtoupper(substr($member->name, 0, 2)) }}
                                        </span>
                                        <span class="font-semibold">{{ $member->name }}</span>
                                    </td>
                                    <td class="py-3.5 text-center font-semibold">{{ $member->total_tickets }}</td>
                                    <td class="py-3.5 text-center font-semibold text-emerald-400 print:text-emerald-700">{{ $member->resolved_tickets }}</td>
                                    <td class="py-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $member->sla_compliance >= 80 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($member->sla_compliance >= 50 ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20') }}">
                                            {{ $member->sla_compliance }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-500">{{ __('Nenhuma atividade de chamados encontrada para os filtros selecionados.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ═══ ADDITIONAL METRICS ROW ═══ -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 print:grid-cols-2 print:gap-4 print:page-break-inside-avoid">
                <!-- Ticket Origin breakdown -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg print:border print:bg-white">
                    <h3 class="text-sm font-semibold text-slate-200 mb-4 print:text-black">{{ __('Origem dos Chamados Abertos') }}</h3>
                    <div class="flex flex-col gap-3.5">
                        @foreach($originsBreakdown as $origin => $count)
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs text-slate-300 font-semibold capitalize print:text-slate-800">{{ __($origin === 'portal' ? 'Portal' : ($origin === 'phone' ? 'Telefone' : $origin)) }}</span>
                                    <span class="text-xs font-bold text-slate-200 print:text-slate-900">{{ $count }}</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden print:bg-slate-200">
                                    <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $totalTickets > 0 ? ($count / $totalTickets) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Board Completion metrics -->
                <div class="bg-slate-900/60 border border-slate-800/80 rounded-2xl p-5 shadow-lg print:border print:bg-white">
                    <h3 class="text-sm font-semibold text-slate-200 mb-4 print:text-black">{{ __('Taxa de Conclusão por Quadro') }}</h3>
                    <div class="flex flex-col gap-3.5">
                        @forelse($boards as $board)
                            @php
                                $rate = $board->total_tasks > 0 ? round(($board->completed_tasks / $board->total_tasks) * 100) : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs text-slate-300 font-semibold print:text-slate-800">{{ $board->title }}</span>
                                    <span class="text-xs font-bold text-indigo-400">{{ $rate }}%</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden print:bg-slate-200">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $rate }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-xs text-slate-500 py-6">{{ __('Nenhum quadro de tarefas registrado.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
