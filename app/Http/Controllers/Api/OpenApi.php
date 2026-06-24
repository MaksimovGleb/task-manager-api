<?php

namespace App\Http\Controllers\Api;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Task Manager API",
    version: "1.0.0",
    description: "REST API для управления списком задач",
    contact: new OA\Contact(email: "admin@example.com")
)]
#[OA\Server(
    url: "/api",
    description: "Основной API сервер"
)]
class OpenApi
{
}
