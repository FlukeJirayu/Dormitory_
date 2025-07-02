<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CustomerModel;
use App\Models\RoomModel;

class Customer extends Component
{
    public $customers = [];
    public $rooms = [];
    public $showModal = false;
    public $showModalDelete = false;
    public $showModalMove = false;
    public $id;
    public $name;
    public $address;
    public $phone;
    public $remark;
    public $roomId;
    public $createdAt;
    public $stayType = 'd'; // รายวัน, รายเดือน (d, m)
    public $roomIdMove;
    public $nameForDelete = '';

    // Search and Pagination properties
    public $searchTerm = '';
    public $stayTypeFilter = ''; // เพิ่มตัวแปรสำหรับกรองประเภทการพัก
    public $currentPage = 1;
    public $perPage = 10;
    public $totalPages = 1;

    public function mount()
    {
        $this->createdAt = date('Y-m-d');
        $this->fetchData();
    }

    public function fetchData()
    {
        $query = CustomerModel::where('status', 'use')
            ->with('room'); // Load room relationship

        // Apply search filter
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', '%' . $this->searchTerm . '%')
                    ->orWhere('phone', 'LIKE', '%' . $this->searchTerm . '%')
                    ->orWhere('address', 'LIKE', '%' . $this->searchTerm . '%')
                    ->orWhereHas('room', function ($roomQuery) {
                        $roomQuery->where('name', 'LIKE', '%' . $this->searchTerm . '%');
                    });
            });
        }

        // Apply stay type filter
        if (!empty($this->stayTypeFilter)) {
            $query->where('stay_type', $this->stayTypeFilter);
        }

        // Get total count for pagination
        $totalCustomers = $query->count();
        $this->totalPages = ceil($totalCustomers / $this->perPage);

        // Apply pagination
        $offset = ($this->currentPage - 1) * $this->perPage;
        $this->customers = $query->orderBy('id', 'desc')
            ->skip($offset)
            ->take($this->perPage)
            ->get();

        // Fetch available rooms
        $this->rooms = RoomModel::where('status', 'use')
            ->where('is_empty', 'yes')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function clearSearch()
    {
        $this->searchTerm = '';
        $this->currentPage = 1;
        $this->fetchData();
    }

    // เพิ่มฟังก์ชันสำหรับล้างการกรอง
    public function clearFilter()
    {
        $this->stayTypeFilter = '';
        $this->currentPage = 1;
        $this->fetchData();
    }

    // เพิ่มฟังก์ชันสำหรับล้างทั้งค้นหาและกรอง
    public function clearAll()
    {
        $this->searchTerm = '';
        $this->stayTypeFilter = '';
        $this->currentPage = 1;
        $this->fetchData();
    }

    public function setPage($page)
    {
        $this->currentPage = max(1, min($page, $this->totalPages));
        $this->fetchData();
    }

    public function updatedSearchTerm()
    {
        $this->currentPage = 1; // Reset to first page when searching
        $this->fetchData();
    }

    // เพิ่มฟังก์ชันสำหรับอัพเดทเมื่อเปลี่ยนการกรอง
    public function updatedStayTypeFilter()
    {
        $this->currentPage = 1; // Reset to first page when filtering
        $this->fetchData();
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->resetForm();
        // Refresh rooms list to get current available rooms
        $this->rooms = RoomModel::where('status', 'use')
            ->where('is_empty', 'yes')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->id = null;
        $this->name = '';
        $this->address = '';
        $this->phone = '';
        $this->remark = '';
        $this->roomId = null;
        $this->roomIdMove = null;
        $this->stayType = 'd';
    }

    public function save()
    {
        // Validate required fields
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'roomId' => 'required|exists:rooms,id',
            'createdAt' => 'required|date',
            'stayType' => 'required|in:d,m'
        ]);

        // Check if room exists and is available
        $room = RoomModel::find($this->roomId);
        if (!$room) {
            session()->flash('error', 'ห้องที่เลือกไม่พบในระบบ');
            return;
        }

        $customer = new CustomerModel();

        if ($this->id) {
            // Editing existing customer
            $customer = CustomerModel::find($this->id);
            if (!$customer) {
                session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
                return;
            }

            // If room changed, update room statuses
            if ($customer->room_id != $this->roomId) {
                // Check if new room is available
                if ($room->is_empty !== 'yes') {
                    session()->flash('error', 'ห้องที่เลือกไม่ว่าง');
                    return;
                }

                // Free old room
                $oldRoom = RoomModel::find($customer->room_id);
                if ($oldRoom) {
                    $oldRoom->is_empty = 'yes';
                    $oldRoom->save();
                }

                // Occupy new room
                $room->is_empty = 'no';
                $room->save();
                $customer->room_id = $this->roomId;
            }
        } else {
            // Creating new customer
            if ($room->is_empty !== 'yes') {
                session()->flash('error', 'ห้องที่เลือกไม่ว่าง');
                return;
            }

            $customer->room_id = $this->roomId;
            // Update room status for new customer
            $room->is_empty = 'no';
            $room->save();
        }

        $price = $room->price_per_day;
        if ($this->stayType == 'm') {
            $price = $room->price_per_month;
        }

        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->address = $this->address;
        $customer->remark = $this->remark;
        $customer->created_at = $this->createdAt;
        $customer->status = 'use';
        $customer->stay_type = $this->stayType;
        $customer->price = $price;
        $customer->save();

        $this->showModal = false;
        $this->resetForm();
        $this->fetchData();

        session()->flash('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    public function openModalDelete($id)
    {
        $customer = CustomerModel::find($id);
        if ($customer) {
            $this->nameForDelete = $customer->name;
            $this->id = $id;
            $this->showModalDelete = true;
        }
    }

    public function openModalEdit($id)
    {
        $customer = CustomerModel::find($id);

        if (!$customer) {
            session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
            return;
        }

        // Get all available rooms plus the current room
        $this->rooms = RoomModel::where('status', 'use')
            ->where(function ($query) use ($customer) {
                $query->where('is_empty', 'yes')
                    ->orWhere('id', $customer->room_id);
            })
            ->orderBy('name', 'asc')
            ->get();

        $this->showModal = true;
        $this->id = $id;
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->remark = $customer->remark;
        $this->roomId = $customer->room_id;
        $this->createdAt = date('Y-m-d', strtotime($customer->created_at));
        $this->stayType = $customer->stay_type;
    }

    public function delete()
    {
        $customer = CustomerModel::find($this->id);

        if (!$customer) {
            session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
            $this->showModalDelete = false;
            return;
        }

        $customer->status = 'delete';
        $customer->save();

        // Update room status
        $room = RoomModel::find($customer->room_id);
        if ($room) {
            $room->is_empty = 'yes';
            $room->save();
        }

        $this->showModalDelete = false;
        $this->fetchData();

        session()->flash('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    }

    public function closeModalDelete()
    {
        $this->showModalDelete = false;
    }

    public function openModalMove($id)
    {
        $customer = CustomerModel::find($id);

        if (!$customer) {
            session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
            return;
        }

        // Get available rooms (excluding current room)
        $this->rooms = RoomModel::where('status', 'use')
            ->where('is_empty', 'yes')
            ->where('id', '!=', $customer->room_id)
            ->orderBy('name', 'asc')
            ->get();

        $this->showModalMove = true;
        $this->id = $id;
    }

    public function closeModalMove()
    {
        $this->showModalMove = false;
        $this->roomIdMove = null;
    }

    public function move()
    {
        // Validate
        $this->validate([
            'roomIdMove' => 'required|exists:rooms,id'
        ]);

        $customer = CustomerModel::find($this->id);

        if (!$customer) {
            session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
            $this->showModalMove = false;
            return;
        }

        // Check if new room exists and is available
        $newRoom = RoomModel::find($this->roomIdMove);
        if (!$newRoom) {
            session()->flash('error', 'ห้องที่เลือกไม่พบในระบบ');
            return;
        }

        if ($newRoom->is_empty !== 'yes') {
            session()->flash('error', 'ห้องที่เลือกไม่ว่าง');
            return;
        }

        // Update old room status
        $oldRoom = RoomModel::find($customer->room_id);
        if ($oldRoom) {
            $oldRoom->is_empty = 'yes';
            $oldRoom->save();
        }

        // Update customer room
        $customer->room_id = $this->roomIdMove;
        $customer->save();

        // Update new room status
        $newRoom->is_empty = 'no';
        $newRoom->save();

        $this->showModalMove = false;
        $this->roomIdMove = null;
        $this->fetchData();

        session()->flash('success', 'ย้ายห้องเรียบร้อยแล้ว');
    }

    public function render()
    {
        return view('livewire.customer');
    }
}
