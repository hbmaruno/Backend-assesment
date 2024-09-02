<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['book_name', 'author', 'book_cover'];

    public static function rules()
    {
        return [
            'book_name' => 'required|unique:books,book_name',
            'author' => 'required',
            'book_cover' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
