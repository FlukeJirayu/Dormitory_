<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Navbar extends Component
{
    public $user_name;
    public $showModal = false;
    public $showModalEdit = false;
    public $username;
    public $password;
    public $password_confirm;
    public $saveSuccess = false;
    public $userLevel= '';

    public function mount()
    {
        $this->user_name = session()->get('user_name');
        $this->userLevel = session()->get('user_level', );
    }

    public function editProfile()
    {
        $this->showModalEdit = true;

        $user = User::find(session()->get('user_id'));
        if ($user) {
            $this->username = $user->name;
        }

        $this->password = '';
        $this->password_confirm = '';
        $this->saveSuccess = false;
        $this->resetValidation();
    }

    public function updateProfile()
    {
        // Validate input
        $validator = Validator::make(
            [
                'username' => $this->username,
                'password' => $this->password,
                'password_confirm' => $this->password_confirm,
            ],
            [
                'username' => 'required|string|min:3|max:50',
                'password' => 'nullable|min:6|same:password_confirm',
            ],
            [
                'username.required' => 'Please enter a username.',
                'password.same' => 'Passwords do not match.',
                'password.min' => 'Password must be at least 6 characters.',
            ]
        );

        if ($validator->fails()) {
            $this->addErrorBag($validator->getMessageBag()->toArray());
            return;
        }

        // Update user
        $user = User::find(session()->get('user_id'));
        if (!$user) {
            $this->addError('username', 'User not found.');
            return;
        }

        $user->name = $this->username;
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->showModalEdit = false;
        $this->saveSuccess = true;

        // Reset fields
        $this->password = '';
        $this->password_confirm = '';
        $this->resetValidation();
    }

    public function confirmLogout()
    {
        $this->showModal = true;
    }

    public function logout()
    {
        session()->flush();
        return redirect()->to('/');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
