<div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">บันทึกค่าใช้จ่าย</h2>
                <p class="text-gray-600">จัดการรายการค่าใช้จ่ายทั้งหมด</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">รายการทั้งหมด</div>
                <div class="text-2xl font-bold text-purple-600">{{ $payLogs->count() }}</div>
                <div class="text-sm text-gray-500">รายการ</div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <button 
                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center justify-center"
                wire:click="openModalPayLog">
                <i class="fas fa-plus mr-2"></i> เพิ่มค่าใช้จ่าย
            </button>
            
            <button 
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center justify-center"
                wire:click="openModalPay">
                <i class="fas fa-list mr-2"></i> รายการค่าใช้จ่าย
            </button>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
            @if($payLogs->count() > 0)
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-calendar mr-2 text-gray-500"></i>
                                    วันที่
                                </div>
                            </th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-list mr-2 text-gray-500"></i>
                                    รายการ
                                </div>
                            </th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-comment mr-2 text-gray-500"></i>
                                    หมายเหตุ
                                </div>
                            </th>
                            <th class="text-right px-6 py-4 font-semibold text-gray-700 border-b border-gray-200 w-40">
                                <div class="flex items-center justify-end">
                                    <i class="fa fa-money-bill-wave mr-2 text-gray-500"></i>
                                    ยอดเงิน
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700 border-b border-gray-200 w-32">
                                การจัดการ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($payLogs as $payLog)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fa fa-calendar text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ date('d/m/Y', strtotime($payLog->pay_date)) }}</div>
                                            <div class="text-sm text-gray-500">{{ date('H:i', strtotime($payLog->pay_date)) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fa fa-tag text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $payLog->pay->name }}</div>
                                            @if ($payLog->status == 'delete')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    ถูกลบ
                                                </span>
                                            @else
                                                <div class="text-sm text-gray-500">รายการปกติ</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $payLog->remark ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="font-semibold text-gray-900">{{ number_format($payLog->amount) }}</div>
                                    <div class="text-sm text-gray-500">บาท</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button 
                                            class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="openModalPayLogEdit({{ $payLog->id }})" title="แก้ไข">
                                            <i class="fa fa-pencil text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>

                                        @if ($payLog->status == 'use')
                                            <button 
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                                wire:click="openModalPayLogDelete({{ $payLog->id }})" title="ลบ">
                                                <i class="fa fa-trash text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>
                                        @endif

                                        @if ($payLog->status == 'delete')
                                            <button 
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                                wire:click="openModalPayLogRestore({{ $payLog->id }})" title="กู้คืน">
                                                <i class="fa fa-undo text-sm group-hover:scale-110 transition-transform"></i>
                                            </button>
                                        @endif
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
                        <i class="fa fa-wallet text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-gray-600 font-medium mb-2">ไม่มีข้อมูลค่าใช้จ่าย</h3>
                    <p class="text-gray-500 text-sm mb-4">เริ่มต้นด้วยการเพิ่มรายการค่าใช้จ่ายใหม่</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Add Pay Log Modal -->
    <x-modal wire:model="showModalPayLog" title="บันทึกค่าใช้จ่าย" maxWidth="2xl">
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
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-calendar mr-2 text-gray-500"></i>วันที่
                </label>
                <input 
                    type="date" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="payLogDate" 
                />
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-list mr-2 text-gray-500"></i>รายการค่าใช้จ่าย
                </label>
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                    รายการ
                                </th>
                                <th class="text-right px-6 py-4 font-semibold text-gray-700 border-b border-gray-200 w-40">
                                    ยอดเงิน
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($pays as $pay)
                                <tr class="hover:bg-blue-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fa fa-tag text-green-600"></i>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $pay->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $pay->remark }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-right"
                                                wire:model="payLogAmount.{{ $pay->id }}" 
                                                placeholder="0.00"
                                                step="0.01"
                                            />
                                            <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">บาท</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                <button 
                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                    wire:click="savePayLog">
                    <i class="fa-solid fa-check mr-2"></i> บันทึก
                </button>
                <button 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                    wire:click="closeModalPayLog">
                    <i class="fa-solid fa-times mr-2"></i> ยกเลิก
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Enhanced Edit Pay Log Modal -->
    <x-modal title="รายการค่าใช้จ่าย" wire:model="showModalPayLogEdit" maxWidth="2xl">
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
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-calendar mr-2 text-gray-500"></i>วันที่
                </label>
                <input 
                    type="date" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="payLogEditDate" 
                />
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-tag mr-2 text-gray-500"></i>รายการ
                </label>
                <input 
                    type="text" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                    wire:model="payLogEditName" 
                    readonly 
                />
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-money-bill-wave mr-2 text-gray-500"></i>ยอดเงิน
                </label>
                <div class="relative">
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-right"
                        wire:model="payLogEditAmount" 
                        placeholder="0.00"
                        step="0.01"
                    />
                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">บาท</span>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-comment mr-2 text-gray-500"></i>หมายเหตุ
                </label>
                <input 
                    type="text" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="payLogEditRemark" 
                    placeholder="กรอกหมายเหตุ (ถ้ามี)"
                />
            </div>

            <div class="flex justify-end gap-3 pt-6 mt-6 border-t border-gray-200">
                <button 
                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                    wire:click="editPayLogSave">
                    <i class="fa-solid fa-check mr-2"></i> บันทึก
                </button>
                <button 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                    wire:click="closeModalPayLogEdit">
                    <i class="fa-solid fa-times mr-2"></i> ยกเลิก
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Enhanced Manage Pay Categories Modal -->
    <x-modal title="รายการค่าใช้จ่าย" wire:model="showModalPay" maxWidth="2xl">
        <div class="space-y-6">
            <!-- Add New Category Form -->
            <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg">
                <div class="flex items-center mb-4">
                    <i class="fa fa-plus-circle text-blue-600 mr-2"></i>
                    <span class="text-blue-800 font-medium">เพิ่มรายการใหม่</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fa fa-tag mr-2 text-gray-500"></i>รายการ
                        </label>
                        <input 
                            type="text" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            wire:model="payName" 
                            placeholder="กรอกชื่อรายการ"
                        />
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">
                            <i class="fa fa-comment mr-2 text-gray-500"></i>หมายเหตุ
                        </label>
                        <input 
                            type="text" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            wire:model="payRemark" 
                            placeholder="กรอกหมายเหตุ (ถ้ามี)"
                        />
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button 
                        class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center"
                        wire:click="savePay">
                        <i class="fa-solid fa-check mr-2"></i> บันทึก
                    </button>
                    <button 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200 flex items-center"
                        wire:click="closeModalPay">
                        <i class="fa-solid fa-times mr-2"></i> ยกเลิก
                    </button>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fa fa-list mr-2 text-gray-600"></i>
                        รายการค่าใช้จ่ายทั้งหมด
                    </h3>
                </div>
                
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-tag mr-2 text-gray-500"></i>
                                    รายการ
                                </div>
                            </th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-comment mr-2 text-gray-500"></i>
                                    หมายเหตุ
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700 border-b border-gray-200 w-32">
                                การจัดการ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($pays as $pay)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fa fa-tag text-green-600"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $pay->name }}</div>
                                            <div class="text-sm text-gray-500">รายการค่าใช้จ่าย</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $pay->remark ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button 
                                            class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="editPay({{ $pay->id }})" title="แก้ไข">
                                            <i class="fa fa-pencil text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button 
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="openModalPayDelete({{ $pay->id }}, '{{ $pay->name }}')" title="ลบ">
                                            <i class="fa fa-trash text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal-confirm 
        title="ยืนยันการลบ" 
        text="คุณต้องการลบรายการ {{ $payLogEditName }} นี้หรือไม่"
        showModalDelete="showModalPayLogDelete" 
        maxWidth="sm"
        clickConfirm="deletePayLog()"
        clickCancel="closeModalPayLogDelete()" 
    />

    <!-- Restore Confirmation Modal -->
    <x-modal-confirm 
        title="ยืนยันการกู้คืน" 
        text="คุณต้องการกู้คืนรายการ {{ $payLogEditName }} นี้หรือไม่"
        showModalDelete="showModalPayLogRestore" 
        maxWidth="sm"
        clickConfirm="restorePayLog()"
        clickCancel="closeModalPayLogRestore()" 
    />

    <!-- Delete Pay Category Confirmation Modal -->
    <x-modal-confirm 
        title="ยืนยันการลบ" 
        text="คุณต้องการลบรายการ {{ $payNameForDelete }} นี้หรือไม่"
        showModalDelete="showModalPayDelete" 
        maxWidth="sm"
        clickConfirm="deletePay()"
        clickCancel="closeModalPayDelete()" 
    />
</div>