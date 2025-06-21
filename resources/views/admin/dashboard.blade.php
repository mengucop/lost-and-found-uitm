@extends('layouts.admin')
@section('title', 'Admin Dashboard')

<!-- Hamburger Menu (Mobile) -->
<div class="md:hidden p-4">
    <button id="hamburgerBtn" class="text-gray-700 text-2xl focus:outline-none">
        <i class="fas fa-bars"></i>
    </button>
</div>


@section('content')
    {{-- Status Toast --}}
    @if(session('status'))
    <div class="fixed top-4 right-4 z-50 animate-slide-in">
        <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
            <i class="fas fa-check-circle"></i>
            {{ session('status') }}
        </div>
    </div>
    @endif

    {{-- Overview Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-6 rounded-xl shadow-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Lost Items</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalLostItems }}</p>
                </div>
                <div class="bg-white/10 p-4 rounded-full"><i class="fas fa-bell text-2xl"></i></div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-xl shadow-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Total Found Items</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalFoundItems }}</p>
                </div>
                <div class="bg-white/10 p-4 rounded-full"><i class="fas fa-search text-2xl"></i></div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-6 rounded-xl shadow-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Registered Users</p>
                    <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white/10 p-4 rounded-full"><i class="fas fa-users text-2xl"></i></div>
            </div>
        </div>
    </div>

    {{-- System Health --}}
    <div class="mb-6">
        <div class="bg-gradient-to-br from-gray-500 to-gray-700 p-6 rounded-xl shadow-xl text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">System Health</p>
                    <p class="text-4xl font-bold mt-2">All Systems Operational</p>
                </div>
                <div class="bg-white/10 p-4 rounded-full"><i class="fas fa-heartbeat text-2xl"></i></div>
            </div>
        </div>
    </div>

    {{-- Type Breakdown Pie Chart --}}
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-600"></i> Item Type Breakdown
            </h2>
        </div>
     <div class="p-6 flex justify-center">
    <div class="w-64 h-64 sm:w-72 sm:h-72 md:w-80 md:h-80 relative">
        <canvas id="typePieChart" class="w-full h-full"></canvas>
    </div>
</div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('typePieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($typeCounts->keys()) !!},
            datasets: [{
                data: {!! json_encode($typeCounts->values()) !!},
                backgroundColor: ['#6366F1', '#10B981'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
      options: {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
        legend: { position: 'top' }
    }
}

    });

    // Toast animation
    setTimeout(() => {
        const toast = document.querySelector('.animate-slide-in');
        if (toast) toast.style.display = 'none';
    }, 5000);
</script>

<style>
    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }
</style>
@endsection
