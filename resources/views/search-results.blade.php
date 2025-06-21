<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .search-header {
            background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.2);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .search-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }

        .results-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 1200px;
            margin: 0 auto;
        }

        .tag-cloud span {
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .tag-cloud span:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(99, 102, 241, 0.2);
        }

        .item-card {
            transition: all 0.3s ease;
            border: 1px solid #eef2ff;
            overflow: hidden;
        }

        .item-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.15);
            border-color: #c7d2fe;
        }

        .item-image {
            height: 180px;
            overflow: hidden;
        }

        .item-image img {
            transition: transform 0.5s ease;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-card:hover .item-image img {
            transform: scale(1.05);
        }

        .back-btn {
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.1);
        }

        .back-btn:hover {
            transform: translateX(-4px);
            box-shadow: 0 6px 12px rgba(79, 70, 229, 0.15);
        }

        .no-results {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px dashed #cbd5e1;
        }

        .result-count {
            background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .footer {
            color: #64748b;
            font-size: 14px;
            margin-top: 30px;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .slide-up {
            animation: slideUp 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto">
        <!-- Header with back button -->
        <div class="search-header flex items-center justify-between">
            <div class="flex items-center">
                <button onclick="history.back()" class="back-btn flex items-center text-indigo-700 font-medium px-5 py-3 rounded-xl">
                    <i class="fas fa-arrow-left mr-3"></i> Back to Search
                </button>
            </div>
            <div class="text-center">
                <h1 class="text-3xl font-bold flex items-center justify-center">
                    <i class="fas fa-search mr-3 bounce"></i>
                    Search Results
                </h1>
                <p class="mt-2 opacity-90">We found what you're looking for</p>
            </div>
            <div class="w-32"></div> <!-- Spacer for alignment -->
        </div>


        <!-- Main content -->
        <div class="results-container fade-in">
            <!-- Detected labels section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Detected Labels</h2>
                    <span class="result-count">{{ count($labels) }} tags</span>
                </div>

                <div class="tag-cloud flex flex-wrap gap-3 mb-2">
                    @foreach($labels as $label)
                    <span class="bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-tag mr-2 text-indigo-500"></i>{{ $label }}
                    </span>
                    @endforeach
                </div>

                <p class="text-sm text-gray-600 mt-4">
                    These labels were detected in your search. Items matching these tags are shown below.
                </p>
            </div>

            <!-- Results section -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Matching Items</h2>
                    <span class="result-count">{{ $items->count() }} results</span>
                </div>

                @if($items->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @foreach($items as $item)
                    <div class="item-card rounded-xl slide-up">
    <div class="item-image">
        <img src="{{ asset('images/' . $item->pic) }}" alt="{{ $item->description }}">
    </div>
    <div class="p-4 space-y-2">
        <p class="font-bold text-gray-800 text-lg">{{ $item->description }}</p>
        <p class="text-sm text-gray-600">{{ ucfirst($item->type) }} Item</p>

        {{-- Optional: show status if not Unresolved --}}
        @if($item->status !== 'Unresolved')
            <p class="text-sm text-red-500 font-semibold">Status: {{ $item->status }}</p>
        @endif

        {{-- Claim Button --}}
        @if($item->status === 'Unresolved')
            <form action="{{ route('claim.initiate', ['item' => $item->id]) }}" method="POST">
                @csrf
                <button type="submit" class="mt-3 px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-hand-holding mr-1"></i> Claim This Item
                </button>
            </form>
        @else
            <p class="text-sm text-gray-500 italic">This item is already in process</p>
        @endif
    </div>
</div>

                    @endforeach
                </div>
                @else
                <div class="no-results rounded-xl p-8 text-center my-8">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 mx-auto bg-gray-200 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-search text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">No matching items found</h3>
                        <p class="text-gray-600 mb-6">
                            We couldn't find any items matching your search criteria.
                        </p>
                        <button onclick="history.back()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium">
                            <i class="fas fa-redo mr-2"></i> Try Again
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="footer text-center mt-8">
            <p>Search completed • Showing {{ $items->count() }} items</p>
        </div>
    </div>
</body>
</html>
