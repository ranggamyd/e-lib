<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.categories.index', [
            'title' => 'Kategori Buku',
            'categories' => Category::orderBy('name')->paginate(6),
            'colors' => $colors
        ]);
    }

    public function create(Category $category)
    {
        return redirect('/admin/categories')->with('create', 'Add new category');
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

        Category::create($input);

        return redirect('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $id = $category->id;
        $booksInCategories = Book::whereExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                ->from('book_categories')
                ->where('category_id', $id)
                ->whereColumn('book_categories.book_id', 'books.id');
        })->paginate(5);

        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.categories.show', [
            'title' => 'Detail Kategori',
            'category' => $category,
            'booksInCategories' => $booksInCategories,
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->validate([
            'name' => 'required|max:255',
        ]);

        Category::where('id', $category->id)->update($input);

        return redirect('/admin/categories/' . $category->id)->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);

        return redirect('/admin/categories')->with('success', 'Kategori berhasil dihapus!');
    }
}
