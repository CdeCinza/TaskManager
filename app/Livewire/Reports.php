<?php

namespace App\Livewire;

use App\Models\Board;
use App\Models\Task;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Carbon;

class Reports extends Component
{
    public $userBoards = [];
    public $startDate;
    public $endDate;
    public $filterPreset = '30';

    public function mount()
    {
        $this->userBoards = auth()->user() ? auth()->user()->boards : collect();
        $this->setPreset('30');
    }

    public function setPreset($days)
    {
        $this->filterPreset = $days;
        
        if ($days === 'all') {
            $this->startDate = Carbon::create(2000, 1, 1)->format('Y-m-d');
            $this->endDate = now()->format('Y-m-d');
        } elseif ($days === 'this_month') {
            $this->startDate = now()->startOfMonth()->format('Y-m-d');
            $this->endDate = now()->endOfMonth()->format('Y-m-d');
        } else {
            $this->startDate = now()->subDays((int)$days)->format('Y-m-d');
            $this->endDate = now()->format('Y-m-d');
        }
    }

    public function setLocale($locale)
    {
        $validLocales = ['en', 'pt_BR', 'es'];
        if (in_array($locale, $validLocales, true)) {
            session()->put('locale', $locale);
            app()->setLocale($locale);
            return $this->redirectRoute('reports', navigate: true);
        }
    }

    public function render()
    {
        $user = auth()->user();
        $start = Carbon::parse($this->startDate)->startOfDay();
        $end = Carbon::parse($this->endDate)->endOfDay();

        // 1. Task Efficiency: completed on time vs overdue vs pending
        $taskQuery = Task::whereHas('column.board', fn($q) => $q->where('user_id', $user?->id))
            ->whereBetween('created_at', [$start, $end]);

        $totalTasks = (clone $taskQuery)->count();
        $completedTasks = (clone $taskQuery)
            ->whereHas('column', fn($q) => $q->where('title', 'like', 'Conclu%'))
            ->get();
            
        $completedCount = $completedTasks->count();
        
        $completedOnTime = $completedTasks->filter(function($task) {
            return !$task->due_date || $task->updated_at->startOfDay()->lte($task->due_date->startOfDay());
        })->count();
        
        $completedLate = $completedCount - $completedOnTime;

        $pendingTasks = (clone $taskQuery)
            ->whereDoesntHave('column', fn($q) => $q->where('title', 'like', 'Conclu%'))
            ->get();

        $pendingCount = $pendingTasks->count();

        $pendingOverdue = $pendingTasks->filter(function($task) {
            return $task->due_date && $task->due_date->isPast() && !$task->due_date->isToday();
        })->count();

        $pendingActive = $pendingCount - $pendingOverdue;

        // 2. Ticket SLA Performance
        $ticketQuery = Ticket::where('user_id', $user?->id)
            ->whereBetween('created_at', [$start, $end]);

        $totalTickets = (clone $ticketQuery)->count();
        $resolvedTickets = (clone $ticketQuery)->where('status', 'resolved')->get();
        $resolvedCount = $resolvedTickets->count();

        $resolvedOnTime = $resolvedTickets->filter(function($ticket) {
            return !$ticket->sla_due_at || $ticket->resolved_at->lte($ticket->sla_due_at);
        })->count();
        $resolvedLate = $resolvedCount - $resolvedOnTime;

        $unresolvedTickets = (clone $ticketQuery)->whereNotIn('status', ['resolved'])->get();
        $unresolvedCount = $unresolvedTickets->count();

        $unresolvedOverdue = $unresolvedTickets->filter(function($ticket) {
            return $ticket->sla_due_at && $ticket->sla_due_at->isPast();
        })->count();
        $unresolvedActive = $unresolvedCount - $unresolvedOverdue;

        // 3. Performance per Team Member (Tickets resolved & SLA compliance)
        $members = User::with(['tickets' => function($q) use ($start, $end) {
            $q->whereBetween('created_at', [$start, $end]);
        }])->get()->map(function($member) {
            $memberTickets = $member->tickets;
            $total = $memberTickets->count();
            $resolved = $memberTickets->where('status', 'resolved');
            $resolvedCount = $resolved->count();
            
            $onTime = $resolved->filter(function($t) {
                return !$t->sla_due_at || $t->resolved_at->lte($t->sla_due_at);
            })->count();

            $member->total_tickets = $total;
            $member->resolved_tickets = $resolvedCount;
            $member->sla_compliance = $resolvedCount > 0 ? round(($onTime / $resolvedCount) * 100) : 100;
            return $member;
        })->filter(fn($m) => $m->total_tickets > 0)->sortByDesc('resolved_tickets')->values();

        // 4. Ticket Origins breakdown
        $originsBreakdown = [
            'portal' => (clone $ticketQuery)->where('origin', 'portal')->count(),
            'email' => (clone $ticketQuery)->where('origin', 'email')->count(),
            'whatsapp' => (clone $ticketQuery)->where('origin', 'whatsapp')->count(),
            'phone' => (clone $ticketQuery)->where('origin', 'phone')->count(),
        ];

        return view('livewire.reports', [
            'totalTasks' => $totalTasks,
            'completedOnTime' => $completedOnTime,
            'completedLate' => $completedLate,
            'pendingOverdue' => $pendingOverdue,
            'pendingActive' => $pendingActive,
            
            'totalTickets' => $totalTickets,
            'resolvedOnTime' => $resolvedOnTime,
            'resolvedLate' => $resolvedLate,
            'unresolvedOverdue' => $unresolvedOverdue,
            'unresolvedActive' => $unresolvedActive,
            
            'members' => $members,
            'originsBreakdown' => $originsBreakdown,
            'boards' => Board::where('user_id', $user?->id)->withCount([
                'columns as total_tasks' => fn($q) => $q->join('tasks', 'columns.id', '=', 'tasks.column_id'),
                'columns as completed_tasks' => fn($q) => $q->join('tasks', 'columns.id', '=', 'tasks.column_id')->where('columns.title', 'like', 'Conclu%')
            ])->get()
        ]);
    }
}
