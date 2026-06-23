<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class UpdateTaskAction
{
    public function execute(Task $task, array $data): bool
    {
        return $task->update($data);
    }
}
