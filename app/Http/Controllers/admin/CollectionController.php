<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.collections.index', [
            'title' => 'Koleksi Buku',
            'collections' => Collection::orderBy('name')->paginate(6),
            'colors' => $colors
        ]);
    }

    public function create(Collection $collection)
    {
        return redirect('/admin/collections')->with('create', 'Add new collection');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $input = $request->all();

        if ($img = $request->file('image')) {
            $destinationPath = public_path() . '/dist/img/collections/';
            $fileName = date('YmdHis') . "." . $img->getClientOriginalExtension();

            $img->move($destinationPath, $fileName);
            $input['image'] = "$fileName";
        }

        Collection::create($input);

        return redirect('/admin/collections')->with('success', 'Koleksi baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.collections.show', [
            'title' => 'Detail Koleksi',
            'collection' => $collection,
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        $rules = $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $input = $rules;

        if ($img = $request->file('image')) {
            if ($collection->image) {
                $file_path = public_path() . "/dist/img/collections/" . $collection->image;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $destinationPath = public_path() . '/dist/img/collections/';
            $fileName = date('YmdHis') . "." . $img->getClientOriginalExtension();

            $img->move($destinationPath, $fileName);
            $input['image'] = "$fileName";
        } else {
            unset($input['image']);
        }

        Collection::where('id', $collection->id)->update($input);

        return redirect('/admin/collections/' . $collection->id)->with('success', 'Koleksi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        if ($collection->image) {
            $file_path = public_path() . "/dist/img/collections/" . $collection->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        Collection::destroy($collection->id);

        return redirect('/admin/collections')->with('success', 'Koleksi berhasil dihapus!');
    }
}
