<?php

namespace App\Livewire;

use App\Livewire\Concerns\HasLocale;
use App\Models\Task;
use App\Models\Ticket;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Calendar extends Component
{
    use HasLocale;

    public string $viewMode = 'month';

    public string $currentDate;

    public string $filterPriority = '';

    public string $filterBoard = '';

    public $selectedTask = null;

    public $selectedTicket = null;

    public function mount()
    {
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

    public function openTicket(int $ticketId): void
    {
        $this->selectedTicket = Ticket::where('user_id', auth()->id())
            ->with(['assignee', 'board', 'checklistItems'])
            ->find($ticketId);
    }

    public function closeTicket(): void
    {
        $this->selectedTicket = null;
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
            ->groupBy(fn (Task $task) => $task->due_date->toDateString());

        $listTasks = $this->baseTaskQuery()
            ->whereNotNull('due_date')
            ->where('due_date', '>=', now()->subWeek()->toDateString())
            ->with(['column.board', 'assignee'])
            ->orderBy('due_date')
            ->take(40)
            ->get();
        $tickets = Ticket::where('user_id', auth()->id())
            ->whereNotIn('status', ['resolved'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('due_date', [$start->toDateString(), $end->toDateString()])
                    ->orWhereBetween('sla_due_at', [$start->copy()->startOfDay(), $end->copy()->endOfDay()]);
            })
            ->with(['assignee', 'board'])
            ->orderByRaw('COALESCE(sla_due_at, due_date)')
            ->get();
        $ticketsByDay = $tickets->groupBy(fn (Ticket $ticket) => ($ticket->due_date ?? $ticket->sla_due_at)->toDateString());
        $listTickets = Ticket::where('user_id', auth()->id())
            ->whereNotIn('status', ['resolved'])
            ->where(function ($query) {
                $query->where('due_date', '>=', now()->subWeek()->toDateString())
                    ->orWhere('sla_due_at', '>=', now()->subWeek());
            })
            ->with(['assignee', 'board'])
            ->orderByRaw('COALESCE(sla_due_at, due_date)')
            ->take(25)
            ->get();

        return view('livewire.calendar', [
            'date' => $date,
            'start' => $start,
            'end' => $end,
            'tasksByDay' => $tasks,
            'listTasks' => $listTasks,
            'ticketsByDay' => $ticketsByDay,
            'listTickets' => $listTickets,
        ]);
    }

    private function baseTaskQuery()
    {
        return Task::query()
            ->whereHas('column.board', fn ($query) => $query->where('user_id', auth()->id()))
            ->when($this->filterPriority !== '', fn ($query) => $query->where('priority', $this->filterPriority))
            ->when($this->filterBoard !== '', fn ($query) => $query->whereHas('column', fn ($column) => $column->where('board_id', $this->filterBoard)));
    }
}
