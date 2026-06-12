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
                    <p class="text-xs text-slate-400">Kanban Board</p>
                </div>
            </div>

            <!-- Boards Section -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between text-xs font-semibold text-slate-400 tracking-wider uppercase px-2">
                    <span>Meus Quadros</span>
                    <i data-lucide="folder" class="w-4 h-4"></i>
                </div>
                
                <div class="flex flex-col gap-1">
                    @foreach($userBoards as $ub)
                        <a href="{{ route('board.show', $ub->id) }}" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition duration-200 group {{ $board->id === $ub->id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-300 hover:bg-slate-800/60 hover:text-white' }}">
                            <i data-lucide="kanban" class="w-4 h-4 text-indigo-400 group-hover:text-white"></i>
                            <span class="truncate flex-1">{{ $ub->title }}</span>
                            @if($board->id === $ub->id)
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="flex flex-col gap-4 border-t border-slate-800 pt-4">
                <!-- Add Board Action -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">Novo Quadro</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               wire:model="newBoardTitle"
                               wire:keydown.enter="createBoard"
                               placeholder="Título do quadro..." 
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                        <button wire:click="createBoard" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-xl transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Add Column Action -->
                <div>
                    <label class="block text-xs font-semibold text-slate-400 tracking-wider uppercase px-2 mb-2">Nova Coluna</label>
                    <div class="flex gap-2">
                        <input type="text" 
                               wire:model="newColumnTitle"
                               wire:keydown.enter="createColumn"
                               placeholder="Título da coluna..." 
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                        <button wire:click="createColumn" class="bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-xl transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logged User Profile Footer -->
        <div class="p-6 border-t border-slate-800 bg-slate-900/60 flex items-center justify-between gap-3">
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
                <button type="submit" class="text-slate-400 hover:text-rose-400 p-2 hover:bg-rose-500/10 rounded-xl transition duration-200" title="Sair">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN KANBAN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-hidden">
        <!-- Main Navbar Header -->
        <header class="h-20 border-b border-slate-900 bg-slate-900/20 px-8 flex items-center justify-between flex-shrink-0">
            <div x-data="{ isEditing: false, title: @js($board->title) }" class="flex items-center gap-4">
                <i data-lucide="kanban" class="w-6 h-6 text-indigo-400"></i>
                
                <div x-show="!isEditing" class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold tracking-tight text-white">{{ $board->title }}</h2>
                    <button x-on:click="isEditing = true; title = @js($board->title); $nextTick(() => $refs.boardTitleInput.focus())" 
                            class="text-slate-400 hover:text-white transition duration-200" title="Renomear Quadro">
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
            
            <div class="flex items-center gap-3">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full border-2 border-slate-950 bg-indigo-500 flex items-center justify-center text-xs font-semibold text-white">US</div>
                    <div class="w-8 h-8 rounded-full border-2 border-slate-950 bg-emerald-500 flex items-center justify-center text-xs font-semibold text-white">AD</div>
                </div>
                <div class="h-6 w-px bg-slate-800"></div>
                <span class="text-xs bg-indigo-500/10 text-indigo-400 px-3 py-1.5 rounded-full font-medium border border-indigo-500/20">
                    {{ $board->columns->count() }} Colunas
                </span>
            </div>
        </header>

        <!-- Filters sub-header -->
        <div class="bg-slate-900/10 border-b border-slate-900/50 px-8 py-3.5 flex flex-wrap items-center justify-between gap-4 flex-shrink-0">
            <!-- Search bar -->
            <div class="relative w-72">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500"></i>
                <input wire:model.live="search" 
                       type="text" 
                       placeholder="Buscar tarefas..." 
                       class="w-full bg-slate-950 border border-slate-800/80 rounded-xl pl-10 pr-4 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500 transition">
            </div>

            <!-- Filter Buttons/Dropdowns -->
            <div class="flex items-center gap-4">
                <!-- Priority filter buttons -->
                <div class="flex items-center gap-1.5 bg-slate-950/40 p-1 border border-slate-800/80 rounded-xl">
                    <button wire:click="$set('filterPriority', '')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === '' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                        Todas
                    </button>
                    <button wire:click="$set('filterPriority', 'low')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === 'low' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/20' : 'text-slate-400 hover:text-emerald-400' }}">
                        Baixa
                    </button>
                    <button wire:click="$set('filterPriority', 'medium')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === 'medium' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:text-amber-400' }}">
                        Média
                    </button>
                    <button wire:click="$set('filterPriority', 'high')" 
                            class="text-[10px] font-semibold px-2.5 py-1.5 rounded-lg transition-all {{ $filterPriority === 'high' ? 'bg-rose-500/20 text-rose-400 border border-rose-500/20' : 'text-slate-400 hover:text-rose-400' }}">
                        Alta
                    </button>
                </div>

                <!-- Assignee filter dropdown -->
                <div class="flex items-center gap-2">
                    <label class="text-xs text-slate-500 font-medium">Responsável:</label>
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" 
                                class="flex items-center justify-between min-w-[160px] bg-slate-950 border border-slate-800/80 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-300 transition group hover:border-indigo-500/50">
                            <span class="truncate">
                                @if($filterAssignee === '')
                                    Todos
                                @elseif($filterAssignee === 'unassigned')
                                    Sem Responsável
                                @else
                                    {{ (string)($users->firstWhere('id', $filterAssignee)->name ?? 'Todos') }}
                                @endif
                            </span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-500 group-hover:text-indigo-400 transition-transform duration-200" :class="{'rotate-180': open}"></i>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="transform opacity-0 scale-95 translate-y-1"
                             class="absolute top-full mt-1.5 right-0 w-52 bg-slate-800 border border-slate-700 rounded-xl shadow-xl overflow-hidden z-50 py-1"
                             style="display: none;">
                            <button @click="$wire.set('filterAssignee', ''); open = false; $nextTick(() => window.lucide.createIcons())" 
                                    class="w-full text-left px-3 py-2 text-xs font-medium transition-colors flex items-center gap-2 {{ $filterAssignee === '' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                                <i data-lucide="users" class="w-3.5 h-3.5"></i> Todos
                            </button>
                            <button @click="$wire.set('filterAssignee', 'unassigned'); open = false; $nextTick(() => window.lucide.createIcons())" 
                                    class="w-full text-left px-3 py-2 text-xs font-medium transition-colors flex items-center gap-2 {{ $filterAssignee === 'unassigned' ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
                                <i data-lucide="user-minus" class="w-3.5 h-3.5"></i> Sem Responsável
                            </button>
                            <div class="h-px bg-slate-700/50 my-1"></div>
                            @foreach($users as $user)
                                <button @click="$wire.set('filterAssignee', '{{ $user->id }}'); open = false; $nextTick(() => window.lucide.createIcons())" 
                                        class="w-full text-left px-3 py-2 text-xs font-medium transition-colors flex items-center gap-2 {{ $filterAssignee == $user->id ? 'text-indigo-400 bg-indigo-500/10' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white' }}">
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
        <div class="flex-1 overflow-x-auto p-8 flex gap-6 items-start">
            @foreach($columns as $column)
                <div wire:key="column-{{ $column->id }}" class="w-80 bg-slate-900/60 border border-slate-800/80 rounded-2xl p-4 flex flex-col flex-shrink-0 max-h-full shadow-lg">
                    <!-- Column Header -->
                    <div class="flex items-center justify-between mb-4 px-1">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="w-2.5 h-2.5 rounded-full {{ ['bg-indigo-400', 'bg-amber-400', 'bg-sky-400', 'bg-emerald-400'][$loop->index % 4] }} flex-shrink-0"></span>
                            <h3 class="font-bold text-slate-200 tracking-wide truncate">{{ $column->title }}</h3>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button x-data x-on:click="confirmAction('Tem certeza que deseja excluir esta coluna e todas as suas tarefas?', () => $wire.deleteColumn({{ $column->id }}))" 
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
                                        <button x-data x-on:click.stop="confirmAction('Deseja excluir esta tarefa?', () => $wire.deleteTask({{ $task->id }}))"
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
                                        <div class="flex items-center gap-1.5" title="Criada há {{ $task->created_at->diffForHumans() }}">
                                            <i data-lucide="clock" class="w-3.5 h-3.5 text-slate-500"></i>
                                            <span class="text-[10px]">{{ $task->created_at->format('d/m') }}</span>
                                        </div>
                                        @if($task->subtasks->count() > 0)
                                            <div class="flex items-center gap-1.5 {{ $task->subtasks->where('is_completed', true)->count() === $task->subtasks->count() ? 'text-emerald-400' : 'text-slate-400' }}" title="Subtarefas">
                                                <i data-lucide="check-square" class="w-3.5 h-3.5"></i>
                                                <span class="text-[10px] font-semibold">{{ $task->subtasks->where('is_completed', true)->count() }}/{{ $task->subtasks->count() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Assignee selector in Task Card -->
                                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                            <button @click.stop="open = !open" 
                                                    title="Responsável: {{ $task->assignee ? $task->assignee->name : 'Ninguém' }}"
                                                    class="flex items-center justify-center w-5 h-5 rounded-full text-[9px] font-bold border transition duration-200 cursor-pointer {{ $task->assignee ? 'bg-indigo-650 border-indigo-400 text-white shadow-sm' : 'bg-slate-700/30 border-slate-600/30 text-slate-400 hover:border-slate-500' }}">
                                                @if($task->assignee)
                                                    {{ strtoupper(substr($task->assignee->name, 0, 2)) }}
                                                @else
                                                    <i data-lucide="user-plus" class="w-2.5 h-2.5"></i>
                                                @endif
                                            </button>

                                            <!-- Assignee Popover -->
                                            <div x-show="open" 
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                                 class="absolute bottom-full right-0 mb-2 w-44 bg-slate-800 border border-slate-700 rounded-lg shadow-xl p-1 z-50"
                                                 style="display: none;">
                                                <button @click.stop="open = false; $wire.assignTask({{ $task->id }}, null)"
                                                        class="w-full text-left px-2.5 py-1.5 text-[11px] rounded-md transition hover:bg-slate-700 text-slate-400 hover:text-white flex items-center gap-2">
                                                    <i data-lucide="user-minus" class="w-3.5 h-3.5"></i>
                                                    Sem responsável
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
                                        </div>

                                        @php
                                            $priorityColors = [
                                                'low' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20 hover:bg-emerald-500/20',
                                                'medium' => 'text-amber-400 bg-amber-500/10 border-amber-500/20 hover:bg-amber-500/20',
                                                'high' => 'text-rose-400 bg-rose-500/10 border-rose-500/20 hover:bg-rose-500/20',
                                            ];
                                            $priorityLabels = [
                                                'low' => 'Baixa',
                                                'medium' => 'Média',
                                                'high' => 'Alta',
                                            ];
                                        @endphp
                                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                            <button @click.stop="open = !open" 
                                                    title="Clique para escolher a prioridade"
                                                    class="text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-md border transition-colors cursor-pointer {{ $priorityColors[$task->priority ?? 'medium'] }}">
                                                {{ $priorityLabels[$task->priority ?? 'medium'] }}
                                            </button>

                                            <!-- Popover Menu -->
                                            <div x-show="open" 
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                                                 x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                                                 x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                                                 class="absolute bottom-full right-0 mb-2 w-24 bg-slate-800 border border-slate-700 rounded-lg shadow-xl overflow-hidden z-20"
                                                 style="display: none;">
                                                <button @click.stop="$wire.setPriority({{ $task->id }}, 'high'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-rose-400 hover:bg-slate-700 transition-colors border-b border-slate-700/50">Alta</button>
                                                <button @click.stop="$wire.setPriority({{ $task->id }}, 'medium'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-amber-400 hover:bg-slate-700 transition-colors border-b border-slate-700/50">Média</button>
                                                <button @click.stop="$wire.setPriority({{ $task->id }}, 'low'); open = false" class="w-full text-left px-3 py-2 text-xs font-semibold text-emerald-400 hover:bg-slate-700 transition-colors">Baixa</button>
                                            </div>
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
                                   placeholder="Nova tarefa..." 
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
             class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm" 
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
                            <p class="text-xs text-slate-400 mt-0.5">Na coluna <span class="font-semibold text-slate-300">{{ $selectedTask->column->title }}</span></p>
                        </div>
                    </div>
                    <button wire:click="closeTaskModal" class="text-slate-500 hover:text-white bg-slate-800/50 hover:bg-slate-700 p-2 rounded-xl transition duration-200">
                        <i data-lucide="x" class="w-5 h-5" wire:ignore></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto flex-1 flex flex-col gap-8 custom-scrollbar">
                    
                    <!-- Description Section -->
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-2 text-slate-200">
                            <i data-lucide="align-left" class="w-4 h-4 text-slate-400" wire:ignore></i>
                            <h3 class="font-semibold text-sm">Descrição</h3>
                        </div>
                        <div class="relative group">
                            <textarea wire:model="editingDescription" 
                                      wire:change="updateTaskDescription"
                                      placeholder="Adicione uma descrição detalhada..."
                                      class="w-full min-h-[100px] bg-slate-950/50 border border-slate-800 rounded-xl p-3 text-sm text-slate-300 focus:outline-none focus:border-indigo-500 focus:bg-slate-950 transition resize-y"></textarea>
                            <div class="absolute bottom-3 right-3 text-[10px] text-slate-500 font-medium opacity-0 group-focus-within:opacity-100 transition">
                                Clica fora para salvar
                            </div>
                        </div>
                    </div>

                    <!-- Subtasks Section -->
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-slate-200">
                                <i data-lucide="check-square" class="w-4 h-4 text-slate-400"></i>
                                <h3 class="font-semibold text-sm">Subtarefas</h3>
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
                                       placeholder="Adicionar um item (Enter para salvar)" 
                                       class="w-full bg-slate-950/50 border border-slate-800 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500 text-slate-100 placeholder-slate-500">
                                <button wire:click="createSubtask" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 rounded-xl transition font-medium text-sm shadow-lg shadow-indigo-600/20">
                                    Adicionar
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
                                        <p class="text-xs text-slate-500">Nenhuma subtarefa adicionada.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="{{ asset('js/board.js') }}"></script>
