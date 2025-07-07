<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;
use App\Models\RoomModel;

class BillingModel extends Model
{
  protected $table = 'billings';
  protected $fillable = [
    'room_id',
    'remake',
    'status',
    'amount_rent',
    'created_at',
    'amount_water',
    'amount_electric',
    'amount_internet',
    'amount_fitness',
    'amount_wash',
    'amount_bin',
    'amount_etc',
    'money_added',
    'payed_date',
  ];
  public $timestamps = false;

  public function room()
  {
    return $this->belongsTo(RoomModel::class, 'room_id', 'id');
  }
  public function getCustomer()
  {
    return CustomerModel::where('room_id', $this->room_id)->first();
  }

  public function sumAmount()
  {
    return floatval($this->amount_rent ?? 0) +
      floatval($this->amount_water ?? 0) +
      floatval($this->amount_electric ?? 0) +
      floatval($this->amount_internet ?? 0) +
      floatval($this->amount_fitness ?? 0) +
      floatval($this->amount_wash ?? 0) +
      floatval($this->amount_bin ?? 0) +
      floatval($this->amount_etc ?? 0);
  }
  public function getStatusName()
  {
    switch ($this->status) {
      case 'wait':
        return 'รอชำระเงิน';
      case 'paid':
        return 'ชำระเงินแล้ว';
      case 'next':
        return 'ขอค้างชำระ';
    }
  }
}
