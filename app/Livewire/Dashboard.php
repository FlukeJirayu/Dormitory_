<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BillingModel;
use App\Models\CustomerModel;
use App\Models\RoomModel;
use App\Models\PayLogModel;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component {
    public $income = 0;
    public $roomFee = 0;
    public $debt = 0;
    public $pay = 0;
    public $incomeInMonths = [];
    public $incomePie = [];
    public $yearList = [];
    public $monthList = [
        'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
        'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
    ];
    public $selectedYear;
    public $selectedMonth;

    public function mount() {
        $this->selectedYear = date('Y');
        $this->selectedMonth = date('m');

        // อ่านจาก query string
        if (request()->has('year') && request()->has('month')) {
            $this->selectedYear = request()->query('year');
            $this->selectedMonth = request()->query('month');
        }

        // ปีย้อนหลัง 5 ปี
        for ($i = 0; $i < 5; $i++) {
            $this->yearList[] = date('Y') - $i;
        }

        $this->fetchData();
    }

    public function fetchData() {
        $this->income = 0;
        $this->debt = 0;
        $this->pay = 0;

        // รายได้เดือนนี้
        $incomes = BillingModel::where('status', 'paid')
            ->whereYear('created_at', $this->selectedYear)
            ->whereMonth('created_at', $this->selectedMonth)
            ->get();

        foreach ($incomes as $income) {
            $this->income += $income->sumAmount() + $income->money_added;
        }

        // ห้องว่าง
        $countCustomer = CustomerModel::where('status', 'use')->count();
        $countRoom = RoomModel::where('status', 'use')->count();
        $this->roomFee = $countRoom - $countCustomer;

        // ค้างจ่ายเดือนนี้
        $waits = BillingModel::where('status', 'wait')
            ->whereYear('created_at', $this->selectedYear)
            ->whereMonth('created_at', $this->selectedMonth)
            ->get();

        foreach ($waits as $wait) {
            $this->debt += $wait->sumAmount() + $wait->money_added;
        }

        // รายจ่ายเดือนนี้
        $this->pay = PayLogModel::where('status', 'use')
            ->whereYear('pay_date', $this->selectedYear)
            ->whereMonth('pay_date', $this->selectedMonth)
            ->sum('amount');

        // รายได้ในแต่ละเดือน
        for ($i = 1; $i <= 12; $i++) {
            $billingsInMonth = BillingModel::where('status', 'paid')
                ->whereYear('payed_date', $this->selectedYear)
                ->whereMonth('payed_date', $i)
                ->get();

            $sum = 0;

            foreach ($billingsInMonth as $billing) {
                $sum += $billing->sumAmount() + $billing->money_added;
            }

            $this->incomeInMonths[$i] = $sum;
        }

        // กราฟวงกลม: รายได้วันนี้ + เดือนนี้
        $incomeToday = BillingModel::where('status', 'paid')
            ->whereDate('created_at', now()->toDateString())
            ->get()
            ->sum(function ($billing) {
                return $billing->sumAmount() + $billing->money_added;
            });

        $incomeMonth = BillingModel::where('status', 'paid')
            ->whereYear('created_at', $this->selectedYear)
            ->whereMonth('created_at', $this->selectedMonth)
            ->get()
            ->sum(function ($billing) {
                return $billing->sumAmount() + $billing->money_added;
            });

        $this->incomePie = [
            'วันนี้' => $incomeToday,
            'เดือนนี้' => $incomeMonth,
        ];
    }

    public function loadNewData() {
        return redirect()->to('/dashboard?year=' . $this->selectedYear . '&month=' . $this->selectedMonth);
    }

    public function render() {
        return view('livewire.dashboard');
    }
}
