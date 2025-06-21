<div class="pt-44"></div> <!-- Adjust this padding if needed -->

<div class="fixed top-0 left-0 w-full z-50 shadow-lg">
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 py-4 md:py-6">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden z-0">
            <!-- Watermark Logo -->
            <div class="absolute inset-0 opacity-5 flex items-center justify-center">
                <svg viewBox="0 0 200 50" class="h-32 w-auto">
                    <path fill="currentColor" d="M40,10 L160,10 L160,40 L40,40 Z M50,20 L70,20 L70,30 L50,30 Z M80,20 L100,20 L100,30 L80,30 Z M110,20 L130,20 L130,30 L110,30 Z M140,20 L150,20 L150,30 L140,30 Z"/>
                </svg>
            </div>

            <!-- Animated Circles -->
            <div class="absolute w-full h-full opacity-10">
                <div class="absolute top-1/4 left-1/5 w-16 h-16 rounded-full bg-yellow-400 blur-xl animate-float1"></div>
                <div class="absolute top-1/3 right-1/4 w-28 h-28 rounded-full bg-blue-600 blur-xl animate-float2"></div>
                <div class="absolute bottom-1/4 left-1/3 w-20 h-20 rounded-full bg-red-500 blur-xl animate-float3"></div>
            </div>
        </div>

        <!-- Header Content -->
        <div class="relative z-10 container mx-auto px-4 flex items-center justify-between">
            <!-- Left Logo -->
            <div class="flex-shrink-0 mr-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-full p-2 border border-white/20">
                    <img src="\images\uitmlogo.png" alt="UiTM Logo" class="h-16 w-auto">
                </div>
            </div>

            <!-- Centered Text & Slot -->
            <div class="flex-1 text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-white animate-fadeIn mb-1">
                    <span class="inline-block transform hover:scale-105 transition-transform duration-300 bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 via-yellow-200 to-yellow-400">
                        Lost & Found
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-blue-200 font-medium animate-slideUp">
                    Universiti Teknologi MARA
                </p>

                <div class="mt-2 text-base text-blue-100 font-medium max-w-2xl mx-auto animate-slideUp">
                    {{ $slot }}
                </div>

                <!-- Animated Dots -->
                <div class="flex justify-center space-x-2 mt-4">
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 opacity-80 animate-pulse"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-white opacity-80 animate-pulse delay-100"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-red-400 opacity-80 animate-pulse delay-200"></div>
                </div>
            </div>

            <!-- Spacer to balance layout -->
            <div class="w-20 hidden sm:block"></div>
        </div>
    </div>

    <!-- Bottom Wave Divider -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden transform rotate-180">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-current text-white/90">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17..." opacity=".25"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86..." opacity=".5"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32..." ></path>
        </svg>
    </div>

    <!-- Animations -->
    <style>
        @keyframes float1 {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(-30px) translateX(15px) rotate(5deg); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(20px) translateX(-20px) rotate(-3deg); }
        }
        @keyframes float3 {
            0%, 100% { transform: translateY(0) translateX(0) rotate(0deg); }
            50% { transform: translateY(-25px) translateX(-15px) rotate(2deg); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-15px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        .animate-float1 { animation: float1 9s ease-in-out infinite; }
        .animate-float2 { animation: float2 11s ease-in-out infinite; }
        .animate-float3 { animation: float3 13s ease-in-out infinite; }
        .animate-fadeIn { animation: fadeIn 1s ease-out both; }
        .animate-slideUp { animation: slideUp 1s ease-out 0.2s both; }
        .animate-pulse { animation: pulse 2s ease-in-out infinite; }
        .delay-100 { animation-delay: 0.15s; }
        .delay-200 { animation-delay: 0.3s; }
    </style>
</div>
