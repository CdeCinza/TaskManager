<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'description'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parse and format the logged JSON description into a translated string.
     */
    public function getFormattedDescriptionAttribute(): string
    {
        $data = json_decode($this->description, true);
        if (json_last_error() !== JSON_ERROR_NONE || ! isset($data['key'])) {
            return $this->description;
        }

        $key = $data['key'];
        $params = $data['params'] ?? [];

        switch ($key) {
            case 'activity_created':
                return __('criou a tarefa');
            case 'activity_moved':
                return __('moveu a tarefa de :old para :new', [
                    'old' => isset($params['old']) ? __($params['old']) : '',
                    'new' => isset($params['new']) ? __($params['new']) : '',
                ]);
            case 'activity_priority':
                return __('alterou a prioridade de :old para :new', [
                    'old' => isset($params['old']) ? __($params['old']) : '',
                    'new' => isset($params['new']) ? __($params['new']) : '',
                ]);
            case 'activity_assigned_changed':
                return __('alterou o responsável de :old para :new', [
                    'old' => $params['old'] ?? '',
                    'new' => $params['new'] ?? '',
                ]);
            case 'activity_assigned':
                return __('atribuiu a tarefa para :new', [
                    'new' => $params['new'] ?? '',
                ]);
            case 'activity_assigned_removed':
                return __('removeu :old como responsável', [
                    'old' => $params['old'] ?? '',
                ]);
            case 'activity_title':
                return __('alterou o título de :old para :new', [
                    'old' => $params['old'] ?? '',
                    'new' => $params['new'] ?? '',
                ]);
            case 'activity_description_added':
                return __('adicionou uma descrição');
            case 'activity_description_removed':
                return __('removeu a descrição');
            case 'activity_description_updated':
                return __('atualizou a descrição');
            case 'activity_due_date_changed':
                return __('alterou o prazo de :old para :new', [
                    'old' => $params['old'] ?? '',
                    'new' => $params['new'] ?? '',
                ]);
            case 'activity_due_date_defined':
                return __('definiu o prazo para :new', [
                    'new' => $params['new'] ?? '',
                ]);
            case 'activity_due_date_removed':
                return __('removeu o prazo de :old', [
                    'old' => $params['old'] ?? '',
                ]);
            case 'activity_archived':
                return __('arquivou a tarefa');
            case 'activity_restored':
                return __('restaurou a tarefa');
            default:
                return $key;
        }
    }
}
