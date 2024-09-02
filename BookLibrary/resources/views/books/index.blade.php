@extends('layout')

@section('content')
<h1>Books</h1>


<form method="GET" action="{{ route('books.index') }}">
    <input type="text" name="search" value="{{ request('search') }}">

    <select name="sort_by">
        <option value="book_name" {{request('sort_by') == 'book_name' ? 'selected' : '' }}>Book Name</option>
        <option value="author" {{request('sort_by') == 'author' ? 'selected' : '' }}>Author</option>
    </select>

    <select name="order">
        <option value="asc" {{ request('order') == 'asc' ? 'selected' : ''}}>Ascending</option>
        <option value="desc" {{ request('order') == 'desc' ? 'selected' : ''}}>Descending</option>
    </select>

    <button type="submit">Search & Sort</button>
</form>

<table>
    <thead>
        <th>Book Name</th>
        <th>Author</th>
        <th>Cover</th>
        <th>Actions</th>
    </thead>

    <tbody>
        @foreach($books as $book)
        <tr data-id="{{ $book->id }}" class="book-row">
            <td>{{ $book->book_name }}</td>
            <td>{{ $book->author }}</td>
            <td>
                @if($book->book_cover)
                <img src="{{ Storage::url($book->book_cover) }}" width="100" />
                @endif
            </td>

            <td>
                <a href="{{ route('books.show', $book) }}">View</a>
                <!-- <a href="{{ route('books.edit', $book) }}">Edit</a> -->
                <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div id="book_modal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Book Details</h2>
        <div id="modal_body">

        </div>
    </div>
</div>

@include('books/create')
@include('books/import')

@endsection

@section('js')
<script src="{{ asset('js/books.js') }}"></script>
@endsection