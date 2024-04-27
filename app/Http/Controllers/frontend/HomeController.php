<?php

namespace App\Http\Controllers\frontend;


use BookCategories;
use App\Models\Book;
use App\Models\Category;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('home', [
            'title' => 'Homepage',
            'books' => Book::latest()->get()->take(5),
            'collections' => Collection::all(),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }
}
