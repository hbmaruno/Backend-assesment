<form method="POST" action="{{ route('books.import') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="csv_file">Import CSV</label>
        <input type="file" name="csv_file" required>
        @error('csv_file')
        <div>{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Import Books</button>
</form>