<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CustomerModel;
use App\Models\RoomModel;

class Customer extends Component {
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

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('Y-m-d');
    }

    public function fetchData() {
        $this->customers = CustomerModel::where('status', 'use')
            ->orderBy('id', 'desc')
            ->get();
        
        $this->rooms = RoomModel::where('status', 'use')
            ->where('is_empty', 'yes')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function openModal() {
        $this->showModal = true;
    }

    public function closeModal() {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm() {
        $this->id = null;
        $this->name = '';
        $this->address = '';
        $this->phone = '';
        $this->remark = '';
        $this->roomId = null;
        $this->roomIdMove = null;
        $this->stayType = 'd';
    }

    public function save() {
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

        if ($room->is_empty !== 'yes' && !$this->id) {
            session()->flash('error', 'ห้องที่เลือกไม่ว่าง');
            return;
        }

        $customer = new CustomerModel();

        if ($this->id) {
            $customer = CustomerModel::find($this->id);
            if (!$customer) {
                session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
                return;
            }
        } else {
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

    public function openModalDelete($id) {
        $this->showModalDelete = true;
        $this->id = $id;
    }

    public function openModalEdit($id) {
        $customer = CustomerModel::find($id);
        
        if (!$customer) {
            session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
            return;
        }

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

    public function delete() {
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

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    public function openModalMove($id) {
        $customer = CustomerModel::find($id);
        
        if (!$customer) {
            session()->flash('error', 'ไม่พบข้อมูลลูกค้า');
            return;
        }

        $this->showModalMove = true;
        $this->id = $id;
    }

    public function closeModalMove() {
        $this->showModalMove = false;
        $this->roomIdMove = null;
    }

    public function move() {
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

    public function render() {
        return view('livewire.customer');
    }
}