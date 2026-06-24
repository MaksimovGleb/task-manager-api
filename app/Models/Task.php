<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Task",
    title: "Task",
    description: "Модель задачи",
    properties: [
        new OA\Property(property: "id", type: "string", format: "uuid", example: "550e8400-e29b-41d4-a716-446655440000"),
        new OA\Property(property: "title", type: "string", description: "Название задачи", example: "Купить хлеб"),
        new OA\Property(property: "description", type: "string", description: "Описание задачи", example: "Зайти в булочную после работы"),
        new OA\Property(property: "due_date", type: "string", format: "date-time", description: "Срок выполнения", example: "2025-01-20T15:00:00Z"),
        new OA\Property(property: "create_date", type: "string", format: "date-time", description: "Дата создания (из запроса)", example: "2025-01-20T15:00:00Z"),
        new OA\Property(property: "status", type: "string", enum: ["выполнена", "не выполнена"], example: "не выполнена"),
        new OA\Property(property: "priority", type: "string", enum: ["низкий", "средний", "высокий"], example: "средний"),
        new OA\Property(property: "category", type: "string", description: "Категория", example: "Дом"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ]
)]
class Task extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'create_date',
        'status',
        'priority',
        'category',
    ];

    /**
     * Scope для фильтрации и сортировки задач.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        $sortField = $filters['sort'] ?? null;
        $allowedSortFields = ['due_date', 'create_date', 'created_at'];

        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }
}
