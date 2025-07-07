<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BillingModel;
use App\Models\CustomerModel;
use App\Models\RoomModel;
use App\Models\OrganizationModel;

class Billing extends Component {
    public $showModal = false;
    public $showModalDelete = false; 
    public $showModalGetMoney = false;
    public $rooms = [];
    public $billings = [];
    public $id;
    public $roomId;
    public $remark;
    public $createdAt;
    public $status;
    public $amountRent;
    public $amountWater;
    public $amountElectric;
    public $amountInternet;
    public $amountFitness;
    public $amountWash;
    public $amountBin;
    public $amountEtc;
    public $customerName;
    public $customerPhone;
    public $listStatus = [
        ['status' => 'wait', 'name' => 'รอชำระเงิน'],
        ['status' => 'paid', 'name' => 'ชำระเงินแล้ว'],
        ['status' => 'next', 'name' => 'ขอค้างจ่าย'],
    ];
    public $sumAmount = 0;
    public $roomForDelete;
    public $waterUnit = 0;
    public $electricUnit = 0;
    public $waterCostPerUnit = 0;
    public $electricCostPerUnit = 0;
    public $roomNameForEdit = '';

    // get money
    public $roomNameForGetMoney = '';
    public $customerNameForGetMoney = '';
    public $payedDateForGetMoney = '';
    public $moneyAdded = 0;
    public $remarkForGetMoney = '';
    public $sumAmountForGetMoney = 0;
    public $amountForGetMoney = 0;
    public $billing; 

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('Y-m-d');
        $this->status = 'wait';
    }

    public function fetchData() {
        $customers = CustomerModel::where('status', 'use')->get();
        $rooms = [];

        $this->billings = BillingModel::orderBy('id', 'desc')->get();

        foreach ($customers as $customer) {
            $isBilling = false;

            foreach ($this->billings as $billing) {
                if ($billing->room_id == $customer->room_id) {
                    $isBilling = true;
                    break;
                }
            }

            if (!$isBilling) {
                $rooms[] = [
                    'id' => $customer->room_id, 
                    'name' => $customer->room->name
                ];
            }
        }

        $this->rooms = $rooms;
        
        if (count($rooms) > 0) {
            $this->roomId = $rooms[0]['id'];
            $this->selectedRoom();
        }
    }

    public function render() {
        return view('livewire.billing');
    }

    public function openModal() {
        $this->resetForm(); // รีเซ็ตก่อนเปิด modal
        $this->showModal = true;
    }

    public function closeModal() {
        $this->showModal = false;
        $this->resetForm(); // รีเซ็ตเมื่อปิด modal
    }

    public function selectedRoom() {
        $room = RoomModel::find($this->roomId);
        $customer = CustomerModel::where('room_id', $this->roomId)->first();
        $organization = OrganizationModel::first();

        // แก้ไข: ตรวจสอบค่าและกำหนดค่าเริ่มต้น
        $this->waterCostPerUnit = $organization->amount_water_per_unit ?? 0;
        $this->electricCostPerUnit = $organization->amount_electric_per_unit ?? 0;
        
        // แก้ไข: ตรวจสอบรูปแบบการคิดค่าน้ำ
        if ($organization->amount_water > 0) {
            // ถ้ามีค่าคงที่ ให้ใช้ค่าคงที่
            $this->amountWater = $organization->amount_water;
            $this->waterUnit = 0; // ไม่ต้องใส่หน่วยถ้าเป็นค่าคงที่
        } else {
            // ถ้าไม่มีค่าคงที่ ให้คำนวณตามหน่วย
            $this->amountWater = 0;
            $this->waterUnit = 0;
        }

        // แก้ไข: ตรวจสอบรูปแบบการคิดค่าไฟ
        if ($organization->amount_electric > 0) {
            // ถ้ามีค่าคงที่ ให้ใช้ค่าคงที่
            $this->amountElectric = $organization->amount_electric;
            $this->electricUnit = 0; // ไม่ต้องใส่หน่วยถ้าเป็นค่าคงที่
        } else {
            // ถ้าไม่มีค่าคงที่ ให้คำนวณตามหน่วย
            $this->amountElectric = 0;
            $this->electricUnit = 0;
        }

        $this->amountInternet = $organization->amount_internet ?? 0;
        $this->amountEtc = $organization->amount_etc ?? 0;
        $this->amountFitness = $organization->amount_fitness ?? 0;
        $this->amountWash = $organization->amount_wash ?? 0;
        $this->amountBin = $organization->amount_bin ?? 0;
        
        $this->customerName = $customer->name ?? '';
        $this->customerPhone = $customer->phone ?? '';
        $this->amountRent = $room->price_per_month ?? 0;

        $this->computeSumAmount();
    }

    public function computeSumAmount() {
        // แก้ไข: ปรับปรุงการคำนวณให้ถูกต้อง
        
        // คำนวณค่าน้ำ - เฉพาะเมื่อมีหน่วยและราคาต่อหน่วย
        if ($this->waterUnit > 0 && $this->waterCostPerUnit > 0) {
            $this->amountWater = $this->waterUnit * $this->waterCostPerUnit;
        }
        // หากไม่มีหน่วย แต่มีค่าคงที่ ให้คงค่าเดิม (ไม่ต้องเปลี่ยน)

        // คำนวณค่าไฟ - เฉพาะเมื่อมีหน่วยและราคาต่อหน่วย
        if ($this->electricUnit > 0 && $this->electricCostPerUnit > 0) {
            $this->amountElectric = $this->electricUnit * $this->electricCostPerUnit;
        }
        // หากไม่มีหน่วย แต่มีค่าคงที่ ให้คงค่าเดิม (ไม่ต้องเปลี่ยน)

        // แก้ไข: ตรวจสอบค่า null และแปลงเป็น numeric
        $this->amountRent = floatval($this->amountRent ?? 0);
        $this->amountWater = floatval($this->amountWater ?? 0);
        $this->amountElectric = floatval($this->amountElectric ?? 0);
        $this->amountInternet = floatval($this->amountInternet ?? 0);
        $this->amountFitness = floatval($this->amountFitness ?? 0);
        $this->amountWash = floatval($this->amountWash ?? 0);
        $this->amountBin = floatval($this->amountBin ?? 0);
        $this->amountEtc = floatval($this->amountEtc ?? 0);

        // คำนวณยอดรวม
        $this->sumAmount = $this->amountRent + $this->amountWater + $this->amountElectric 
            + $this->amountInternet + $this->amountFitness + $this->amountWash 
            + $this->amountBin + $this->amountEtc;
            
        // แก้ไข: ป้องกันค่าติดลบ
        $this->sumAmount = max(0, $this->sumAmount);
    }

    public function save() {
        // แก้ไข: คำนวณใหม่ก่อนบันทึก
        $this->computeSumAmount();
        
        $billing = new BillingModel();

        if ($this->id != null) {
            $billing = BillingModel::find($this->id);
        }

        $billing->room_id = $this->roomId;
        $billing->created_at = $this->createdAt;
        $billing->status = $this->status;
        $billing->remark = $this->remark ?? '';
        $billing->amount_rent = floatval($this->amountRent ?? 0);
        $billing->amount_water = floatval($this->amountWater ?? 0);
        $billing->amount_electric = floatval($this->amountElectric ?? 0);
        $billing->amount_internet = floatval($this->amountInternet ?? 0);
        $billing->amount_fitness = floatval($this->amountFitness ?? 0);
        $billing->amount_wash = floatval($this->amountWash ?? 0);
        $billing->amount_bin = floatval($this->amountBin ?? 0);
        $billing->amount_etc = floatval($this->amountEtc ?? 0);
        $billing->save();

        $this->fetchData();
        $this->closeModal();
    }

    // แก้ไข: ปรับปรุงฟังก์ชัน resetForm
    private function resetForm() {
        $this->id = null;
        $this->waterUnit = 0;
        $this->electricUnit = 0;
        $this->electricCostPerUnit = 0;
        $this->waterCostPerUnit = 0;
        $this->amountRent = 0;
        $this->amountWater = 0;
        $this->amountElectric = 0;
        $this->amountInternet = 0;
        $this->amountFitness = 0;
        $this->amountWash = 0;
        $this->amountBin = 0;
        $this->amountEtc = 0;
        $this->sumAmount = 0;
        $this->remark = '';
        $this->roomNameForEdit = '';
        $this->customerName = '';
        $this->customerPhone = '';
        $this->status = 'wait';
        $this->createdAt = date('Y-m-d');
    }

    public function openModalEdit($id) {
        $this->showModal = true;
        $this->billing = BillingModel::find($id);
        $this->id = $id;
        $this->roomId = $this->billing->room_id;

        // แก้ไข: โหลดข้อมูลจาก billing และตรวจสอบค่า null
        $this->amountRent = floatval($this->billing->amount_rent ?? 0);
        $this->amountWater = floatval($this->billing->amount_water ?? 0);
        $this->amountElectric = floatval($this->billing->amount_electric ?? 0);
        $this->amountInternet = floatval($this->billing->amount_internet ?? 0);
        $this->amountFitness = floatval($this->billing->amount_fitness ?? 0);
        $this->amountWash = floatval($this->billing->amount_wash ?? 0);
        $this->amountBin = floatval($this->billing->amount_bin ?? 0);
        $this->amountEtc = floatval($this->billing->amount_etc ?? 0);
        $this->remark = $this->billing->remark ?? '';
        $this->createdAt = $this->billing->created_at;
        $this->status = $this->billing->status;

        $this->roomNameForEdit = $this->billing->room->name ?? '';
    
        $organization = OrganizationModel::first();    
        
        // แก้ไข: ปรับปรุงการคำนวณหน่วย
        if ($organization && $organization->amount_water_per_unit > 0) {
            $this->waterCostPerUnit = $organization->amount_water_per_unit;
            if ($this->amountWater > 0) {
                $this->waterUnit = intval($this->amountWater / $organization->amount_water_per_unit);
            }
        } else {
            $this->waterUnit = 0;
            $this->waterCostPerUnit = 0;
        }
        
        if ($organization && $organization->amount_electric_per_unit > 0) {
            $this->electricCostPerUnit = $organization->amount_electric_per_unit;
            if ($this->amountElectric > 0) {
                $this->electricUnit = intval($this->amountElectric / $organization->amount_electric_per_unit);
            }
        } else {
            $this->electricUnit = 0;
            $this->electricCostPerUnit = 0;
        }

        // โหลดข้อมูลลูกค้า
        $customer = CustomerModel::where('room_id', $this->roomId)->first();
        $this->customerName = $customer->name ?? '';
        $this->customerPhone = $customer->phone ?? '';

        // แก้ไข: คำนวณยอดรวมใหม่
        $this->computeSumAmount();
    }

    public function closeModalEdit() {
        $this->showModal = false;
        $this->resetForm();
    }

    public function openModalDelete($id, $name) {
        $this->showModalDelete = true;
        $this->id = $id;
        $this->roomForDelete = $name;
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    public function deleteBilling() {
        $billing = BillingModel::find($this->id);
        $billing->delete();

        $this->fetchData();
        $this->closeModalDelete();
    }

    public function openModalGetMoney($id) {
        $billing = BillingModel::find($id);
        $this->showModalGetMoney = true;
        $this->id = $id;
        $this->roomNameForGetMoney = $billing->room->name ?? '';
        $this->customerNameForGetMoney = $billing->getCustomer()->name ?? '';
        $this->sumAmountForGetMoney = floatval($billing->sumAmount() ?? 0);
        $this->payedDateForGetMoney = date('Y-m-d');
        
        // แก้ไข: ตรวจสอบค่า money_added
        $this->moneyAdded = floatval($billing->money_added ?? 0);
        $this->remarkForGetMoney = $billing->remark ?? '';
        
        // แก้ไข: คำนวณใหม่ทุกครั้ง
        $this->calculateAmountForGetMoney();
    }

    public function closeModalGetMoney() {
        $this->showModalGetMoney = false;
        $this->resetGetMoneyForm();
    }

    // แก้ไข: เพิ่มฟังก์ชัน resetGetMoneyForm
    private function resetGetMoneyForm() {
        $this->id = null;
        $this->roomNameForGetMoney = '';
        $this->customerNameForGetMoney = '';
        $this->sumAmountForGetMoney = 0;
        $this->payedDateForGetMoney = '';
        $this->moneyAdded = 0;
        $this->remarkForGetMoney = '';
        $this->amountForGetMoney = 0;
    }

    // แก้ไข: ปรับปรุงฟังก์ชันคำนวณ
    private function calculateAmountForGetMoney() {
        $this->moneyAdded = floatval($this->moneyAdded ?? 0);
        $this->sumAmountForGetMoney = floatval($this->sumAmountForGetMoney ?? 0);
        $this->amountForGetMoney = $this->sumAmountForGetMoney + $this->moneyAdded;
        
        // แก้ไข: ป้องกันค่าติดลบ
        $this->amountForGetMoney = max(0, $this->amountForGetMoney);
    }

    public function handleChangeAmountForGetMoney() {
        // แก้ไข: ใช้ฟังก์ชันคำนวณใหม่
        $this->calculateAmountForGetMoney();
    }

    public function printBilling($billingId) {
        return redirect()->to('print-billing/' . $billingId);
    }

    public function saveGetMoney() {
        $billing = BillingModel::find($this->id);
        
        // แก้ไข: ตรวจสอบข้อมูลก่อนบันทึก
        if ($billing) {
            $billing->payed_date = $this->payedDateForGetMoney;
            $billing->remark = $this->remarkForGetMoney ?? '';
            $billing->money_added = floatval($this->moneyAdded ?? 0);
            $billing->status = 'paid';
            $billing->save();

            $this->fetchData();
            $this->closeModalGetMoney();
        }
    }
}