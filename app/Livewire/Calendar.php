<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    public $userBoards = [];
    public string $viewMode = 'month';
    public string $currentDate;
    public string $filterPriority = '';
    public string $filterBoard = '';
    public $selectedTask = null;

    public function mount()
    {
        $this->userBoards = auth()->user() ? auth()->user()->boards : collect();
        $this->currentDate = now()->toDateString();
    }

    public function setViewMode(string $mode): void
    {
        if (in_array($mode, ['month', 'week', 'list'], true)) {
            $this->viewMode = $mode;
        }
    }

    public function previousPeriod(): void
    {
        $date = Carbon::parse($this->currentDate);
        $this->currentDate = ($this->viewMode === 'week' ? $date->subWeek() : $date->subMonth())->toDateString();
    }

    public function nextPeriod(): void
    {
        $date = Carbon::parse($this->currentDate);
        $this->currentDate = ($this->viewMode === 'week' ? $date->addWeek() : $date->addMonth())->toDateString();
    }

    public function goToday(): void
    {
        $this->currentDate = now()->toDateString();
    }

    public function openTask(int $taskId): void
    {
        $this->selectedTask = $this->baseTaskQuery()
            ->with(['column.board', 'assignee', 'subtasks'])
            ->find($taskId);
    }

    public function closeTask(): void
    {
        $this->selectedTask = null;
    }

    public function render()
    {
        $date = Carbon::parse($this->currentDate);
        $start = $this->viewMode === 'week' ? $date->copy()->startOfWeek() : $date->copy()->startOfMonth()->startOfWeek();
        $end = $this->viewMode === 'week' ? $date->copy()->endOfWeek() : $date->copy()->endOfMonth()->endOfWeek();

        $tasks = $this->baseTaskQuery()
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [$start->toDateString(), $end->toDateString()])
            ->with(['column.board', 'assignee'])
            ->orderBy('due_date')
            ->get()
            ->groupBy(fn(Task $task) => $task->due_date->toDateString());

        $listTasks = $this->baseTaskQuery()
            ->whereNotNull('due_date')
            ->where('due_date', '>=', now()->subWeek()->toDateString())
            ->with(['column.board', 'assignee'])
            ->orderBy('due_date')
            ->take(40)
            ->get();

        return view('livewire.calendar', [
            'date' => $date,
            'start' => $start,
            'end' => $end,
            'tasksByDay' => $tasks,
            'listTasks' => $listTasks,
        ]);
    }

    private function baseTaskQuery()
    {
        return Task::query()
            ->whereHas('column.board', fn($query) => $query->where('user_id', auth()->id()))
            ->when($this->filterPriority !== '', fn($query) => $query->where('priority', $this->filterPriority))
            ->when($this->filterBoard !== '', fn($query) => $query->whereHas('column', fn($column) => $column->where('board_id', $this->filterBoard)));
    }
}
