@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📚 Books Management</h4>
            <a href="{{ route('books.create') }}" class="btn btn-primary">➕ Add New Book</a>
        </div>

        <div class="card-body">
            {{-- Success Message --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Year</th>
                            <th>ISBN</th>
                            <th>Stock</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td class="text-center">{{ $book->published_year }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td class="text-center">{{ $book->stock }}</td>
                            <td class="text-center">
                                <a href="{{ route('books.show', $book) }}" class="btn btn-info btn-sm me-1">View</a>
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No books available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection