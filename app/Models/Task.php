<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';
    protected $fillable = ['subject', 'description', 'start_date', 'due_date', 'status', 'priority'];

    public function notes()
    {
        return $this->hasMany(Notes::class);
    }

    public static function getAll(array $filter = [])
    {
        return self::select('id', 'subject', 'description', 'start_date', 'due_date', 'status', 'priority')
            ->where($filter)
            ->orderBy('id', 'desc')
            ->get();
    }

    public static function filter(array $filter = [])
    {

        $q = Task::with('notes');

        if (isset($filter['status']) && $filter['status'] != "") {
            $q->where('status', '=', $filter['status']);
        }
        if (isset($filter['priority']) && $filter['priority'] != "") {
            $q->where('priority', '=', $filter['priority']);
        }
        if (isset($filter['due_date']) && $filter['due_date'] != "") {
            $q->where('due_date', '=', $filter['due_date']);
        }
        if (isset($filter['note']) && $filter['note'] != "") {
            $q->whereRelation("notes", "note", "like", "%{$filter['note']}%");
        }
        return $q->get();
    }

    public static function storeData(array $data): array
    {
        $possibleFieldsToInsert = [
            'subject', 'description', 'start_date', 'due_date', 'status', 'priority'
        ];

        $model = new self();
        foreach ($data as $column => $value) {
            if (in_array($column, $possibleFieldsToInsert)) {
                $model->$column = $value;
            }
        }

        return $model->save()
            ? [
                'is_success' => true,
                'data' => [
                    'id' => $model->id
                ]
            ]
            : [
                'is_success' => false
            ];
    }
}
