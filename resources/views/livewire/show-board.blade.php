<div class="flex h-dvh w-full flex-col overflow-hidden bg-slate-950 text-slate-100 lg:flex-row">
    <x-sidebar :userBoards="$userBoards" activePage="kanban" :currentBoardId="$board->id">
        <x-slot:extraContent>
            {{-- Quick Actions Section --}}
            <div class="hidden sm:flex flex-col gap-4 border-t border-slate-800 pt-4">
                {{-- Add Board Action --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">{{ __('Novo Quadro') }}</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               wire:model="newBoardTitle"
                               wire:keydown.enter="createBoard"
                               placeholder="{{ __('Título do quadro...') }}" 
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                        <button wire:click="createBoard" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-xl transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Add Column Action --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">{{ __('Nova Coluna') }}</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               wire:model="newColumnTitle"
                               wire:keydown.enter="createColumn"
                               placeholder="{{ __('Título da coluna...') }}" 
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                        <button wire:click="createColumn" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-xl transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </x-slot:extraContent>
    </x-sidebar>

    <!-- MAIN KANBAN CONTENT -->
    <main class="min-h-0 min-w-0 flex-1 flex flex-col overflow-hidden">
        <!-- Main Navbar Header -->
        <header class="min-h-20 border-b border-slate-900 bg-slate-900/20 px-4 py-4 sm:px-6 lg:px-8 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between flex-shrink-0">
            <div x-data="{ isEditing: false, title: @js($board->title) }" class="flex min-w-0 items-center gap-4">
                <i data-lucide="kanban" class="w-6 h-6 text-indigo-400"></i>
                
                <div x-show="!isEditing" class="flex min-w-0 items-center gap-3">
                    <h2 class="truncate text-xl sm:text-2xl font-bold tracking-tight text-white">{{ $board->title }}</h2>
                    <button x-on:click="isEditing = true; title = @js($board->title); $nextTick(() => $refs.boardTitleInput.focus())" 
                            class="text-slate-400 hover:text-white transition duration-200" title="{{ __('Renomear Quadro') }}">
                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                    </button>
                </div>
                
                <div x-show="isEditing" x-cloak class="flex items-center gap-2">
                    <input x-ref="boardTitleInput" 
                           type="text" 
                           x-model="title" 
                           x-on:keydown.enter="isEditing = false; $wire.renameBoard(title)" 
                           x-on:keydown.escape="isEditing = false; title = @js($board->title)" 
                           class="bg-slate-950 border border-slate-800 rounded-xl px-3 py-1.5 text-lg font-semibold focus:outline-none focus:border-indigo-500 text-slate-100">
                    <button x-on:click="isEditing = false; $wire.renameBoard(title)" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-xl transition">
                        <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                    <button x-on:click="isEditing = false; title = @js($board->title)" class="bg-slate-800 hover:bg-slate-700 text-white p-2 rounded-xl transition">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                <button wire:click="exportCsv" 
                        class="flex items-center gap-2 bg-slate-850 hover:bg-slate-850/80 text-slate-300 hover:text-white px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700/60 transition duration-200">
                    <i data-lucide="download" class="w-3.5 h-3.5 text-indigo-400"></i>
                    {{ __('Exportar CSV') }}
                </button>
                <button wire:click="openTrashModal" 
                        class="flex items-center gap-2 bg-slate-850 hover:bg-slate-850/80 text-slate-300 hover:text-white px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-700/60 transition duration-200 relative">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5 text-rose-400"></i>
                    {{ __('Lixeira') }}
                    @if($trashedTasks->count() > 0)
                        <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-rose-600 text-[9px] font-bold text-white border border-slate-900 shadow">
                            {{ $trashedTasks->count() }}
                        </span>
                    @endif
                </button>

                <x-language-selector />

                <div class="h-6 w-px bg-slate-800"></div>
                @php
                    $avatarColors = ['bg-indigo-500', 'bg-emerald-500', 'bg-amber-500', 'bg-rose-500', 'bg-sky-500', 'bg-violet-500'];
                @endphp
                <div class="flex -space-x-2">
                    @foreach($users->take(5) as $user)
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" 
                                    class="w-8 h-8 rounded-full border-2 border-slate-950 {{ $avatarColors[$user->id % count($avatarColors)] }} flex items-center justify-center text-[10px] font-bold text-white uppercase transition-transform hover:scale-110 focus:outline-none" 
                                    title="{{ $user->name }}">
                                {{ substr($user->name, 0, 2) }}
                            </button>
                            
                            <!-- Profile Popover -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                 class="absolute top-full mt-2 left-1/2 -translate-x-1/2 w-56 bg-slate-800 border border-slate-700 rounded-xl shadow-2xl p-4 z-50 flex flex-col items-center text-center gap-3"
                                 style="display: none;">
                                 
                                <div class="w-12 h-12 rounded-full {{ $avatarColors[$user->id % count($avatarColors)] }} flex items-center justify-center text-sm font-bold text-white uppercase shadow-inner">
                                    {{ substr($user->name, 0, 2) }}
                                </div>
                                
                                <div class="overflow-hidden w-full">
                                    <h4 class="text-sm font-semibold text-white truncate">{{ $user->name }}</h4>
                                    <p class="text-xs text-slate-400 truncate mt-0.5">{{ $user->email }}</p>
                                </div>
                                
                                <div class="w-full border-t border-slate-700/50 pt-2 mt-1">
                                    <span class="text-[10px] bg-indigo-500/10 text-indigo-400 px-2 py-1 rounded-full font-medium border border-indigo-500/20">
                                        {{ __('Membro') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($users->count() > 5)
                        <div class="w-8 h-8 rounded-full border-2 border-slate-950 bg-slate-800 flex items-center justify-center text-[9px] font-bold text-slate-400 cursor-help" title="{{ $users->count() - 5 }} {{ __('mais') }}">
                            +{{ $users->count() - 5 }}
                        </div>
                    @endif
                </div>
                <div class="h-6 w-px bg-slate-800"></div>
                <span class="text-xs bg-indigo-500/10 text-indigo-400 px-3 py-1.5 rounded-full font-medium border border-indigo-500/20">
                    {{ $board->columns->count() }} {{ __('Colunas') }}
                </span>
            </div>
        </header>

        <!-- Filters sub-header -->
        <div class="bg-slate-900/10 border-b border-slate-900/50 px-4 py-3.5 sm:px-6 lg:px-8 flex flex-col items-stretch justify-between gap-3 flex-shrink-0 xl:flex-row xl:items-center">
            <!-- Search bar -->
            <div class="relative w-full xl:w-72">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                <input wire:model.live="search" 
                       type="text" 
                       placeholder="{{ __('Buscar tarefas...') }}" 
                       class="w-full bg-slate-950 border border-slate-800/80 rounded-xl pl-10 pr-4 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500 transition">
            </div>

            <!-- Filter Buttons/Dropdowns -->
            <div class="flex items-center gap-3 overflow-x-auto pb-1 custom-scrollbar xl:overflow-visible xl:pb-0">
                <!-- Priority filter buttons -->
                <div class="flex items-center gap-1.5 bg-slate-950/40 p-1 border border-slate-800/80 rounded-xl">
                    <button wire:click="$set('filterPriority', '')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === '' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                        {{ __('Todas') }}
                    </button>
                    <button wire:click="$set('filterPriority', 'low')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === 'low' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-emerald-400' }}">
                        {{ __('Baixa') }}
                    </button>
                    <button wire:click="$set('filterPriority', 'medium')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === 'medium' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:text-amber-400' }}">
                        {{ __('Média') }}
                    </button>
                    <button wire:click="$set('filterPriority', 'high')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === 'high' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/20' : 'text-slate-400 hover:text-rose-400' }}">
                        {{ __('Alta') }}
                    </button>
                </div>

                <!-- Assignee filter dropdown -->
                <div class="flex items-center gap-2">
                    <label class="text-xs text-slate-500 font-medium">{{ __('Responsável') }}:</label>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center justify-between min-w-[160px] bg-slate-950 border border-slate-800/80 rounded-xl px-3 py-2 text-xs font-semibold focus:outline-none text-slate-300 transition group hover:border-indigo-500/50 hover:text-white"
                                :class="{'border-indigo-500/70 text-white': open}">
                            <span class="truncate">
                                @if($filterAssignee === '')
                                    {{ __('Todos') }}
                                @elseif($filterAssignee === 'unassigned')
                                    {{ __('Sem Responsável') }}
                                @else
                                    {{ (string)($users->firstWhere('id', $filterAssignee)->name ?? __('Todos')) }}
                                @endif
                            </span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-500 group-hover:text-indigo-400 transition-transform duration-200" :class="{'rotate-180 text-indigo-400': open}"></i>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                             class="absolute top-full mt-1.5 right-0 w-56 bg-slate-950 border border-slate-700 rounded-xl shadow-2xl shadow-black/40 overflow-hidden z-50 py-1"
                             style="display: none;">
                            <button @click="$wire.set('filterAssignee', ''); open = false; $nextTick(() => window.lucide.createIcons())" 
                                    class="w-full text-left px-3 py-2 text-xs font-semibold transition-colors flex items-center gap-2 {{ $filterAssignee === '' ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <i data-lucide="users" class="w-3.5 h-3.5"></i> {{ __('Todos') }}
                            </button>
                            <button @click="$wire.set('filterAssignee', 'unassigned'); open = false; $nextTick(() => window.lucide.createIcons())" 
                                    class="w-full text-left px-3 py-2 text-xs font-semibold transition-colors flex items-center gap-2 {{ $filterAssignee === 'unassigned' ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                <i data-lucide="user-minus" class="w-3.5 h-3.5"></i> {{ __('Sem Responsável') }}
                            </button>
                            <div class="h-px bg-slate-700/50 my-1"></div>
                            @foreach($users as $user)
                                <button @click="$wire.set('filterAssignee', '{{ $user->id }}'); open = false; $nextTick(() => window.lucide.createIcons())" 
                                        class="w-full text-left px-3 py-2 text-xs font-semibold transition-colors flex items-center gap-2 {{ $filterAssignee == $user->id ? 'text-indigo-300 bg-indigo-500/10' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                                    <span class="w-4 h-4 rounded-full bg-slate-700 flex items-center justify-center text-[8px] font-bold text-slate-300 shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </span>
                                    <span class="truncate">{{ $user->name }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columns Area (Horizontal Scroll) -->
        <div class="flex-1 overflow-x-auto p-4 sm:p-6 lg:p-8 flex gap-4 sm:gap-6 items-start custom-scrollbar animate-fade-in-up">
            @foreach($columns as $column)
                <div wire:key="column-{{ $column->id }}" class="w-[min(20rem,calc(100vw-2rem))] sm:w-80 bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col flex-shrink-0 max-h-full shadow-lg">
                    <!-- Column Header -->
                    <div class="flex items-center justify-between mb-4 px-1">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-2.5 h-2.5 rounded-full {{ ['bg-indigo-400', 'bg-amber-400', 'bg-sky-400', 'bg-emerald-400'][$loop->index % 4] }} flex-shrink-0"></span>
                            <h3 class="font-bold text-slate-200 tracking-wide truncate">{{ __($column->title) }}</h3>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button x-data x-on:click="confirmAction('{{ __('Tem certeza que deseja excluir esta coluna e todas as suas tarefas?') }}', () => $wire.deleteColumn({{ $column->id }}), '{{ __('Atenção') }}', '{{ __('Sim, confirmar!') }}', '{{ __('Cancelar') }}')" 
                                    class="text-slate-500 hover:text-rose-400 p-1 rounded transition hover:bg-rose-500/10">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                            </button>
                            <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded-full font-semibold">
                                {{ $column->tasks->count() }}
                            </span>
                        </div>
                    </div>

                    <!-- Task Cards Container -->
                    <div class="space-y-3 overflow-y-auto pr-1 flex-1 min-h-[150px] sortable-column" data-column-id="{{ $column->id }}">
                        @foreach($column->tasks as $task)
                            <div wire:key="task-{{ $task->id }}"
                                 wire:click="openTaskModal({{ $task->id }})" 
                                 class="bg-slate-800/80 hover:bg-slate-850 border border-slate-700/30 rounded-xl p-3.5 shadow-md hover:shadow-lg transition duration-200 cursor-grab active:cursor-grabbing group sortable-task hover:border-slate-600/50" 
                                 data-task-id="{{ $task->id }}">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="font-semibold text-sm text-slate-100 group-hover:text-white leading-tight transition">{{ $task->title }}</h4>
                                    <div class="flex items-center gap-1">
                                        <button x-data x-on:click.stop="confirmAction('{{ __('Deseja excluir esta tarefa?') }}', () => $wire.deleteTask({{ $task->id }}), '{{ __('Atenção') }}', '{{ __('Sim, confirmar!') }}', '{{ __('Cancelar') }}')"
                                                class="text-slate-500 hover:text-rose-400 p-0.5 rounded transition opacity-0 group-hover:opacity-100">
                                            <i data-lucide="trash" class="w-3.5 h-3.5"></i>
                                        </button>
                                        <div @click.stop class="cursor-grab text-slate-500 opacity-0 group-hover:opacity-100 transition">
                                            <i data-lucide="grip-vertical" class="w-4 h-4"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($task->description)
                                    <p class="text-xs text-slate-400 mt-2 line-clamp-3 leading-relaxed">{{ $task->description }}</p>
                                @endif

                                <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-700/30">
                                    <div class="flex items-center gap-3 text-slate-400">
                                        <div class="flex items-center gap-1.5" title="{{ $task->created_at->diffForHumans() }}">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-500"></i>
                                            <span class="text-[10px]">{{ $task->created_at->format('d/m') }}</span>
                                        </div>
                                        @if($task->due_date)
                                            @php
                                                $isOverdue = $task->due_date->isPast() && !$task->due_date->isToday() && $column->title !== 'Concluído';
                                                $isToday = $task->due_date->isToday() && $column->title !== 'Concluído';
                                                $isTomorrow = $task->due_date->isTomorrow() && $column->title !== 'Concluído';
                                                
                                                if ($column->title === 'Concluído') {
                                                    $dueColor = 'text-slate-400 bg-slate-800/40 border border-slate-700/30';
                                                    $dueIcon = 'calendar-check';
                                                    $dueText = __('Entregue');
                                                } elseif ($isOverdue) {
                                                    $diff = now()->startOfDay()->diffInDays($task->due_date);
                                                    $dueColor = 'text-rose-400 bg-rose-500/10 border border-rose-500/20';
                                                    $dueIcon = 'alert-circle';
                                                    $dueText = $diff == 1 ? __('Atrasada 1 dia') : __('Atrasada :count dias', ['count' => $diff]);
                                                } elseif ($isToday) {
                                                    $dueColor = 'text-amber-400 bg-amber-500/10 border border-amber-500/20';
                                                    $dueIcon = 'calendar';
                                                    $dueText = __('Hoje');
                                                } elseif ($isTomorrow) {
                                                    $dueColor = 'text-indigo-400 bg-indigo-500/10 border border-indigo-500/20';
                                                    $dueIcon = 'calendar';
                                                    $dueText = __('Amanhã');
                                                } else {
                                                    $dueColor = 'text-slate-400 bg-slate-800/60 border border-slate-700/50';
                                                    $dueIcon = 'calendar';
                                                    $dueText = $task->due_date->format('d/m');
                                                }
                                            @endphp
                                            <div class="flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold {{ $dueColor }}" title="{{ __('Prazo de Entrega') }}: {{ $task->due_date->format('d/m/Y') }}">
                                                <i data-lucide="{{ $dueIcon }}" class="w-3 h-3"></i>
                                                <span>{{ $dueText }}</span>
                                            </div>
                                        @endif
                                        @if($task->subtasks->count() > 0)
                                            <div class="flex items-center gap-1.5 {{ $task->subtasks->where('is_completed', true)->count() === $task->subtasks->count() ? 'text-emerald-400' : 'text-slate-400' }}" title="{{ __('Subtarefas') }}">
                                                <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                                                <span class="text-[10px] font-semibold">{{ $task->subtasks->where('is_completed', true)->count() }}/{{ $task->subtasks->count() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Assignee selector in Task Card -->
                                        <!-- Assignee selector in Task Card -->
                                        <div class="relative" x-data="{
                                            open: false,
                                            coords: { top: 0, left: 0 },
                                            update() {
                                                if (!this.open || !this.$refs.trigger) return;
                                                const rect = this.$refs.trigger.getBoundingClientRect();
                                                this.coords.top = rect.bottom + window.scrollY;
                                                this.coords.left = rect.right - (this.$refs.dropdown?.offsetWidth || 176) + window.scrollX;
                                            },
                                            init() {
                                                const up = () => this.update();
                                                this.$watch('open', value => {
                                                    if (value) {
                                                        this.$nextTick(() => {
                                                            this.update();
                                                            window.addEventListener('scroll', up, true);
                                                            window.addEventListener('resize', up);
                                                        });
                                                    } else {
                                                        window.removeEventListener('scroll', up, true);
                                                        window.removeEventListener('resize', up);
                                                    }
                                                });
                                            }
                                        }" @close-other-dropdowns.window="if ($event.detail.trigger !== $refs.trigger) open = false">
                                            <button x-ref="trigger"
                                                    @click.stop="open = !open; if (open) $dispatch('close-other-dropdowns', { trigger: $refs.trigger })" 
                                                    title="{{ __('Responsável') }}: {{ $task->assignee ? $task->assignee->name : __('Ninguém') }}"
                                                    class="flex items-center justify-center w-5 h-5 rounded-full text-[9px] font-bold border transition duration-200 cursor-pointer {{ $task->assignee ? 'bg-indigo-650 border-indigo-400 text-white shadow-sm' : 'bg-slate-700/30 border-slate-600/30 text-slate-400 hover:border-slate-500' }}">
                                                @if($task->assignee)
                                                    {{ strtoupper(substr($task->assignee->name, 0, 2)) }}
                                                @else
                                                    <i data-lucide="user-plus" class="w-2.5 h-2.5"></i>
                                                @endif
                                            </button>

                                            <!-- Assignee Popover -->
                                            <template x-teleport="body">
                                                <div x-show="open" 
                                                     x-ref="dropdown"
                                                     @click.outside="open = false"
                                                     x-transition:enter="transition ease-out duration-100"
                                                     x-transition:enter-start="transform opacity-0 scale-95"
                                                     x-transition:enter-end="transform opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-75"
                                                     x-transition:leave-start="transform opacity-100 scale-100"
                                                     x-transition:leave-end="transform opacity-0 scale-95"
                                                     :style="'position: absolute; z-index: 9999; top: ' + coords.top + 'px; left: ' + coords.left + 'px;'"
                                                     class="w-44 bg-slate-800 border border-slate-700 rounded-lg shadow-xl p-1"
                                                     style="display: none;">
                                                    <button @click.stop="open = false; $wire.assignTask({{ $task->id }}, null)"
                                                            class="w-full text-left px-2.5 py-1.5 text-[11px] rounded-md transition hover:bg-slate-700 text-slate-400 hover:text-white flex items-center gap-2">
                                                        <i data-lucide="user-minus" class="w-3.5 h-3.5"></i>
                                                        {{ __('Sem responsável') }}
                                                    </button>
                                                    <div class="h-px bg-slate-700/50 my-1"></div>
                                                    @foreach($users as $user)
                                                        <button @click.stop="open = false; $wire.assignTask({{ $task->id }}, {{ $user->id }})"
                                                                class="w-full text-left px-2.5 py-1.5 text-[11px] rounded-md transition hover:bg-slate-700 {{ $task->user_id == $user->id ? 'text-indigo-400 bg-indigo-500/10 font-semibold' : 'text-slate-300 hover:text-white' }} flex items-center gap-2">
                                                            <span class="w-4 h-4 rounded-full bg-slate-700 flex items-center justify-center text-[8px] font-bold text-slate-300">
                                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                                            </span>
                                                            <span class="truncate">{{ $user->name }}</span>
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </template>
                                        </div>

                                        @php
                                            $priorityColors = [
                                                'low' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20 hover:bg-emerald-500/20',
                                                'medium' => 'text-amber-400 bg-amber-500/10 border-amber-500/20 hover:bg-amber-500/20',
                                                'high' => 'text-rose-400 bg-rose-500/10 border-rose-500/20 hover:bg-rose-500/20',
                                            ];
                                            $priorityLabels = [
                                                'low' => __('Baixa'),
                                                'medium' => __('Média'),
                                                'high' => __('Alta'),
                                            ];
                                        @endphp
                                        <div class="relative" x-data="{
                                            open: false,
                                            coords: { top: 0, left: 0 },
                                            update() {
                                                if (!this.open || !this.$refs.trigger) return;
                                                const rect = this.$refs.trigger.getBoundingClientRect();
                                                this.coords.top = rect.bottom + window.scrollY;
                                                this.coords.left = rect.right - (this.$refs.dropdown?.offsetWidth || 96) + window.scrollX;
                                            },
                                            init() {
                                                const up = () => this.update();
                                                this.$watch('open', value => {
                                                    if (value) {
                                                        this.$nextTick(() => {
                                                            this.update();
                                                            window.addEventListener('scroll', up, true);
                                                            window.addEventListener('resize', up);
                                                        });
                                                    } else {
                                                        window.removeEventListener('scroll', up, true);
                                                        window.removeEventListener('resize', up);
                                                    }
                                                });
                                            }
                                        }" @close-other-dropdowns.window="if ($event.detail.trigger !== $refs.trigger) open = false">
                                            <button x-ref="trigger"
                                                    @click.stop="open = !open; if (open) $dispatch('close-other-dropdowns', { trigger: $refs.trigger })" 
                                                    title="{{ __('Clique para escolher a prioridade') }}"
                                                    class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-md border transition-colors cursor-pointer {{ $priorityColors[$task->priority ?? 'medium'] }}">
                                                {{ $priorityLabels[$task->priority ?? 'medium'] }}
                                            </button>

                                            <!-- Popover Menu -->
                                            <template x-teleport="body">
                                                <div x-show="open" 
                                                     x-ref="dropdown"
                                                     @click.outside="open = false"
                                                     x-transition:enter="transition ease-out duration-100"
                                                     x-transition:enter-start="transform opacity-0 scale-95"
                                                     x-transition:enter-end="transform opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-75"
                                                     x-transition:leave-start="transform opacity-100 scale-100"
                                                     x-transition:leave-end="transform opacity-0 scale-95"
                                                     :style="'position: absolute; z-index: 9999; top: ' + coords.top + 'px; left: ' + coords.left + 'px;'"
                                                     class="w-24 bg-slate-800 border border-slate-700 rounded-lg shadow-xl overflow-hidden"
                                                     style="display: none;">
                                                    <button @click.stop="$wire.setPriority({{ $task->id }}, 'high'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-rose-400 hover:bg-slate-700 transition-colors border-b border-slate-700/50">{{ __('Alta') }}</button>
                                                    <button @click.stop="$wire.setPriority({{ $task->id }}, 'medium'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-amber-400 hover:bg-slate-700 transition-colors border-b border-slate-700/50">{{ __('Média') }}</button>
                                                    <button @click.stop="$wire.setPriority({{ $task->id }}, 'low'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-emerald-400 hover:bg-slate-700 transition-colors">{{ __('Baixa') }}</button>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Column Footer (Add Task Form) -->
                    <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-col gap-2">
                        <div class="flex gap-2">
                            <input type="text" 
                                   wire:model="newTaskTitle.{{ $column->id }}" 
                                   wire:keydown.enter="createTask({{ $column->id }})"
                                   placeholder="{{ __('Nova tarefa...') }}" 
                                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                            
                            <button wire:click="createTask({{ $column->id }})" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-xl transition flex items-center justify-center">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <!-- TASK DETAILS MODAL -->
    @if($showTaskModal && $selectedTask)
        <div wire:key="modal-{{ $selectedTask->id }}"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/80" 
             x-data
             x-init="$nextTick(() => window.lucide.createIcons())">
            
            <div @click.away="$wire.closeTaskModal()"
                 class="w-full max-w-2xl bg-slate-900 border border-slate-700/60 rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b border-slate-800/80 bg-slate-900/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20">
                            <i data-lucide="layout-list" class="w-5 h-5 text-indigo-400" wire:ignore></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white tracking-tight">{{ $selectedTask->title }}</h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ __('Na coluna') }} <span class="font-semibold text-slate-300">{{ __($selectedTask->column->title) }}</span></p>
                        </div>
                    </div>
                    <button wire:click="closeTaskModal" class="text-slate-500 hover:text-white bg-slate-800/50 hover:bg-slate-700 p-2 rounded-xl transition duration-200">
                        <i data-lucide="x" class="w-5 h-5" wire:ignore></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto flex-1 flex flex-col gap-8 custom-scrollbar">
                    
                    <!-- Task Metadata Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 rounded-xl bg-slate-950/20 border border-slate-800/50">
                        <!-- Priority -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-500 tracking-wider uppercase">{{ __('Prioridade') }}</label>
                            @php
                                $modalPriorityColors = [
                                    'low' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20 hover:bg-emerald-500/20',
                                    'medium' => 'text-amber-400 bg-amber-500/10 border-amber-500/20 hover:bg-amber-500/20',
                                    'high' => 'text-rose-400 bg-rose-500/10 border-rose-500/20 hover:bg-rose-500/20',
                                ];
                                $modalPriorityLabels = [
                                    'low' => __('Baixa'),
                                    'medium' => __('Média'),
                                    'high' => __('Alta'),
                                ];
                            @endphp
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" 
                                        class="w-full flex items-center justify-between bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs font-semibold {{ $modalPriorityColors[$selectedTask->priority ?? 'medium'] }}">
                                    <span>{{ $modalPriorityLabels[$selectedTask->priority ?? 'medium'] }}</span>
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5"></i>
                                </button>
                                <div x-show="open" 
                                     class="absolute top-full left-0 right-0 mt-1 bg-slate-800 border border-slate-700 rounded-xl shadow-xl overflow-hidden z-50 py-1"
                                     style="display: none;">
                                    <button @click="$wire.setPriority({{ $selectedTask->id }}, 'high'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-rose-400 hover:bg-slate-700 transition-colors border-b border-slate-700/50">{{ __('Alta') }}</button>
                                    <button @click="$wire.setPriority({{ $selectedTask->id }}, 'medium'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-amber-400 hover:bg-slate-700 transition-colors border-b border-slate-700/50">{{ __('Média') }}</button>
                                    <button @click="$wire.setPriority({{ $selectedTask->id }}, 'low'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-emerald-400 hover:bg-slate-700 transition-colors">{{ __('Baixa') }}</button>
                                </div>
                            </div>
                        </div>

                        <!-- Assignee -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-500 tracking-wider uppercase">{{ __('Responsável') }}</label>
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" 
                                        class="w-full flex items-center justify-between bg-slate-900 border border-slate-800 rounded-xl px-3 py-2 text-xs font-semibold text-slate-200">
                                    <span class="truncate">{{ $selectedTask->assignee ? $selectedTask->assignee->name : __('Ninguém') }}</span>
                                    <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-500"></i>
                                </button>
                                <div x-show="open" 
                                     class="absolute top-full left-0 right-0 mt-1 max-h-40 overflow-y-auto bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-50 py-1 custom-scrollbar"
                                     style="display: none;">
                                    <button @click="open = false; $wire.assignTask({{ $selectedTask->id }}, null)"
                                            class="w-full text-left px-3 py-2 text-xs text-slate-400 hover:bg-slate-700 flex items-center gap-2">
                                        <i data-lucide="user-minus" class="w-3.5 h-3.5"></i> {{ __('Sem responsável') }}
                                    </button>
                                    <div class="h-px bg-slate-700/50 my-1"></div>
                                    @foreach($users as $user)
                                        <button @click="open = false; $wire.assignTask({{ $selectedTask->id }}, {{ $user->id }})"
                                                class="w-full text-left px-3 py-2 text-xs text-slate-200 hover:bg-slate-700 flex items-center gap-2">
                                            <span class="w-4 h-4 rounded-full bg-slate-700 flex items-center justify-center text-[8px] font-bold text-slate-300">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                            <span class="truncate">{{ $user->name }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-500 tracking-wider uppercase">{{ __('Prazo de Entrega') }}</label>
                            <input type="date" 
                                   wire:model="editingDueDate" 
                                   wire:change="updateTaskDueDate"
                                   class="w-full bg-slate-900 border border-slate-800 rounded-xl px-3 py-1.5 text-xs font-semibold text-slate-200 focus:outline-none focus:border-indigo-500 transition">
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i data-lucide="align-left" class="w-4 h-4 text-slate-400" wire:ignore></i>
                            <h3 class="font-semibold text-sm">{{ __('Descrição') }}</h3>
                        </div>
                        <div class="relative group">
                            <textarea wire:model="editingDescription" 
                                      wire:change="updateTaskDescription"
                                      placeholder="{{ __('Adicione uma descrição detalhada...') }}"
                                      class="w-full min-h-[100px] bg-slate-950/50 border border-slate-800 rounded-xl p-3 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 focus:bg-slate-950 transition resize-y"></textarea>
                            <div class="absolute bottom-3 right-3 text-[10px] text-slate-500 font-medium opacity-0 group-focus-within:opacity-100 transition">
                                {{ __('Clica fora para salvar') }}
                            </div>
                        </div>
                    </div>

                    <!-- Attachments Section -->
                    <div class="flex flex-col gap-3" x-data="{ isDragging: false }">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i data-lucide="paperclip" class="w-4 h-4 text-slate-400" wire:ignore></i>
                            <h3 class="font-semibold text-sm">{{ __('Anexos') }}</h3>
                        </div>

                        <!-- Drag and Drop Zone -->
                        <div class="relative border-2 border-dashed rounded-xl p-6 transition-all duration-200 flex flex-col items-center justify-center text-center cursor-pointer"
                             :class="isDragging ? 'border-indigo-500 bg-indigo-500/10' : 'border-slate-800 bg-slate-950/20 hover:border-slate-700'"
                             x-on:dragover.prevent="isDragging = true"
                             x-on:dragleave.prevent="isDragging = false"
                             x-on:drop.prevent="isDragging = false; @this.uploadMultiple('newAttachments', $event.dataTransfer.files, () => { $wire.uploadAttachments(); }, () => { typeof Swal !== 'undefined' ? Swal.fire({ title: 'Erro de Upload', text: 'Não foi possível fazer o upload. Verifique se o arquivo não excede o limite de tamanho.', icon: 'error', confirmButtonColor: '#4f46e5', ...window.tasklyAlertTheme() }) : alert('Erro ao fazer upload.'); })">
                            
                            <input type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   x-on:change="@this.uploadMultiple('newAttachments', $event.target.files, () => { $wire.uploadAttachments(); }, () => { typeof Swal !== 'undefined' ? Swal.fire({ title: 'Erro de Upload', text: 'Não foi possível fazer o upload. Verifique se o arquivo não excede o limite de tamanho.', icon: 'error', confirmButtonColor: '#4f46e5', ...window.tasklyAlertTheme() }) : alert('Erro ao fazer upload.'); }); $event.target.value = ''" />

                            <i data-lucide="upload-cloud" class="w-8 h-8 text-slate-500 mb-2"></i>
                            <p class="text-xs text-slate-300 font-semibold">{{ __('Arraste arquivos aqui ou clique para fazer upload') }}</p>
                            <p class="text-[10px] text-slate-500 mt-1">{{ __('Qualquer imagem, PDF ou documento (máx. 10MB)') }}</p>
                            
                            <!-- Loading indicator -->
                            <div wire:loading wire:target="newAttachments" class="absolute inset-0 bg-slate-900/80 rounded-xl flex items-center justify-center gap-2 text-xs font-semibold text-indigo-400">
                                <i data-lucide="loader" class="w-4 h-4 animate-spin"></i>
                                <span>{{ __('Fazendo upload...') }}</span>
                            </div>
                        </div>

                        <!-- Attachments List -->
                        @if($selectedTask->attachments && $selectedTask->attachments->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-1">
                                @foreach($selectedTask->attachments as $attachment)
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

                    <!-- Subtasks Section -->
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-200">
                                <i data-lucide="check-square" class="w-4 h-4 text-slate-400"></i>
                                <h3 class="font-semibold text-sm">{{ __('Subtarefas') }}</h3>
                            </div>
                            @if($selectedTask->subtasks->count() > 0)
                                <div class="text-xs font-semibold px-2 py-1 rounded-lg bg-slate-800 text-slate-300 border border-slate-700">
                                    {{ $selectedTask->subtasks->where('is_completed', true)->count() }} / {{ $selectedTask->subtasks->count() }}
                                </div>
                            @endif
                        </div>

                        <!-- Progress Bar -->
                        @if($selectedTask->subtasks->count() > 0)
                            @php
                                $percentage = ($selectedTask->subtasks->where('is_completed', true)->count() / $selectedTask->subtasks->count()) * 100;
                            @endphp
                            <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 transition-all duration-500 ease-out" style="width: {{ $percentage }}%"></div>
                            </div>
                        @endif

                        <div class="flex flex-col gap-2">
                            <!-- Add Subtask Input -->
                            <div class="flex gap-2 mb-2">
                                <input type="text" 
                                       wire:model="newSubtaskTitle"
                                       wire:keydown.enter="createSubtask"
                                       placeholder="{{ __('Adicionar um item (Enter para salvar)') }}" 
                                       class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                                <button wire:click="createSubtask" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 rounded-xl transition font-medium text-sm shadow-lg shadow-indigo-600/20">
                                    {{ __('Adicionar') }}
                                </button>
                            </div>

                            <!-- Subtasks List -->
                            <div class="flex flex-col gap-2">
                                @foreach($selectedTask->subtasks as $subtask)
                                    <div class="flex items-start gap-3 p-3 rounded-xl border {{ $subtask->is_completed ? 'bg-slate-950/40 border-slate-800/50' : 'bg-slate-800/40 border-slate-700/50 hover:border-slate-600' }} group transition">
                                        <button wire:click="toggleSubtask({{ $subtask->id }})" class="mt-0.5 flex-shrink-0 focus:outline-none">
                                            @if($subtask->is_completed)
                                                <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-500 transition-transform hover:scale-110"></i>
                                            @else
                                                <i data-lucide="circle" class="w-5 h-5 text-slate-500 hover:text-indigo-400 transition"></i>
                                            @endif
                                        </button>
                                        <span class="flex-1 text-sm {{ $subtask->is_completed ? 'text-slate-500 line-through' : 'text-slate-300' }} transition-colors">
                                            {{ $subtask->title }}
                                        </span>
                                        <button wire:click="deleteSubtask({{ $subtask->id }})" class="text-slate-500 hover:text-rose-400 p-1 rounded transition opacity-0 group-hover:opacity-100 focus:outline-none">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                @endforeach
                                @if($selectedTask->subtasks->count() === 0)
                                    <div class="text-center py-6 border border-dashed border-slate-800 rounded-xl bg-slate-900/20">
                                        <p class="text-xs text-slate-500">{{ __('Nenhuma subtarefa adicionada.') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Activity History Section -->
                    <div class="flex flex-col gap-4 border-t border-slate-800/80 pt-6">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i data-lucide="activity" class="w-4 h-4 text-slate-400" wire:ignore></i>
                            <h3 class="font-semibold text-sm">{{ __('Histórico de Atividade') }}</h3>
                        </div>

                        <div class="flex flex-col gap-3 max-h-[220px] overflow-y-auto pr-1 custom-scrollbar">
                            @foreach($selectedTask->activities as $activity)
                                @php
                                    $desc = $activity->description;
                                    if (str_starts_with($desc, '{')) {
                                        $data = json_decode($desc, true);
                                        if (isset($data['key'])) {
                                            $params = [];
                                            foreach ($data['params'] ?? [] as $k => $v) {
                                                $params[$k] = __($v);
                                            }
                                            $desc = __($data['key'], $params);
                                        }
                                    } else {
                                        $desc = __($desc);
                                    }
                                @endphp
                                <div class="flex items-start gap-3 text-xs text-slate-300">
                                    <div class="w-6 h-6 rounded-full bg-slate-800 flex items-center justify-center shrink-0 border border-slate-700/50 text-[10px] font-bold text-slate-400">
                                        @if($activity->user)
                                            {{ strtoupper(substr($activity->user->name, 0, 2)) }}
                                        @else
                                            SY
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="leading-relaxed">
                                            <span class="font-semibold text-slate-200">{{ $activity->user ? $activity->user->name : __('Sistema') }}</span>
                                            {{ $desc }}
                                        </p>
                                        <span class="text-[10px] text-slate-500 mt-0.5 block">{{ $activity->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach

                            @if($selectedTask->activities->count() === 0)
                                <div class="text-center py-4">
                                    <p class="text-xs text-slate-500">{{ __('Nenhuma atividade registrada.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TRASH MODAL -->
    @if($showTrashModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/80"
             x-data
             x-init="$nextTick(() => window.lucide.createIcons())">
            
            <div @click.away="$wire.closeTrashModal()"
                 class="w-full max-w-2xl bg-slate-900 border border-slate-700/60 rounded-2xl shadow-2xl flex flex-col max-h-[80vh] overflow-hidden">
                
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b border-slate-800/80 bg-slate-900/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <i data-lucide="trash-2" class="w-5 h-5 text-rose-400" wire:ignore></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white tracking-tight">{{ __('Lixeira do Quadro') }}</h2>
                            <p class="text-xs text-slate-400 mt-0.5">{{ __('Restaure ou exclua permanentemente as tarefas removidas') }}</p>
                        </div>
                    </div>
                    <button wire:click="closeTrashModal" class="text-slate-500 hover:text-white bg-slate-800/50 hover:bg-slate-700 p-2 rounded-xl transition duration-200">
                        <i data-lucide="x" class="w-5 h-5" wire:ignore></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto flex-1 flex flex-col gap-4 custom-scrollbar">
                    @if($trashedTasks->count() > 0)
                        <div class="flex flex-col gap-2.5">
                            @foreach($trashedTasks as $task)
                                <div class="flex items-center justify-between p-4 rounded-xl bg-slate-950/40 border border-slate-800 hover:border-slate-700/80 transition duration-200 group">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-white truncate">{{ $task->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1.5 text-[10px] text-slate-400">
                                            <span class="px-2 py-0.5 rounded-md bg-slate-800 border border-slate-750 text-slate-300">
                                                {{ __('Coluna:') }} {{ __($task->column->title) }}
                                            </span>
                                            @if($task->due_date)
                                                <span class="flex items-center gap-1">
                                                    <i data-lucide="calendar" class="w-3 h-3 text-slate-500"></i>
                                                    {{ __('Prazo:') }} {{ $task->due_date->format('d/m/Y') }}
                                                </span>
                                            @endif
                                            <span>{{ __('Excluída em') }} {{ $task->deleted_at->format('d/m H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <button wire:click="restoreTask({{ $task->id }})" 
                                                class="flex items-center justify-center p-2 rounded-xl bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 hover:bg-indigo-600 hover:text-white transition duration-200" 
                                                title="{{ __('Restaurar Tarefa') }}">
                                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                                        </button>
                                        <button x-data 
                                                x-on:click="confirmAction('{{ __('Deseja excluir PERMANENTEMENTE esta tarefa? Essa ação não pode ser desfeita!') }}', () => $wire.forceDeleteTask({{ $task->id }}), '{{ __('Atenção') }}', '{{ __('Sim, confirmar!') }}', '{{ __('Cancelar') }}')" 
                                                class="flex items-center justify-center p-2 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-600 hover:text-white transition duration-200" 
                                                title="{{ __('Excluir Permanentemente') }}">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 border border-dashed border-slate-800 rounded-2xl bg-slate-900/10">
                            <div class="w-12 h-12 rounded-full bg-slate-800/40 border border-slate-700/50 flex items-center justify-center mx-auto mb-3">
                                <i data-lucide="trash" class="w-6 h-6 text-slate-500"></i>
                            </div>
                            <h3 class="text-sm font-semibold text-slate-300">{{ __('Lixeira vazia') }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ __('Nenhuma tarefa foi enviada para a lixeira neste quadro.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
