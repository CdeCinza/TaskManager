<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Column;
use App\Models\User;
use App\Models\Activity;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Activity::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'description' => json_encode(['key' => 'activity_created']),
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $userId = auth()->id();

        // 1. Column changed (drag-and-drop sorting / move column)
        if ($task->wasChanged('column_id')) {
            $oldColId = $task->getOriginal('column_id');
            $newColId = $task->column_id;

            $oldCol = Column::find($oldColId);
            $newCol = Column::find($newColId);

            $oldColName = $oldCol ? $oldCol->title : 'desconhecida';
            $newColName = $newCol ? $newCol->title : 'desconhecida';

            Activity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'description' => json_encode([
                    'key' => 'activity_moved',
                    'params' => ['old' => $oldColName, 'new' => $newColName]
                ]),
            ]);
        }

        // 2. Priority changed
        if ($task->wasChanged('priority')) {
            $priorities = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'];
            
            $oldPriorityRaw = $task->getOriginal('priority') ?? 'medium';
            $newPriorityRaw = $task->priority ?? 'medium';

            $oldPriority = $priorities[$oldPriorityRaw] ?? 'Média';
            $newPriority = $priorities[$newPriorityRaw] ?? 'Média';

            Activity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'description' => json_encode([
                    'key' => 'activity_priority',
                    'params' => ['old' => $oldPriority, 'new' => $newPriority]
                ]),
            ]);
        }

        // 3. Assignee changed
        if ($task->wasChanged('user_id')) {
            $oldUserId = $task->getOriginal('user_id');
            $newUserId = $task->user_id;

            $oldUser = $oldUserId ? User::find($oldUserId) : null;
            $newUser = $newUserId ? User::find($newUserId) : null;

            if ($oldUser && $newUser) {
                $description = json_encode([
                    'key' => 'activity_assigned_changed',
                    'params' => ['old' => $oldUser->name, 'new' => $newUser->name]
                ]);
            } elseif ($newUser) {
                $description = json_encode([
                    'key' => 'activity_assigned',
                    'params' => ['new' => $newUser->name]
                ]);
            } else {
                $description = json_encode([
                    'key' => 'activity_assigned_removed',
                    'params' => ['old' => $oldUser->name]
                ]);
            }

            Activity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'description' => $description,
            ]);
        }

        // 4. Title changed
        if ($task->wasChanged('title')) {
            $oldTitle = $task->getOriginal('title');
            $newTitle = $task->title;

            Activity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'description' => json_encode([
                    'key' => 'activity_title',
                    'params' => ['old' => $oldTitle, 'new' => $newTitle]
                ]),
            ]);
        }

        // 5. Description changed
        if ($task->wasChanged('description')) {
            $oldDesc = $task->getOriginal('description');
            $newDesc = $task->description;

            if (empty($oldDesc) && !empty($newDesc)) {
                $description = json_encode(['key' => 'activity_description_added']);
            } elseif (!empty($oldDesc) && empty($newDesc)) {
                $description = json_encode(['key' => 'activity_description_removed']);
            } else {
                $description = json_encode(['key' => 'activity_description_updated']);
            }

            Activity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'description' => $description,
            ]);
        }

        // 6. Due date changed
        if ($task->wasChanged('due_date')) {
            $oldDueDate = $task->getOriginal('due_date') ? \Carbon\Carbon::parse($task->getOriginal('due_date'))->format('d/m/Y') : null;
            $newDueDate = $task->due_date ? $task->due_date->format('d/m/Y') : null;

            if ($oldDueDate && $newDueDate) {
                $description = json_encode([
                    'key' => 'activity_due_date_changed',
                    'params' => ['old' => $oldDueDate, 'new' => $newDueDate]
                ]);
            } elseif ($newDueDate) {
                $description = json_encode([
                    'key' => 'activity_due_date_defined',
                    'params' => ['new' => $newDueDate]
                ]);
            } else {
                $description = json_encode([
                    'key' => 'activity_due_date_removed',
                    'params' => ['old' => $oldDueDate]
                ]);
            }

            Activity::create([
                'task_id' => $task->id,
                'user_id' => $userId,
                'description' => $description,
            ]);
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        if ($task->isForceDeleting()) {
            return;
        }

        Activity::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'description' => json_encode(['key' => 'activity_archived']),
        ]);
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        Activity::create([
            'task_id' => $task->id,
            'user_id' => auth()->id(),
            'description' => json_encode(['key' => 'activity_restored']),
        ]);
    }
}
