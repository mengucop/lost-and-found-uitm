<!-- resources/views/components/stat-card.blade.php -->
@props(['title', 'value', 'color' => 'from-blue-100 to-blue-200'])

<div class="bg-gradient-to-br {{ $color }} rounded-xl p-4 text-center shadow-sm">
    <p class="text-3xl font-bold text-gray-800">{{ $value }}</p>
    <p class="text-sm text-gray-600 mt-1">{{ $title }}</p>
</div>
