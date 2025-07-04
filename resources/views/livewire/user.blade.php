<div>
    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fa fa-users text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">ผู้ใช้งาน</h2>
                        <p class="text-blue-100 text-sm">จัดการข้อมูลผู้ใช้งานระบบ</p>
                    </div>
                </div>
                <button class="inline-flex items-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 text-black text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-sm border border-white border-opacity-20 hover:scale-105 transform" wire:click="openModal">
                    <i class="fa fa-plus mr-2"></i>
                    เพิ่มผู้ใช้งาน
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="p-8">
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-48">
                                <div class="flex items-center space-x-2">
                                    <i class="fa fa-user text-gray-500"></i>
                                    <span>ชื่อ</span>
                                </div>
                            </th>
                            <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <i class="fa fa-envelope text-gray-500"></i>
                                    <span>อีเมล</span>
                                </div>
                            </th>
                            <th class="px-8 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider w-20">
                                <div class="flex items-center space-x-2">
                                    <i class="fa fa-shield text-gray-500"></i>
                                    <span>สิทธิ์</span>
                                </div>
                            </th>
                            <th class="px-8 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-32">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fa fa-calendar text-gray-500"></i>
                                    <span>วันที่สร้าง</span>
                                </div>
                            </th>
                            <th class="px-8 py-5 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-32">
                                <div class="flex items-center justify-center space-x-2">
                                    <i class="fa fa-cog text-gray-500"></i>
                                    <span>จัดการ</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($listUser as $user)
                            <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 group">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ strtoupper(substr($user->name ?? '', 0, 1)) }}
                                        </div>
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">
                                            {{ $user->name ?? 'ไม่ระบุชื่อ' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 group-hover:text-gray-800 transition-colors duration-200">
                                        {{ $user->email ?? 'ไม่ระบุอีเมล' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 border border-blue-200">
                                        <i class="fa fa-shield mr-1"></i>
                                        {{ $user->level ?? 'ไม่ระบุ' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-600 font-medium">
                                        {{ $user->created_at ? date('d/m/Y', strtotime($user->created_at)) : 'ไม่ระบุวันที่' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="inline-flex items-center p-3 text-sm font-medium text-gray-600 bg-white border-2 border-gray-200 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200 shadow-sm hover:shadow-md group" wire:click="openModalEdit({{ $user->id }})">
                                            <i class="fa fa-pencil group-hover:scale-110 transition-transform duration-200"></i>
                                        </button>
                                        <button class="inline-flex items-center p-3 text-sm font-medium text-gray-600 bg-white border-2 border-gray-200 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-300 transition-all duration-200 shadow-sm hover:shadow-md group" wire:click="openModalDelete({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="fa fa-times group-hover:scale-110 transition-transform duration-200"></i>
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

    <!-- User Modal -->
    <x-modal wire:model="showModal" title="ผู้ใช้งาน">
        @if (isset($error))
            <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-400 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fa fa-exclamation-triangle text-red-500 text-sm"></i>
                    </div>
                    <span class="text-red-700 text-sm font-medium">{{ $error }}</span>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Name Input -->
            <div class="relative">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa fa-user mr-2 text-gray-500"></i>
                    ชื่อ
                </label>
                <input type="text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" wire:model="name" placeholder="กรอกชื่อผู้ใช้งาน">
            </div>

            <!-- Email Input -->
            <div class="relative">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa fa-envelope mr-2 text-gray-500"></i>
                    อีเมล
                </label>
                <input type="email" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" wire:model="email" placeholder="กรอกอีเมล">
            </div>

            <!-- Password Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fa fa-lock mr-2 text-gray-500"></i>
                        รหัสผ่าน
                    </label>
                    <input type="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" wire:model="password" placeholder="กรอกรหัสผ่าน">
                </div>
                <div class="relative">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        <i class="fa fa-lock mr-2 text-gray-500"></i>
                        ยืนยันรหัสผ่าน
                    </label>
                    <input type="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" wire:model="password_confirmation" placeholder="ยืนยันรหัสผ่าน">
                </div>
            </div>

            <!-- Level Selection -->
            <div class="relative">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <i class="fa fa-shield mr-2 text-gray-500"></i>
                    Level
                </label>
                <select class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 hover:bg-white" wire:model="level">
                    @foreach ($listLevel as $level)
                        <option value="{{ $level }}">{{ $level }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Modal Actions -->
        <div class="flex justify-center space-x-4 mt-8 pt-6 border-t border-gray-200">
            <button class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white text-sm font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105" wire:click="save">
                <i class="fa fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white text-sm font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105" wire:click="closeModal">
                <i class="fa fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal-confirm 
        showModalDelete="showModalDelete" 
        title="ยืนยันการลบ"
        text="คุณต้องการลบผู้ใช้งาน {{ $nameForDelete }} หรือไม่?" 
        clickConfirm="delete"
        clickCancel="closeModalDelete" 
    />
</div>