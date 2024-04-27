<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keywords = $request->keywords;

        return view('admin.search.index', [
            'title' => 'Explore E-library',
            'books' => Book::where(
                ['title', 'like', '%' . $keywords . '%'],
                ['summary', 'like', '%' . $keywords . '%'],
                ['shelf', 'like', '%' . $keywords . '%']
            )->get()
        ]);

        // can jalan search na :((
    }
}
