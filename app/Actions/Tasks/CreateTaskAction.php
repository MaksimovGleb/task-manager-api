<?php

namespace App\Actions\Tasks;

use App\Dto\TaskDto;
use App\Models\Task;

class CreateTaskAction
{
    public function execute(TaskDto $data): Task
    {
        return Task::create($data->toArray());
    }
}
