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
                                <a href="{{ route('create.customer') }}" class="btn btn-primary border" title="Create New"><i class="bx bx-plus"></i> New</a>
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
                    <table class="table table-borderless table-striped">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start">
                                    Name
                                    <button wire:click="sortBy('name')" class="btn btn-sm btn-default border-gray px-1 py-1">Sort</button>
                                    @if ($sortField === 'name')
                                    @if ($sortDirection === 'asc')
                                    <i class='bx bx-sort-down'></i>
                                    @else
                                    <i class='bx bx-sort-up text-primary'></i>
                                    @endif
                                    @endif
                                </th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($customers->count() > 0)
                            @php
                            $no = ($customers->currentPage() - 1) * $customers->perPage() + 1
                            @endphp
                            @foreach ($customers as $customer)
                            <tr>
                                <td class="text-start">
                                    <a href="{{ route('edit.customer', $customer->id) }}" class="dropdown-item">
                                        {{ $customer->name }}
                                    </a>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item text-danger" wire:click="showDialogDelete('{{ $customer->id }}')"><i class="bx bx-trash me-1"></i> Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                               <tr>
                                <td colspan="3" class="text-default text-center">No Data Found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-2 p-0">
                        <ul class="pagination">
                            {{ $customers->withQueryString()->links() }}
                        </ul>
                    </div>
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
            window.location.reload();
        }, 1000);
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
                // jalan function customerConfirmAction di backend
                Livewire.dispatch('confirmDelete', {
                    id: event.detail[0].id 
                });
            } else {
                Swal.fire("Delete Data Dibatalkan", "", "info");
            }
        });
    });
</script>