<?php

namespace App\Livewire\Role;

use Livewire\Component;
// use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRole extends Component
{
    public $name;
    // public $selectedPermission = [];

    protected $rules = [
        'name'             => 'required|unique:roles,name',
        // 'selectedPermission'    => 'required|array|min:1',
    ];

    protected $messages = [
        'name.required'            => 'Role Name tidak boleh kosong.',
        'name.unique'              => 'Role Name sudah dibuat.',
        // 'selectedPermission.required'   => 'Permission access harus dicentang minimal 1 akses.',
    ];

    // public function mount()
    // {
    //     if (auth()->check()) {
    //         if (!auth()->user()->can('role-create')) {
    //             return redirect()->route('access-denied');
    //         }
    //     }
    // }

    public function saveRole()
    {
        $this->validate();

        $role = Role::create(['name' => ucwords(trim($this->name))]);

        // Convert permission IDs to permission names
        // $permissions = Permission::whereIn('id', $this->selectedPermission)->pluck('name');

        // $role->syncPermissions($permissions);

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Role baru berhasil ditambahkan.',
            'route' => route('index.role')
        ]);
    }

    public function render()
    {
        // $permissions = Permission::all();
        // ['permissions' => $permissions]
        return view('livewire.role.create-role')->layout('components.layouts.app');;
    }
}
