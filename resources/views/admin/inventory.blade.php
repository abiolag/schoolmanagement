@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-boxes me-2"></i>Inventory Management</h4>
                </div>
                <div class="card-body">
                    <!-- Stock Alert -->
                    @php
                        $lowStockBooks = $books->filter(function($book) {
                            return $book->stock_status === 'low_stock';
                        });
                        $outOfStockBooks = $books->filter(function($book) {
                            return $book->stock_status === 'out_of_stock';
                        });
                    @endphp

                    @if($outOfStockBooks->count() > 0)
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Out of Stock Alert</h6>
                        <p>The following books are out of stock: 
                            {{ $outOfStockBooks->pluck('title')->implode(', ') }}
                        </p>
                    </div>
                    @endif

                    @if($lowStockBooks->count() > 0)
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-circle me-2"></i>Low Stock Alert</h6>
                        <p>The following books are running low: 
                            {{ $lowStockBooks->pluck('title')->implode(', ') }}
                        </p>
                    </div>
                    @endif

                    <!-- Inventory Update Form -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Update Inventory</h5>
                            <form action="{{ route('admin.inventory.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ request('book_id') }}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="book_select" class="form-label">Select Book</label>
                                            <select class="form-control" id="book_select" name="book_id" required>
                                                <option value="">Select Book</option>
                                                @foreach($books as $book)
                                                    <option value="{{ $book->id }}" 
                                                        {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                                        {{ $book->title }} ({{ $book->category->name }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Transaction Type</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="in">Stock In</option>
                                                <option value="out">Stock Out</option>
                                                <option value="adjustment">Adjustment</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">&nbsp;</label>
                                            <button type="submit" class="btn btn-primary w-100">Update</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes (Optional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="2" 
                                              placeholder="Reason for stock adjustment..."></textarea>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Current Stock Summary -->
                        <div class="col-md-6">
                            <h5>Stock Summary</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-success text-white text-center mb-3">
                                        <div class="card-body">
                                            <h3>{{ $books->where('stock_status', 'in_stock')->count() }}</h3>
                                            <small>In Stock</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-warning text-dark text-center mb-3">
                                        <div class="card-body">
                                            <h3>{{ $lowStockBooks->count() }}</h3>
                                            <small>Low Stock</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-danger text-white text-center">
                                        <div class="card-body">
                                            <h3>{{ $outOfStockBooks->count() }}</h3>
                                            <small>Out of Stock</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-info text-white text-center">
                                        <div class="card-body">
                                            <h3>{{ $books->count() }}</h3>
                                            <small>Total Books</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Books Inventory Table -->
                    <h5>Books Inventory</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Class</th>
                                    <th>Type</th>
                                    <th>Current Stock</th>
                                    <th>Reorder Level</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr class="{{ $book->stock_status === 'out_of_stock' ? 'table-danger' : ($book->stock_status === 'low_stock' ? 'table-warning' : '') }}">
                                    <td>
                                        <strong>{{ $book->book_code }}</strong><br>
                                        <small>{{ $book->title }}</small>
                                    </td>
                                    <td>{{ $book->category->name }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark text-capitalize">
                                            {{ str_replace('_', ' ', $book->book_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $book->quantity_available }}</strong>
                                    </td>
                                    <td>{{ $book->reorder_level }}</td>
                                    <td>
                                        <span class="badge bg-{{ $book->stock_status_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $book->stock_status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($book->inventoryTransactions->count() > 0)
                                            {{ $book->inventoryTransactions->last()->created_at->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Never</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection