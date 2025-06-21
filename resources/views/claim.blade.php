<x-header>Claims</x-header>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 p-6 min-h-screen">
    <div class="max-w-4xl mx-auto">
        <x-info><x-icon></x-icon></x-info>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Claim Information</h1>
            <p class="text-gray-600">Manage your item claims and communications</p>
        </div>

        @php
            use App\Models\Student;
            use App\Models\Message;

            $authEmail = session('student')['email'] ?? null;
            $authStudent = Student::where('email', $authEmail)->first();
        @endphp

        @forelse($claims as $claim)
        @continue(is_null($claim->item_id))

        @php
            $claimedBy = \App\Models\Student::where('email', $claim->claimed_by)->first();
            $claimedTo = \App\Models\Student::where('email', $claim->claimed_to)->first();

            $targetStudent = $authStudent && $claimedBy && $claimedBy->id === $authStudent->id
                            ? $claimedTo
                            : $claimedBy;

            $targetId = optional($targetStudent)->id;

            $unreadCount = \App\Models\Message::where('item_id', $claim->item_id)
                ->where('sender_id', $targetId)
                ->where('receiver_id', optional($authStudent)->id)
                ->whereNull('read_at')
                ->count();
        @endphp

        <div class="relative bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 mb-6 transition-all duration-300 hover:shadow-xl">
            <div class="absolute top-4 right-4">
                <div class="bg-{{ $authStudent && $claimedBy && $authStudent->id == $claimedBy->id ? 'blue' : 'emerald' }}-100 text-{{ $authStudent && $claimedBy && $authStudent->id == $claimedBy->id ? 'blue' : 'emerald' }}-800 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $authStudent && $claimedBy && $authStudent->id == $claimedBy->id ? 'CLAIMER' : 'RECIPIENT' }}
                </div>
            </div>

            <div class="flex flex-col md:flex-row p-5 gap-5">
                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full md:w-32 h-32 overflow-hidden flex items-center justify-center">
                    @if($claim->pic)
                        <img class="w-full h-full object-cover" src="{{ asset('images/'.$claim->pic) }}" alt="Claim Image">
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Item ID</h3>
                            <p class="font-mono font-medium">{{ $claim->item_id ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Status</h3>
                            <p class="font-medium">
                                @if($authStudent && $claimedBy && $authStudent->id == $claimedBy->id)
                                    You claimed this item
                                @elseif($authStudent && $claimedTo && $authStudent->id == $claimedTo->id)
                                    Claimed from you
                                @else
                                    <span class="text-amber-600">Status unknown</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Claimed By</h3>
                            <p class="text-sm truncate">{{ $claimedBy->email ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Claimed To</h3>
                            <p class="text-sm truncate">{{ $claimedTo->email ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                        @if($claim->item_id && $targetId)
                            <a href="{{ route('chat.show', ['itemId' => $claim->item_id, 'userId' => $targetId]) }}"
                            class="flex items-center space-x-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span>Open Chat</span>
                                @if($unreadCount > 0)
                                    <span class="ml-2 bg-rose-500 text-white text-xs font-bold h-6 w-6 rounded-full flex items-center justify-center">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        @else
                            <span class="inline-flex items-center text-gray-500 italic">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Chat unavailable
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">No Claims Found</h2>
            <p class="text-gray-500 max-w-md mx-auto">You don't have any active claims at this time. When claims are made, they'll appear here.</p>
        </div>
        @endforelse
    </div>
</body>
</html>
