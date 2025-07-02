<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">จัดการรายจ่าย</h1>
                    <p class="text-gray-600 mt-1">ระบบจัดการรายจ่ายและบันทึกประวัติการใช้เงิน</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg">
                        <span class="text-sm font-medium">ทั้งหมด {{ count($pays) }} รายการ</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 mb-6">
            <button class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors" wire:click="openModalPay">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                เพิ่มรายจ่าย
            </button>
            <button class="flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors" wire:click="openModalPayLog">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                บันทึกรายจ่าย
            </button>
        </div>

        <!-- Expense Types Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">ประเภทรายจ่าย</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อรายจ่าย</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">หมายเหตุ</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pays as $pay)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $pay->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ $pay->remark ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="editPay({{ $pay->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            แก้ไข
                                        </button>
                                        <button wire:click="openModalPayDelete({{ $pay->id }}, '{{ $pay->name }}')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            ลบ
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Expense History -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">ประวัติรายจ่าย</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">วันที่</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">รายจ่าย</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">จำนวนเงิน</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">หมายเหตุ</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">สถานะ</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payLogs as $log)
                            <tr class="hover:bg-gray-50 transition-colors {{ $log->status == 'delete' ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ date('d/m/Y', strtotime($log->pay_date)) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->pay->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="text-sm font-medium text-gray-900">{{ number_format($log->amount, 2) }} บาท</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ $log->remark ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($log->status == 'use')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            ใช้งาน
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            ลบแล้ว
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($log->status == 'use')
                                            <button wire:click="openModalPayLogEdit({{ $log->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                แก้ไข
                                            </button>
                                            <button wire:click="openModalPayLogDelete({{ $log->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                ลบ
                                            </button>
                                        @else
                                            <button wire:click="openModalPayLogRestore({{ $log->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 transition-colors">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                คืนค่า
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

    {{-- Modal เพิ่ม/แก้ไข รายจ่าย --}}
    <x-modal wire:model="showModalPay" :title="$payId ? 'แก้ไขรายจ่าย' : 'เพิ่มรายจ่าย'">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อรายจ่าย</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.defer="payName" placeholder="กรอกชื่อรายจ่าย">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">หมายเหตุ</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" wire:model.defer="payRemark" placeholder="กรอกหมายเหตุ (ถ้ามี)"></textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="closeModalPay">ยกเลิก</button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition-colors" wire:click="savePay">บันทึก</button>
        </div>
    </x-modal>

    {{-- Modal บันทึก pay log --}}
    <x-modal wire:model="showModalPayLog" title="บันทึกรายจ่าย">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">วันที่</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.defer="payLogDate">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">รายการค่าใช้จ่าย</label>
                <div class="space-y-3">
                    @foreach($listPays as $pay)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <span class="font-medium text-gray-900">{{ $pay->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="number" class="w-24 px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.defer="payLogAmount.{{ $pay->id }}" placeholder="0.00" step="0.01">
                                <span class="text-sm text-gray-500">บาท</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="closeModalPayLog">ยกเลิก</button>
            <button class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 transition-colors" wire:click="savePayLog">บันทึก</button>
        </div>
    </x-modal>

    {{-- Modal แก้ไข Pay Log --}}
    <x-modal wire:model="showModalPayLogEdit" title="แก้ไขประวัติรายจ่าย">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">ชื่อรายจ่าย</label>
                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50" value="{{ $payLogEditName }}" disabled>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">วันที่</label>
                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.defer="payLogEditDate">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">จำนวนเงิน</label>
                <div class="relative">
                    <input type="number" class="w-full px-3 py-2 pr-12 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model.defer="payLogEditAmount" step="0.01">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-sm text-gray-500">บาท</span>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">หมายเหตุ</label>
                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" rows="3" wire:model.defer="payLogEditRemark" placeholder="กรอกหมายเหตุ"></textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-6">
            <button class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors" wire:click="closeModalPayLogEdit">ยกเลิก</button>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 transition-colors" wire:click="editPayLogSave">บันทึก</button>
        </div>
    </x-modal>

    {{-- Confirm Modals --}}
    <x-modal-confirm showModalDelete="showModalPayDelete" title="ลบรายจ่าย" text="คุณต้องการลบรายการนี้หรือไม่?" clickConfirm="deletePay" clickCancel="closeModalPayDelete" />
    <x-modal-confirm showModalDelete="showModalPayLogDelete" title="ลบประวัติรายจ่าย" text="คุณต้องการลบประวัติรายการนี้หรือไม่?" clickConfirm="deletePayLog" clickCancel="closeModalPayLogDelete" />
    <x-modal-confirm showModalDelete="showModalPayLogRestore" title="คืนค่าประวัติรายจ่าย" text="คุณต้องการคืนค่ารายการนี้หรือไม่?" clickConfirm="restorePayLog" clickCancel="closeModalPayLogRestore" />
</div>