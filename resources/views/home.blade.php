<x-header>Homepage</x-header>

<body class="bg-gradient-to-b from-gray-50 to-gray-100">
    <div id="toast" class="fixed bottom-6 right-6 z-50 hidden px-5 py-3 rounded-md shadow-lg text-white bg-green-600 transition-all duration-300">
        <span id="toastMsg">Message here</span>
    </div>


    <x-info><x-icon></x-icon></x-info>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-2xl font-bold text-indigo-800 mb-4">UiTM Lost & Found Portal</h1>
            </p>
        </div>

        <!-- Map Section -->
        <div class="mb-12 bg-white rounded-xl shadow-lg overflow-hidden">
            <div id="lostItemsMap" class="w-full h-96 rounded-lg"></div>
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                <p class="text-sm text-gray-600 text-center">
                    <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span> Lost items
                    <span class="inline-block w-3 h-3 rounded-full bg-green-500 ml-4 mr-2"></span> Found items
                </p>
            </div>
        </div>

        <!-- Post Item Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
            <!-- Post Form -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-indigo-700 text-white">
                    <h2 class="text-2xl font-bold">Report a Lost or Found Item</h2>
                    <p class="opacity-90">Help our community reunite with their belongings</p>
                </div>

                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg">
                            <ul class="list-disc pl-5 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('home.add', session('student.username')) }}" method="POST" enctype="multipart/form-data" id="itemForm" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Item Status</label>
                                <select name="type" id="type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                    <option value="">-- Select Status --</option>
                                    <option value="lost">I Lost Something</option>
                                    <option value="found">I Found Something</option>
                                </select>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Item Description</label>
                                <input type="text" name="description" id="description" required placeholder="e.g. Black wallet with student ID"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Location on Map</label>
                            <div id="selectLocationMap" class="w-full h-64 rounded-lg border border-gray-300"></div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Latitude</label>
                                    <input type="text" id="lat" name="latitude" readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Longitude</label>
                                    <input type="text" id="lng" name="longitude" readonly
                                        class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Image</label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-indigo-400 transition-colors" id="uploadContainer">
                                <input type="file" id="pic" name="pic" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-medium text-indigo-600">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                <div id="fileNameDisplay" class="mt-2 text-sm font-medium text-gray-900 hidden"></div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="button" onclick="showEthicsModal()"
                                class="w-full py-3 px-4 rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-md transition-all">
                                Post Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Guidelines Section -->
            <div class="space-y-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-lg p-5 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Ethical Posting Guidelines</h3>
                            <ul class="space-y-2 text-sm text-yellow-700">
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Only post items you have genuinely found or lost</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Do not use misleading or false information</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Choose the correct location as accurately as possible</span>
                                </li>
                                <li class="flex items-start">
                                    <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Upload clear images without personal data</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-5 shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">How It Works</h3>
                            <ol class="space-y-3 text-sm text-blue-700">
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">1</span>
                                    <span>Select whether you lost or found an item</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">2</span>
                                    <span>Describe the item in detail to help identification</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">3</span>
                                    <span>Pin the exact location on the map where it was lost/found</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">4</span>
                                    <span>Upload a clear photo of the item</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-2 flex-shrink-0">5</span>
                                    <span>Confirm your post and help reunite items with owners</span>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ethics Confirmation Modal -->
    <div id="ethicsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-40 hidden transition-opacity">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-xl transform transition-transform">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Ethical Confirmation</h3>
            <p class="text-gray-600 mb-4">By submitting this item, you confirm that:</p>
            <ul class="space-y-2 mb-6">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">The information provided is accurate and truthful</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">You are acting in good faith to reunite lost items with owners</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">You will not misuse this system for fraudulent purposes</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-gray-700">You understand misuse may result in disciplinary action</span>
                </li>
            </ul>
            <div class="flex items-center mb-6">
                <input id="ethicsAgreement" type="checkbox" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="ethicsAgreement" class="ml-3 block text-gray-700">
                    I understand and agree to these terms
                </label>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="hideEthicsModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="submitForm()" id="confirmBtn" disabled
                    class="px-4 py-2 rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 transition-colors">
                    Confirm & Post
                </button>
            </div>
        </div>
    </div>

    <!-- AI Override Modal -->
    <div id="ai-override-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-50 hidden">
        <div class="bg-white rounded-xl w-11/12 max-w-lg mx-auto shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-white">Analysis Complete!</h3>
                    <button onclick="closeAiOverrideModal()" class="text-white text-2xl leading-none hover:text-green-200">&times;</button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 space-y-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-green-700 font-medium">
                        {{ implode(', ', session('image_labels') ?? []) }}
                    </p>
                </div>

                <form id="aiOverrideForm" action="{{ session('last_item_id') ? route('items.updateLabel', session('last_item_id')) : '#' }}" method="POST">
                    @csrf
                    <label for="selected_label_modal" class="block text-sm font-medium text-gray-700 mb-1">Choose the best matching label:</label>
                    <select name="selected_label" id="selected_label_modal" required
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" disabled selected>-- Select the most accurate label --</option>
                        @foreach(session('image_labels') ?? [] as $label)
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="mt-4 w-full py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Confirm Label
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-end">
                    <button onclick="closeAiOverrideModal()" class="px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="/js/leaflet.js"></script>
    <script src="/js/itempost.js"></script>
    <script>
        // Ethics Modal logic
        function showEthicsModal() {
            document.getElementById('ethicsModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('ethicsModal').classList.add('opacity-100');
            }, 10);
        }

        function hideEthicsModal() {
            document.getElementById('ethicsModal').classList.add('hidden');
            document.getElementById('ethicsModal').classList.remove('opacity-100');
            let chk = document.getElementById('ethicsAgreement');
            let btn = document.getElementById('confirmBtn');
            if (chk) chk.checked = false;
            if (btn) btn.disabled = true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            let chk = document.getElementById('ethicsAgreement');
            let btn = document.getElementById('confirmBtn');
            if (chk && btn) {
                chk.addEventListener('change', function() {
                    btn.disabled = !this.checked;
                });
            }

            // File upload display
            const fileInput = document.getElementById('pic');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const uploadContainer = document.getElementById('uploadContainer');

            if (fileInput && fileNameDisplay && uploadContainer) {
                fileInput.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        fileNameDisplay.textContent = this.files[0].name;
                        fileNameDisplay.classList.remove('hidden');
                        uploadContainer.classList.add('border-green-400', 'bg-green-50');
                    } else {
                        fileNameDisplay.classList.add('hidden');
                        uploadContainer.classList.remove('border-green-400', 'bg-green-50');
                    }
                });
            }
        });

        function submitForm() {
            document.getElementById('itemForm').submit();
        }

        // AI Override Popup logic
        function showAiOverrideModal() {
            document.getElementById('ai-override-modal').classList.remove('hidden');
        }

        function closeAiOverrideModal() {
            document.getElementById('ai-override-modal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('image_labels'))
                showAiOverrideModal();
            @endif
        });

        // Toast Function
        function showToast(msg) {
            const toast = document.getElementById('toast');
            if (toast) {
                document.getElementById('toastMsg').textContent = msg;
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3000);
            }
        }

        // Form Validation
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('itemForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const lat = document.getElementById('lat').value;
                    const lng = document.getElementById('lng').value;

                    if (!lat || !lng) {
                        e.preventDefault();
                        showToast('Please select a location on the map');
                    }
                });
            }
        });

        // Google Maps Setup
        let lostItemsMap, selectLocationMap, marker;
        const defaultLocation = { lat: 6.448577537416546, lng: 100.28222320638474 };

        window.initMap = function() {
            lostItemsMap = new google.maps.Map(document.getElementById("lostItemsMap"), {
                center: defaultLocation,
                zoom: 16,
                mapTypeControl: false,
                streetViewControl: false,
                styles: [
                    {
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{ visibility: "off" }]
                    }
                ]
            });

            const items = @json($mapItems);
            items.forEach(item => {
                if (item.latitude && item.longitude) {
                    new google.maps.Marker({
                        position: { lat: parseFloat(item.latitude), lng: parseFloat(item.longitude) },
                        map: lostItemsMap,
                        icon: {
                            url: item.type === 'lost'
                                ? 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
                                : 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                            scaledSize: new google.maps.Size(32, 32)
                        }
                    });
                }
            });

            selectLocationMap = new google.maps.Map(document.getElementById("selectLocationMap"), {
                center: defaultLocation,
                zoom: 15,
                mapTypeControl: false,
                streetViewControl: false
            });

            selectLocationMap.addListener("click", (e) => {
                if (marker) marker.setMap(null);
                marker = new google.maps.Marker({
                    position: e.latLng,
                    map: selectLocationMap,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                });
                document.getElementById("lat").value = e.latLng.lat().toFixed(6);
                document.getElementById("lng").value = e.latLng.lng().toFixed(6);

                marker.addListener('dragend', function(e) {
                    document.getElementById("lat").value = e.latLng.lat().toFixed(6);
                    document.getElementById("lng").value = e.latLng.lng().toFixed(6);
                });
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBI0IHdwGx4iXJoj_ODuaXpJWTfNe9U5bU&callback=initMap"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
</body>
