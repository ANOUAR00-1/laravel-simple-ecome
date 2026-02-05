<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Laravel</title>
    <!-- Include Laravel's default Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Hello, Laravel!</h1>
            <p class="text-gray-600">Welcome to your first Laravel application. Here's what you can learn next:</p>
            
            <ul class="mt-4 space-y-2">
                <li class="flex items-center text-gray-700">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Routes and Controllers
                </li>
                <li class="flex items-center text-gray-700">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Database and Migrations
                </li>
                <li class="flex items-center text-gray-700">
                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Blade Templates
                </li>
            </ul>
            
            <div class="mt-6">
                <a href="https://laravel.com/docs" class="inline-block bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition-colors">
                    Read Documentation
                </a>
            </div>
        </div>
    </div>
</body>
</html>
