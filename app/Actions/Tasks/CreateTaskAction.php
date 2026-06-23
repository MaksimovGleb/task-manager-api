<?php

namespace App\Actions\Tasks;

use App\Models\Task;

class CreateTaskAction
{
    public function execute(array $data): Task
    {
        return Task::create($data);
    }
}
