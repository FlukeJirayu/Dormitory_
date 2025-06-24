<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationModel extends Model
{
    // เชื่อมกับตาราง organizations ในฐานข้อมูล
    protected $table = 'organizations';

    // ฟิลด์ที่อนุญาตให้กรอกข้อมูลได้ (mass assignment)
    protected $fillable = [
        'name',       // ชื่อสถานประกอบการ
        'address',    // ที่อยู่
        'phone',      // เบอร์โทรศัพท์
        'tax_code',   // รหัสผู้เสียภาษี
        'logo',       // โลโก้ (path รูปภาพ)
    ];

    // ปิดการใช้งาน timestamps (created_at / updated_at)
    public $timestamps = false;
}
