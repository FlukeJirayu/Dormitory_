<div
    class="navbar p-6 bg-gradient-to-r from-white via-purple-50 to-blue-50 shadow-xl rounded-2xl border border-purple-100 backdrop-blur-sm">
    <div class="flex items-center justify-between">
        <!-- Enhanced User Info Section -->
        <div class="flex items-center gap-4">
            <div class="relative">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg ring-4 ring-purple-100">
                    <i class="fa-solid fa-user text-white text-xl"></i>
                </div>
                <div
                    class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white shadow-sm">
                </div>
            </div>
            <div class="flex flex-col">
                <span class="user-name text-gray-900 font-bold text-xl tracking-wide">{{ $user_name }}</span>
                <span class="text-sm text-gray-500 font-medium">Administrator</span>
            </div>
        </div>

        <!-- Enhanced Buttons Container -->
        <div class="flex items-center space-x-3">
            <!-- Edit Profile Button -->
            <button wire:click="editProfile"
                class="group relative flex items-center px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-500 text-white rounded-full hover:from-blue-500 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <i class="fa-solid fa-user-pen text-base mr-2 relative z-10"></i>
                <span class="font-semibold relative z-10">Edit Profile</span>
                <div
                    class="absolute inset-0 rounded-full bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                </div>
            </button>

            <!-- Logout Button -->
            <button wire:click="confirmLogout"
                class="group relative flex items-center px-6 py-3 bg-gradient-to-r from-purple-400 to-purple-500 text-white rounded-full hover:from-purple-500 hover:to-purple-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-purple-600 to-purple-700 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <span class="font-semibold mr-2 relative z-10">Logout</span>
                <i class="fa-solid fa-arrow-right-from-bracket text-base relative z-10"></i>
                <div
                    class="absolute inset-0 rounded-full bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                </div>
            </button>
        </div>
    </div>

    <!-- Enhanced Success Message -->
    @if ($saveSuccess)
        <div class="fixed top-6 right-6 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-4 rounded-2xl shadow-2xl z-50 flex items-center border border-green-400"
            x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-500 transform"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95" x-init="setTimeout(() => show = false, 4000)">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <i class="fa-solid fa-check text-sm"></i>
                </div>
                <div>
                    <p class="font-bold">Success!</p>
                    <p class="text-sm opacity-90">Profile updated successfully</p>
                </div>
                <button @click="show = false"
                    class="ml-6 text-white hover:text-gray-200 transition-colors duration-200">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Enhanced Logout Confirmation Modal - Perfectly Centered -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center min-h-screen">
            <div class="relative w-full h-full flex items-center justify-center p-4">
                <div
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-md border border-gray-100 transform transition-all duration-300">
                    <div class="p-8">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fa-solid fa-sign-out-alt text-red-500 text-3xl"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign Out</h2>
                            <p class="text-gray-600 text-lg leading-relaxed">Are you sure you want to end your session? You'll
                                need to sign in again to access your account.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 mt-8">
                            <button wire:click="logout"
                                class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                                <i class="fa-solid fa-check mr-2"></i>Yes, Sign Out
                            </button>
                            <button wire:click="$set('showModal', false)"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-2xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                                <i class="fa-solid fa-xmark mr-2"></i>Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Enhanced Edit Profile Modal - Perfectly Centered -->
    @if ($showModalEdit)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center min-h-screen">
            <div class="relative w-full h-full flex items-center justify-center p-4">
                <div
                    class="bg-white rounded-3xl shadow-2xl w-full max-w-lg border border-gray-100 transform transition-all duration-300 max-h-[90vh] overflow-y-auto">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                <i class="fa-solid fa-user-pen text-white text-3xl"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Edit Profile</h2>
                            <p class="text-gray-600">Update your account information</p>
                        </div>

                        <form wire:submit.prevent="updateProfile" class="space-y-6">
                            <!-- Username Field -->
                            <div class="space-y-2">
                                <label
                                    class="block text-left text-gray-700 font-bold text-sm uppercase tracking-wide">Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" wire:model.defer="username"
                                        class="w-full pl-12 pr-4 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 focus:outline-none text-gray-900 font-medium transition-all duration-200"
                                        placeholder="Enter your username">
                                </div>
                                @error('username')
                                    <div class="flex items-center text-red-500 text-sm mt-2">
                                        <i class="fa-solid fa-exclamation-circle mr-2"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- New Password Field -->
                            <div x-data="{ show: false }" class="space-y-2">
                                <label class="block text-left text-gray-700 font-bold text-sm uppercase tracking-wide">New
                                    Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-lock text-gray-400"></i>
                                    </div>
                                    <input :type="show ? 'text' : 'password'" wire:model.defer="password"
                                        class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 focus:outline-none text-gray-900 font-medium transition-all duration-200"
                                        placeholder="Enter new password (optional)">
                                    <button type="button" @click="show = !show"
                                        class="absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none transition-colors duration-200">
                                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="flex items-center text-red-500 text-sm mt-2">
                                        <i class="fa-solid fa-exclamation-circle mr-2"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div x-data="{ show: false }" class="space-y-2">
                                <label class="block text-left text-gray-700 font-bold text-sm uppercase tracking-wide">Confirm
                                    Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-lock text-gray-400"></i>
                                    </div>
                                    <input :type="show ? 'text' : 'password'" wire:model.defer="password_confirm"
                                        class="w-full pl-12 pr-12 py-4 border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-purple-300 focus:border-purple-400 focus:outline-none text-gray-900 font-medium transition-all duration-200"
                                        placeholder="Confirm new password">
                                    <button type="button" @click="show = !show"
                                        class="absolute top-1/2 right-4 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none transition-colors duration-200">
                                        <i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                    </button>
                                </div>
                                @error('password_confirm')
                                    <div class="flex items-center text-red-500 text-sm mt-2">
                                        <i class="fa-solid fa-exclamation-circle mr-2"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3 pt-6">
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                                    <i class="fa-solid fa-save mr-2"></i>Save Changes
                                </button>
                                <button type="button" wire:click="$set('showModalEdit', false)"
                                    class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 px-6 rounded-2xl transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center">
                                    <i class="fa-solid fa-xmark mr-2"></i>Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>