<?php

namespace App\Livewire\Otentikasi;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Illuminate\Http\Request;

class Login extends Component
{
    #[Validate('required', message: 'Username wajib di isi.')]
    public $username = '';

    #[Validate('required', message: 'Password tidak boleh kosong.')]
    public $password = '';

    public function login(Request $request)
    {
        $this->validate([
            'username'     => 'required',
            'password'     => 'required',
        ]);
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        } else {
            session()->flash('error', 'Username atau password salah.');
        }
    }

    public function render()
    {
        // karna layout nya terpisah, maka kasih path ke layout login
        return view('livewire.otentikasi.login')->layout('components.layouts.login');
    }
}
