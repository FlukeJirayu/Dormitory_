{{-- <----sidebar---> --}}
<div class="sidebar flex flex-col h-screen px-6 py-5 bg-gray-50 border-r border-gray-200 shadow-sm">
    {{-- Header --}}
    <div class="sidebar-header mb-6">
        <div
            class="text-center text-2xl font-bold text-violet-700 bg-violet-100 py-3 rounded-xl shadow-md tracking-wider">
            FALUK 1.0
        </div>
    </div>

    <div class="sidebar-body" style="flex-grow: 1;">
        <div class="menu">
            <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 15px;">
                @if ($userLevel == 'admin')
                    <li wire:click="changeMenu('dashboard')" @if ($currentMenu == 'dashboard') class="active" @endif
                        style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box;">
                        <i class="fa-solid fa-chart-line me-2"></i> Dashboard
                    </li>

                    <li wire:click="changeMenu('billing')" @if ($currentMenu == 'billing') class="active" @endif
                        style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box;">
                        <i class="fa-solid fa-building me-2"></i> ใบเสร็จรับเงิน
                    </li>

                    <li wire:click="changeMenu('pay')" @if ($currentMenu == 'pay') class="active" @endif
                        style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box;">
                        <i class="fa-solid fa-building me-2"></i> บันทึกค่าใช้จ่าย
                    </li>

                    <li wire:click="changeMenu('room')" @if ($currentMenu == 'room') class="active" @endif
                        style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box;">
                        <i class="fa-solid fa-home me-2"></i> ห้องพัก
                    </li>
                @endif
                <li wire:click="changeMenu('customer')" @if ($currentMenu == 'customer') class="active" @endif
                    style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box;">
                    <i class="fa-solid fa-user me-2"></i> ผู้เข้าพัก
                </li>
                @if ($userLevel == 'admin')
                    <li wire:click="changeMenu('user')" @if ($currentMenu == 'user') class="active" @endif
                        style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box;">
                        <i class="fa-solid fa-gear me-2"></i> ผู้ใช้งาน
                    </li>

                    <li wire:click="changeMenu('company')" @if ($currentMenu == 'company') class="active" @endif
                        style="padding: 10px 15px; border-radius: 8px; cursor: pointer; width: 100%; box-sizing: border-box; white-space: nowrap;">
                        <i class="fa-solid fa-building me-2"></i> ข้อมูลสถานประกอบการ
                    </li>
                @endif
            </ul>

        </div>
    </div>

    <div class="sidebar-footer text-center mt-auto p-3 border-top small text-muted"
        style="margin-top: auto; padding-top: 15px; font-size: 0.85rem; border-top: 1px solid #dee2e6;">
        &copy; {{ date('Y') }} FALUK. All rights reserved.
    </div>
</div>
