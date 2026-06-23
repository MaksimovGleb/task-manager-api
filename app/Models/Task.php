<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
