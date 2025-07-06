<div>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">ผู้ใช้งาน</h2>
                <p class="text-gray-600">จัดการข้อมูลผู้ใช้งานระบบ</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">ทั้งหมด</div>
                <div class="text-2xl font-bold text-blue-600">{{ $listUser->count() }}</div>
                <div class="text-sm text-gray-500">ผู้ใช้งาน</div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <button
                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-medium shadow-md transition-all duration-200 flex items-center justify-center"
                wire:click="openModal">
                <i class="fa-solid fa-plus mr-2"></i> เพิ่มผู้ใช้งาน
            </button>
        </div>

        <!-- Enhanced Table -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
            @if($listUser->count() > 0)
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-user mr-2 text-gray-500"></i>
                                    ชื่อ
                                </div>
                            </th>
                            <th class="text-left px-6 py-4 font-semibold text-gray-700 border-b border-gray-200">
                                <div class="flex items-center">
                                    <i class="fa fa-envelope mr-2 text-gray-500"></i>
                                    อีเมล
                                </div>
                            </th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-700 border-b border-gray-200 w-32">
                                <div class="flex items-center justify-center">
                                    <i class="fa fa-shield mr-2 text-gray-500"></i>
                                    สิทธิ์
                                </div>
                            </th>
                            <th class="text-center px-6 py-4 font-semibold text-gray-700 border-b border-gray-200 w-40">
                                <div class="flex items-center justify-center">
                                    <i class="fa fa-calendar mr-2 text-gray-500"></i>
                                    วันที่สร้าง
                                </div>
                            </th>
                            <th class="px-6 py-4 text-center font-semibold text-gray-700 border-b border-gray-200 w-32">
                                การจัดการ
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($listUser as $user)
                            <tr class="hover:bg-blue-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white font-semibold text-sm">{{ strtoupper(substr($user->name ?? '', 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $user->name ?? 'ไม่ระบุชื่อ' }}</div>
                                            <div class="text-sm text-gray-500">ผู้ใช้งาน</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-900">{{ $user->email ?? 'ไม่ระบุอีเมล' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 border border-blue-200">
                                        <i class="fa fa-shield mr-1"></i>
                                        {{ $user->level ?? 'ไม่ระบุ' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="font-semibold text-gray-900">{{ $user->created_at ? date('d/m/Y', strtotime($user->created_at)) : 'ไม่ระบุวันที่' }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->created_at ? date('H:i', strtotime($user->created_at)) : '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button
                                            class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="openModalEdit({{ $user->id }})" title="แก้ไข">
                                            <i class="fa fa-pencil text-sm group-hover:scale-110 transition-transform"></i>
                                        </button>
                                        <button
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-colors duration-200 group"
                                            wire:click="openModalDelete({{ $user->id }}, '{{ $user->name }}')" title="ลบ">
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
                        <i class="fa fa-users text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-gray-600 font-medium mb-2">ไม่มีข้อมูลผู้ใช้งาน</h3>
                    <p class="text-gray-500 text-sm mb-4">เริ่มต้นด้วยการเพิ่มผู้ใช้งานใหม่</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced User Modal -->
    <x-modal wire:model="showModal" title="เพิ่มผู้ใช้งาน" maxWidth="xl">
        @if (isset($error))
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-6">
                <div class="flex items-center mb-2">
                    <i class="fa fa-exclamation-triangle mr-2"></i>
                    <span class="font-medium">กรุณาตรวจสอบข้อมูล</span>
                </div>
                <div class="text-sm">{{ $error }}</div>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Name Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-user mr-2 text-gray-500"></i>ชื่อ
                </label>
                <input type="text"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="name" placeholder="กรอกชื่อผู้ใช้งาน">
            </div>

            <!-- Email Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-envelope mr-2 text-gray-500"></i>อีเมล
                </label>
                <input type="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    wire:model="email" placeholder="กรอกอีเมล">
            </div>

            <!-- Password Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-lock mr-2 text-gray-500"></i>รหัสผ่าน
                    </label>
                    <input type="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="password" placeholder="กรอกรหัสผ่าน">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">
                        <i class="fa fa-lock mr-2 text-gray-500"></i>ยืนยันรหัสผ่าน
                    </label>
                    <input type="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        wire:model="password_confirmation" placeholder="ยืนยันรหัสผ่าน">
                </div>
            </div>

            <!-- Level Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fa fa-shield mr-2 text-gray-500"></i>สิทธิ์
                </label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" wire:model="level">
                    @foreach ($listLevel as $level)
                        <option value="{{ $level }}">{{ $level }}</option>
                    @endforeach
                </select>
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

    <!-- Delete Confirmation Modal -->
    <x-modal-confirm 
        showModalDelete="showModalDelete" 
        title="ลบผู้ใช้งาน"
        text="คุณต้องการลบผู้ใช้งาน {{ $nameForDelete }} หรือไม่?" 
        clickConfirm="delete"
        clickCancel="closeModalDelete" 
    />
</div>