<div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New User</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="storeUser" class="row g-3 needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" wire:model.live.debounce.150ms="name">
                            </div>
                            @error('name')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-company">Username</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text">@</span>
                                <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" wire:model.live.debounce.150ms="username">
                            </div>
                            @error('username')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Role</label>
                            <select class="form-select @error('user_role') is-invalid @enderror" wire:model="user_role">
                                <option selected="">Select</option>
                                @foreach ($roles as $role => $name)
                                <option value="{{ $role }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('user_role')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Division</label>
                            <select class="form-select @error('divisi_id') is-invalid @enderror" wire:model="divisi_id">
                                <option selected="">Select</option>
                                @foreach ($divisions as $divisi)
                                <option value="{{ $divisi->id }}">{{ ucwords($divisi->name) }}</option>
                                @endforeach
                            </select>
                            @error('divisi_id')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-company">Password</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" wire:model.live.debounce.150ms="password">
                            </div>
                            @error('password')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-company">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-lock"></i></span>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation your password" wire:model="password_confirmation">
                                @error('password_confirmation')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <!-- SHOW LOADING -->
                        <div wire:loading class="mb-0 mt-2">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('sneat-template/assets/vendor/js/sweetalert.js') }}"></script>
<script>
    window.addEventListener('swal:success', event => {
        Swal.fire({
            icon: event.detail[0].type,
            title: event.detail[0].title,
            html: event.detail[0].message,
            showConfirmButton: false,
        });
        // Reload after 1.2 seconds
        setTimeout(() => {
            window.location.href = event.detail[0].route;
        }, 1200);
    });
</script>