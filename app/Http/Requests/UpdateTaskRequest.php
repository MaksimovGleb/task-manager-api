<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'create_date' => 'nullable|date',
            'priority' => 'nullable|string|in:низкий,средний,высокий',
            'category' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:выполнена,не выполнена',
        ];
    }
}
