<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class BooksImport
{
    use Importable;

    public function model(array $row)
    {
        return new Book([
            'book_name' => $row[0],
            'author' => $row[1],
            'book_cover' => $row[2]
        ]);
    }

    public function rules(): array
    {
        return [
            '0' => ['required', 'string', 'max:255', 'unique:books,book_name'],
            '1' => ['required', 'string', 'max:255'],
            '2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ];
    }
}
