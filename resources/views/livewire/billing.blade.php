<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">ใบเสร็จรับเงิน</h1>
                    <p class="text-gray-600">จัดการรายการเช่าและการชำระเงิน</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center" wire:click="openModal">
                        <i class="fa fa-plus mr-2"></i>
                        เพิ่มรายการ
                    </button>
                    <button class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center">
                        <i class="fa fa-print mr-2"></i>
                        พิมพ์ใบแจ้งค่าเช่าทุกห้อง
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">ห้อง</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">ผู้เช่า</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">เบอร์โทร</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">วันที่</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-700 uppercase tracking-wider">ยอดเงิน</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">สถานะ</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">หมายเหตุ</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($billings as $billing)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $billing->room ? $billing->room->name : 'ไม่ระบุห้อง' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $billing->getCustomer() ? $billing->getCustomer()->name : 'ไม่ระบุผู้เช่า' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $billing->getCustomer() ? $billing->getCustomer()->phone : '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ date('d/m/Y', strtotime($billing->created_at)) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ number_format($billing->sumAmount() ?? 0) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($billing->status == 'paid')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fa fa-check mr-1"></i>
                                            {{ $billing->getStatusName() }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fa fa-times mr-1"></i>
                                            {{ $billing->getStatusName() }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $billing->remark ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" wire:click="openModalGetMoney({{ $billing->id }})" title="รับเงิน">
                                            <i class="fa fa-dollar-sign"></i>
                                        </button>
                                        <button class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" wire:click="printBilling({{ $billing->id }})" title="พิมพ์">
                                            <i class="fa fa-file-alt"></i>
                                        </button>
                                        <button class="bg-gray-500 hover:bg-gray-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" wire:click="openModalEdit({{ $billing->id }})" title="แก้ไข">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md" wire:click="openModalDelete({{ $billing->id }}, '{{ $billing->getCustomer() ? $billing->getCustomer()->name : '' }}')" title="ลบ">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Bill Details -->
    <x-modal title="รายการบิล" wire:model="showModal" maxWidth="3xl">
        <div class="space-y-4">
            <!-- First Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-700">ห้อง</label>
                    @if ($id != null)
                        <input type="text" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" value="{{ $roomNameForEdit }}" readonly />
                    @else
                        <select class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="roomId" wire:change="selectedRoom()">
                            @foreach ($rooms as $room)
                                <option value="{{ $room['id'] }}">{{ $room['name'] }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-700">วันที่</label>
                    <input type="date" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="createdAt" />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-700">สถานะบิล</label>
                    <select class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="status">
                        @foreach ($listStatus as $statusItem)
                            <option value="{{ $statusItem['status'] }}">{{ $statusItem['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Second Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-700">ผู้เช่า</label>
                    <input type="text" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="customerName" readonly />
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-700">เบอร์โทร</label>
                    <input type="text" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="customerPhone" readonly />
                </div>
            </div>

            <!-- Remark -->
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-700">หมายเหตุ</label>
                <input type="text" class="w-full px-2 py-1.5 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="remark" />
            </div>

            <!-- Billing Details Table -->
            <div class="bg-gray-50 rounded-md p-3">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">รายละเอียดค่าใช้จ่าย</h3>
                <div class="space-y-2">
                    <!-- Room Rent -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-700">ค่าเช่าห้อง</span>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountRent" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Water -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-700">ค่าน้ำ</span>
                            <div class="flex items-center space-x-1">
                                <input type="number" class="w-16 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="waterUnit" wire:change="computeSumAmount()" />
                                <span class="text-xs text-gray-500">หน่วย</span>
                            </div>
                        </div>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountWater" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Electric -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-700">ค่าไฟฟ้า</span>
                            <div class="flex items-center space-x-1">
                                <input type="number" class="w-16 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="electricUnit" wire:change="computeSumAmount()" />
                                <span class="text-xs text-gray-500">หน่วย</span>
                            </div>
                        </div>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountElectric" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Internet -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-700">ค่าอินเตอร์เน็ต</span>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountInternet" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Fitness -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-700">ค่าฟิตเนส</span>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountFitness" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Laundry -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-700">ค่าซักรีด</span>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountWash" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Garbage -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-700">ค่าเก็บขยะ</span>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountBin" wire:change="computeSumAmount()" />
                    </div>

                    <!-- Others -->
                    <div class="flex justify-between items-center p-2 bg-white rounded shadow-sm">
                        <span class="text-sm font-medium text-gray-700">ค่าอื่นๆ</span>
                        <input type="number" class="w-24 px-2 py-1 text-sm border border-gray-300 rounded text-right focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent" wire:model="amountEtc" wire:change="computeSumAmount()" />
                    </div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="bg-blue-50 rounded-md p-3 border-l-4 border-blue-400">
                <div class="text-center text-lg font-bold text-blue-800">
                    รวมค่าใช้จ่าย : {{ number_format($sumAmount ?? 0) }} บาท
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-3 pt-3">
                <button class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-2 rounded-md font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center text-sm" wire:click="save()">
                    <i class="fa fa-check mr-2"></i>
                    บันทึก
                </button>
                <button class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-6 py-2 rounded-md font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center text-sm" wire:click="closeModal()">
                    <i class="fa fa-times mr-2"></i>
                    ยกเลิก
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการห้อง {{ $roomForDelete }} หรือไม่?" showModalDelete="showModalDelete" clickConfirm="deleteBilling()" clickCancel="closeModalDelete()">
    </x-modal-confirm>

    <!-- Get Money Modal -->
    <x-modal title="รับเงิน" wire:model="showModalGetMoney" maxWidth="3xl">
        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                <div>
                    <span class="text-sm font-medium text-gray-700">ห้อง</span>
                    <span class="text-blue-600 font-bold text-2xl ml-3">{{ $roomNameForGetMoney }}</span>
                </div>
                <a class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center" href="print-billing/{{ $id }}" target="_blank">
                    <i class="fa fa-print mr-2"></i>
                    พิมพ์ใบเสร็จรับเงิน
                </a>
            </div>

            <!-- Customer Info -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <div class="text-lg font-semibold text-gray-900">ผู้เช่า : {{ $customerNameForGetMoney }}</div>
            </div>

            <!-- Payment Date -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">วันที่ชำระ</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" wire:model="payedDateForGetMoney" />
            </div>

            <!-- Total Amount -->
            <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                <div class="text-lg font-semibold text-yellow-800">
                    ยอดรวมค่าใช้จ่าย : {{ number_format($sumAmountForGetMoney ?? 0) }} บาท
                </div>
            </div>

            <!-- Fine and Payment Amount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">ค่าปรับ</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" wire:model="moneyAdded" wire:blur="handleChangeAmountForGetMoney()" />
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">ยอดรับเงิน</label>
                    <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" wire:model="amountForGetMoney" />
                </div>
            </div>

            <!-- Remark -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">หมายเหตุ</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" wire:model="remarkForGetMoney" />
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center space-x-4 pt-4">
                <button class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center" wire:click="saveGetMoney()">
                    <i class="fa fa-check mr-2"></i>
                    บันทึก
                </button>
                <button class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 flex items-center" wire:click="closeModalGetMoney()">
                    <i class="fa fa-times mr-2"></i>
                    ยกเลิก
                </button>
            </div>
        </div>
    </x-modal>
</div>