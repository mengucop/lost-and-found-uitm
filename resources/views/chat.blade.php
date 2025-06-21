<x-header>Chat</x-header>

<body class="p-4 bg-gradient-to-br from-gray-50 to-gray-200 min-h-screen dark:from-gray-800 dark:to-gray-900 dark:text-white transition-colors duration-300">
    <div class="max-w-3xl mx-auto">

        <!-- Back Button -->
        <div class="max-w-3xl mx-auto mt-2 mb-4">
            @php
    $claim = \App\Models\Claim::where('item_id', $itemId)
        ->where(function ($q) use ($userId) {
            $q->where('claimed_by', auth('students')->user()->email)
              ->orWhere('claimed_to', auth('students')->user()->email);
        })->first();
@endphp


            <a href="{{ url('/claim') }}"
               class="inline-flex items-center text-blue-600 hover:underline dark:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-11a1 1 0 112 0v2h2a1 1 0 110 2h-2v2a1 1 0 11-2 0v-2H7a1 1 0 110-2h2V7z" clip-rule="evenodd" />
                </svg>
                Back to Claims
            </a>
        </div>

        <!-- Chat Header -->
        <div class="flex items-center justify-between mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>Lost & Found Chat</span>
            </h1>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                @if($messages->count())
                    Last message: {{ $messages->last()->created_at->diffForHumans() }}
                @endif
            </div>
        </div>

        @php
    use App\Models\Claim;
    use App\Models\Item;

    $claim = Claim::where('item_id', $itemId)
        ->where(function($q) use ($userId) {
            $q->where('claimed_by', auth('students')->user()->email)
              ->orWhere('claimed_to', auth('students')->user()->email);
        })
        ->first();

    $item = $claim ? Item::find($claim->item_id) : null;
    $isOwner = $item && $item->from === auth('students')->user()->email;
@endphp

@if($claim && $item && $item->status === 'Pending' && $isOwner)
    <div class="mb-4 flex justify-center gap-4">
        <form action="{{ route('claim.approve', ['item_id' => $itemId]) }}" method="POST">
            @csrf
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">✅ Approve</button>
        </form>

        <form action="{{ route('claim.reject', ['item_id' => $itemId]) }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">❌ Reject</button>
        </form>
    </div>
@endif


        <!-- Chat Messages -->
        <div class="border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6 h-[400px] overflow-y-auto p-4 custom-scroll">
            @forelse ($messages as $msg)
            <div class="mb-4 flex {{ $msg->sender_id == auth('students')->id() ? 'justify-end' : 'justify-start' }}">
    <div class="max-w-xs md:max-w-md">
        <div class="{{ $msg->sender_id == auth('students')->id()
            ? 'bg-blue-500 text-white rounded-l-xl rounded-tr-xl'
            : 'bg-gray-100 dark:bg-gray-700 text-black dark:text-white rounded-r-xl rounded-tl-xl' }}
            px-4 py-2 shadow-sm">

            @if ($msg->message)
                <p class="break-words">{{ $msg->message }}</p>
            @endif

            @if ($msg->image)
                <img src="{{ asset('storage/' . $msg->image) }}"
                     class="mt-2 max-w-xs rounded border border-gray-300 dark:border-gray-600"
                     alt="Uploaded proof">
            @endif
        </div>
        <div class="text-xs mt-1 {{ $msg->sender_id == auth('students')->id() ? 'text-right' : 'text-left' }} text-gray-500 dark:text-gray-400">
            {{ $msg->created_at->format('h:i A · M d') }}
            @if($msg->sender_id == auth('students')->id())
                <span class="ml-1 text-blue-400">✓✓</span>
            @endif
        </div>
    </div>
    </div>

            @empty
                <div class="h-full flex flex-col items-center justify-center text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <p>No messages yet. Start the conversation!</p>
                </div>
            @endforelse
        </div>



        <!-- Message Input Form -->
<form action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4">
    @csrf
    <input type="hidden" name="item_id" value="{{ $itemId }}">
    <input type="hidden" name="receiver_id" value="{{ $userId }}">

    <div class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 w-full">
        <input
            type="text"
            name="message"
            placeholder="Type your message..."
            class="flex-1 p-3 rounded border dark:bg-gray-700 dark:text-white"
        >
        <input
            type="file"
            name="image"
            accept="image/*"
            class="text-sm dark:text-white"
        >
        <button
            type="submit"
            class="p-3 bg-blue-600 text-white rounded hover:bg-blue-700"
        >➤ Send</button>
    </div>
</form>


    <style>
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scroll::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.05);
            border-radius: 10px;
        }
        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .dark .custom-scroll::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        .dark .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.1);
        }
    </style>
</body>
</html>
