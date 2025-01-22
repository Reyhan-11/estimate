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
                            <div class="col-lg-1">
                                <button wire:click="clearSearch" class="btn btn-danger" title="Clear search"><i class="bx bx-x"></i></button>
                            </div>
                            @endif
                            <div class="col-lg-3 text-end">
                                <a href="{{ route('create.item') }}" class="btn btn-primary border" title="Create New Item"><i class="bx bx-plus"></i> New</a>
                                @if($itemsOnTrash->count() > 0)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#itemInTrash">
                                    <i class="bx bx-trash"></i> Recycle ( {{ $itemsOnTrash->count() }} )
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
                <div class="table-responsive text-wrap text-break mx-4">
                    <table class="table table-bordered" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start px-4" style="width:20%">
                                    Name
                                    <button wire:click="sortBy('item_name')" class="btn btn-sm btn-default border-gray px-1 py-1">Sort</button>
                                    @if ($sortField === 'item_name')
                                        @if ($sortDirection === 'asc')
                                            <i class='bx bx-sort-down'></i>
                                        @else
                                            <i class='bx bx-sort-up text-primary'></i>
                                        @endif
                                    @endif
                                </th>
                                <th class="text-center" style="width: 5%">Satuan</th>
                                <th class="text-end" style="width:0%">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($items->count() > 0)
                            @php
                            $no = ($items->currentPage() - 1) * $items->perPage() + 1
                            @endphp
                            @foreach ($items as $item)
                            <tr>
                                <td class="text-start px-1">
                                    <a class="dropdown-item" href="{{ route('edit.item', $item->id) }}">
                                        {{ $item->item_name }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    {{ $item->unit ? $item->unit->name : '' }}
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item text-danger" wire:click="showDialogDelete('{{ $item->id }}')"><i class="bx bx-trash me-1"></i> Delete</button>

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

                    <div class="d-flex justify-content-end mt-2 p-0">
                        <ul class="pagination">
                            {{ $items->withQueryString()->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-top fade" id="itemInTrash" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">Items On Recycle Bin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th class="text-center">Delete at</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($itemsOnTrash->count() > 0)
                                @foreach ($itemsOnTrash as $item)
                                <tr>
                                    <td>{{ $item->item_name }}</td>
                                    <td class="text-center"><span class="badge bg-label-primary me-1 text-capitalize">{{ $this->getFormattedTimestamp($item->deleted_at) }}</span></td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu" style="">
                                                <button class="dropdown-item" wire:click="restoreData('{{ $item->id }}')"><i class="bx bx-sync me-1"></i> Restore</button>
                                                <button class="dropdown-item text-danger" wire:click="deletePermanent('{{ $item->id }}')"><i class="bx bx-trash me-1"></i> Permanent Delete</button>
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
                Livewire.dispatch('confirmDelete', {
                    id: event.detail[0].id
                });
            } else {
                Swal.fire("Delete Data Dibatalkan", "", "info");
            }
        });
    });
</script>