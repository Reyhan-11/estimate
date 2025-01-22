<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="col-lg-12">
                    <form method="GET">
                        <div class="row m-3">
                            <div class="col-lg-1">
                                <select wire:model.live='perPage' class="form-select p-2">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" wire:model.live.debounce.300ms='search' class="form-control border p-2" placeholder="Search...">
                                    </div>
                                </div>
                            </div>
                            @if($search)
                            <div class="col-lg-1 text-end">
                                <button wire:click="clearSearch" class="btn btn-danger" title="Clear search"><i class="bx bx-x"></i></button>
                            </div>
                            @endif
                            <div class="col-lg-4 text-end">
                                <a href="{{ route('create.user') }}" class="btn btn-primary border" title="Create New User"><i class="bx bx-plus"></i> New</a>
                                @if($userOnTrash->count() > 0)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#userInTrash">
                                    <i class="bx bx-trash"></i> Recycle ( {{ $userOnTrash->count() }} )
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
                @endif
                <div class="table-responsive text-nowrap mx-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    @if ($sortField === 'name')
                                    @if ($sortDirection === 'asc')
                                    <i class='bx bx-sort-down'></i>
                                    @else
                                    <i class='bx bx-sort-up text-primary'></i>
                                    @endif
                                    @endif
                                    Name
                                    <button wire:click="sortBy('name')" class="btn btn-sm btn-default border-gray px-1 py-1">Sort</button>
                                </th>
                                <th>Username</th>
                                <th class="text-center">Photo</th>
                                <th>Role</th>
                                <th class="text-center">Last Activity</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count() > 0)
                            @php
                            $no = ($users->currentPage() - 1) * $users->perPage() + 1
                            @endphp
                            @foreach ($users as $user)
                            <tr>
                                <td title="Nama dan Divisi"><i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $user->name }}</strong> ({{ $user->divisi ? $user->divisi->name : '-' }})</td>
                                <td>{{ $user->username }}</td>
                                <td class="text-center">
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="{{ $user->name }}">
                                            <img src="{{ ( $user->foto != null) ? asset('storage/foto_user/'. $user->foto) : asset('storage/avatar-default/avatar-default.jpg') }}" alt="Avatar" class="rounded-circle">
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                    <span class="badge rounded-pill bg-gray text-capitalize">{{ $v }}</span>
                                    @endforeach
                                    @endif
                                </td>
                                <td class="text-center"><span class="badge bg-label-primary me-1 text-capitalize">{{ $this->getFormattedTimestamp($user->last_activity) }}</span></td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="{{ route('edit.user', $user->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>

                                            <button class="dropdown-item text-danger" wire:click="showDialogDelete('{{ $user->id }}')"><i class="bx bx-trash me-1"></i> Delete</button>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-default text-center">No Data Found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-2 p-0">
                        <ul class="pagination">
                            {{ $users->withQueryString()->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-top fade" id="userInTrash" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">Users On Recycle Bin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Photo</th>
                                    <th>Role</th>
                                    <th>Delete at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($userOnTrash->count() > 0)
                                @foreach ($userOnTrash as $user)
                                <tr>
                                    <td title="Nama dan Divisi"><i class="fab fa-angular fa-lg text-danger"></i> <strong>{{ $user->name }} ({{ $user->divisi ? $user->divisi->name : '-' }})</strong></td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="{{ $user->name }}">
                                                <img src="{{ ( $user->foto != null) ? asset('storage/foto_user/'. $user->foto) : asset('storage/avatar-default/avatar-default.jpg') }}" alt="Avatar" class="rounded-circle">
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                        <span class="badge rounded-pill bg-gray text-capitalize">{{ $v }}</span>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td><span class="badge bg-label-primary me-1 text-capitalize">{{ $this->getFormattedTimestamp($user->deleted_at) }}</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <button class="dropdown-item" wire:click="restoreUser('{{ $user->id }}')"><i class="bx bx-sync me-1"></i> Restore</button>
                                                <button class="dropdown-item text-danger" wire:click="deletePermanent('{{ $user->id }}')"><i class="bx bx-trash me-1"></i> Permanent Delete</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-default text-center">No Data Found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
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
            window.location.reload();
        }, 1200);
    });

    window.addEventListener('swal:error', event => {
        Swal.fire({
            icon: event.detail[0].type,
            title: event.detail[0].title,
            html: event.detail[0].message,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    });
    window.addEventListener('showDialogDelete', (event) => {
        Swal.fire({
            icon: event.detail[0].type,
            title: event.detail[0].title,
            html: event.detail[0].message,
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#33cc33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                // jalan function clientConfirmAcrion di backend
                Livewire.dispatch('confirmDeleteUser', {
                    userId: event.detail[0].userId
                });
            } else {
                Swal.fire("Delete Data User Dibatalkan", "", "info");
            }
        });
    });
</script>