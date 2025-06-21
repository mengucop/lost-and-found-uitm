@php
    $student = session()->get('student');
    $items = \App\Models\Item::where('type', $slot)->get();
    $visibleItems = $items->take(3);
    $hiddenItems = $items->slice(3);
    $slugSlot = Str::slug($slot); // This will make 'lost' or 'found'
@endphp

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="text-center mb-10 relative">
        <div class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-indigo-500 to-transparent"></div>
        <h1 class="text-4xl font-bold text-indigo-700 inline-block px-6 bg-white relative z-10">
            {{ Str::title($slot) }} Items
            @if($slot === 'lost')
                🔍
            @else
                🎉
            @endif
        </h1>
    </div>

    @if($items->count() > 0)
        <!-- Items Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 pb-6">
            @foreach($visibleItems as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5 flex flex-col h-full">
                        <div class="flex justify-center mb-4">
                            <a href="{{ url('/picview/'.$item->pic) }}" class="group block">
                                <img src="{{ asset('images/'.$item->pic) }}" alt="Item image"
                                     class="w-full h-40 object-cover rounded-lg group-hover:opacity-90 transition-opacity">
                            </a>
                        </div>

                        <div class="flex-grow space-y-3">
                            <p class="text-gray-700 text-lg font-medium text-center">{{ $item->description }}</p>
                            <div class="flex items-center text-sm text-gray-500 justify-center">
                                <i class="fas fa-user-circle mr-2"></i>
                                <span>{{ \App\Models\Student::where('email', $item->from)->first()?->name ?? 'Unknown' }}</span>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-center">
                            @if($student['email'] == $item->from)
                                <a href="{{ url('/picview/delete/'.$item->pic) }}"
                                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    <i class="fas fa-trash-alt mr-2"></i> Delete
                                </a>
                            @elseif(\App\Models\Claim::where('claimed_by', $student['email'])->where('pic', $item->pic)->exists())
                                <button class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg">
                                    <i class="fas fa-hourglass-half mr-2"></i> Claim Pending
                                </button>
                            @else
                                <a href="{{ url('/claim/pic/'.$item->pic) }}"
                                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    <i class="fas fa-hand-holding-heart mr-2"></i> Claim Item
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($hiddenItems->count() > 0)
            <!-- See More Button -->
            <div class="flex justify-center mt-6">
                <button id="open-modal-{{ $slugSlot }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    See More
                </button>
            </div>

            <!-- Modal -->
            <div id="see-more-modal-{{ $slugSlot }}" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                <div class="bg-white p-8 rounded-xl w-11/12 max-w-4xl max-h-[90vh] overflow-y-auto relative">
                    <button id="close-modal-{{ $slugSlot }}" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($hiddenItems as $item)
                            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-5 flex flex-col h-full">
                                    <div class="flex justify-center mb-4">
                                        <a href="{{ url('/picview/'.$item->pic) }}" class="group block">
                                            <img src="{{ asset('images/'.$item->pic) }}" alt="Item image"
                                                 class="w-full h-40 object-cover rounded-lg group-hover:opacity-90 transition-opacity">
                                        </a>
                                    </div>

                                    <div class="flex-grow space-y-3">
                                        <p class="text-gray-700 text-lg font-medium text-center">{{ $item->description }}</p>
                                        <div class="flex items-center text-sm text-gray-500 justify-center">
                                            <i class="fas fa-user-circle mr-2"></i>
                                            <span>{{ \App\Models\Student::where('email', $item->from)->first()?->name ?? 'Unknown' }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-4 flex justify-center">
                                        @if($student['email'] == $item->from)
                                            <a href="{{ url('/picview/delete/'.$item->pic) }}"
                                               class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                <i class="fas fa-trash-alt mr-2"></i> Delete
                                            </a>
                                        @elseif(\App\Models\Claim::where('claimed_by', $student['email'])->where('pic', $item->pic)->exists())
                                            <button class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg">
                                                <i class="fas fa-hourglass-half mr-2"></i> Claim Pending
                                            </button>
                                        @else
                                            <a href="{{ url('/claim/pic/'.$item->pic) }}"
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                                <i class="fas fa-hand-holding-heart mr-2"></i> Claim Item
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="text-center py-12">
            <h3 class="text-lg font-medium text-gray-900">No {{ $slot }} items found</h3>
            <p class="mt-1 text-gray-500">Check back later or post a new item if you've found something.</p>
            <div class="mt-6">
                <a href="/post" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-plus-circle mr-2"></i> Post New Item
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach(['lost', 'found'] as $type)
        const openModalBtn{{ $type }} = document.getElementById('open-modal-{{ $type }}');
        const closeModalBtn{{ $type }} = document.getElementById('close-modal-{{ $type }}');
        const modal{{ $type }} = document.getElementById('see-more-modal-{{ $type }}');

        if (openModalBtn{{ $type }}) {
            openModalBtn{{ $type }}.addEventListener('click', function () {
                modal{{ $type }}.classList.remove('hidden');
                modal{{ $type }}.classList.add('flex');
            });
        }

        if (closeModalBtn{{ $type }}) {
            closeModalBtn{{ $type }}.addEventListener('click', function () {
                modal{{ $type }}.classList.remove('flex');
                modal{{ $type }}.classList.add('hidden');
            });
        }
    @endforeach
});
</script>
