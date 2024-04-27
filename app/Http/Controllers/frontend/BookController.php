<?php

namespace App\Http\Controllers\frontend;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index()
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('books.index', [
            'title' => 'Semua Buku',
            'books' => Book::latest()->paginate(5),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }

    public function show($id)
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('books.show', [
            'title' => 'Detail Buku',
            'book' => Book::where('id', $id)->first(),
            'booksInLoans' => Loan::where('book_id', $id)->get(),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }
}
