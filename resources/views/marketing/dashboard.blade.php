<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Marketing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-50 to-blue-100 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-4xl font-bold text-blue-900 mb-8">Marketing Manager Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Registered Clients Tile -->
            <a href="{{ route('clients.index') }}" class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-blue-300 transition hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-blue-800">Registered Clients</h2>
                        <p class="text-sm text-gray-500 mt-2">View and manage your clients</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </a>

            <!-- Add New Client Tile -->
            <a href="{{ route('clients.create') }}" class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-blue-300 transition hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-green-700">+ New Client</h2>
                        <p class="text-sm text-gray-500 mt-2">Register a new client</p>
                    </div>
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </a>

            <!-- Reminder Tile -->
            <a  class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-blue-300 transition hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-blue-700">Reminders</h2>
                        <p class="text-sm text-gray-500 mt-2">View upcoming client reminders</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
            </a>

        </div>
    </div>

</body>
</html>
