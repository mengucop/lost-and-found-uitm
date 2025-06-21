@extends('layouts.admin')
@section('title', 'Claim Moderation')

@section('content')
<div class="mb-6">
    {{-- Filter Tabs --}}
    <div class="flex flex-wrap gap-4 mb-4">
        @foreach (['All', 'Pending', 'Approved', 'Rejected'] as $status)
            <a href="{{ route('admin.claims', ['status' => strtolower($status)]) }}"
                class="px-4 py-2 rounded-lg font-medium transition
                    {{ request('status') === strtolower($status) || (request('status') === null && $status === 'All')
                        ? 'bg-indigo-600 text-white'
                        : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-indigo-200 dark:hover:bg-indigo-500' }}">
                {{ $status }}
            </a>
        @endforeach
    </div>

    {{-- Search Bar --}}
    <form method="GET" action="{{ route('admin.claims') }}" class="mb-6">
        <input type="text" name="search" placeholder="Search by student email or item description" value="{{ request('search') }}"
            class="w-full md:w-1/2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring focus:ring-indigo-400">
    </form>

    {{-- Claims Grid --}}
    @if($claims->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($claims as $claim)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 space-y-3">
                    <img src="{{ asset('storage/uploads/' . $claim->item->pic) }}"
                      alt="Item Image"
                     class="w-full h-48 object-contain rounded" />

                    <div class="text-sm dark:text-gray-200">
                        <p><strong>Item:</strong> {{ $claim->item->description ?? 'N/A' }}</p>
                        <p><strong>Status:</strong> {{ $claim->status }}</p>
                        <p><strong>From:</strong> {{ $claim->claimed_by }}</p>
                        <p><strong>To:</strong> {{ $claim->claimed_to }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($claim->item->type ?? '-') }}</p>
                        <p><strong>Location:</strong> {{ $claim->item->location ?? '-' }}</p>
                        <p><strong>Date:</strong> {{ $claim->created_at->format('Y-m-d H:i') }}</p>
                    </div>

                    {{-- Moderation Form --}}
                    <form action="{{ route('admin.claims.moderate') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="hidden" name="claim_id" value="{{ $claim->id }}">
                        <select name="action" class="w-full px-2 py-1 rounded border dark:bg-gray-900 dark:border-gray-600">
                            <option value="">-- Action --</option>
                            <option value="approve">Approve</option>
                            <option value="reject">Reject</option>
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                            Go
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $claims->withQueryString()->links('pagination::tailwind') }}
        </div>
    @else
        <div class="text-center text-gray-400 dark:text-gray-500 py-10">
            No claims found for this filter or search term.
        </div>
    @endif
</div>
@endsection
