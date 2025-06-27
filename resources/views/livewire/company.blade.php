<div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-100">
    <div class="flex items-center mb-8">
        <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-xl mr-4">
            <i class="fa-solid fa-building text-white text-xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
            ข้อมูลสถานประกอบการ
        </h2>
    </div>

    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 flex items-center">
                    <i class="fa-solid fa-store text-violet-500 mr-2"></i>
                    ชื่อสถานประกอบการ
                </label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white" 
                       wire:model="name"
                       placeholder="กรอกชื่อสถานประกอบการ">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 flex items-center">
                    <i class="fa-solid fa-map-marker-alt text-violet-500 mr-2"></i>
                    ที่อยู่
                </label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white" 
                       wire:model="address"
                       placeholder="กรอกที่อยู่">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 flex items-center">
                    <i class="fa-solid fa-phone text-violet-500 mr-2"></i>
                    เบอร์โทรศัพท์
                </label>
                <input type="text" 
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white" 
                       wire:model="phone"
                       placeholder="กรอกเบอร์โทรศัพท์">
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700 flex items-center">
                <i class="fa-solid fa-file-invoice text-violet-500 mr-2"></i>
                รหัสประจำตัวผู้เสียภาษี
            </label>
            <input type="text" 
                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white" 
                   wire:model="tax_code"
                   placeholder="กรอกรหัสประจำตัวผู้เสียภาษี">
        </div>
        
        <div class="space-y-4">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700 flex items-center">
                    <i class="fa-solid fa-image text-violet-500 mr-2"></i>
                    โลโก้สถานประกอบการ
                </label>
                
                @if ($logoUrl)
                    <div class="flex justify-center mb-4">
                        <div class="relative">
                            <img src="{{ $logoUrl }}" 
                                 alt="Logo" 
                                 class="w-32 h-32 object-cover rounded-2xl border-4 border-violet-200 shadow-lg">
                            <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="relative">
                    <input type="file" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100" 
                           wire:model="logo"
                           accept="image/*">
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fa-solid fa-upload"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">รองรับไฟล์: JPG, PNG, GIF (ขนาดไม่เกิน 2MB)</p>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
            <button type="submit" 
                    class="bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                <i class="fa fa-save mr-3"></i>
                บันทึกข้อมูล
            </button>

            @if ($flashMessage)
                <div class="flex-1 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm animate-pulse">
                    <div class="flex items-center">
                        <div class="bg-green-500 text-white rounded-full p-1 mr-3">
                            <i class="fa fa-check-circle text-sm"></i>
                        </div>
                        <span class="font-medium">{{ $flashMessage }}</span>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>