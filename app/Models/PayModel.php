<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PayLogModel;

class PayModel extends Model
{
  protected $table = 'pays';
  protected $fillable = [
    'name',
    'remark',
    'status',
  ];

  public $timestamps = false;

  public function payLogs()
  {
    return $this->hasMany(PayLogModel::class, 'pay_id', 'id');
  }
}