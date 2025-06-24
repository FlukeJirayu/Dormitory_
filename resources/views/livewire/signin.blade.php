<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-purple-300 via-indigo-300 to-pink-300">
    <!-- เอฟเฟกต์แสงเวียน -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute w-[150%] h-[150%] animate-spin-slow bg-white rounded-full opacity-25 blur-3xl"></div>
        <div class="absolute w-full h-full animate-pulse bg-white rounded-full opacity-20 blur-[120px] top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></div>

        <!-- ฟองสบู่ -->
        @for ($i = 0; $i < 20; $i++)
            <div class="bubble"
                style="
                    left: {{ rand(0, 100) }}%;
                    width: {{ rand(20, 60) }}px;
                    height: {{ rand(20, 60) }}px;
                    animation-delay: {{ rand(0, 100) / 10 }}s;
                    animation-duration: {{ rand(15, 30) }}s;
                ">
            </div>
        @endfor
    </div>

    <!-- กล่องฟอร์ม -->
    <div class="z-10 tilt-wrapper">
        <div id="tilt-card"
            class="w-full max-w-xl bg-white border border-purple-100 rounded-3xl shadow-2xl p-12 backdrop-blur-sm bg-opacity-90 transition-transform duration-300 preserve-3d animate-float">
            <h2 class="text-2xl font-bold text-purple-700 mb-6 text-center flex items-center justify-center gap-2">
                <i class="fa fa-user-circle text-purple-500 text-2xl"></i>
                Sign In to Dormitory
            </h2>

            <form wire:submit.prevent="signin" class="space-y-5">
                @csrf
                <div>
                    <label class="text-sm text-gray-700">Username</label>
                    <input type="text" wire:model="username"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-300 transition" />
                    @if (isset($errorUsername))
                        <div class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="fa fa-exclamation-circle"></i> {{ $errorUsername }}
                        </div>
                    @endif
                </div>

                <div>
                    <label class="text-sm text-gray-700">Password</label>
                    <input type="password" wire:model="password"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-300 transition" />
                    @if (isset($errorPassword))
                        <div class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <i class="fa fa-exclamation-circle"></i> {{ $errorPassword }}
                        </div>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-400 via-indigo-400 to-pink-400 text-white text-sm py-2 rounded-full hover:brightness-110 transition-all duration-300 shadow-md">
                    <i class="fa fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>

            @if (isset($error))
                <div class="text-red-500 text-sm mt-5 text-center flex items-center justify-center gap-2">
                    <i class="fa fa-exclamation-triangle"></i> {{ $error }}
                </div>
            @endif
        </div>
    </div>
</div>
