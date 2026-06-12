<div>
    <h1 class="text-3xl font-bold mb-6 text-gray-700">{{ $board->title }}</h1>

    <div class="flex space-x-4 overflow-x-auto pb-4">
        @foreach($board->columns as $column)
            <div class="bg-gray-200 rounded-lg shadow-sm w-80 flex-shrink-0 p-4">
                <h3 class="font-semibold text-gray-700 mb-3">{{ $column->title }}</h3>

                <div class="space-y-3 min-h-[50px] sortable-column" data-column-id="{{ $column->id }}">
                    
                    @foreach($column->tasks as $task)
                        <div class="bg-white p-3 rounded shadow-sm border border-gray-100 cursor-grab hover:bg-gray-50 sortable-task" 
                             data-task-id="{{ $task->id }}">
                            <h4 class="font-medium text-sm text-gray-800">{{ $task->title }}</h4>
                            @if($task->description)
                                <p class="text-xs text-gray-500 mt-1 truncate">{{ $task->description }}</p>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    document.addEventListener('livewire:init', () => {
        // Pega todas as colunas que criamos no HTML
        let columns = document.querySelectorAll('.sortable-column');

        columns.forEach(column => {
            new Sortable(column, {
                group: 'kanban', // Permite arrastar de uma coluna para outra
                animation: 150,
                ghostClass: 'opacity-50', // Efeito visual do card original enquanto arrasta
                
                // O evento 'onEnd' dispara no momento exato que você solta o clique do mouse
                onEnd: function (evt) {
                    let newColumn = evt.to; // A coluna onde o card caiu
                    let newColumnId = newColumn.getAttribute('data-column-id');
                    
                    // Cria um array com a nova ordem dos IDs dos cards dessa coluna
                    let taskIds = Array.from(newColumn.children).map(child => child.getAttribute('data-task-id'));

                    // A MÁGICA: Chama a função do PHP lá no backend enviando os dados!
                    @this.updateTaskOrder(taskIds, newColumnId);
                }
            });
        });
    });
</script>
