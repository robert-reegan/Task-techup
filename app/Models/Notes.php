<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    protected $table = 'notes';
    protected $fillable = ['subject', 'task_id', 'attachment', 'note'];


    public static function storeData(array $data): array
    {
        $possibleFieldsToInsert = [
            'subject', 'task_id', 'attachment', 'note'
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
