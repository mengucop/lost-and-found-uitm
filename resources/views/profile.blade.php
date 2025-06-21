<x-header>{{ session('student')['name'] ?? 'Guest' }}</x-header>

<!-- Add top spacing container -->
<div class="pt-6"> <!-- Added top padding for spacing -->
    <x-info><x-icon></x-icon></x-info>

    <div class="max-w-4xl mx-auto p-4">
        <!-- Added margin-top to site header for more spacing -->
        <div class="bg-sky-200 text-center py-3 mb-8 mt-4 rounded-lg shadow-md"> <!-- Added mt-4 -->
            <h1 class="text-2xl md:text-3xl font-bold">Lost & Found UiTM</h1>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <!-- Added mb-6 to avatar container -->
            <div class="p-6 flex flex-col items-center text-center mb-6"> <!-- Added mb-6 -->
                <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mb-4 border-4 border-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">{{ session('student')['name'] ?? 'Guest' }}</h1>
                <p class="text-gray-600 mt-2">UiTM Community Member</p> <!-- Increased mt-1 to mt-2 -->
            </div>

            <!-- Stats Section -->
            <div class="bg-gray-50 p-6 border-t">
                <!-- Added mb-6 to heading -->
                <h3 class="text-xl font-semibold text-center mb-6 text-gray-800">Your Activity Summary</h3> <!-- Increased mb-4 to mb-6 -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg text-center shadow-sm">
                        <p class="text-2xl font-bold text-gray-800">{{ session('student')['lost'] ?? 0 }}</p>
                        <p class="text-gray-600 text-sm mt-2">Lost Items</p> <!-- Added mt-2 -->
                    </div>
                    <div class="bg-white p-4 rounded-lg text-center shadow-sm">
                        <p class="text-2xl font-bold text-gray-800">{{ session('student')['found'] ?? 0 }}</p>
                        <p class="text-gray-600 text-sm mt-2">Found Items</p> <!-- Added mt-2 -->
                    </div>
                    <div class="bg-white p-4 rounded-lg text-center shadow-sm">
                        <p class="text-2xl font-bold text-gray-800">{{ session('student')['found_delivered'] ?? 0 }}</p>
                        <p class="text-gray-600 text-sm mt-2">Delivered</p> <!-- Added mt-2 -->
                    </div>
                    <div class="bg-white p-4 rounded-lg text-center shadow-sm">
                        <p class="text-2xl font-bold text-gray-800">{{ session('student')['lost_received'] ?? 0 }}</p>
                        <p class="text-gray-600 text-sm mt-2">Retrieved</p> <!-- Added mt-2 -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Profile Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <!-- Added mb-6 to heading -->
            <h3 class="text-xl font-semibold text-center mb-6 text-gray-800">Update Profile Information</h3> <!-- Increased mb-4 to mb-6 -->
            <form action="/profile/{{ session('student')['username'] ?? 'guest' }}" method="POST" class="max-w-md mx-auto">
                @csrf
                @method('PUT')
                <div class="mb-5"> <!-- Increased mb-4 to mb-5 -->
                    <label for="name" class="block text-gray-700 mb-3 font-medium">Your Name:</label> <!-- Increased mb-2 to mb-3 -->
                    <input type="text" name="name" id="name" value="{{ session('student')['name'] ?? '' }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition"> <!-- Increased py-2 to py-3 -->
                </div>
                <div class="text-center mt-8"> <!-- Increased mt-6 to mt-8 -->
                    <x-button class="px-6 py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Update Profile
                    </x-button>
                </div>
            </form>
        </div>

        <!-- Account Management -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <!-- Added mb-6 to heading -->
            <h3 class="text-xl font-semibold text-center mb-6 text-gray-800">Account Management</h3> <!-- Increased mb-4 to mb-6 -->
            <div class="max-w-md mx-auto text-center">
                <!-- Added mb-6 to paragraph -->
                <p class="text-gray-600 mb-6">Permanently delete your account and all associated data</p> <!-- Increased mb-4 to mb-6 -->
                <a href="/profile/{{ session('student')['username'] ?? 'guest' }}/delete" class="inline-block">
                    <x-delete_button class="px-6 py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete Account
                    </x-delete_button>
                </a>
            </div>
        </div>
    </div>
</div>
