@extends('layouts.admin')
@section('title', 'Item Moderation')

@section('content')
<div class="mx-6 mb-8">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-shield-alt text-indigo-600"></i> Item Moderation Panel
            </h2>
        </div>

        <form action="{{ route('admin.moderate') }}" method="POST" class="p-6 space-y-6">
            @csrf

            {{-- Select Item --}}
            <div>
                <label class="block font-medium text-gray-700">Select Item</label>
                <select name="item_id" id="item_id" onchange="showItemDetails(this)"
                        class="w-full mt-2 border px-4 py-2 rounded-lg">
                    <option value="">-- Select Item --</option>
                    @foreach($allItems as $item)
                        <option value="{{ $item->id }}"
                                data-image="{{ asset('storage/' . $item->pic) }}"
                                data-type="{{ $item->type }}"
                                data-description="{{ $item->description }}"
                                data-location="{{ $item->location }}"
                                data-created="{{ $item->created_at->format('Y-m-d H:i') }}">
                            {{ $item->description }} - {{ ucfirst($item->type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Action --}}
            <div>
                <label class="block font-medium text-gray-700">Moderation Action</label>
                <select name="action" class="w-full mt-2 border px-4 py-2 rounded-lg">
                    <option value="">-- Select Action --</option>
                    <option value="approve">✓ Approve Item</option>
                    <option value="flag">⚠ Flag as Unethical</option>
                    <option value="delete">✗ Delete Permanently</option>
                </select>
            </div>

            {{-- Preview --}}
            <div id="itemPreview" class="hidden bg-gray-50 border rounded-lg p-4 shadow space-y-3">
                <div class="flex justify-center">
                    <img id="itemImage" src="" class="max-w-xs rounded-lg border shadow-md">
                </div>
                <div class="text-sm text-gray-700 space-y-1">
                    <p><strong>Type:</strong> <span id="itemType"></span></p>
                    <p><strong>Description:</strong> <span id="itemDescription"></span></p>
                    <p><strong>Location:</strong> <span id="itemLocation"></span></p>
                    <p><strong>Reported At:</strong> <span id="itemCreated"></span></p>
                </div>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg w-full">
                Execute Moderation
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showItemDetails(select) {
        const selected = select.options[select.selectedIndex];
        if (!selected || !selected.dataset.image) {
            document.getElementById('itemPreview').classList.add('hidden');
            return;
        }

        document.getElementById('itemImage').src = selected.dataset.image;
        document.getElementById('itemType').innerText = selected.dataset.type;
        document.getElementById('itemDescription').innerText = selected.dataset.description;
        document.getElementById('itemLocation').innerText = selected.dataset.location;
        document.getElementById('itemCreated').innerText = selected.dataset.created;

        document.getElementById('itemPreview').classList.remove('hidden');
    }
</script>
@endsection
