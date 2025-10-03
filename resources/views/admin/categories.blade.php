@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-layer-group me-2"></i>Class Categories Management</h4>
                </div>
                <div class="card-body">
                    <!-- Add Category Form -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Add New Category</h5>
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Category Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="type" class="form-label">Type</label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="early_years">Early Years</option>
                                                <option value="primary">Primary</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Add Category</button>
                            </form>
                        </div>
                    </div>

                    <!-- Categories List -->
                    <h5>Existing Categories</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Sort Order</th>
                                    <th>Students Count</th>
                                    <th>Books Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $category->type == 'early_years' ? 'info' : 'success' }}">
                                            {{ ucfirst($category->type) }}
                                        </span>
                                    </td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>{{ $category->students->count() }}</td>
                                    <td>{{ $category->books->count() }}</td>
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