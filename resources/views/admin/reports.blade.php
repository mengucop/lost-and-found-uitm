@extends('layouts.admin')
@section('title', 'Activity Logs')

@section('content')
<div class="mx-6 mb-8">
    <div class="bg-white rounded-2xl shadow-xl">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-blue-500"></i> Recent Moderation Activity
            </h2>
        </div>

        <div class="p-6">
            @if($activityLogs->count())
                <ul class="divide-y divide-gray-200 text-sm text-gray-700">
                    @foreach($activityLogs as $log)
                    <li class="py-2">
                        <strong>Action:</strong> {{ ucfirst($log->action) }} |
                        <strong>Item ID:</strong> {{ $log->item_id ?? 'N/A' }} |
                        <strong>Time:</strong> {{ $log->created_at->diffForHumans() }}
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center text-gray-400 py-8">No recent moderation activity found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
