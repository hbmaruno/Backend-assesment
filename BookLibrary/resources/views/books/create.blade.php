<form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="book_name">Book Name</label>
        <input type="text" name="book_name" id="book_name" value="{{ old('book_name') }}" required>
        @error('book_name')
        <div>{{ $message }}</div>
        @enderror

        <label for="author">Author</label>
        <input type="text" name="author" id="author" value="{{ old('author') }}" required>
        @error('author')
        <div>{{ $message }}</div>
        @enderror

        <label for="book_cover">Book Cover</label>
        <input type="file" name="book_cover" id="book_cover" value="{{ old('book_cover') }}" required>
        @error('book_cover')
        <div>{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Add Book</button>
</form>