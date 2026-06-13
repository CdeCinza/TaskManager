<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Carbon;

class Dashboard extends Component
{
    public $userBoards = [];

    public function mount()
    {
        $this->userBoards = auth()->user() ? auth()->user()->boards : collect();
    }

    public function setLocale($locale)
    {
        $validLocales = ['en', 'pt_BR', 'es'];
        if (in_array($locale, $validLocales)) {
            session()->put('locale', $locale);
            app()->setLocale($locale);
            return $this->redirectRoute('dashboard', navigate: true);
        }
    }

    public function render()
    {
        $user = auth()->user();

        // --- Global Stats ---
        $totalBoards   = Board::count();
        $totalUsers    = User::count();
        $totalTasks    = Task::count();
        $completedTasks = Task::whereHas('column', fn($q) => $q->where('title', 'Concluído'))->count();
        $overdueTasks  = Task::whereNotNull('due_date')
            ->where('due_date', '<', now()->startOfDay())
            ->whereDoesntHave('column', fn($q) => $q->where('title', 'Concluído'))
            ->count();
        $highPriorityTasks = Task::where('priority', 'high')->count();

        // --- Tasks per board ---
        $boards = Board::withCount(['columns as tasks_count' => function($q) {
            // We actually need tasks count, do it through columns relation chain
        }])->with(['columns.tasks'])->get()->map(function($board) {
            $board->total_tasks     = $board->columns->flatMap->tasks->count();
            $board->completed_tasks = $board->columns->flatMap->tasks->filter(fn($t) => $t->column?->title === 'Concluído')->count();
            $board->overdue_tasks   = $board->columns->flatMap->tasks->filter(function($t) {
                return $t->due_date && $t->due_date->isPast() && !$t->due_date->isToday();
            })->count();
            return $board;
        });

        // --- Priority breakdown ---
        $priorityBreakdown = [
            'high'   => Task::where('priority', 'high')->count(),
            'medium' => Task::where('priority', 'medium')->count(),
            'low'    => Task::where('priority', 'low')->count(),
        ];

        // --- Tasks per user ---
        $usersStats = User::withCount([
            'tasks as total_tasks',
            'tasks as completed_tasks' => fn($q) => $q->whereHas('column', fn($c) => $c->where('title', 'Concluído')),
            'tasks as overdue_tasks'   => fn($q) => $q->whereNotNull('due_date')
                ->where('due_date', '<', now()->startOfDay())
                ->whereDoesntHave('column', fn($c) => $c->where('title', 'Concluído')),
        ])->get();

        // --- Recent activity (last 10) ---
        $recentActivities = Activity::with(['user', 'task'])
            ->latest()
            ->take(10)
            ->get();

        // --- Tasks due this week ---
        $tasksDueThisWeek = Task::whereNotNull('due_date')
            ->whereBetween('due_date', [now()->startOfDay(), now()->endOfWeek()])
            ->with(['column', 'assignee'])
            ->orderBy('due_date')
            ->take(8)
            ->get();

        // --- Completion rate ---
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        return view('livewire.dashboard', [
            'totalBoards'        => $totalBoards,
            'totalUsers'         => $totalUsers,
            'totalTasks'         => $totalTasks,
            'completedTasks'     => $completedTasks,
            'overdueTasks'       => $overdueTasks,
            'highPriorityTasks'  => $highPriorityTasks,
            'completionRate'     => $completionRate,
            'boards'             => $boards,
            'priorityBreakdown'  => $priorityBreakdown,
            'usersStats'         => $usersStats,
            'recentActivities'   => $recentActivities,
            'tasksDueThisWeek'   => $tasksDueThisWeek,
        ]);
    }
}
