<x-header>{{ session('pic')->pic }}</x-header>

<body>
    <x-info><x-icon></x-icon></x-info>

    <h1 class="text-center text-2xl">Item Details</h1>
    <br><br>

    <div class="grid grid-cols-2 place-content-center">
        <div class="ml-40">
            <img class="w-44 h-44 object-cover" src="{{ asset('images/'.session('pic')->pic) }}" alt="Nothing">
        </div>
        <div>
            <p><b>Type:</b> {{ Str::title(session('pic')->type) }}</p>
            <p><b>From:</b> {{ \App\Models\Student::where('email', session('pic')->from)->first()->name }}</p>
            <p><b>Uploaded At:</b> {{ session('pic')->created_at }}</p>
            <p><b>Status:</b> {{ session('pic')->status }}</p>
            <p><b>Description:</b> {{ session('pic')->description }}</p>
            <br><br>
        </div>
    </div>

    <!-- Horizontal Scrolling for Lost Items -->
    <div class="mt-8">
        <h2 class="text-center text-xl font-semibold">Lost Items</h2>
        <div class="flex space-x-4 overflow-x-auto pb-4 snap-x snap-mandatory">
            @foreach($lostItems as $item)
                <div class="w-64 snap-start flex-shrink-0">
                    <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow duration-300">
                        <img class="w-full h-32 object-cover rounded-md" src="{{ asset('images/'.$item->pic) }}" alt="Lost Item">
                        <h3 class="mt-2 text-sm font-semibold">{{ Str::title($item->type) }}</h3>
                        <p class="text-xs">{{ $item->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Horizontal Scrolling for Found Items -->
    <div class="mt-8">
        <h2 class="text-center text-xl font-semibold">Found Items</h2>
        <div class="flex space-x-4 overflow-x-auto pb-4 snap-x snap-mandatory">
            @foreach($foundItems as $item)
                <div class="w-64 snap-start flex-shrink-0">
                    <div class="bg-gray-100 rounded-lg p-4 hover:shadow-lg transition-shadow duration-300">
                        <img class="w-full h-32 object-cover rounded-md" src="{{ asset('images/'.$item->pic) }}" alt="Found Item">
                        <h3 class="mt-2 text-sm font-semibold">{{ Str::title($item->type) }}</h3>
                        <p class="text-xs">{{ $item->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid place-content-center">
        @if(isset(session('student')['email']) && \App\Models\Claim::where("claimed_by", session('student')['email'])->where("pic", session('pic')->pic)->count() > 0)
            <a href="{{ "/claim/pic/".session('pic')->pic }}"><x-pending_button>Claimed</x-pending_button></a>
        @elseif(session('student')['email'] != session('pic')->from)
            <a href="{{ "/claim/pic/".session('pic')->pic }}"><x-button>Claim</x-button></a>
        @else
            <a href="{{ "/picview/delete/".session('pic')->pic }}"><x-delete_button>Delete</x-delete_button></a>
        @endif
    </div>
</body>
