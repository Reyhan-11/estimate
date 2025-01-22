<?php

namespace App\Livewire\User;

use App\Models\Divisi;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Component
{
    public $name;
    public $username;
    public $password;
    public $password_confirmation;
    public $divisi_id;
    public $user_role;

    protected $rules = [
        'name'      => 'required|min:4',
        'username'  => 'required|unique:users,username',
        'password'  => 'required|min:4|confirmed',
        'divisi_id' => 'nullable',
        'user_role' => 'nullable'
    ];

    protected $messages = [
        'name.required'      => 'Nama tidak boleh kosong.',
        'name.min'           => 'Nama minimal 4 karakter.',
        'username.required'  => 'Username tidak boleh kosong.',
        'username.unique'    => 'Username sudah digunakan.',
        'password.required'  => 'Password tidak boleh kosong.',
        'password.min'       => 'Password minimal 4 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        // 'divisi_id.required' => 'Divisi harus dipilih.',
        // 'user_role.required' => 'Roles harus dipilih.'
    ];

    // public function mount()
    // {
    //     if (auth()->check()) {
    //         if (!auth()->user()->can('user-create')) {
    //             return redirect()->route('access-denied');
    //         }
    //     }
    // }

    public function storeUser()
    {
        $this->validate();
        $user = User::create([
            'name'      => $this->name,
            'username'  => $this->username,
            'password'  => Hash::make($this->password),
            'divisi_id' => $this->divisi_id,
            'log'       => "Create by " . auth()->user()->name
        ]);
        $user->assignRole($this->user_role); // assign data ke table model_has_roles
        // Trigger SweetAlert
        $this->dispatch('swal:success', [
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'User baru berhasil ditambahkan.',
            'route'     => route('index.user') // Pass the route to JavaScript
        ]);
    }

    public function render()
    {
        $divisions = Divisi::all();
        $roles     = Role::pluck('name', 'name')->all();
        return view(
            'livewire.user.create-user',
            [
                'divisions' => $divisions,
                'roles'     => $roles
            ]
        )->layout('components.layouts.app');
    }
}
