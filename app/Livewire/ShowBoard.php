<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Board;

class ShowBoard extends Component
{
    public Board $board;

    public function mount(Board $board)
    {
        // Aqui carregamos o quadro e já trazemos as colunas e as tarefas 
        // ordenadas pela coluna 'position', para que apareçam na ordem certa.
        $this->board = $board->load([
            'columns' => function ($query) {
                $query->orderBy('position');
            },
            'columns.tasks' => function ($query) {
                $query->orderBy('position');
            }
        ]);
    }

    public function render()
    {
        return view('livewire.show-board');
    }
}
