<div class="navbar p-4 bg-white shadow-lg rounded-xl border border-gray-200">
    <div class="flex items-center justify-between">
        <!-- User Info -->
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-user text-purple-600 text-2xl"></i>
            <span class="user-name text-gray-900 font-semibold text-lg tracking-wide">{{ $user_name }}</span>
        </div>

        <!-- Logout Button -->
        <button 
            wire:click="confirmLogout" 
            class="flex items-center gap-2 px-6 py-2 bg-purple-300 text-purple-900 rounded-full hover:bg-purple-400 transition-all duration-300 shadow-sm"
        >
            <span class="font-medium">Logout</span>
            <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
        </button>
    </div>

    <!-- Logout Confirmation Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 border border-gray-100">
                <div class="text-center">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-5xl mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-800">Confirm Logout</h2>
                    <p class="text-gray-500 mt-2 text-sm">Are you sure you want to end this session?</p>
                </div>
                <div class="flex justify-center gap-4 mt-6">
                    <button 
                        wire:click="logout"
                        class="bg-red-600 hover:bg-red-700 text-white font-medium px-5 py-2 rounded-full shadow transition duration-300"
                    >
                        <i class="fa-solid fa-check mr-2"></i>Yes, Logout
                    </button>
                    <button 
                        wire:click="$set('showModal', false)"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-5 py-2 rounded-full transition duration-300"
                    >
                        <i class="fa-solid fa-xmark mr-2"></i>Cancel
                    </button> 
                </div>
            </div>
        </div>
    @endif
</div>
