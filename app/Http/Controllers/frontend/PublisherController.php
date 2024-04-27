<?php

namespace App\Http\Controllers\frontend;

use App\Models\Book;
use App\Models\Publisher;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PublisherController extends Controller
{
    public function index()
    {
        $popTags = BookCategory::select('*', DB::raw('COUNT(category_id)'))
            ->groupBy('category_id')
            ->having('COUNT(category_id)', '>', 2)
            ->get()->take(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('publishers.index', [
            'title' => 'Semua Penerbit',
            'publishers' => Publisher::orderBy('name')->paginate(5),
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

        return view('publishers.show', [
            'title' => 'Detail Penerbit',
            'publisher' => Publisher::where('id', $id)->first(),
            'books' => Book::where('publisher_id', $id)->orderBy('title')->paginate(5),
            'newCollections' => Collection::latest()->get()->take(5),
            'popTags' => $popTags,
            'colors' => $colors
        ]);
    }
}
