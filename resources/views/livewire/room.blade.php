<div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">ห้องพัก</h2>
                <p class="text-gray-600">จัดการข้อมูลห้องพักทั้งหมด</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">ทั้งหมด</div>
                <div class="text-2xl font-bold text-blue-600">{{ $rooms->count() }}</div>
                <div class="text-sm text-gray-500">ห้อง</div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <button
                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center justify-center"
                wire:click="openModal">
                <i class="fa-solid fa-plus mr-2"></i> เพิ่มห้องพัก
            </button>

            <!-- Enhanced Search Section -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" placeholder="ค้นหาห้องพัก, ราคา..."
                        class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model.live.debounce.300ms="searchTerm">
                    <i class="fa fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    
                    <!-- Clear Search Button -->
                    @if($searchTerm)
                        <button 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
                            wire:click="clearSearch"
                            title="ล้างการค้นหา">
                            <i class="fa fa-times"></i>
                        </button>
                    @endif
                </div>
                
                <!-- Search Results Info -->
                @if($searchTerm)
                    <div class="mt-2 text-sm text-gray-600">
                        <i class="fa fa-info-circle mr-1"></i>
                        ค้นหา: "{{ $searchTerm }}" พบ {{ $rooms->count() }} ห้อง
                    </div>
                @endif
            </div>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
            @if($rooms->count() > 0)
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-door-open mr-2 text-gray-500"></i>
                                    ห้องพัก
                                </div>
                            </th>
                            <th class="text-right px-6 py-4 font-semibold text-gray-700 border-b border-gray-200 w-40">
                                <div class="flex items-center justify-end">
                                    <i class="fa fa-calendar-day mr-2 text-gray-500"></i>
                                    ค่าเช่าต่อวัน
                                </div>
                            </th>
                            <th class="text-right px-6 py-4 font-semibold text-gray-700 border-b border-gray-200 w-40">
                                <div class="flex items-center justify-end">
                                    <i class="fa fa-calendar-alt mr-2 text-gray-500"></i>
                                    ค่าเช่าต่อเดือน
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700 border-b border-gray-200 w-32">
                                การจัดการ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($rooms as $room)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fa fa-bed text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $room->name }}</div>
                                            <div class="text-sm text-gray-500">ห้องพัก</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-semibold text-gray-900">{{ number_format($room->price_per_day) }}</div>
                                    <div class="text-sm text-gray-500">บาท/วัน</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-semibold text-gray-900">{{ number_format($room->price_per_month) }}
                                    </div>
                                    <div class="text-sm text-gray-500">บาท/เดือน</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button
                                            class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="openModalEdit({{ $room->id }})" title="แก้ไข">
                                            <i class="fa fa-pencil text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="openModalDelete({{ $room->id }})" title="ลบ">
                                            <i class="fa fa-trash text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <!-- No Results Message -->
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-search text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-gray-600 font-medium mb-2">
                        @if($searchTerm)
                            ไม่พบข้อมูลที่ค้นหา
                        @else
                            ไม่มีข้อมูลห้องพัก
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">
                        @if($searchTerm)
                            ลองค้นหาด้วยคำอื่น หรือ
                            <button class="text-blue-600 hover:text-blue-800 underline" wire:click="clearSearch">
                                ล้างการค้นหา
                            </button>
                        @else
                            เริ่มต้นด้วยการเพิ่มห้องพักใหม่
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Enhanced Pagination - Only show if there are results -->
        @if($rooms->count() > 0 && $totalPages > 1)
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                <div class="text-gray-600 flex items-center">
                    <i class="fa fa-info-circle mr-2"></i>
                    @if($searchTerm)
                        ผลการค้นหา: หน้า {{ $currentPage }} จาก {{ $totalPages }}
                    @else
                        ข้อมูลทั้งหมด {{ $totalPages }} หน้า
                    @endif
                </div>

                <div class="flex justify-center flex-wrap gap-2">
                    @if ($currentPage > 1)
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center"
                            wire:click="setPage(1)">
                            <i class="fa fa-angle-double-left mr-2"></i> หน้าแรก
                        </button>
                    @else
                        <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed flex items-center"
                            disabled>
                            <i class="fa fa-angle-double-left mr-2"></i> หน้าแรก
                        </button>
                    @endif

                    @for ($i = 2; $i < $totalPages; $i++)
                        @if ($i == $currentPage)
                            <button class="bg-blue-700 text-white px-4 py-2 rounded-lg font-bold shadow-md"
                                disabled>{{ $i }}</button>
                        @else
                            <button
                                class="bg-white hover:bg-blue-600 hover:text-white text-blue-600 border border-blue-600 px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                wire:click="setPage({{ $i }})">{{ $i }}</button>
                        @endif
                    @endfor

                    @if ($currentPage < $totalPages)
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center"
                            wire:click="setPage({{ $totalPages }})">
                            หน้าสุดท้าย <i class="fa fa-angle-double-right ml-2"></i>
                        </button>
                    @else
                        <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed flex items-center"
                            disabled>
                            หน้าสุดท้าย <i class="fa fa-angle-double-right ml-2"></i>
                        </button>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Enhanced Add Room Modal -->
    <x-modal wire:model="showModal" title="เพิ่มห้องพัก" maxWidth="xl">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fa fa-exclamation-triangle mr-2"></i>
                    <span class="font-medium">กรุณาตรวจสอบข้อมูล</span>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fa fa-info-circle text-blue-600 mr-2"></i>
                <span class="text-blue-800 text-sm">กรอกช่วงหมายเลขห้องพักที่ต้องการสร้าง เช่น 101-110 จะสร้างห้องพัก 10
                    ห้อง</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-play mr-2 text-gray-500"></i>หมายเลขเริ่มต้น
                </label>
                <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="from_number" placeholder="เช่น 101">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-stop mr-2 text-gray-500"></i>ถึงหมายเลข
                </label>
                <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="to_number" placeholder="เช่น 110">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-calendar-day mr-2 text-gray-500"></i>ค่าเช่าต่อวัน
                </label>
                <div class="relative">
                    <input type="text"
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="price_per_day" placeholder="0">
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">บาท</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-calendar-alt mr-2 text-gray-500"></i>ค่าเช่าต่อเดือน
                </label>
                <div class="relative">
                    <input type="text"
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="price_per_month" placeholder="0">
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">บาท</span>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
            <button
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                wire:click="createRoom">
                <i class="fa-solid fa-check mr-2"></i> สร้างห้องพัก
            </button>
            <button
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                wire:click="showModal = false">
                <i class="fa-solid fa-times mr-2"></i> ยกเลิก
            </button>
        </div>
    </x-modal>

    <!-- Enhanced Edit Room Modal -->
    <x-modal wire:model="showModalEdit" title="แก้ไขห้องพัก" maxWidth="xl">
        <div class="space-y-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-door-open mr-2 text-gray-500"></i>ห้องพัก
                </label>
                <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="name" placeholder="หมายเลขห้อง">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-calendar-day mr-2 text-gray-500"></i>ราคาเช่าต่อวัน
                    </label>
                    <div class="relative">
                        <input type="text"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            wire:model="price_day" placeholder="0">
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">บาท</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-calendar-alt mr-2 text-gray-500"></i>ราคาเช่าต่อเดือน
                    </label>
                    <div class="relative">
                        <input type="text"
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            wire:model="price_month" placeholder="0">
                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">บาท</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
            <button
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                wire:click="updateRoom">
                <i class="fa-solid fa-check mr-2"></i> บันทึก
            </button>
            <button
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                wire:click="showModalEdit = false">
                <i class="fa-solid fa-times mr-2"></i> ยกเลิก
            </button>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal (unchanged) -->
    <x-modal-confirm showModalDelete="showModalDelete" title="ลบห้องพัก"
        text="คุณต้องการลบห้องพัก {{ $nameForDelete }} หรือไม่" clickConfirm="deleteRoom"
        clickCancel="showModalDelete = false" />
</div>