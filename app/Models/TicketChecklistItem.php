<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'title',
        'is_required',
        'requires_evidence',
        'is_completed',
        'evidence_note',
        'completed_at',
        'completed_by',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'requires_evidence' => 'boolean',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}
