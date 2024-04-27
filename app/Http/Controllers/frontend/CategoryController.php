<?php

namespace App\Http\Controllers\frontend;

use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('categories.index', [
            'title' => 'Semua Kategori',
            'categories' => Category::orderBy('name')->paginate(5),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }

    public function show($id)
    {
        $booksInCategories = Book::whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                ->from('book_categories')
                ->where('category_id', $id)
                ->whereColumn('book_categories.book_id', 'books.id');
        })->paginate(5);

        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('categories.show', [
            'title' => 'Detail Kategori',
            'category' => Category::where('id', $id)->first(),
            'booksInCategories' => $booksInCategories,
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }
}
