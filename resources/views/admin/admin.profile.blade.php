<x-header>{{ session('admin')['name'] ?? 'Admin' }}</x-header>

<body>
    <x-info><x-icon></x-icon></x-info>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ session('admin')['name'] ?? 'Admin' }}'s Profile | Lost & Found UiTM</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100">
    <!-- Header -->
    <div class="bg-sky-200 text-center py-2 text-3xl">
        <h1>Lost & Found UiTM - Admin Panel</h1>
    </div>

    <div class="max-w-3xl mx-auto p-4">
        <!-- Profile Info -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-blue-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">{{ session('admin')['name'] ?? 'Admin' }}</h1>
        </div>

        <!-- Admin Stats -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold text-center mb-4 text-gray-800">{{ session('admin')['name'] ?? 'Admin' }}'s Overview</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tr class="bg-gray-50">
                        <x-row_header>Reports Reviewed</x-row_header>
                        <x-row_header>Items Approved</x-row_header>
                        <x-row_header>Items Archived</x-row_header>
                    </tr>
                    <tr>
                        <x-row_data class="text-center">{{ session('admin')['reviewed'] ?? 0 }}</x-row_data>
                        <x-row_data class="text-center">{{ session('admin')['approved'] ?? 0 }}</x-row_data>
                        <x-row_data class="text-center">{{ session('admin')['archived'] ?? 0 }}</x-row_data>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Update Admin Profile -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold text-center mb-4 text-gray-800">Update Profile</h3>
            <form action="/admin/profile/{{ session('admin')['username'] ?? 'admin' }}" method="POST" class="max-w-md mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 mb-2">Your Name:</label>
                    <input type="text" name="name" id="name" value="{{ session('admin')['name'] ?? '' }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="text-center">
                    <x-button>Update</x-button>
                </div>
            </form>
        </div>

        <!-- Delete Admin Profile -->
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <h3 class="text-xl font-semibold mb-4 text-gray-800">Delete Profile</h3>
            <a href="/admin/profile/{{ session('admin')['username'] ?? 'admin' }}/delete" class="inline-block">
                <x-delete_button>Delete</x-delete_button>
            </a>
        </div>
    </div>
</body>
</html>
