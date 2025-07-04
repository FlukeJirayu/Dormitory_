<?php 

namespace App\Livewire;

use Livewire\Component;
use App\Models\RoomModel;

class Room extends Component {
    public $rooms = [];
    public $showModal = false;
    public $showModalEdit = false;
    public $showModalDelete = false;
    public $id;
    public $name;
    public $price_per_day;
    public $price_per_month;
    public $from_number;
    public $to_number;
    public $nameForDelete;

    // เพิ่มตัวแปรสำหรับค้นหา
    public $searchTerm = '';

    // paginate
    public $itemsPerPage = 5;
    public $currentPage = 1;
    public $totalPages;

    // Protected properties for Livewire
    protected $rules = [
        'name' => 'required|string|max:255',
        'price_per_day' => 'required|numeric|min:0',
        'price_per_month' => 'required|numeric|min:0',
        'from_number' => 'required|integer|min:1',
        'to_number' => 'required|integer|min:1',
    ];

    protected $messages = [
        'name.required' => 'กรุณากรอกชื่อห้องพัก',
        'name.string' => 'ชื่อห้องพักต้องเป็นข้อความ',
        'name.max' => 'ชื่อห้องพักต้องไม่เกิน 255 ตัวอักษร',
        'price_per_day.required' => 'กรุณากรอกราคาต่อวัน',
        'price_per_day.numeric' => 'ราคาต่อวันต้องเป็นตัวเลข',
        'price_per_day.min' => 'ราคาต่อวันต้องมากกว่าหรือเท่ากับ 0',
        'price_per_month.required' => 'กรุณากรอกราคาต่อเดือน',
        'price_per_month.numeric' => 'ราคาต่อเดือนต้องเป็นตัวเลข',
        'price_per_month.min' => 'ราคาต่อเดือนต้องมากกว่าหรือเท่ากับ 0',
        'from_number.required' => 'กรุณากรอกหมายเลขเริ่มต้น',
        'from_number.integer' => 'หมายเลขเริ่มต้นต้องเป็นตัวเลข',
        'from_number.min' => 'หมายเลขเริ่มต้นต้องมากกว่า 0',
        'to_number.required' => 'กรุณากรอกหมายเลขสิ้นสุด',
        'to_number.integer' => 'หมายเลขสิ้นสุดต้องเป็นตัวเลข',
        'to_number.min' => 'หมายเลขสิ้นสุดต้องมากกว่า 0',
    ];

    public function mount() {
        $this->fetchData();
    }

    public function updatedSearchTerm() {
        $this->currentPage = 1;
        $this->fetchData();
    }

    public function clearSearch() {
        $this->searchTerm = '';
        $this->currentPage = 1;
        $this->fetchData();
    }

    public function setPage($page) {
        $this->currentPage = $page;
        $this->fetchData();
    }

    public function openModal() {
        $this->resetForm();
        $this->showModal = true;
    }

    public function openModalEdit($id) {
        $this->resetForm();
        $this->showModalEdit = true;
        $this->id = $id;

        $room = RoomModel::find($id);
        if ($room) {
            $this->name = $room->name;
            $this->price_per_day = $room->price_per_day;
            $this->price_per_month = $room->price_per_month;
        }
    }

    public function openModalDelete($id) {
        $this->showModalDelete = true;
        $this->id = $id;

        $room = RoomModel::find($id);
        if ($room) {
            $this->nameForDelete = $room->name;
        }
    }

    public function updateRoom() {
        // ตรวจสอบว่าชื่อห้องซ้ำกับห้องอื่นหรือไม่
        $existingRoom = RoomModel::where('name', $this->name)
            ->where('status', 'use')
            ->where('id', '!=', $this->id)
            ->first();

        if ($existingRoom) {
            $this->addError('name', 'ชื่อห้องพักนี้มีอยู่แล้ว');
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'price_per_month' => 'required|numeric|min:0',
        ]);

        try {
            $room = RoomModel::find($this->id);
            
            if (!$room) {
                session()->flash('error', 'ไม่พบข้อมูลห้องพัก');
                return;
            }

            $room->name = $this->name;
            $room->price_per_day = $this->price_per_day;
            $room->price_per_month = $this->price_per_month;
            $room->save();

            $this->showModalEdit = false;
            $this->resetForm();
            $this->fetchData();
            
            session()->flash('success', 'แก้ไขข้อมูลห้องพัก "' . $this->name . '" เรียบร้อยแล้ว');
            
        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล: ' . $e->getMessage());
        }
    }

    public function deleteRoom() {
        try {
            $room = RoomModel::find($this->id);
            
            if (!$room) {
                session()->flash('error', 'ไม่พบข้อมูลห้องพัก');
                $this->showModalDelete = false;
                return;
            }

            // ตรวจสอบว่าห้องมีคนพักอยู่หรือไม่
            if ($room->is_empty === 'no') {
                session()->flash('error', 'ไม่สามารถลบห้องที่มีคนพักอยู่ได้');
                $this->showModalDelete = false;
                return;
            }

            $roomName = $room->name;
            $room->status = 'delete';
            $room->save(); 

            $this->showModalDelete = false;
            $this->resetForm();
            $this->fetchData();
            
            session()->flash('success', 'ลบห้องพัก "' . $roomName . '" เรียบร้อยแล้ว');
            
        } catch (\Exception $e) {
            session()->flash('error', 'เกิดข้อผิดพลาดในการลบห้องพัก: ' . $e->getMessage());
        }
    }

    public function createRoom() {
        $this->validate([
            'from_number' => 'required|integer|min:1',
            'to_number' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'price_per_month' => 'required|numeric|min:0',
        ]);

        if ($this->from_number > $this->to_number) {
            $this->addError('from_number', 'หมายเลขเริ่มต้นต้องน้อยกว่าหรือเท่ากับหมายเลขสิ้นสุด');
            return;
        }

        if ($this->to_number > 1000) {
            $this->addError('to_number', 'หมายเลขสิ้นสุดต้องไม่เกิน 1000');
            return;
        }

        // ตรวจสอบว่าห้องที่ต้องการสร้างมีอยู่แล้วหรือไม่
        $existingRooms = [];
        for ($i = $this->from_number; $i <= $this->to_number; $i++) {
            $existingRoom = RoomModel::where('name', $i)
                ->where('status', 'use')
                ->first();
            if ($existingRoom) {
                $existingRooms[] = $i;
            }
        }

        if (!empty($existingRooms)) {
            $existingRoomsList = implode(', ', $existingRooms);
            $this->addError('from_number', "ห้อง {$existingRoomsList} มีอยู่แล้วในระบบ");
            return;
        }

        $createdRooms = [];
        
        try {
            for ($i = $this->from_number; $i <= $this->to_number; $i++) {
                $room = new RoomModel();
                $room->name = $i;
                $room->price_per_day = $this->price_per_day;
                $room->price_per_month = $this->price_per_month;
                $room->status = 'use';
                $room->is_empty = 'yes';
                $room->save();
                
                $createdRooms[] = $i;
            }

            $this->showModal = false;
            $this->resetForm();
            $this->fetchData();
            
            $roomCount = count($createdRooms);
            session()->flash('success', "สร้างห้องพัก {$roomCount} ห้อง (ห้อง " . implode(', ', $createdRooms) . ") เรียบร้อยแล้ว");
            
        } catch (\Exception $e) {
            // หากเกิดข้อผิดพลาด ให้ลบห้องที่สร้างไปแล้ว
            foreach ($createdRooms as $roomName) {
                $room = RoomModel::where('name', $roomName)->where('status', 'use')->first();
                if ($room) {
                    $room->delete();
                }
            }
            
            session()->flash('error', 'เกิดข้อผิดพลาดในการสร้างห้องพัก: ' . $e->getMessage());
        }
    }

    public function fetchData() {
        $this->rooms = collect();
        $start = ($this->currentPage - 1) * $this->itemsPerPage;

        // สร้าง query พื้นฐาน
        $query = RoomModel::where('status', 'use');

        // เพิ่มเงื่อนไขการค้นหา
        if (!empty($this->searchTerm)) {
            $query->where(function($q) {
                $q->where('name', 'LIKE', '%' . $this->searchTerm . '%')
                  ->orWhere('price_per_day', 'LIKE', '%' . $this->searchTerm . '%')
                  ->orWhere('price_per_month', 'LIKE', '%' . $this->searchTerm . '%');
            });
        }

        // ดึงข้อมูลพร้อม pagination
        $this->rooms = $query->orderBy('id', 'asc')
            ->skip($start)
            ->take($this->itemsPerPage)
            ->get();

        // คำนวณจำนวนหน้าทั้งหมด
        $totalRoomsQuery = RoomModel::where('status', 'use');
        if (!empty($this->searchTerm)) {
            $totalRoomsQuery->where(function($q) {
                $q->where('name', 'LIKE', '%' . $this->searchTerm . '%')
                  ->orWhere('price_per_day', 'LIKE', '%' . $this->searchTerm . '%')
                  ->orWhere('price_per_month', 'LIKE', '%' . $this->searchTerm . '%');
            });
        }
        $totalRooms = $totalRoomsQuery->count();
        $this->totalPages = ceil($totalRooms / $this->itemsPerPage);
    }

    public function resetForm() {
        $this->name = '';
        $this->price_per_day = '';
        $this->price_per_month = '';
        $this->from_number = '';
        $this->to_number = '';
        $this->id = null;
        $this->nameForDelete = '';
        $this->resetErrorBag();
    }

    public function closeModal() {
        $this->showModal = false;
        $this->resetForm();
    }

    public function closeModalEdit() {
        $this->showModalEdit = false;
        $this->resetForm();
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
        $this->resetForm();
    }

    public function render() {
        return view('livewire.room');
    }
}