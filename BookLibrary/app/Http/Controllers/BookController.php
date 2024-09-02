<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Imports\BooksImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $book_query = Book::query();
        // dd($book_query);

        if ($request->has('search')) {
            $search = $request->input('search');
            $book_query->where('book_name', 'like', '%{search}%')->orWhere('author', 'like', '%{search}%');
        }

        if ($request->has('sort_by') && $request->has('order')) {
            $sort_by = $request->input('sort_by');
            $order = $request->input('order');
            $book_query->orderBy($sort_by, $order);
        } else {
            $book_query->orderBy('book_name', 'asc');
        }

        $books = $book_query->paginate(10);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_name' => ['required', 'string', 'max:255', 'unique:books,book_name'],
            'author' => ['required', 'string', 'max:255'],
            'book_cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $cover = null;
        if ($request->hasFile('book_cover')) {
            $cover = $request->file('book_cover')->store('book_covers');
        }

        Book::create([
            'book_name' => $request->book_name,
            'author' => $request->author,
            'book_cover' => $cover
        ]);

        return redirect()->route('books.index')->with('success', 'Book added succesfully');
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'book_name' => ['required', 'string', 'max:255', 'unique:books,book_name'],
            'author' => ['required', 'string', 'max:255'],
            'book_cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $cover = $book->book_cover;
        if ($request->hasFile('book_cover')) {
            if ($cover) {
                Storage::delete($cover);
            }
            $cover = $request->file('book_cover')->store('book_covers');
        }

        $book->update([
            'book_name' => $request->book_name,
            'author' => $request->author,
            'book_cover' => $cover
        ]);

        return redirect()->route('books.index')->with('success', 'Book updated succesfully');
    }

    public function destroy(Book $book)
    {
        if ($book->book_cover) {
            Storage::delete($book->book_cover);
        }

        $book->delete();
        return redirect()->route('books.index')->with('Success', 'Book deleted successfully.');
    }

    public function importForm()
    {
        return view('books.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        Excel::import(new BooksImport, $request->file('csv_file'));

        return redirect()->route('books.index')->with('sucess', 'Books imported successfuly');
    }
}
