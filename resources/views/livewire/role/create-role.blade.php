<div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Role</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="saveRole" class="row g-3 needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Role Name</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Manager" wire:model.lazy="name">
                            </div>
                            @error('name')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Permissions</label>
                            <div class="input-group input-group-merge">
                                <div class="form-group">
                                    @php
                                    $permissionGroups = [];
                                    @endphp

                                    <div class="input-group input-group-outline @error('selectedPermission') is-invalid @enderror">
                                        @foreach($permissions as $permission)
                                        @php
                                        $permissionParts = explode('-', $permission->name);
                                        $groupName = $permissionParts[0];
                                        $permissionGroups[$groupName][] = $permission;
                                        @endphp
                                        @endforeach
                                    </div>

                                    @foreach($permissionGroups as $group => $groupedPermissions)
                                    <div class="group">
                                        <h5>{{ ucfirst($group) }}</h5>
                                        <ul>
                                            @foreach($groupedPermissions as $permission)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" wire:model="selectedPermission" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            @error('selectedPermission')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Save</button>
                        <!-- SHOW LOADING -->
                        <div wire:loading class="mb-0 mt-2">
                            <div class="text-center">
                                <div class="spinner-border text-primary" role="status"></div>
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
        // Redirect after 1.2 seconds
        setTimeout(() => {
            window.location.href = event.detail[0].route;
        }, 1200);
    });
</script>