<?php

namespace App\Livewire\Otentikasi;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.otentikasi.logout');
    }
}
