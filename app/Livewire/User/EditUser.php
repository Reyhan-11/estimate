<?php

namespace App\Livewire\User;

use App\Models\Divisi;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditUser extends Component
{
    public $id;
    public $name;
    public $username;
    public $divisi_id;
    public $user_role;

    protected function rules()
    {
        return [
            'name'      => 'required|min:4',
            'username'  => 'required|unique:users,username,' . $this->id,
            'divisi_id' => 'nullable',
            'user_role' => 'nullable'
        ];
    }

    protected $messages = [
        'name.required'     => 'Nama tidak boleh kosong.',
        'name.min'          => 'Nama minimal 4 karakter.',
        'username.required' => 'Username tidak boleh kosong.',
        'username.unique'   => 'Username sudah digunakan.',
        // 'divisi_id.required' => 'Divisi harus dipilih.',
        // 'user_role.required' => 'Roles harus dipilih.'
    ];

    public function mount($id)
    {
        // if (auth()->check()) {
        //     if (!auth()->user()->can('user-edit')) {
        //         return redirect()->route('access-denied');
        //     }
        // }
        $user               = User::findOrFail($id);
        $this->id           = $user->id;
        $this->name         = $user->name;
        $this->username     = $user->username;
        $this->divisi_id    = $user->divisi_id;
        $this->user_role    = $user->roles->pluck('name')->first(); // Assuming a user has one role
    }

    public function updateUser()
    {
        $this->validate();

        $user            = User::findOrFail($this->id);
        $user->name      = $this->name;
        $user->username  = $this->username;
        $user->divisi_id = $this->divisi_id;
        $user->log       = "Edit by ". auth()->user()->name;
        $user->save();

        // Update role
        $user->syncRoles($this->user_role);
        
        $this->dispatch('swal:success', [
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'User berhasil diperbarui.',
            'route'     => route('index.user')
        ]);
    }

    public function render()
    {
        $divisions = Divisi::all();
        $roles     = Role::pluck('name', 'name')->all();
        return view('livewire.user.edit-user', ['divisions' => $divisions,'roles' => $roles]);
    }
}
