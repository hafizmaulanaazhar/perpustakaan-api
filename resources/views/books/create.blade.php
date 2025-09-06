@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Book</h4>
        </div>
        <div class="card-body">
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary mb-3">
                ← Back to List
            </a>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter book title" required>
                </div>

                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="author" name="author" placeholder="Enter author name" required>
                </div>

                <div class="mb-3">
                    <label for="published_year" class="form-label">Published Year</label>
                    <input type="number" class="form-control" id="published_year" name="published_year" min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g. 2023" required>
                </div>

                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN number" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="Enter available stock" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-outline-secondary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary">Save Book</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection