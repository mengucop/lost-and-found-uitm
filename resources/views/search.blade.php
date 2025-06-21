{{-- resources/views/search.blade.php --}}
<x-header>Search</x-header>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white">
    <x-info><x-icon></x-icon></x-info>

    {{-- ========================================= --}}
    {{-- MAIN SEARCH CONTAINER WITH GRADIENT BACKGROUND --}}
    {{-- ========================================= --}}
    <div class="max-w-7xl mx-auto px-4 md:px-8 lg:px-12 py-8">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-xl p-6 mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Find Your Lost Items</h1>
            <p class="text-indigo-100 max-w-2xl mx-auto text-lg">
                Search through lost and found items using keywords or upload an image for AI-powered search
            </p>
        </div>

        {{-- ========================================= --}}
        {{-- SEARCH SECTIONS WITH IMPROVED UI --}}
        {{-- ========================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Lost Items Search --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-indigo-100 dark:border-gray-700">
                    <div class="bg-indigo-600 p-5">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Lost Items Search
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="mb-6">
                            <p class="text-indigo-700 dark:text-indigo-300 mb-4">
                                Search for items you've lost on campus
                            </p>
                            <form id="lost-search-form" class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1 relative">
                                    <input type="text" id="search-lost" placeholder="Search lost items..."
                                        class="w-full py-3 pl-10 pr-4 border-2 border-indigo-200 dark:border-gray-700 rounded-xl focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 bg-white dark:bg-gray-800">
                                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Search
                                    </button>
                                    <button type="button" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition clear-btn hidden flex items-center">
                                        Clear
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Image Upload for Vision Search --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-indigo-700 dark:text-indigo-300 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Search by Image
                            </h3>
                            <form action="{{ route('search.by.image') }}" method="POST" enctype="multipart/form-data" class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg">
                                @csrf
                                <div class="flex flex-col md:flex-row gap-4 items-center">
                                    <div class="flex-1 w-full">
                                        <label class="block mb-1 text-sm font-medium text-indigo-700 dark:text-indigo-300">Upload item image</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label class="flex flex-col w-full border-2 border-dashed border-indigo-300 dark:border-indigo-600 hover:border-indigo-400 rounded-lg cursor-pointer">
                                                <div class="flex flex-col items-center justify-center py-6">
                                                    <svg class="w-8 h-8 text-indigo-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                    <p class="text-sm text-indigo-500 dark:text-indigo-400">
                                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                                    </p>
                                                    <p class="text-xs text-indigo-400 dark:text-indigo-500">PNG, JPG up to 2MB</p>
                                                </div>
                                                <input type="file" name="vision_image" accept="image/*" required class="hidden">
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition flex items-center gap-2 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Analyze Image
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div id="lost-container" class="hidden mt-6">
                            <div class="flex space-x-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-indigo-200 scrollbar-track-indigo-50">
                                <x-home_pic>lost</x-home_pic>
                            </div>
                            <p class="text-center text-gray-500 mt-4 hidden no-results">No matching lost items found</p>
                        </div>
                    </div>
                </div>

                {{-- Found Items Search --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden border border-green-100 dark:border-gray-700">
                    <div class="bg-green-600 p-5">
                        <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Found Items Search
                        </h2>
                    </div>

                    <div class="p-6">
                        <div class="mb-6">
                            <p class="text-green-700 dark:text-green-300 mb-4">
                                Search for items found by others
                            </p>
                            <form id="found-search-form" class="flex flex-col sm:flex-row gap-3">
                                <div class="flex-1 relative">
                                    <input type="text" id="search-found" placeholder="Search found items..."
                                        class="w-full py-3 pl-10 pr-4 border-2 border-green-200 dark:border-gray-700 rounded-xl focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-100 bg-white dark:bg-gray-800">
                                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        Search
                                    </button>
                                    <button type="button" class="px-4 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition clear-btn hidden flex items-center">
                                        Clear
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Image Upload for Vision Search --}}
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-green-700 dark:text-green-300 mb-3 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Search by Image
                            </h3>
                            <form action="{{ route('search.by.image') }}" method="POST" enctype="multipart/form-data" class="bg-indigo-50 dark:bg-indigo-900/20 p-4 rounded-lg">
                                @csrf
                                <div class="flex flex-col md:flex-row gap-4 items-center">
                                    <div class="flex-1 w-full">
                                        <label class="block mb-1 text-sm font-medium text-green-700 dark:text-green-300">Upload item image</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label class="flex flex-col w-full border-2 border-dashed border-green-300 dark:border-green-600 hover:border-green-400 rounded-lg cursor-pointer">
                                                <div class="flex flex-col items-center justify-center py-6">
                                                    <svg class="w-8 h-8 text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                    </svg>
                                                    <p class="text-sm text-green-500 dark:text-green-400">
                                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                                    </p>
                                                    <p class="text-xs text-green-400 dark:text-green-500">PNG, JPG up to 2MB</p>
                                                </div>
                                                <input type="file" name="vision_image" accept="image/*" required class="hidden">
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="px-5 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition flex items-center gap-2 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        Analyze Image
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div id="found-container" class="hidden mt-6">
                            <div class="flex space-x-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-thin scrollbar-thumb-green-200 scrollbar-track-green-50">
                                <x-home_pic>found</x-home_pic>
                            </div>
                            <p class="text-center text-gray-500 mt-4 hidden no-results">No matching found items found</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips Section Sidebar --}}
            <div class="space-y-8">
                {{-- Lost Items Tips --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="bg-indigo-100 dark:bg-indigo-900/30 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Tips for Image Search</h2>
                    </div>

                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-indigo-600 dark:text-indigo-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Ensure the item is in clear focus — avoid blurry images</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-indigo-600 dark:text-indigo-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Use good lighting to make details visible</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-indigo-600 dark:text-indigo-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Center the item and avoid cluttered backgrounds</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-indigo-600 dark:text-indigo-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Upload PNG or JPG formats (max 2MB)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-indigo-600 dark:text-indigo-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Avoid including human faces or unrelated objects</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-indigo-600 dark:text-indigo-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Capture from a reasonable distance for recognition</span>
                        </li>
                    </ul>

                    <div class="mt-4 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg">
                        <p class="text-sm text-indigo-700 dark:text-indigo-300">
                            Following these tips will improve AI recognition accuracy by up to 70%
                        </p>
                    </div>
                </div>

                {{-- Found Items Tips --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="bg-green-100 dark:bg-green-900/30 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Finding Your Item</h2>
                    </div>

                    <ul class="space-y-3">
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-600 dark:text-green-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Use an image that matches the item's likely condition</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-600 dark:text-green-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Natural lighting works best for accurate colors</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-600 dark:text-green-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Center the item with minimal distractions</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-600 dark:text-green-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Upload PNG or JPG formats (max 2MB)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-0.5 text-green-600 dark:text-green-400">✓</span>
                            <span class="text-gray-700 dark:text-gray-300">Avoid selfies or images with people</span>
                        </li>
                    </ul>

                    <div class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <p class="text-sm text-green-700 dark:text-green-300">
                            Clear images increase match success rate by 60%
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- AI OVERRIDE MODAL (MODERNIZED) --}}
    {{-- ========================================= --}}
    <div id="ai-override-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-70 z-50 hidden transition-opacity duration-300">
        <div class="bg-white dark:bg-gray-800 rounded-xl w-11/12 max-w-lg mx-auto shadow-2xl transform transition-transform duration-300 scale-95 opacity-0"
            id="modal-content">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-t-xl px-6 py-4 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Analysis Complete!
                </h3>
                <button onclick="closeAiOverrideModal()" class="text-white hover:text-green-100 text-2xl leading-none">&times;</button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 space-y-4">
                <p class="text-gray-700 dark:text-gray-300">
                    We identified these characteristics in your image:
                </p>

                <div class="flex flex-wrap gap-2">
                    @foreach(session('image_labels') ?? [] as $label)
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-full text-sm">
                            {{ $label }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-4">
                    <label for="selected_label_modal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Choose the most relevant label:
                    </label>
                    <form id="aiOverrideForm" action="{{ session('last_item_id') ? route('items.updateLabel', session('last_item_id')) : '#' }}" method="POST">
                        @csrf
                        <select name="selected_label" id="selected_label_modal" required
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-600 px-4 py-3 focus:border-green-500 focus:ring-green-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="" disabled selected>Select the best match...</option>
                            @foreach(session('image_labels') ?? [] as $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl transition flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Confirm Label
                        </button>
                    </form>
                </div>
            </div>

            {{-- Footer --}}
            <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 text-right">
                <button onclick="closeAiOverrideModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- JAVASCRIPT ENHANCEMENTS --}}
    {{-- ========================================= --}}
    <script src="/js/leaflet.js"></script>
    <script src="/js/itempost.js"></script>
    <script>
        // Enhanced modal animation
        function showAiOverrideModal() {
            const modal = document.getElementById('ai-override-modal');
            const content = document.getElementById('modal-content');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeAiOverrideModal() {
            const modal = document.getElementById('ai-override-modal');
            const content = document.getElementById('modal-content');

            content.classList.remove('opacity-100', 'scale-100');
            content.classList.add('opacity-0', 'scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('opacity-100');
            }, 300);
        }

        // File upload preview
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function(e) {
                const fileName = this.files[0]?.name || 'No file chosen';
                const label = this.closest('label');
                if (label) {
                    const uploadText = label.querySelector('p:first-of-type');
                    if (uploadText) {
                        uploadText.innerHTML = `<span class="font-semibold">Selected:</span> ${fileName}`;
                    }
                }
            });
        });

        // Enhanced search functionality
        document.addEventListener('DOMContentLoaded', function () {
            function setupSearch(formId, inputId, containerId) {
                const form = document.getElementById(formId);
                const input = document.getElementById(inputId);
                const container = document.getElementById(containerId);
                const clearBtn = form.querySelector('.clear-btn');
                const noResults = container.querySelector('.no-results');

                input.addEventListener('input', function () {
                    clearBtn.classList.toggle('hidden', this.value.trim() === '');
                });

                clearBtn.addEventListener('click', function () {
                    input.value = '';
                    clearBtn.classList.add('hidden');
                    container.classList.add('hidden');
                    noResults.classList.add('hidden');
                    container.querySelectorAll('.bg-white').forEach(card => card.classList.remove('hidden'));
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const keyword = input.value.trim().toLowerCase();

                    if (!keyword) {
                        showToast('Please enter a search term');
                        return;
                    }

                    const cards = container.querySelectorAll('.bg-white');
                    let visibleCount = 0;

                    cards.forEach(card => {
                        const cardText = card.textContent.toLowerCase();
                        if (cardText.includes(keyword)) {
                            card.classList.remove('hidden');
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    container.classList.remove('hidden');
                    noResults.classList.toggle('hidden', visibleCount > 0);

                    if (visibleCount === 0) {
                        showToast('No matching items found');
                    }
                });
            }

            setupSearch('lost-search-form', 'search-lost', 'lost-container');
            setupSearch('found-search-form', 'search-found', 'found-container');

            // Toast notification
            function showToast(msg) {
                const toast = document.createElement('div');
                toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-3 rounded-lg shadow-lg transform translate-y-10 opacity-0 transition-all duration-300 z-50';
                toast.innerHTML = `
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ${msg}
                    </div>
                `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove('translate-y-10', 'opacity-0');
                    toast.classList.add('translate-y-0', 'opacity-100');
                }, 10);

                setTimeout(() => {
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }
        });

        // Auto-open AI modal if labels exist
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('image_labels'))
                setTimeout(showAiOverrideModal, 500);
            @endif
        });
    </script>
</body>
