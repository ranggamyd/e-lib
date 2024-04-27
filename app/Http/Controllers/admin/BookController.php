<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\BookAuthor;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.books.index', [
            'title' => 'Semua Buku',
            'books' => Book::latest()->get(),
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.create', [
            'title' => 'Tambah Buku',
            'collections' => Collection::all(),
            'categories' => Category::all(),
            'authors' => Author::all(),
            'publishers' => Publisher::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Book Attrs
        $request->validate([
            'title' => 'required|max:255',
            'collection_id' => 'nullable',
            'book_categories' => 'required',
            'isbn' => 'nullable|integer|digits:13',
            'book_authors' => 'nullable',
            'publisher_id' => 'nullable',
            'publish_year' => 'nullable|digits:4|integer|max:' . date('Y'),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'book_pdf' => 'nullable|mimes:pdf|max:10000',
            'summary' => 'nullable',
            'page_count' => 'nullable|integer',
            'stock' => 'required|integer|min:1',
            'shelf' => 'required|max:255',
            'librarian_id' => 'nullable'
        ]);

        $input = $request->all();
        $input['librarian_id'] = auth()->user()->id;

        // Upload Cover Image
        if ($img = $request->file('image')) {
            $destinationPath = public_path() . '/dist/img/books/';
            $fileName = date('YmdHis') . "." . $img->getClientOriginalExtension();

            $img->move($destinationPath, $fileName);
            $input['image'] = "$fileName";
        }

        // Upload File
        if ($file = $request->file('book_pdf')) {
            $destinationPath = public_path() . '/dist/pdf/';
            $fileName = date('YmdHis') . "." . $file->getClientOriginalExtension();

            $file->move($destinationPath, $fileName);
            $input['book_pdf'] = "$fileName";
        }

        // Insert Book to Table
        $book = Book::create($input);

        // Insert Book Categories
        foreach ($request->input('book_categories') as $category) {
            $bookCategory = [
                'book_id' => $book->id,
                'category_id' => $category
            ];

            BookCategory::create($bookCategory);
        }

        // Insert Book Authors
        if ($request->input('book_authors') != null) {
            foreach ($request->input('book_authors') as $author) {
                $bookAuthor = [
                    'book_id' => $book->id,
                    'author_id' => $author
                ];

                BookAuthor::create($bookAuthor);
            }
        }

        // Redirect w/ flash
        return redirect('/admin/books')->with('success', 'Buku baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('admin.books.show', [
            'title' => 'Detail Buku',
            'book' => Book::where('id', $book->id)->first(),
            'booksInLoans' => Loan::where('book_id', $book->id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        // dd($book);
        return view('admin.books.edit', [
            'title' => 'Edit Buku',
            'collections' => Collection::all(),
            'categories' => Category::all(),
            'authors' => Author::all(),
            'publishers' => Publisher::all(),
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        // Validate Book Attrs
        $request->validate([
            'title' => 'required|max:255',
            'collection_id' => 'nullable',
            'book_categories' => 'required',
            'isbn' => 'nullable|integer|digits:13',
            'book_authors' => 'nullable',
            'publisher_id' => 'nullable',
            'publish_year' => 'nullable|digits:4|integer|max:' . date('Y'),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'book_pdf' => 'nullable|mimes:pdf|max:10000',
            'summary' => 'nullable',
            'page_count' => 'nullable|integer',
            'stock' => 'required|integer|min:1',
            'shelf' => 'required|max:255',
            'librarian_id' => 'nullable'
        ]);

        $input = request()->except(['_method', '_token', 'book_categories', 'book_authors']);
        $input['librarian_id'] = auth()->user()->id;

        // Update Cover Image
        if ($img = $request->file('image')) {
            // Delete Old Image
            if ($book->image) {
                $file_path = public_path() . "/dist/img/books/" . $book->image;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            // Upload New Image
            $destinationPath = public_path() . '/dist/img/books/';
            $fileName = date('YmdHis') . "." . $img->getClientOriginalExtension();

            $img->move($destinationPath, $fileName);
            $input['image'] = "$fileName";
        } else {
            unset($input['image']);
        }

        // Update File
        if ($file = $request->file('book_pdf')) {
            // Delete Old File
            if ($book->book_pdf) {
                $file_path = public_path() . "/dist/pdf/" . $book->book_pdf;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            // Upload New File
            $destinationPath = public_path() . '/dist/pdf/';
            $fileName = date('YmdHis') . "." . $file->getClientOriginalExtension();

            $file->move($destinationPath, $fileName);
            $input['book_pdf'] = "$fileName";
        } else {
            unset($input['book_pdf']);
        }

        // Update Book to Table
        $newBook = Book::where('id', $book->id)->update($input);

        // Update Book Categories
        BookCategory::where('book_id', $book->id)->delete();
        foreach ($request->input('book_categories') as $category) {
            $bookCategory = [
                'book_id' => $book->id,
                'category_id' => $category
            ];

            BookCategory::create($bookCategory);
        }

        // Update Book Authors
        BookAuthor::where('book_id', $book->id)->delete();
        if ($request->input('book_authors') != null) {
            foreach ($request->input('book_authors') as $author) {
                $bookAuthor = [
                    'book_id' => $book->id,
                    'author_id' => $author
                ];

                BookAuthor::create($bookAuthor);
            }
        }

        // Redirect w/ flash
        return redirect('/admin/books')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book->image) {
            $file_path = public_path() . "/dist/img/books/" . $book->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        if ($book->book_pdf) {
            $file_path = public_path() . "/dist/pdf/" . $book->book_pdf;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        Book::destroy($book->id);
        return redirect('/admin/books')->with('success', 'Buku berhasil dihapus!');
    }
}
