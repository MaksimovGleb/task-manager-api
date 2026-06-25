<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Task Manager API</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-50 text-gray-900 font-sans min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto p-8 bg-white shadow-xl rounded-2xl text-center">
            <h1 class="text-4xl font-bold text-indigo-600 mb-4">Task Manager API</h1>
            <p class="text-xl text-gray-600 mb-8">
                Добро пожаловать в сервис управления задачами.
            </p>
            
            <div class="space-y-4 mb-10 text-left bg-gray-50 p-6 rounded-xl border border-gray-100">
                <h2 class="font-semibold text-lg text-gray-800">Функционал:</h2>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Полный CRUD для управления задачами</li>
                    <li>Автоматическое развертывание в Docker</li>
                    <li>Документация эндпоинтов в Swagger</li>
                    <li>Набор тестов для проверки стабильности</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/api/documentation" class="px-8 py-4 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition duration-200 shadow-lg shadow-indigo-200">
                    Swagger UI (Документация)
                </a>
                <a href="/api/tasks" class="px-8 py-4 bg-white text-indigo-600 border-2 border-indigo-600 font-semibold rounded-xl hover:bg-indigo-50 transition duration-200">
                    Список задач (API)
                </a>
            </div>
            
            <footer class="mt-12 text-sm text-gray-400">
                2026 &copy; Task Manager API Service
            </footer>
        </div>
    </body>
</html>
