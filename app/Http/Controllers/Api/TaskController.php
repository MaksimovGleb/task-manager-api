<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Tasks", description: "Операции с задачами")]
class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {}

    #[OA\Get(
        path: "/tasks",
        summary: "Получить список задач",
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(name: "search", in: "query", description: "Поиск по названию", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "sort", in: "query", description: "Сортировка (due_date, create_date, created_at)", schema: new OA\Schema(type: "string")),
            new OA\Parameter(name: "page", in: "query", description: "Номер страницы", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Список задач",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "data", type: "array", items: new OA\Items(ref: "#/components/schemas/Task")),
                        new OA\Property(property: "total", type: "integer"),
                        new OA\Property(property: "per_page", type: "integer")
                    ]
                )
            )
        ]
    )]
    public function index(Request $request)
    {
        return $this->taskService->list($request);
    }

    #[OA\Post(
        path: "/tasks",
        summary: "Создать новую задачу",
        tags: ["Tasks"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["title"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Задача1"),
                    new OA\Property(property: "description", type: "string", example: "Описание"),
                    new OA\Property(property: "due_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                    new OA\Property(property: "create_date", type: "string", format: "date-time", example: "2025-01-20T15:00:00"),
                    new OA\Property(property: "priority", type: "string", enum: ["низкий", "средний", "высокий"]),
                    new OA\Property(property: "category", type: "string", example: "Работа"),
                    new OA\Property(property: "status", type: "string", enum: ["выполнена", "не выполнена"])
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Задача создана",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "id", type: "string", format: "uuid"),
                        new OA\Property(property: "message", type: "string")
                    ]
                )
            )
        ]
    )]
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request->toDto());

        return response()->json([
            'id' => $task->id,
            'message' => 'Task created successfully'
        ], 201);
    }

    #[OA\Get(
        path: "/tasks/{id}",
        summary: "Получить конкретную задачу",
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID задачи", schema: new OA\Schema(type: "string", format: "uuid"))
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Данные задачи",
                content: new OA\JsonContent(ref: "#/components/schemas/Task")
            ),
            new OA\Response(response: 404, description: "Задача не найдена")
        ]
    )]
    public function show(string $id): JsonResponse|array|\App\Models\Task
    {
        $task = $this->taskService->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return $task;
    }

    #[OA\Put(
        path: "/tasks/{id}",
        summary: "Обновить задачу",
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID задачи", schema: new OA\Schema(type: "string", format: "uuid"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "title", type: "string"),
                    new OA\Property(property: "description", type: "string"),
                    new OA\Property(property: "due_date", type: "string", format: "date-time"),
                    new OA\Property(property: "priority", type: "string", enum: ["низкий", "средний", "высокий"]),
                    new OA\Property(property: "status", type: "string", enum: ["выполнена", "не выполнена"])
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Задача обновлена"),
            new OA\Response(response: 404, description: "Задача не найдена")
        ]
    )]
    public function update(UpdateTaskRequest $request, string $id): JsonResponse
    {
        $task = $this->taskService->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $this->taskService->update($task, $request->toDto());

        return response()->json(['message' => 'Task updated successfully']);
    }

    #[OA\Delete(
        path: "/tasks/{id}",
        summary: "Удалить задачу",
        tags: ["Tasks"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "ID задачи", schema: new OA\Schema(type: "string", format: "uuid"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Задача удалена"),
            new OA\Response(response: 404, description: "Задача не найдена")
        ]
    )]
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
