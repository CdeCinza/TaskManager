<?php

namespace App\Livewire;

use App\Livewire\Concerns\HasLocale;
use App\Models\Activity;
use App\Models\Board;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    use HasLocale;

    public function render()
    {
        $user = auth()->user();
        $userTaskQuery = Task::whereHas('column.board', fn ($q) => $q->where('user_id', $user?->id));

        $totalBoards = Board::where('user_id', $user?->id)->count();
        $totalUsers = User::count();
        $totalTasks = (clone $userTaskQuery)->count();
        $completedTasks = (clone $userTaskQuery)
            ->whereHas('column', fn ($q) => $q->where('title', 'like', 'Conclu%'))
            ->count();
        $overdueTasks = (clone $userTaskQuery)
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->startOfDay())
            ->whereDoesntHave('column', fn ($q) => $q->where('title', 'like', 'Conclu%'))
            ->count();
        $highPriorityTasks = (clone $userTaskQuery)->where('priority', 'high')->count();

        $boards = Board::where('user_id', $user?->id)
            ->with(['columns.tasks'])
            ->get()
            ->map(function ($board) {
                $tasks = $board->columns->flatMap->tasks;

                $board->total_tasks = $tasks->count();
                $board->completed_tasks = $tasks->filter(fn ($task) => str_starts_with($task->column?->title ?? '', 'Conclu'))->count();
                $board->overdue_tasks = $tasks->filter(fn ($task) => $task->due_date && $task->due_date->isPast() && ! $task->due_date->isToday())->count();
                $board->risk_score = ($board->overdue_tasks * 3) + $tasks->where('priority', 'high')->count();

                return $board;
            });

        $priorityBreakdown = [
            'high' => (clone $userTaskQuery)->where('priority', 'high')->count(),
            'medium' => (clone $userTaskQuery)->where('priority', 'medium')->count(),
            'low' => (clone $userTaskQuery)->where('priority', 'low')->count(),
        ];

        $usersStats = User::withCount([
            'tasks as total_tasks' => fn ($q) => $q->whereHas('column.board', fn ($b) => $b->where('user_id', $user?->id)),
            'tasks as completed_tasks' => fn ($q) => $q->whereHas('column.board', fn ($b) => $b->where('user_id', $user?->id))
                ->whereHas('column', fn ($c) => $c->where('title', 'like', 'Conclu%')),
            'tasks as overdue_tasks' => fn ($q) => $q->whereHas('column.board', fn ($b) => $b->where('user_id', $user?->id))
                ->whereNotNull('due_date')
                ->where('due_date', '<', now()->startOfDay())
                ->whereDoesntHave('column', fn ($c) => $c->where('title', 'like', 'Conclu%')),
        ])->get();

        $recentActivities = Activity::with(['user', 'task.column.board'])
            ->whereHas('task.column.board', fn ($q) => $q->where('user_id', $user?->id))
            ->latest()
            ->take(10)
            ->get();

        $tasksDueThisWeek = (clone $userTaskQuery)
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->endOfWeek()])
            ->with(['column', 'assignee'])
            ->orderBy('due_date')
            ->take(8)
            ->get();

        $myWeek = [
            'today' => (clone $userTaskQuery)->whereDate('due_date', today())->with(['column.board', 'assignee'])->orderBy('priority')->take(6)->get(),
            'tomorrow' => (clone $userTaskQuery)->whereDate('due_date', today()->addDay())->with(['column.board', 'assignee'])->orderBy('priority')->take(6)->get(),
            'week' => (clone $userTaskQuery)->whereBetween('due_date', [today()->addDays(2), now()->endOfWeek()])->with(['column.board', 'assignee'])->orderBy('due_date')->take(8)->get(),
            'overdue' => (clone $userTaskQuery)
                ->whereNotNull('due_date')
                ->where('due_date', '<', today())
                ->whereDoesntHave('column', fn ($q) => $q->where('title', 'like', 'Conclu%'))
                ->with(['column.board', 'assignee'])
                ->orderBy('due_date')
                ->take(8)
                ->get(),
        ];

        $unassignedTasks = (clone $userTaskQuery)
            ->whereNull('user_id')
            ->whereDoesntHave('column', fn ($q) => $q->where('title', 'like', 'Conclu%'))
            ->with(['column.board'])
            ->latest()
            ->take(8)
            ->get();

        $riskyBoards = $boards->sortByDesc('risk_score')->take(4);

        $relevantActivities = Activity::with(['user', 'task.column.board'])
            ->whereHas('task.column.board', fn ($q) => $q->where('user_id', $user?->id))
            ->latest()
            ->take(6)
            ->get();

        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        $ticketQuery = Ticket::where('user_id', $user?->id);
        $ticketStats = [
            'total' => (clone $ticketQuery)->count(),
            'open' => (clone $ticketQuery)->whereIn('status', ['open', 'progress', 'waiting'])->count(),
            'slaRisk' => (clone $ticketQuery)
                ->whereNotIn('status', ['resolved'])
                ->whereNotNull('sla_due_at')
                ->where('sla_due_at', '<=', now()->addDay())
                ->count(),
        ];
        $ticketsDueSoon = (clone $ticketQuery)
            ->whereNotIn('status', ['resolved'])
            ->where(function ($query) {
                $query->whereBetween('due_date', [today(), now()->endOfWeek()])
                    ->orWhereBetween('sla_due_at', [now(), now()->addDays(3)]);
            })
            ->with(['assignee', 'board'])
            ->orderByRaw('COALESCE(sla_due_at, due_date)')
            ->take(6)
            ->get();

        return view('livewire.dashboard', [
            'totalBoards' => $totalBoards,
            'totalUsers' => $totalUsers,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'overdueTasks' => $overdueTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'completionRate' => $completionRate,
            'boards' => $boards,
            'priorityBreakdown' => $priorityBreakdown,
            'usersStats' => $usersStats,
            'recentActivities' => $recentActivities,
            'tasksDueThisWeek' => $tasksDueThisWeek,
            'myWeek' => $myWeek,
            'unassignedTasks' => $unassignedTasks,
            'riskyBoards' => $riskyBoards,
            'relevantActivities' => $relevantActivities,
            'ticketStats' => $ticketStats,
            'ticketsDueSoon' => $ticketsDueSoon,
        ]);
    }
}
