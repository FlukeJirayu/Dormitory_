<div>
    <div class="content-header">
        <div class="flex justify-between">
            <div class="text-gray-800 font-semibold">ห้องพัก</div>
            <div class="text-gray-600">ทั้งหมด <strong>{{ $rooms->count() }}</strong> ห้อง</div>
        </div>
    </div>

    <div class="content-body">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded" wire:click="openModal">
            <i class="fa-solid fa-plus mr-2"></i> เพิ่มห้องพัก
        </button>

        <table class="table table-bordered mt-4 w-full">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="text-left px-3 py-2">ห้องพัก</th>
                    <th class="text-right px-3 py-2" width="150px">ค่าเช่าต่อวัน</th>
                    <th class="text-right px-3 py-2" width="150px">ค่าเช่าต่อเดือน</th>
                    <th class="px-3 py-2 text-center" width="130px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr class="hover:bg-gray-50">
                        <td class="text-left px-3 py-2 text-gray-800">{{ $room->name }}</td>
                        <td class="text-right px-3 py-2 text-gray-800">{{ number_format($room->price_per_day) }}</td>
                        <td class="text-right px-3 py-2 text-gray-800">{{ number_format($room->price_per_month) }}</td>
                        <td class="text-center px-3 py-2">
                            <button class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded" wire:click="openModalEdit({{ $room->id }})">
                                <i class="fa fa-pencil mr-1"></i>
                            </button>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded" wire:click="openModalDelete({{ $room->id }})">
                                <i class="fa fa-trash mr-1"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 text-gray-700">ข้อมูลทั้งหมด {{ $totalPages }} หน้า</div>

        <div class="flex justify-center mt-4 flex-wrap gap-1">
            @if ($currentPage > 1)
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded" wire:click="setPage(1)">
                    <i class="fa fa-angle-left mr-2"></i> หน้าแรก
                </button>
            @else
                <button class="bg-blue-800 text-white px-4 py-1 rounded cursor-not-allowed" disabled>
                    <i class="fa fa-angle-left mr-2"></i> หน้าแรก
                </button>
            @endif

            @for ($i = 2; $i < $totalPages; $i++)
                @if ($i == $currentPage)
                    <button class="bg-blue-700 text-white px-4 py-1 rounded" disabled>{{ $i }}</button>
                @else
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded"
                        wire:click="setPage({{ $i }})">{{ $i }}</button>
                @endif
            @endfor

            @if ($currentPage < $totalPages)
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded"
                    wire:click="setPage({{ $totalPages }})">
                    <i class="fa fa-angle-right mr-2"></i> หน้าสุดท้าย
                </button>
            @else
                <button class="bg-blue-800 text-white px-4 py-1 rounded cursor-not-allowed" disabled>
                    <i class="fa fa-angle-right mr-2"></i> หน้าสุดท้าย
                </button>
            @endif
        </div>
    </div>


    <x-modal wire:model="showModal" title="ห้องพัก" maxWidth="xl">
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="flex flex-wrap gap-5 mt-3">
            <div class="w-1/2">
                <label class="text-gray-700">หมายเลขเริ่มต้น</label>
                <input type="text" class="form-control" wire:model="from_number">
            </div>
            <div class="w-1/2">
                <label class="text-gray-700">ถึงหมายเลข</label>
                <input type="text" class="form-control" wire:model="to_number">
            </div>
            <div class="w-1/2">
                <label class="text-gray-700">ค่าเช่าต่อวัน</label>
                <input type="text" class="form-control" wire:model="price_per_day">
            </div>
            <div class="w-1/2">
                <label class="text-gray-700">ค่าเช่าต่อเดือน</label>
                <input type="text" class="form-control" wire:model="price_per_month">
            </div>
        </div>

        <div class="mt-5 flex justify-end gap-2 pb-3">
            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded" wire:click="createRoom">
                <i class="fa-solid fa-check mr-2"></i> สร้างห้องพัก
            </button>
            <button class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded" wire:click="showModal = false">
                <i class="fa-solid fa-times mr-2"></i> ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal wire:model="showModalEdit" title="แก้ไขห้องพัก" maxWidth="xl">
        <div class="mb-2 text-gray-700">ห้องพัก</div>
        <input type="text" class="form-control" wire:model="name">

        <div class="mt-3 text-gray-700">ราคาเช่าต่อวัน</div>
        <input type="text" class="form-control" wire:model="price_day">

        <div class="mt-3 text-gray-700">ราคาเช่าต่อเดือน</div>
        <input type="text" class="form-control" wire:model="price_month">

        <div class="mt-5 flex justify-end gap-2 pb-3">
            <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded" wire:click="updateRoom">
                <i class="fa-solid fa-check mr-2"></i> บันทึก
            </button>
            <button class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded" wire:click="showModalEdit = false">
                <i class="fa-solid fa-times mr-2"></i> ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal-confirm showModalDelete="showModalDelete" title="ลบห้องพัก"
        text="คุณต้องการลบห้องพัก {{ $nameForDelete }} หรือไม่" clickConfirm="deleteRoom"
        clickCancel="showModalDelete = false" />
</div>
