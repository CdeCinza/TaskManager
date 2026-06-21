<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assignee_id',
        'board_id',
        'title',
        'description',
        'requester_name',
        'requester_email',
        'origin',
        'status',
        'priority',
        'due_date',
        'sla_due_at',
        'resolved_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'sla_due_at' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function checklistItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TicketChecklistItem::class);
    }

    public function getChecklistProgressAttribute(): int
    {
        $total = $this->checklistItems->count();

        if ($total === 0) {
            return 0;
        }

        return (int) round(($this->checklistItems->where('is_completed', true)->count() / $total) * 100);
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
