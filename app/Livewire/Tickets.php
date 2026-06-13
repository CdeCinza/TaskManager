<?php

namespace App\Livewire;

use App\Models\Board;
use App\Models\Ticket;
use App\Models\TicketChecklistItem;
use App\Models\User;
use Livewire\Component;

class Tickets extends Component
{
    public $userBoards = [];
    public $users = [];
    public string $filterStatus = '';
    public string $filterPriority = '';
    public string $search = '';
    public $selectedTicket = null;
    public bool $showCreateModal = false;
    public string $newChecklistItem = '';

    public array $form = [
        'title' => '',
        'description' => '',
        'requester_name' => '',
        'requester_email' => '',
        'origin' => 'portal',
        'status' => 'open',
        'priority' => 'medium',
        'assignee_id' => '',
        'board_id' => '',
        'due_date' => '',
        'sla_due_at' => '',
    ];

    public function mount(): void
    {
        $this->userBoards = auth()->user()?->boards ?? collect();
        $this->users = User::orderBy('name')->get();
    }

    public function setLocale($locale)
    {
        if (in_array($locale, ['en', 'pt_BR', 'es'], true)) {
            session()->put('locale', $locale);
            app()->setLocale($locale);

            return $this->redirectRoute('tickets', navigate: true);
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
    }

    public function createTicket(): void
    {
        $validated = $this->validate([
            'form.title' => ['required', 'string', 'max:255'],
            'form.description' => ['nullable', 'string'],
            'form.requester_name' => ['nullable', 'string', 'max:255'],
            'form.requester_email' => ['nullable', 'email', 'max:255'],
            'form.origin' => ['required', 'string', 'max:50'],
            'form.status' => ['required', 'string', 'max:50'],
            'form.priority' => ['required', 'string', 'max:50'],
            'form.assignee_id' => ['nullable', 'exists:users,id'],
            'form.board_id' => ['nullable', 'exists:boards,id'],
            'form.due_date' => ['nullable', 'date'],
            'form.sla_due_at' => ['nullable', 'date'],
        ])['form'];

        $ticket = Ticket::create([
            ...$validated,
            'user_id' => auth()->id(),
            'assignee_id' => $validated['assignee_id'] ?: null,
            'board_id' => $validated['board_id'] ?: null,
            'due_date' => $validated['due_date'] ?: null,
            'sla_due_at' => $validated['sla_due_at'] ?: null,
            'resolved_at' => $validated['status'] === 'resolved' ? now() : null,
        ]);

        foreach (['Triagem inicial', 'Diagnóstico documentado', 'Solução validada com solicitante'] as $title) {
            $ticket->checklistItems()->create(['title' => $title]);
        }

        $this->showCreateModal = false;
        $this->openTicket($ticket->id);
    }

    public function openTicket(int $ticketId): void
    {
        $this->selectedTicket = $this->baseTicketQuery()
            ->with(['assignee', 'board', 'checklistItems'])
            ->find($ticketId);
    }

    public function closeTicket(): void
    {
        $this->selectedTicket = null;
        $this->newChecklistItem = '';
    }

    public function updateTicketField(string $field, $value): void
    {
        if (!$this->selectedTicket || !in_array($field, ['status', 'priority', 'assignee_id', 'board_id'], true)) {
            return;
        }

        $value = $value === '' ? null : $value;
        $this->selectedTicket->update([
            $field => $value,
            'resolved_at' => $field === 'status' && $value === 'resolved' ? now() : ($field === 'status' ? null : $this->selectedTicket->resolved_at),
        ]);

        $this->refreshSelectedTicket();
    }

    public function addChecklistItem(): void
    {
        if (!$this->selectedTicket || trim($this->newChecklistItem) === '') {
            return;
        }

        $this->selectedTicket->checklistItems()->create([
            'title' => trim($this->newChecklistItem),
        ]);

        $this->newChecklistItem = '';
        $this->refreshSelectedTicket();
    }

    public function toggleChecklistItem(int $itemId): void
    {
        $item = TicketChecklistItem::whereHas('ticket', fn($query) => $query->where('user_id', auth()->id()))->findOrFail($itemId);

        $item->update([
            'is_completed' => !$item->is_completed,
            'completed_at' => $item->is_completed ? null : now(),
            'completed_by' => $item->is_completed ? null : auth()->id(),
        ]);

        $this->refreshSelectedTicket();
    }

    public function deleteChecklistItem(int $itemId): void
    {
        TicketChecklistItem::whereHas('ticket', fn($query) => $query->where('user_id', auth()->id()))->findOrFail($itemId)->delete();
        $this->refreshSelectedTicket();
    }

    public function render()
    {
        $tickets = $this->baseTicketQuery()
            ->with(['assignee', 'board', 'checklistItems'])
            ->latest()
            ->get();

        $stats = [
            'open' => (clone $this->baseTicketQuery())->where('status', 'open')->count(),
            'progress' => (clone $this->baseTicketQuery())->where('status', 'progress')->count(),
            'waiting' => (clone $this->baseTicketQuery())->where('status', 'waiting')->count(),
            'slaRisk' => (clone $this->baseTicketQuery())
                ->whereNotIn('status', ['resolved'])
                ->whereNotNull('sla_due_at')
                ->where('sla_due_at', '<=', now()->addDay())
                ->count(),
        ];

        return view('livewire.tickets', [
            'tickets' => $tickets,
            'ticketsByStatus' => $tickets->groupBy('status'),
            'stats' => $stats,
            'boards' => Board::where('user_id', auth()->id())->orderBy('title')->get(),
        ]);
    }

    private function baseTicketQuery()
    {
        return Ticket::query()
            ->where('user_id', auth()->id())
            ->when($this->filterStatus !== '', fn($query) => $query->where('status', $this->filterStatus))
            ->when($this->filterPriority !== '', fn($query) => $query->where('priority', $this->filterPriority))
            ->when(trim($this->search) !== '', fn($query) => $query->where(function ($nested) {
                $term = '%' . trim($this->search) . '%';
                $nested->where('title', 'like', $term)
                    ->orWhere('requester_name', 'like', $term)
                    ->orWhere('requester_email', 'like', $term);
            }));
    }

    private function resetForm(): void
    {
        $this->form = [
            'title' => '',
            'description' => '',
            'requester_name' => '',
            'requester_email' => '',
            'origin' => 'portal',
            'status' => 'open',
            'priority' => 'medium',
            'assignee_id' => '',
            'board_id' => '',
            'due_date' => '',
            'sla_due_at' => '',
        ];
    }

    private function refreshSelectedTicket(): void
    {
        if ($this->selectedTicket) {
            $this->openTicket($this->selectedTicket->id);
        }
    }
}
