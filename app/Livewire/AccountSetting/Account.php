<?php

namespace App\Livewire\AccountSetting;

use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;

class Account extends Component
{
    use WithFileUploads;

    public $userId;

    #[Validate('required', message: 'Nama tidak boleh kosong.')]
    #[Validate('min:3', message: 'Nama minimal 3 karakter.')]
    public $name = '';

    #[Validate('required', message: 'Username tidak boleh kosong.')]
    #[Validate('min:3', message: 'Username minimal 3 karakter.')]
    #[Validate('unique:users', message: 'Username sudah digunakan.')]
    public $username = '';

    public $divisi = '';
    public $created_at = '';
    public $updated_at = '';
    public $last_activity = '';

    #[Validate('max:4096', message: 'Foto yang diupload melebihi 4MB.')]
    #[Validate('image', message: 'File yang diupload harus jpg, png, gif.')]
    public $foto = '';

    public function mount()
    {
        // Retrieve the current authenticated user along with their division data
        $user = auth()->user()->load('divisi');
        $this->userId        = $user->id;
        $this->name          = $user->name;
        $this->username      = $user->username;
        $this->divisi        = $user->divisi->name;
        $this->foto          = $user->foto;
        $this->created_at    = $this->getFormattedTimestamp($user->created_at);
        $this->updated_at    = $this->getFormattedTimestamp($user->updated_at);
        $this->last_activity = $this->getFormattedTimestamp($user->last_activity);
    }

    public function updateProfile()
    {
        $this->validate([
            'username'      => 'required|min:3|unique:users,username,' . $this->userId,
            'name'          => 'required|min:3',
        ]);

        $user      = User::findOrFail($this->userId);
        $user->update([
            'username'  => $this->username,
            'name'      => $this->name,
        ]);

        // Trigger SweetAlert
        $this->dispatch('swal:success', [
            'type'      => 'success',
            'title'     => 'Success!',
            'message'   => 'Data updated successfully',
        ]);
    }

    public function updatedFoto()
    {
        try {
            $this->validate([
                'foto' => 'image|mimes:jpeg,png,gif|max:4096',
            ]);
            if ($this->foto) {
                $user       = User::findOrFail(auth()->id());
                $fileName   = uniqid() . '.' . $this->foto->getClientOriginalExtension();
                $this->foto->storeAs('public/foto_user', $fileName);

                // Delete old photo
                if ($user->foto && Storage::exists('public/foto_user/' . $user->foto)) {
                    Storage::delete('public/foto_user/' . $user->foto);
                }

                // Update user's photo
                $user->update(['foto' => $fileName]);

                // Trigger SweetAlert
                $this->dispatch('swal:success', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Photo updated successfully',
                ]);
            }
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $errorMessage = implode('<br>', $errors);

            $this->dispatch('swal:error', [
                'type'    => 'error',
                'title'   => 'Error!',
                'message' => $errorMessage,
            ]);
        }
    }

    public function resetFoto($userId)
    {
        // Dispatching a browser event to trigger the SweetAlert popup
        $this->dispatch('confirmResetFoto', [
            'type'      => 'warning',
            'title'     => 'Hapus?',
            'message'   => 'Apakah anda ingin reset foto ke default?',
            'userId'    => $userId
        ]);
    }

    #[On('confirmResetFotoAction')]
    public function confirmResetFotoAction($userId)
    {
        $user       = User::findOrFail($userId);

        
        // Delete old photo
        if ($user->foto && Storage::exists('public/foto_user/' . $user->foto)) {
            Storage::delete('public/foto_user/' . $user->foto);
        }

        // Update user's photo
        $user->update(['foto' => NULL]);

        // Trigger SweetAlert
        $this->dispatch('swal:success', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Foto di setting ke default.',
        ]);
    }


    public function render()
    {
        Carbon::setLocale('id');
        $user = Auth::user();
        // Get all permissions via roles
        $permissions = $user->getPermissionsViaRoles()->pluck('name');

        // Group permissions by category
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            return explode('-', $permission)[0]; // Get the prefix before the first dash
        });
        return view('livewire.account-setting.account', [
            'user' => $user,
            'groupedPermissions' => $groupedPermissions,
        ]);
    }

    public function getFormattedTimestamp($timestamp)
    {
        return Carbon::parse($timestamp)->diffForHumans();
    }
}
