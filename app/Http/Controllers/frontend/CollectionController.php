<?php

namespace App\Http\Controllers\frontend;

use App\Models\Book;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CollectionController extends Controller
{
    public function index()
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('collections.index', [
            'title' => 'Semua Koleksi',
            'collections' => Collection::paginate(5),
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

        return view('collections.show', [
            'title' => 'Detail Koleksi',
            'collection' => Collection::where('id', $id)->first(),
            'books' => Book::where('collection_id', $id)->orderBy('title')->paginate(5),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }
}
