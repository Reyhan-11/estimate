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
                            <div class="col-lg-5">
                                <input type="text" wire:model.live.debounce.300ms='search'
                                    class="form-control border p-2" placeholder="Search estimates...">
                            </div>
                            @if ($search)
                                <div class="col-lg-1">
                                    <button wire:click="clearSearch" class="btn btn-danger" title="Clear search"><i
                                            class="bx bx-x"></i></button>
                                </div>
                            @endif
                            <div class="col-lg-3 text-end">
                                <a href="{{ route('create.estimate') }}" class="btn btn-primary border"
                                    title="Create New Estimate"><i class="bx bx-plus"></i> New</a>
                                @if ($estimatesOnTrash->count() > 0)
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#estimateInTrash">
                                        <i class="bx bx-trash"></i> Recycle ( {{ $estimatesOnTrash->count() }} )
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive text-wrap text-break mx-5">
                    <table class="table table-bordered" style="width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start px-4" style="width:20%">Estimate Number</th>
                                <th class="text-start" style="width:20%">Customer Name</th>
                                <th class="text-start" style="width:20%">Sales Name</th>
                                <th class="text-start" style="width:15%">Estimate Date</th>
                                <th class="text-start" style="width:15%">Expiry Date</th>
                                <th class="text-end" style="width:10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($estimates->count() > 0)
                                @php
                                    $no = ($estimates->currentPage() - 1) * $estimates->perPage() + 1;
                                @endphp
                                @foreach ($estimates as $estimate)
                                    <tr>
                                        <td class="text-start px-1">{{ $estimate->estimate_number }}</td>
                                        <td class="text-start">{{ $estimate->customers ? $estimate->customers->name : '-' }}</td>
                                        <td class="text-start">{{ $estimate->saleses ? $estimate->saleses->name : '-' }}</td>
                                        <td class="text-start">
                                            {{ $estimate->estimate_date ? \Carbon\Carbon::parse($estimate->estimate_date)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="text-start">
                                            {{ $estimate->expiry_date ? \Carbon\Carbon::parse($estimate->expiry_date)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ route('print.estimate', $estimate->id) }}"
                                                    class="btn btn-sm btn-info me-1" title="Print PDF">
                                                    <i class="bx bx-printer"></i>
                                                </a>
                                                <a href="{{ route('detail.estimate', $estimate->id) }}"
                                                    class="btn btn-sm btn-primary me-1" title="Detail">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                                <a href="{{ route('edit.estimate', $estimate->id) }}"
                                                    class="btn btn-sm btn-warning me-1" title="Edit">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger"
                                                    wire:click="confirmDelete('{{ $estimate->id }}')" title="Delete">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        {{-- <td class="text-end">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('edit.estimate', $estimate->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <button class="dropdown-item text-danger"
                                                        wire:click="confirmDelete('{{ $estimate->id }}')">
                                                        <i class="bx bx-trash me-1"></i> Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </td> --}}
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
                            {{ $estimates->withQueryString()->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-top fade" id="estimateInTrash" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTopTitle">Estimate On Recycle Bin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Estimate Number</th>
                                    <th>Item Name</th>
                                    <th class="text-center">Delete at</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($estimatesOnTrash->count() > 0)
                                    @foreach ($estimatesOnTrash as $estimate)
                                        <tr>
                                            <td>{{ $estimate->estimate_number }}</td>
                                            <td>{{ $estimate->item_name }}</td>
                                            <td class="text-center"><span
                                                    class="badge bg-label-primary me-1 text-capitalize">{{ $this->getFormattedTimestamp($estimate->deleted_at) }}</span>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <button class="dropdown-item"
                                                            wire:click="restoreData('{{ $estimate->id }}')"><i
                                                                class="bx bx-sync me-1"></i> Restore</button>
                                                        <button class="dropdown-item text-danger"
                                                            wire:click="deletePermanent('{{ $estimate->id }}')"><i
                                                                class="bx bx-trash me-1"></i> Permanent Delete</button>
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
                // jalan function customerConfirmAcrion di backend
                Livewire.dispatch('confirmDelete', {
                    id: event.detail[0].id
                });
            } else {
                Swal.fire("Delete Data Dibatalkan", "", "info");
            }
        });
    });
</script>
