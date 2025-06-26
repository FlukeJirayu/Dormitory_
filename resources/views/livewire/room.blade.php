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
</div>
