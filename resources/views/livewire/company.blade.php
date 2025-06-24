<div class="bg-white rounded-lg p-6 shadow-md">
    <div class="text-xl font-semibold mb-4 text-gray-800">ข้อมูลสถานประกอบการ</div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">ชื่อสถานประกอบการ</label>
                <input type="text" class="form-control mt-1 w-full" wire:model="name">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">ที่อยู่</label>
                <input type="text" class="form-control mt-1 w-full" wire:model="address">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">เบอร์โทรศัพท์</label>
                <input type="text" class="form-control mt-1 w-full" wire:model="phone">
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">รหัสประจำตัวผู้เสียภาษี</label>
            <input type="text" class="form-control mt-1 w-full" wire:model="tax_code">
        </div>
        

        <div class="mt-4">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="Logo" class="w-32 h-32 object-cover mb-3 rounded border">
            @endif

            <label class="block text-sm font-medium text-gray-700">โลโก้สถานประกอบการ</label>
            <input type="file" class="form-control mt-1 w-full" wire:model="logo">
        </div>
        

        <div class="mt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                <i class="fa fa-save mr-2"></i>บันทึก
            </button>

            @if ($flashMessage)
                <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    <i class="fa fa-check-circle mr-2"></i> {{ $flashMessage }}
                </div>
            @endif
        </div>
    </form>
</div>
