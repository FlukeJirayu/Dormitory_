<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Signin extends Component
{
    public $username;
    public $password;
    public $errorUsername;
    public $errorPassword;
    public $error = null;

    public function signin() {
        logger('Signin attempt', [
            'username' => $this->username
        ]);

        $this->errorUsername = null;
        $this->errorPassword = null;
        $this->error = null;

        $validator = Validator::make([
            'username' => $this->username,
            'password' => $this->password
        ], [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'password.required' => 'กรุณากรอกรหัสผ่าน'
        ]);

        if ($validator->fails()) {
            $this->errorUsername = $validator->errors()->get('username')[0] ?? null;
            $this->errorPassword = $validator->errors()->get('password')[0] ?? null;
        } else {
            try {
                $user = User::where('name', $this->username)->first();

                if ($user && Hash::check($this->password, $user->password)) {
                    session()->put('user_id', $user->id);
                    session()->put('user_name', $user->name);
                    session()->put('user_level', $user->level);

                    logger('Signin successful', [
                        'user_id' => $user->id,
                        'username' => $user->name
                    ]);

                    return $this->redirect('/dashboard');
                } else {
                    $this->error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
                    
                    logger('Signin failed', [
                        'username' => $this->username,
                        'reason' => 'Invalid credentials'
                    ]);
                }
            } catch (\Exception $e) {
                logger('Signin error', [
                    'error' => $e->getMessage(),
                    'username' => $this->username
                ]);
                $this->error = 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ';
            }
        }
    }

    public function render()
    {
        return view('livewire.signin');
    }
}