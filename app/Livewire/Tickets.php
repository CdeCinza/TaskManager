<?php

namespace App\Livewire;

use App\Models\Board;
use App\Models\Ticket;
use App\Models\TicketChecklistItem;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Tickets extends Component
{
    use WithFileUploads;
    public $userBoards = [];
    public $users = [];
    public string $filterStatus = '';
    public string $filterPriority = '';
    public string $search = '';
    public $selectedTicket = null;
    public bool $showCreateModal = false;
    public string $newChecklistItem = '';
    public $newAttachments = [];

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

    public function messages(): array
    {
        return [
            'form.title.required' => __('O título do chamado é obrigatório.'),
            'form.title.string' => __('O título do chamado deve ser um texto válido.'),
            'form.title.max' => __('O título não pode ter mais de 255 caracteres.'),
            'form.requester_name.string' => __('O nome do solicitante deve ser um texto válido.'),
            'form.requester_name.max' => __('O nome do solicitante não pode ter mais de 255 caracteres.'),
            'form.requester_email.email' => __('Por favor, insira um e-mail válido.'),
            'form.requester_email.max' => __('O e-mail não pode ter mais de 255 caracteres.'),
            'form.origin.required' => __('A origem do chamado é obrigatória.'),
            'form.origin.string' => __('A origem do chamado deve ser um texto válido.'),
            'form.origin.max' => __('A origem do chamado não pode ter mais de 50 caracteres.'),
            'form.status.required' => __('O status do chamado é obrigatório.'),
            'form.status.string' => __('O status do chamado deve ser um texto válido.'),
            'form.status.max' => __('O status do chamado não pode ter mais de 50 caracteres.'),
            'form.priority.required' => __('A prioridade do chamado é obrigatória.'),
            'form.priority.string' => __('A prioridade do chamado deve ser um texto válido.'),
            'form.priority.max' => __('A prioridade do chamado não pode ter mais de 50 caracteres.'),
            'form.assignee_id.exists' => __('O responsável selecionado não é válido.'),
            'form.board_id.exists' => __('O quadro selecionado não é válido.'),
            'form.due_date.date' => __('A data de vencimento deve ser uma data válida.'),
            'form.sla_due_at.date' => __('O SLA deve ser uma data/hora válida.'),
        ];
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
            ->with(['assignee', 'board', 'checklistItems', 'attachments'])
            ->find($ticketId);
    }

    public function closeTicket(): void
    {
        $this->selectedTicket = null;
        $this->newChecklistItem = '';
        $this->newAttachments = [];
    }

    public function uploadAttachments(): void
    {
        if (!$this->selectedTicket) {
            return;
        }

        $this->validate([
            'newAttachments' => ['required', 'array'],
            'newAttachments.*' => ['required', 'file', 'max:10240'], // 10MB max
        ]);

        $ticket = Ticket::query()
            ->where('user_id', auth()->id())
            ->find($this->selectedTicket->id);

        if (!$ticket) {
            $this->closeTicket();
            return;
        }

        foreach ($this->newAttachments as $file) {
            $path = $file->store('attachments', 'public');

            $ticket->attachments()->create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'user_id' => auth()->id(),
            ]);
        }

        $this->newAttachments = [];
        $this->resetValidation('newAttachments');
        $this->openTicket($ticket->id);
    }

    public function deleteAttachment($attachmentId)
    {
        if (!$this->selectedTicket || $this->selectedTicket->user_id !== auth()->id()) return;

        $attachment = $this->selectedTicket->attachments()->findOrFail($attachmentId);
        
        \Illuminate\Support\Facades\Storage::disk('public')->delete($attachment->path);
        
        $attachment->delete();

        $this->refreshSelectedTicket();
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
