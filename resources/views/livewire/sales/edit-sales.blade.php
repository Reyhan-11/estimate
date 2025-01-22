<div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Sales</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="update" class="row g-3 needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Sales Name</label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Sales Name" wire:model.lazy="name" autofocus>
                            </div>
                            @error('name')<span class="text text-danger text-xxs">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
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
        }, 1000);
    });
</script>