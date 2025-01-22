<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class EditRole extends Component
{
    public $roleId;
    public $name;
    public $selectedPermission = [];

    protected function rules()
    {
        return [
            'name'               => 'required|unique:roles,name,' . $this->roleId,
            'selectedPermission' => 'required|array|min:1',
        ];
    }

    protected $messages = [
        'name.required'                 => 'Role Name tidak boleh kosong.',
        'name.unique'                   => 'Role Name sudah dibuat.',
        'selectedPermission.required'   => 'Permission access harus dicentang minimal 1 akses.',
    ];

    public function mount($id)
    {
        // if (auth()->check()) {
        //     if (!auth()->user()->can('role-edit')) {
        //         return redirect()->route('access-denied');
        //     }
        // }
        $role         = Role::find($id);
        $this->roleId = $role->id;
        $this->name   = $role->name;
        // Inisialisasi $selectedPermission dengan permission yang dimiliki oleh role ini
        $this->selectedPermission = DB::table("role_has_permissions")
            ->where("role_has_permissions.role_id", $this->roleId)
            ->pluck('role_has_permissions.permission_id')
            ->toArray();
    }

    public function updateRole()
    {
        $this->validate();

        $role = Role::find($this->roleId);
        $role->name = ucwords(trim($this->name));
        $role->save();

        // Convert permission IDs to permission names
        $permissions = Permission::whereIn('id', $this->selectedPermission)->pluck('name');

        $role->syncPermissions($permissions);

        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Role berhasil diperbarui.',
            'route' => route('index.role')
        ]);
    }

    public function render()
    {
        $permissions     = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $this->roleId)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view(
            'livewire.role.edit-role',
            [
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions
            ]
        )->layout('components.layouts.app');
    }
}
