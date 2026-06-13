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
    public $editingDueDate = '';
    public $showTrashModal = false;

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
        return redirect()->route('board.show', $newBoard->id)->navigate();
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
            $task = Task::find($taskId);
            if ($task) {
                $task->column_id = $columnId;
                $task->position = $index;
                $task->save();
            }
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

        $this->selectedTask = Task::with(['subtasks', 'activities.user'])->whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);
        
        $this->editingDescription = $this->selectedTask->description ?? '';
        $this->editingDueDate = $this->selectedTask->due_date ? $this->selectedTask->due_date->format('Y-m-d') : '';
        $this->showTaskModal = true;
    }

    public function closeTaskModal()
    {
        $this->showTaskModal = false;
        $this->selectedTask = null;
        $this->newSubtaskTitle = '';
        $this->editingDescription = '';
        $this->editingDueDate = '';
    }

    public function updateTaskDescription()
    {
        if (!$this->selectedTask || $this->board->user_id !== auth()->id()) return;

        $this->selectedTask->update([
            'description' => $this->editingDescription
        ]);

        $this->selectedTask->load('activities.user');
    }

    public function updateTaskDueDate()
    {
        if (!$this->selectedTask || $this->board->user_id !== auth()->id()) return;

        $dueDate = !empty($this->editingDueDate) ? $this->editingDueDate : null;

        $this->selectedTask->update([
            'due_date' => $dueDate
        ]);

        $this->selectedTask->load('activities.user');
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

    public function exportCsv()
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $fileName = 'export_' . str($this->board->title)->slug() . '_' . now()->format('Ymd_His') . '.csv';

        $columns = $this->board->columns()->orderBy('position')->with(['tasks' => function($q) {
            $q->orderBy('position')->with(['assignee', 'subtasks']);
        }])->get();

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to make Excel open it correctly
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, ['Coluna', 'Tarefa', 'Descrição', 'Prioridade', 'Responsável', 'Subtarefas Concluídas', 'Total Subtarefas', 'Prazo', 'Criado Em'], ';');

            $priorities = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'];

            foreach ($columns as $column) {
                foreach ($column->tasks as $task) {
                    $completedSubtasks = $task->subtasks->where('is_completed', true)->count();
                    $totalSubtasks = $task->subtasks->count();
                    
                    fputcsv($file, [
                        $column->title,
                        $task->title,
                        $task->description ?? '',
                        $priorities[$task->priority ?? 'medium'] ?? 'Média',
                        $task->assignee ? $task->assignee->name : 'Ninguém',
                        $completedSubtasks,
                        $totalSubtasks,
                        $task->due_date ? $task->due_date->format('d/m/Y') : 'Sem prazo',
                        $task->created_at->format('d/m/Y H:i'),
                    ], ';');
                }
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }

    public function openTrashModal()
    {
        $this->showTrashModal = true;
    }

    public function closeTrashModal()
    {
        $this->showTrashModal = false;
    }

    public function restoreTask($taskId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $task = Task::onlyTrashed()->whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);

        $task->restore();
    }

    public function forceDeleteTask($taskId)
    {
        if ($this->board->user_id !== auth()->id()) {
            abort(403, 'Ação não autorizada.');
        }

        $task = Task::onlyTrashed()->whereHas('column', function($query) {
            $query->where('board_id', $this->board->id);
        })->findOrFail($taskId);

        $task->forceDelete();
    }

    public function setLocale($locale)
    {
        $validLocales = ['en', 'pt_BR', 'es'];
        if (in_array($locale, $validLocales)) {
            session()->put('locale', $locale);
            app()->setLocale($locale);
            
            return $this->redirectRoute('board.show', ['board' => $this->board->id], navigate: true);
        }
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

        $trashedTasks = Task::onlyTrashed()
            ->whereHas('column', function($q) {
                $q->where('board_id', $this->board->id);
            })
            ->with('column')
            ->get();

        return view('livewire.show-board', [
            'columns' => $columns,
            'users' => $users,
            'trashedTasks' => $trashedTasks
        ]);
    }
}
