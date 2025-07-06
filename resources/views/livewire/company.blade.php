<div class="bg-white rounded-xl shadow-lg p-8 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 border-b-4 border-blue-500 pb-4">
            ข้อมูลสถานประกอบการ
        </h1>
    </div>

    <form wire:submit="save" class="space-y-8">
        <!-- ข้อมูลหลัก -->
        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-6 flex items-center">
                <i class="fas fa-building mr-2 text-blue-500"></i>
                ข้อมูลทั่วไป
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        ชื่อสถานประกอบการ
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        wire:model="name"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white"
                        placeholder="กรอกชื่อสถานประกอบการ"
                    >
                </div>
                
                <div class="space-y-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        ที่อยู่
                    </label>
                    <input 
                        type="text" 
                        id="address"
                        wire:model="address"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white"
                        placeholder="กรอกที่อยู่"
                    >
                </div>
                
                <div class="space-y-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        เบอร์โทร
                    </label>
                    <input 
                        type="text" 
                        id="phone"
                        wire:model="phone"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white"
                        placeholder="กรอกเบอร์โทร"
                    >
                </div>
            </div>
        </div>

        <!-- เลขประจำตัวผู้เสียภาษี -->
        <div class="bg-gray-50 p-6 rounded-lg">
            <div class="space-y-2">
                <label for="tax_code" class="block text-sm font-medium text-gray-700">
                    เลขประจำตัวผู้เสียภาษี
                </label>
                <input 
                    type="text" 
                    id="tax_code"
                    wire:model="tax_code"
                    class="w-full max-w-md px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white"
                    placeholder="กรอกเลขประจำตัวผู้เสียภาษี"
                >
            </div>
        </div>

        <!-- โลโก้ -->
        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-6 flex items-center">
                <i class="fas fa-image mr-2 text-green-500"></i>
                โลโก้
            </h2>
            
            <div class="space-y-4">
                @if ($logoUrl)
                    <div class="flex items-center space-x-4">
                        <img 
                            src="{{ $logoUrl }}" 
                            alt="Logo" 
                            class="w-20 h-20 rounded-lg shadow-md border-2 border-gray-200 object-cover" 
                        />
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                            โลโก้ปัจจุบัน
                        </div>
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label for="logo" class="block text-sm font-medium text-gray-700">
                        อัพโหลดโลโก้ใหม่
                    </label>
                    <input 
                        type="file" 
                        id="logo"
                        wire:model="logo"
                        accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                </div>
            </div>
        </div>

        <!-- ค่าใช้จ่ายรายเดือน -->
        <div class="bg-gray-50 p-6 rounded-lg">
            <h2 class="text-xl font-semibold text-gray-700 mb-6 flex items-center">
                <i class="fas fa-calculator mr-2 text-orange-500"></i>
                ค่าใช้จ่ายรายเดือน
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="space-y-2">
                    <label for="amount_water" class="block text-sm font-medium text-gray-700 text-center">
                        ค่าน้ำ/เดือน
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="amount_water"
                            wire:model="amount_water"
                            class="w-full px-4 py-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white text-right"
                            placeholder="0.00"
                            step="0.01"
                        >
                        <span class="absolute right-3 top-3 text-gray-500 text-sm">฿</span>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label for="amount_water_per_unit" class="block text-sm font-medium text-gray-700 text-center">
                        ค่าน้ำ/หน่วย
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="amount_water_per_unit"
                            wire:model="amount_water_per_unit"
                            class="w-full px-4 py-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white text-right"
                            placeholder="0.00"
                            step="0.01"
                        >
                        <span class="absolute right-3 top-3 text-gray-500 text-sm">฿</span>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label for="amount_electric_per_unit" class="block text-sm font-medium text-gray-700 text-center">
                        ค่าไฟ/หน่วย
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="amount_electric_per_unit"
                            wire:model="amount_electric_per_unit"
                            class="w-full px-4 py-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white text-right"
                            placeholder="0.00"
                            step="0.01"
                        >
                        <span class="absolute right-3 top-3 text-gray-500 text-sm">฿</span>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label for="amount_internet" class="block text-sm font-medium text-gray-700 text-center">
                        ค่า Internet
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="amount_internet"
                            wire:model="amount_internet"
                            class="w-full px-4 py-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white text-right"
                            placeholder="0.00"
                            step="0.01"
                        >
                        <span class="absolute right-3 top-3 text-gray-500 text-sm">฿</span>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <label for="amount_etc" class="block text-sm font-medium text-gray-700 text-center">
                        ค่าอื่นๆ
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="amount_etc"
                            wire:model="amount_etc"
                            class="w-full px-4 py-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 bg-white text-right"
                            placeholder="0.00"
                            step="0.01"
                        >
                        <span class="absolute right-3 top-3 text-gray-500 text-sm">฿</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ปุ่มบันทึก -->
        <div class="flex justify-center pt-6">
            <button 
                type="submit" 
                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2"
            >
                <i class="fas fa-save"></i>
                <span>บันทึกข้อมูล</span>
            </button>
        </div>

        <!-- ข้อความแจ้งเตือน -->
        @if ($flashMessage)
            <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center space-x-2 text-green-700">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span class="font-medium">{{ $flashMessage }}</span>
                </div>
            </div>
        @endif
    </form>
</div>