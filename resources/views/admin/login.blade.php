<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Portal - UiTM Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 min-h-screen flex items-center justify-center">
    <!-- Animated background pattern -->
    <div class="absolute inset-0 z-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.4'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4v2c-3.314 0-6-2.686-6-6 0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <!-- Login Container -->
    <div class="relative z-10 bg-gray-800/80 backdrop-blur-lg border border-gray-700/30 p-8 rounded-2xl shadow-2xl w-full max-w-md transform transition-all hover:shadow-purple-500/10 hover:border-purple-500/30">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 mb-4">
                <img src="\images\uitmlogo.png" alt="UiTM Logo" class="w-32 h-24">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">
                    Admin Portal
                </h1>
            </div>
            <p class="text-gray-400">Secure access to Management Dashboard</p>
            <p class="text-gray-400">for Lost and Found </p>
        </div>

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/30 p-3 rounded-lg mb-6 flex items-center gap-2">
            <i class='bx bx-error-circle text-red-400'></i>
            <span class="text-red-300 text-sm">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email Input -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-300 uppercase tracking-wide">Admin Email</label>
                <div class="flex items-center bg-gray-700/50 border border-gray-600/30 rounded-lg px-3 transition focus-within:border-purple-500/50">
                    <i class='bx bx-envelope text-gray-400 mr-2'></i>
                    <input type="email" name="email" id="email" required
                           class="w-full py-3 bg-transparent text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-0">
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-300 uppercase tracking-wide">Password</label>
                <div class="flex items-center bg-gray-700/50 border border-gray-600/30 rounded-lg px-3 transition focus-within:border-purple-500/50">
                    <i class='bx bx-lock-alt text-gray-400 mr-2'></i>
                    <input type="password" name="password" id="password" required
                           class="w-full py-3 bg-transparent text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-0">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-500 hover:to-blue-400 text-white font-semibold py-3 px-4 rounded-lg transition-all transform hover:scale-[1.02] flex items-center justify-center gap-2">
                <i class='bx bx-log-in-circle'></i>
                Access Dashboard
            </button>
        </form>

            <!-- System Info Footer -->
            <div class="mt-6 text-center text-xs text-gray-500">
                <p>&copy; 2025 UiTM Lost & Found System</p>
                <p class="mt-1">v1.0 | Secure Admin Access</p>
            </div>
        </div>
    </div>

    <!-- Animated Background Circles -->
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-64 h-64 bg-purple-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-32 -right-32 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>
</body>
</html>
