<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.authors.index', [
            'title' => 'Penulis Buku',
            'authors' => Author::orderBy('name')->paginate(6),
            'colors' => $colors
        ]);
    }

    public function create(Author $author)
    {
        return redirect('/admin/authors')->with('create', 'Add new author');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'name' => 'required|max:255',
        ]);

        Author::create($input);

        return redirect('/admin/authors')->with('success', 'Penulis baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $id = $author->id;
        $booksInAuthors = Book::whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                ->from('book_authors')
                ->where('author_id', $id)
                ->whereColumn('book_authors.book_id', 'books.id');
        })->paginate(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.authors.show', [
            'title' => 'Detail Penulis',
            'author' => $author,
            'booksInAuthors' => $booksInAuthors,
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $input = $request->validate([
            'name' => 'required|max:255',
        ]);

        Author::where('id', $author->id)->update($input);

        return redirect('/admin/authors/' . $author->id)->with('success', 'Penulis berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        Author::destroy($author->id);

        return redirect('/admin/authors')->with('success', 'Penulis berhasil dihapus!');
    }
}
