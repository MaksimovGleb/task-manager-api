<?php

namespace App\Services;

use App\Actions\Tasks\CreateTaskAction;
use App\Actions\Tasks\DeleteTaskAction;
use App\Actions\Tasks\UpdateTaskAction;
use App\Dto\TaskDto;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class TaskService
{
    public function __construct(
        protected CreateTaskAction $createAction,
        protected UpdateTaskAction $updateAction,
        protected DeleteTaskAction $deleteAction
    ) {}

    public function list(Request $request): LengthAwarePaginator
    {
        return Task::filter($request->all())
            ->paginate($request->get('per_page', 10));
    }

    public function create(TaskDto $data): Task
    {
        return $this->createAction->execute($data);
    }

    public function update(Task $task, TaskDto $data): Task
    {
        $this->updateAction->execute($task, $data);
        return $task->fresh();
    }

    public function delete(Task $task): bool
    {
        return $this->deleteAction->execute($task);
    }

    public function find(string $id): ?Task
    {
        return Task::find($id);
    }
}
