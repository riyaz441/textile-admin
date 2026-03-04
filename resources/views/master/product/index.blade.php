@extends('layouts.master')
@section('title', 'Products - ' . env('APP_NAME'))
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('components.alert')
        <!-- Bootstrap Table with Header - Light -->
        <div class="card">
            <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="card-header mb-0">Products</h5>
                <div class="ms-auto">
                    <button class="btn btn-primary" onclick="location.href='{{ route('products.form') }}'">
                        + Add Product
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap p-3">
                <table id="products-table" class="table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="50"
                                            height="50" style="object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="badge bg-label-secondary">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td><span class="badge bg-label-primary">{{ $product->sku }}</span></td>
                                <td>₹{{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span
                                        class="badge {{ $product->stock_quantity > $product->min_stock_level ? 'bg-label-success' : 'bg-label-warning' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td>
                                    @if ($product->rating > 0)
                                        <span class="badge bg-label-info">⭐ {{ $product->rating }}/5</span>
                                    @else
                                        <span class="badge bg-label-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input change_product_status" type="checkbox"
                                            id="flexSwitchCheckChecked" data-id="{{ $product->id }}"
                                            {{ $product->status == 'Active' ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu product-action-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('products.form', $product->id) }}'">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);"
                                                onclick="location.href='{{ route('products.show', $product->id) }}'">
                                                <i class="bx bx-show me-1"></i> View
                                            </a>
                                            <a class="dropdown-item delete-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $product->id }}"
                                                data-name="products/delete">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Handle product status change
        document.querySelectorAll('.change_product_status').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const productId = this.getAttribute('data-id');
                const status = this.checked ? 'true' : 'false';

                fetch('{{ url('change_product_status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            id: productId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                            alertDiv.innerHTML = data.message +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
                            document.querySelector('.container-xxl').insertBefore(alertDiv, document
                                .querySelector('.card'));
                            setTimeout(() => alertDiv.remove(), 3000);
                        }
                    });
            });
        });

        // Handle delete modal
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const productId = button.getAttribute('data-id');
            const actionName = button.getAttribute('data-name');
            const form = document.getElementById('deleteForm');
            form.action = '{{ url('/') }}/' + actionName + '/' + productId;
        });
    </script>
@endpush
