<?php

namespace App\Http\Controllers\frontend;

use App\Models\Book;
use App\Models\Author;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('authors.index', [
            'title' => 'Semua Kategori',
            'authors' => Author::orderBy('name')->paginate(5),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }

    public function show($id)
    {
        $booksInAuthors = Book::whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                ->from('book_authors')
                ->where('author_id', $id)
                ->whereColumn('book_authors.book_id', 'books.id');
        })->paginate(5);

        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('authors.show', [
            'title' => 'Detail Kategori',
            'author' => Author::where('id', $id)->first(),
            'booksInAuthors' => $booksInAuthors,
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }
}
