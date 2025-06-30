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
    public $price_day;
    public $price_month;
    public $from_number;
    public $to_number;
    public $price_per_day;
    public $price_per_month;
    public $nameForDelete;

    // เพิ่มตัวแปรสำหรับค้นหา
    public $searchTerm = '';

    //
    // paginate
    //
    public $itemsPerPage = 5;
    public $currentPage = 1;
    public $totalPages;

    public function mount() {
        $this->fetchData();
    }

    // เพิ่มฟังก์ชันสำหรับการค้นหา
    public function updatedSearchTerm() {
        $this->currentPage = 1; // รีเซ็ตไปหน้าแรกเมื่อค้นหา
        $this->fetchData();
    }

    // เพิ่มฟังก์ชันล้างการค้นหา
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
        $this->showModal = true;
        $this->from_number = '';
        $this->to_number = '';
        $this->price_per_day = '';
        $this->price_per_month = '';
    }

    public function openModalEdit($id) {
        $this->showModalEdit = true;
        $this->id = $id;

        $room = RoomModel::find($id);
        $this->name = $room->name;
        $this->price_day = $room->price_per_day;
        $this->price_month = $room->price_per_month;
    }

    public function nextPage() {
        if ($this->currentPage < $this->totalPages) {
            $this->currentPage++;
            $this->fetchData();
        }
    }

    public function prevPage() {
        if ($this->currentPage > 1) {
            $this->currentPage--;
            $this->fetchData();
        }
    }

    public function openModalDelete($id) {
        $this->showModalDelete = true;
        $this->id = $id;

        $room = RoomModel::find($id);
        $this->nameForDelete = $room->name;
    }

    public function updateRoom() {
        $this->validate([
            'name' => 'required|string|max:255',
            'price_day' => 'required|numeric|min:0',
            'price_month' => 'required|numeric|min:0',
        ]);

        $room = RoomModel::find($this->id);
        
        if (!$room) {
            session()->flash('error', 'ไม่พบข้อมูลห้องพัก');
            return;
        }

        $room->name = $this->name;
        $room->price_per_day = $this->price_day;
        $room->price_per_month = $this->price_month;
        $room->save();

        $this->showModalEdit = false;
        $this->fetchData();
        
        session()->flash('success', 'แก้ไขข้อมูลห้องพักเรียบร้อยแล้ว');
    }

    public function deleteRoom() {
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

        $room->status = 'delete';
        $room->save(); 

        $this->showModalDelete = false;
        $this->fetchData();
        
        session()->flash('success', 'ลบห้องพักเรียบร้อยแล้ว');
    }

    public function fetchData() {
        $this->rooms = [];
        $start = ($this->currentPage - 1) * $this->itemsPerPage;
        $end = $this->itemsPerPage;

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
            ->take($end)
            ->get();

        // คำนวณจำนวนหน้าทั้งหมด
        $totalRooms = RoomModel::where('status', 'use');
        if (!empty($this->searchTerm)) {
            $totalRooms->where(function($q) {
                $q->where('name', 'LIKE', '%' . $this->searchTerm . '%')
                  ->orWhere('price_per_day', 'LIKE', '%' . $this->searchTerm . '%')
                  ->orWhere('price_per_month', 'LIKE', '%' . $this->searchTerm . '%');
            });
        }
        $totalRooms = $totalRooms->count();
        $this->totalPages = ceil($totalRooms / $this->itemsPerPage);
    }

    public function createRoom() {
        $this->validate([
            'from_number' => 'required|integer|min:1',
            'to_number' => 'required|integer|min:1',
            'price_per_day' => 'required|numeric|min:0',
            'price_per_month' => 'required|numeric|min:0',
        ]);

        if ($this->from_number > $this->to_number) {
            $this->addError('from_number', 'ห้องต้องมีค่าน้อยกว่าห้องสุดท้าย');
            return;
        }

        if ($this->to_number > 1000) {
            $this->addError('to_number', 'ห้องสุดท้ายต้องมีค่าน้อยกว่า 1000');
            return;
        }

        // ตรวจสอบว่าห้องที่ต้องการสร้างมีอยู่แล้วหรือไม่
        $existingRooms = RoomModel::where('status', 'use')
            ->whereBetween('name', [$this->from_number, $this->to_number])
            ->pluck('name')
            ->toArray();

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
                $room->is_empty = 'yes'; // เพิ่มบรรทัดนี้เพื่อแก้ไขปัญหา
                $room->save();
                
                $createdRooms[] = $i;
            }

            $this->showModal = false;
            $this->resetForm();
            $this->fetchData();
            
            $roomCount = count($createdRooms);
            session()->flash('success', "สร้างห้องพัก {$roomCount} ห้อง เรียบร้อยแล้ว");
            
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

    public function resetForm() {
        $this->from_number = '';
        $this->to_number = '';
        $this->price_per_day = '';
        $this->price_per_month = '';
        $this->name = '';
        $this->price_day = '';
        $this->price_month = '';
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
    }

    public function render() {
        return view('livewire.room');
    }
}