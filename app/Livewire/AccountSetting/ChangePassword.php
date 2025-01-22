<?php

namespace App\Livewire\AccountSetting;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePassword extends Component
{
    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    protected $rules = [
        'old_password' => 'required',
        'new_password' => 'required|confirmed|min:4|different:old_password',
    ];

    protected $messages = [
        'old_password.required'  => 'Password lama tidak boleh kosong.',
        'new_password.required'  => 'Password baru tidak boleh kosong.',
        'new_password.min'       => 'Password baru minimal 4 karakter.',
        'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        'new_password.different' => 'Password baru harus berbeda dengan password lama.',
    ];

    public function updatePassword()
    {
        $this->validate();

        if (!Hash::check($this->old_password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'old_password' => ['Password lama anda salah.'],
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        session()->flash('success', 'Password berhasil diperbarui.');

        // Optionally, you can reset the input fields
        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);
    }

    public function render()
    {
        return view('livewire.account-setting.change-password');
    }
}

