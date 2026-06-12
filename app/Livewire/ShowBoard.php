<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Board;
use App\Models\Task;

class ShowBoard extends Component
{
    public Board $board;
    public $userBoards = [];
    public $newBoardTitle = '';
    public $newColumnTitle = '';
    public $newTaskTitle = [];
    public $search = '';
    public $filterPriority = '';
    public $filterAssignee = '';

    // Modal state
    public $selectedTask = null;
    public $showTaskModal = false;
    public $newSubtaskTitle = '';
    public $editingDescription = '';

    public function mount(Board $board)
    {
        $this->board = $board;
        $this->userBoards = auth()->user() ? auth()->user()->boards : collect();
    }

    public function createBoard()
    {
        if (empty(trim((string)$this->newBoardTitle))) return;
        
        $newBoard = Board::create([
            'user_id' => auth()->id(),
            'title' => $this->newBoardTitle,
        ]);

        $this->newBoardTitle = '';
        return redirect()->route('board.show', $newBoard->id);
    }

    public function renameBoard($newTitle)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        if (empty(trim((string)$newTitle))) return;

        $this->board->update([
            'title' => $newTitle
        ]);

        $this->userBoards = auth()->user() ? auth()->user()->boards : collect();
    }

    public function createColumn()
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        if (empty(trim((string)$this->newColumnTitle))) return;

        $lastPosition = $this->board->columns()->max('position') ?? -1;

        $this->board->columns()->create([
            'title' => $this->newColumnTitle,
            'position' => $lastPosition + 1,
        ]);

        $this->newColumnTitle = '';
    }

    public function createTask($columnId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $title = $this->newTaskTitle[$columnId] ?? '';
        if (empty(trim((string)$title))) return;

        $lastPosition = Task::where('column_id', $columnId)->max('position') ?? -1;

        Task::create([
            'column_id' => $columnId,
            'title' => $title,
            'position' => $lastPosition + 1
        ]);

        $this->newTaskTitle[$columnId] = '';
    }

    // Reordenação arrastar-e-soltar do frontend (SortableJS)
    public function updateTaskOrder($orderedIds, $columnId)
    {
        foreach ($orderedIds as $index => $taskId) {
            Task::where('id', $taskId)->update([
                'column_id' => $columnId,
                'position'  => $index
            ]);
        }
    }

    public function deleteColumn($columnId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $column = $this->board->columns()->findOrFail($columnId);
        $column->delete();
    }

    public function deleteTask($taskId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $task = Task::whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);

        $task->delete();
    }

    public function setPriority($taskId, $priority)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $validPriorities = ['low', 'medium', 'high'];
        if (!in_array($priority, $validPriorities)) return;

        $task = Task::whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);

        $task->update(['priority' => $priority]);
    }

    public function assignTask($taskId, $userId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $task = Task::whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);

        $task->update(['user_id' => $userId]);
    }

    public function openTaskModal($taskId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $this->selectedTask = Task::with('subtasks')->whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);
        
        $this->editingDescription = $this->selectedTask->description ?? '';
        $this->showTaskModal = true;
    }

    public function closeTaskModal()
    {
        $this->showTaskModal = false;
        $this->selectedTask = null;
        $this->newSubtaskTitle = '';
        $this->editingDescription = '';
    }

    public function updateTaskDescription()
    {
        if (!$this->selectedTask || $this->board->user_id !== auth()->id()) return;

        $this->selectedTask->update([
            'description' => $this->editingDescription
        ]);
    }

    public function createSubtask()
    {
        if (!$this->selectedTask || $this->board->user_id !== auth()->id()) return;

        if (empty(trim((string)$this->newSubtaskTitle))) return;

        $this->selectedTask->subtasks()->create([
            'title' => $this->newSubtaskTitle
        ]);

        $this->newSubtaskTitle = '';
        $this->selectedTask->load('subtasks');
    }

    public function toggleSubtask($subtaskId)
    {
        if (!$this->selectedTask || $this->board->user_id !== auth()->id()) return;

        $subtask = $this->selectedTask->subtasks()->findOrFail($subtaskId);
        $subtask->update([
            'is_completed' => !$subtask->is_completed
        ]);

        $this->selectedTask->load('subtasks');
    }

    public function deleteSubtask($subtaskId)
    {
        if (!$this->selectedTask || $this->board->user_id !== auth()->id()) return;

        $this->selectedTask->subtasks()->findOrFail($subtaskId)->delete();
        $this->selectedTask->load('subtasks');
    }

    public function render()
    {
        $columns = $this->board->columns()
            ->orderBy('position')
            ->with(['tasks' => function($query) {
                $query->orderBy('position')->with(['assignee', 'subtasks']);
                
                if (!empty(trim((string)$this->search))) {
                    $query->where(function($q) {
                        $q->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
                }
                
                if (!empty($this->filterPriority)) {
                    $query->where('priority', $this->filterPriority);
                }
                
                if ($this->filterAssignee !== '') {
                    if ($this->filterAssignee === 'unassigned') {
                        $query->whereNull('user_id');
                    } else {
                        $query->where('user_id', $this->filterAssignee);
                    }
                }
            }])
            ->get();

        $users = \App\Models\User::all();

        return view('livewire.show-board', [
            'columns' => $columns,
            'users' => $users
        ]);
    }
}
