<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-l-4 border-blue-500">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-wallet text-blue-500 mr-3"></i>
                บันทึกค่าใช้จ่าย
            </h1>
            <p class="text-gray-600 mt-2">จัดการรายรับ-รายจ่ายของคุณได้อย่างง่ายดาย</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-8">
            <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center"
                wire:click="openModalPayLog">
                <i class="fas fa-plus mr-2"></i>
                เพิ่มค่าใช้จ่าย
            </button>
            <button class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center"
                wire:click="openModalPay">
                <i class="fas fa-list mr-2"></i>
                รายการค่าใช้จ่าย
            </button>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">รายการค่าใช้จ่าย</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 w-32">วันที่</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 w-80">รายการ</th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700">หมายเหตุ</th>
                            <th class="text-right px-6 py-4 font-semibold text-gray-700 w-32">ยอดเงิน</th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-700 w-40">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($payLogs as $payLog)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-700">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                        {{ date('d/m/Y', strtotime($payLog->pay_date)) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <span class="text-gray-800 font-medium">{{ $payLog->pay->name }}</span>
                                        @if ($payLog->status == 'delete')
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                <i class="fas fa-trash-alt mr-1"></i>
                                                ถูกลบ
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $payLog->remark }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-lg font-semibold text-blue-600">
                                        {{ number_format($payLog->amount) }}
                                    </span>
                                    <span class="text-sm text-gray-500 ml-1">บาท</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center space-x-2">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-md"
                                            wire:click="openModalPayLogEdit({{ $payLog->id }})"
                                            title="แก้ไข">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        @if ($payLog->status == 'use')
                                            <button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-md"
                                                wire:click="openModalPayLogDelete({{ $payLog->id }})"
                                                title="ลบ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif

                                        @if ($payLog->status == 'delete')
                                            <button class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition-colors duration-200 shadow-md"
                                                wire:click="openModalPayLogRestore({{ $payLog->id }})"
                                                title="กู้คืน">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <x-modal title="แก้ไขรายการค่าใช้จ่าย" wire:model="showModalPayLogEdit" maxWidth="2xl">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2"></i>วันที่
                </label>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    wire:model="payLogEditDate" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-2"></i>รายการ
                </label>
                <input type="text" class="w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-600"
                    wire:model="payLogEditName" readonly />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-money-bill mr-2"></i>ยอดเงิน
                </label>
                <input type="number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    wire:model="payLogEditAmount" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sticky-note mr-2"></i>หมายเหตุ
                </label>
                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                    wire:model="payLogEditRemark" />
            </div>

            <div class="flex justify-center space-x-4 pt-4">
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200 flex items-center"
                    wire:click="editPayLogSave">
                    <i class="fas fa-save mr-2"></i>
                    บันทึก
                </button>
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200 flex items-center"
                    wire:click="closeModalPayLogEdit">
                    <i class="fas fa-times mr-2"></i>
                    ยกเลิก
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการ {{ $payLogEditName }} นี้หรือไม่"
        showModalDelete="showModalPayLogDelete" maxWidth="sm" clickConfirm="deletePayLog()"
        clickCancel="closeModalPayLogDelete()" />

    <!-- Restore Confirmation Modal -->
    <x-modal-confirm title="ยืนยันการกู้คืน" text="คุณต้องการกู้คืนรายการ {{ $payLogEditName }} นี้หรือไม่"
        showModalDelete="showModalPayLogRestore" maxWidth="sm" clickConfirm="restorePayLog()"
        clickCancel="closeModalPayLogRestore()" />

    <!-- Expense Categories Modal -->
    <x-modal title="จัดการรายการค่าใช้จ่าย" wire:model="showModalPay" maxWidth="3xl">
        <div class="space-y-6">
            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                <h3 class="font-semibold text-blue-800 mb-4">เพิ่มรายการใหม่</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">รายการ</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            wire:model="payName" placeholder="ระบุชื่อรายการ..." />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">หมายเหตุ</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            wire:model="payRemark" placeholder="หมายเหตุ (ถ้ามี)..." />
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200 flex items-center"
                        wire:click="savePay">
                        <i class="fas fa-plus mr-2"></i>
                        เพิ่มรายการ
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">รายการทั้งหมด</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left px-4 py-3 font-semibold text-gray-700">รายการ</th>
                                <th class="text-left px-4 py-3 font-semibold text-gray-700">หมายเหตุ</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700 w-32">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($pays as $pay)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $pay->name }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $pay->remark }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-center space-x-2">
                                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white p-1.5 rounded transition-colors duration-200"
                                                wire:click="editPay({{ $pay->id }})" title="แก้ไข">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded transition-colors duration-200"
                                                wire:click="openModalPayDelete({{ $pay->id }}, '{{ $pay->name }}')" title="ลบ">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-center">
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200 flex items-center"
                    wire:click="closeModalPay">
                    <i class="fas fa-times mr-2"></i>
                    ปิด
                </button>
            </div>
        </div>
    </x-modal>

    <!-- Pay Delete Confirmation Modal -->
    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการ {{ $payNameForDelete }} นี้หรือไม่"
        showModalDelete="showModalPayDelete" maxWidth="sm" clickConfirm="deletePay()"
        clickCancel="closeModalPayDelete()" />

    <!-- Add Expense Modal -->
    <x-modal wire:model="showModalPayLog" title="บันทึกค่าใช้จ่าย" maxWidth="3xl">
        <div class="space-y-6">
            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                    <label class="block text-sm font-medium text-green-800">วันที่</label>
                </div>
                <input type="date" class="mt-2 w-full px-4 py-2 border border-green-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    wire:model="payLogDate" />
            </div>

            <div class="bg-white rounded-lg border border-gray-200">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-list mr-2"></i>
                        รายการค่าใช้จ่าย
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left px-4 py-3 font-semibold text-gray-700">รายการ</th>
                                <th class="text-center px-4 py-3 font-semibold text-gray-700 w-40">ยอดเงิน (บาท)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($pays as $pay)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $pay->name }}</td>
                                    <td class="px-4 py-3">
                                        <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-center"
                                            wire:model="payLogAmount.{{ $pay->id }}" 
                                            placeholder="0" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-center space-x-4 pt-4">
                <button class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center shadow-lg"
                    wire:click="savePayLog">
                    <i class="fas fa-save mr-2"></i>
                    บันทึก
                </button>
                <button class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center shadow-lg"
                    wire:click="closeModalPayLog">
                    <i class="fas fa-times mr-2"></i>
                    ยกเลิก
                </button>
            </div>
        </div>
    </x-modal>
</div>