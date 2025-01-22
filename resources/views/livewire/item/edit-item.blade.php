<div>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Item</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="update" class="row g-3 needs-validation" novalidate>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="item_name">Item Name</label>
                            <div class="input-group input-group-merge">
                                <span id="item_name" class="input-group-text"></span>
                                <input type="text" class="form-control @error('item_name') is-invalid @enderror"
                                    wire:model.live.debounce.150ms="item_name" placeholder="Item Name" autofocus>
                            </div>
                            @error('item_name')
                                <span class="text text-danger text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="col-lg-6 mb-3">
                            <label for="unit_id" class="form-label">Unit</label>
                            <select wire:model.live="unit_id" class="form-select">
                                <option value="">Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Save Item</button>
                        <!-- SHOW LOADING -->
                        <div wire:loading>
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
        // Reload after 1.2 seconds
        setTimeout(() => {
            window.location.href = event.detail[0].route;
        }, 1200);
    });
</script>