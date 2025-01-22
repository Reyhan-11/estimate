<div>
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Estimate</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save" class="row g-3 needs-validation" novalidate>
                        <!-- Select Sales -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="sales_id">Sales</label>
                            <select wire:model="sales_id" class="form-select @error('sales_id') is-invalid @enderror">
                                <option value="">Select Sales</option>
                                @foreach ($saleses as $sales)
                                    <option value="{{ $sales->id }}">{{ $sales->name }}</option>
                                @endforeach
                            </select>
                            @error('sales_id')
                                <span class="text-danger text-xxs">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Select Customer -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="customer_id">Customer</label>
                            <select wire:model="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <span class="text-danger text-xxs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Estimate Date -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="estimate_date">Estimate Date</label>
                            <input type="date" id="estimate_date" wire:model="estimate_date" 
                                   class="form-control @error('estimate_date') is-invalid @enderror">
                            @error('estimate_date')
                                <span class="text-danger text-xxs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="expiry_date">Expiry Date</label>
                            <input type="date" id="expiry_date" wire:model="expiry_date" 
                                   class="form-control @error('expiry_date') is-invalid @enderror">
                            @error('expiry_date')
                                <span class="text-danger text-xxs">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Select Items -->
                        <div class="col-12 mb-3">
                            <label class="form-label" for="item_id">Items</label>
                            <div>
                                @foreach ($item_ids as $index => $item_id)
                                    <div class="row mb-2 g-2 align-items-center">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <select wire:model="item_ids.{{ $index }}" class="form-select @error('item_ids.' . $index) is-invalid @enderror">
                                                <option value="">Select Item</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_ids.' . $index)
                                                <span class="text-danger text-xxs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <input type="number" id="quantity-{{ $index }}" wire:model.defer="quantity.{{ $index }}" 
                                                class="form-control @error('quantity.' . $index) is-invalid @enderror" 
                                                placeholder="Enter quantity">
                                            @error('quantity.' . $index)
                                                <span class="text-danger text-xxs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <input type="number" id="rate-{{ $index }}" wire:model.defer="rate.{{ $index }}" 
                                                class="form-control @error('rate.' . $index) is-invalid @enderror" 
                                                placeholder="Enter rate">
                                            @error('rate.' . $index)
                                                <span class="text-danger text-xxs">{{ $message }}</span>
                                            @enderror
                                        </div>                                        

                                        <div class="col-lg-6 col-md-12 col-sm-12" wire:ignore>
                                            <textarea id="description-{{ $index }}" 
                                                      class="form-control description-editor" 
                                                      data-index="{{ $index }}" 
                                                      wire:model.defer="description.{{ $index }}"></textarea>
                                            @error('description.' . $index)
                                                <span class="text-danger text-xxs">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-2 col-md-12 text-md-end">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click.prevent="removeItem({{ $index }})">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary mt-2" wire:click.prevent="addItem">Add Item</button>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary">Save Estimate</button>
                        </div>

                        <!-- Show Loading -->
                        <div wire:loading class="text-center">
                            <div class="spinner-border text-primary" role="status"></div>
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

<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    // Fungsi untuk inisialisasi CKEditor pada elemen `textarea`
    function initializeCKEditor() {
        document.querySelectorAll('.description-editor').forEach((editorElement) => {
            if (!editorElement.classList.contains('ckeditor-initialized')) {
                ClassicEditor
                    .create(editorElement, {
                        ckfinder: {
                            uploadUrl: "{{ route('ckeditor.upload.create.estimate') }}?_token={{ csrf_token() }}",
                        }
                    })
                    .then(editor => {
                        const index = editorElement.getAttribute('data-index'); // Ambil indeks dari elemen
                        editorElement.classList.add('ckeditor-initialized'); // Tandai elemen telah diinisialisasi
                        editor.model.document.on('change:data', () => {
                            @this.set('description.' + index, editor.getData());
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });
    }

    // Inisialisasi saat pertama kali Livewire dimuat
    document.addEventListener('livewire:load', () => {
        initializeCKEditor();
    });

    // Inisialisasi ulang setelah pembaruan dari Livewire
    document.addEventListener('livewire:update', () => {
        initializeCKEditor();
    });

    // Inisialisasi untuk elemen baru
    window.addEventListener('initializeNewEditor', event => {
        const editorElement = document.querySelector('#description-' + event.detail.index);
        if (editorElement) {
            ClassicEditor
                .create(editorElement, {
                    ckfinder: {
                        uploadUrl: "{{ route('ckeditor.upload.create.estimate') }}?_token={{ csrf_token() }}",
                    }
                })
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('description.' + event.detail.index, editor.getData());
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>
