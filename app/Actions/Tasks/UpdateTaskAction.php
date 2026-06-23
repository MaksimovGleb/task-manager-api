<?php

namespace App\Actions\Tasks;

use App\Dto\TaskDto;
use App\Models\Task;

class UpdateTaskAction
{
    public function execute(Task $task, TaskDto $data): bool
    {
        return $task->update($data->toArray());
    }
}
