<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Board;
use App\Models\Task;

class ShowBoard extends Component
{
    public Board $board;

    public function mount(Board $board)
    {
        $this->board = $board->load([
            'columns' => fn($q) => $q->orderBy('position'),
            'columns.tasks' => fn($q) => $q->orderBy('position')
        ]);
    }

    // ESTE É O MÉTODO QUE O JAVASCRIPT ESTÁ CHAMANDO
    public function updateTaskOrder($orderedIds, $columnId)
    {
        // $orderedIds é um array tipo [15, 8, 22] (Os IDs das tarefas)
        // O index do array (0, 1, 2) passa a ser a nova 'position' no banco
        
        foreach ($orderedIds as $index => $taskId) {
            Task::where('id', $taskId)->update([
                'column_id' => $columnId,
                'position'  => $index
            ]);
        }

        // Recarrega os dados do banco para garantir que a tela fique atualizada
        $this->board->load([
            'columns' => fn($q) => $q->orderBy('position'),
            'columns.tasks' => fn($q) => $q->orderBy('position')
        ]);
    }

    public function render()
    {
        return view('livewire.show-board');
    }
}
