<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    /**
     * Отобразить список задач.
     */
    public function index(Request $request)
    {
        return $this->taskService->list($request);
    }

    /**
     * Сохранить новую задачу в хранилище.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request->toDto());

        return response()->json([
            'id' => $task->id,
            'message' => 'Task created successfully'
        ], 201);
    }

    /**
     * Отобразить указанную задачу.
     */
    public function show(string $id): JsonResponse|array|\App\Models\Task
    {
        $task = $this->taskService->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return $task;
    }

    /**
     * Обновить указанную задачу в хранилище.
     */
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = $this->taskService->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $this->taskService->update($task, $request->toDto());

        return response()->json(['message' => 'Task updated successfully']);
    }

    /**
     * Удалить указанную задачу из хранилища.
     */
    public function destroy(string $id): JsonResponse
    {
        $task = $this->taskService->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $this->taskService->delete($task);

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
