<div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">ผู้เข้าพัก</h2>
                <p class="text-gray-600">จัดการข้อมูลผู้เข้าพักทั้งหมด</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">ทั้งหมด</div>
                <div class="text-2xl font-bold text-blue-600">{{ $customers->count() }}</div>
                <div class="text-sm text-gray-500">คน</div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <button
                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center justify-center"
                wire:click="openModal">
                <i class="fa-solid fa-plus mr-2"></i> เพิ่มผู้เข้าพัก
            </button>

            <!-- Enhanced Search Section -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" placeholder="ค้นหาชื่อ, เบอร์โทร, ห้องพัก..."
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
                        ค้นหา: "{{ $searchTerm }}" พบ {{ $customers->count() }} คน
                    </div>
                @endif
            </div>

            <!-- Filter Section -->
            <div class="flex gap-2">
                <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model.live="stayTypeFilter">
                    <option value="">ทุกประเภท</option>
                    <option value="d">รายวัน</option>
                    <option value="m">รายเดือน</option>
                </select>
            </div>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
            @if($customers->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fa fa-user mr-2 text-gray-500"></i>
                                        ข้อมูลผู้เข้าพัก
                                    </div>
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fa fa-door-open mr-2 text-gray-500"></i>
                                        ห้องพัก
                                    </div>
                                </th>
                                <th class="text-center px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                    <div class="flex items-center justify-center">
                                        <i class="fa fa-calendar mr-2 text-gray-500"></i>
                                        วันที่เข้าพัก
                                    </div>
                                </th>
                                <th class="text-center px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                    <div class="flex items-center justify-center">
                                        <i class="fa fa-tag mr-2 text-gray-500"></i>
                                        ประเภทการพัก
                                    </div>
                                </th>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fa fa-sticky-note mr-2 text-gray-500"></i>
                                        หมายเหตุ
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center font-semibold text-gray-700 border-b border-gray-200 w-56">
                                    การจัดการ
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fa fa-user text-blue-600"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                                <div class="text-sm text-gray-500 flex items-center">
                                                    <i class="fa fa-phone mr-1"></i>
                                                    {{ $customer->phone }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                                <i class="fa fa-bed text-green-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $customer->room->name }}</div>
                                                <div class="text-sm text-gray-500">ห้องพัก</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="font-medium text-gray-900">
                                            {{ date('d/m/Y', strtotime($customer->created_at)) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $customer->stay_type == 'd' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            <i class="fa {{ $customer->stay_type == 'd' ? 'fa-calendar-day' : 'fa-calendar-alt' }} mr-1"></i>
                                            {{ $customer->stay_type == 'd' ? 'รายวัน' : 'รายเดือน' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs">
                                            @if($customer->remark)
                                                <div class="text-sm text-gray-700 truncate" title="{{ $customer->remark }}">
                                                    {{ $customer->remark }}
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm italic">ไม่มีหมายเหตุ</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button
                                                class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                                wire:click="openModalMove({{ $customer->id }})" title="ย้ายห้อง">
                                                <i class="fa fa-exchange-alt text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>
                                            <button
                                                class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                                wire:click="openModalEdit({{ $customer->id }})" title="แก้ไข">
                                                <i class="fa fa-pencil text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>
                                            <button
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                                wire:click="openModalDelete({{ $customer->id }})" title="ลบ">
                                                <i class="fa fa-trash text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- No Results Message -->
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa fa-users text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-gray-600 font-medium mb-2">
                        @if($searchTerm)
                            ไม่พบข้อมูลที่ค้นหา
                        @else
                            ไม่มีข้อมูลผู้เข้าพัก
                        @endif
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">
                        @if($searchTerm)
                            ลองค้นหาด้วยคำอื่น หรือ
                            <button class="text-blue-600 hover:text-blue-800 underline" wire:click="clearSearch">
                                ล้างการค้นหา
                            </button>
                        @else
                            เริ่มต้นด้วยการเพิ่มผู้เข้าพักใหม่
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Enhanced Pagination -->
        @if($customers->count() > 0 && $totalPages > 1)
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4">
                <div class="text-gray-600 flex items-center">
                    <i class="fa fa-info-circle mr-2"></i>
                    @if($searchTerm)
                        ผลการค้นหา: หน้า {{ $currentPage }} จาก {{ $totalPages }}
                    @else
                        ข้อมูลทั้งหมด {{ $totalPages }} หน้า ({{ $customers->count() }} คน)
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

    <!-- Enhanced Add/Edit Customer Modal -->
    <x-modal wire:model="showModal" title="ผู้เข้าพัก" maxWidth="2xl">
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

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-user mr-2 text-gray-500"></i>ชื่อ
                    </label>
                    <input type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="name" placeholder="กรอกชื่อ">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-phone mr-2 text-gray-500"></i>เบอร์โทร
                    </label>
                    <input type="text"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="phone" placeholder="กรอกเบอร์โทร">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-door-open mr-2 text-gray-500"></i>ห้องพัก
                    </label>
                    <select
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="roomId">
                        <option value="">เลือกห้องพัก</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-calendar mr-2 text-gray-500"></i>วันที่เข้าพัก
                    </label>
                    <input type="date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="createdAt">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-tag mr-2 text-gray-500"></i>ประเภทการพัก
                    </label>
                    <select
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="stayType">
                        <option value="d">รายวัน</option>
                        <option value="m">รายเดือน</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-map-marker-alt mr-2 text-gray-500"></i>ที่อยู่
                </label>
                <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="address" placeholder="กรอกที่อยู่">
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-sticky-note mr-2 text-gray-500"></i>หมายเหตุ
                </label>
                <textarea
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="remark" rows="3" placeholder="กรอกหมายเหตุ (ถ้ามี)"></textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
            <button
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                wire:click="save">
                <i class="fa-solid fa-check mr-2"></i> บันทึก
            </button>
            <button
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                wire:click="closeModal">
                <i class="fa-solid fa-times mr-2"></i> ยกเลิก
            </button>
        </div>
    </x-modal>

    <!-- Enhanced Move Room Modal -->
    <x-modal wire:model="showModalMove" title="ย้ายห้องพัก" maxWidth="lg">
        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fa fa-info-circle text-blue-600 mr-2"></i>
                <span class="text-blue-800 text-sm">เลือกห้องใหม่ที่ต้องการย้าย</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-door-open mr-2 text-gray-500"></i>ห้องใหม่
                </label>
                <select
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="roomIdMove">
                    <option value="">เลือกห้องพัก</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
                @error('roomIdMove') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
            <button
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                wire:click="move">
                <i class="fa-solid fa-check mr-2"></i> บันทึก
            </button>
            <button
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                wire:click="closeModalMove">
                <i class="fa-solid fa-times mr-2"></i> ยกเลิก
            </button>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal-confirm showModalDelete="showModalDelete" title="ลบผู้เข้าพัก"
        text="คุณต้องการลบผู้เข้าพักนี้หรือไม่?" clickConfirm="delete"
        clickCancel="showModalDelete = false" />

    <!-- Enhanced Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg z-50 flex items-center" role="alert">
            <i class="fa fa-check-circle mr-2"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg z-50 flex items-center" role="alert">
            <i class="fa fa-exclamation-circle mr-2"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif
</div>