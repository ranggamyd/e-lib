<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.publishers.index', [
            'title' => 'Penerbit Buku',
            'publishers' => Publisher::orderBy('name')->paginate(6),
            'colors' => $colors
        ]);
    }

    public function create(Publisher $publisher)
    {
        return redirect('/admin/publishers')->with('create', 'Add new publisher');
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
            'name' => 'required|max:255'
        ]);

        Publisher::create($input);

        return redirect('/admin/publishers')->with('success', 'Penerbit baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        $colors = ['danger', 'info', 'warning', 'success'];

        return view('admin.publishers.show', [
            'title' => 'Detail Penerbit',
            'publisher' => $publisher,
            'colors' => $colors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        $input = $request->validate([
            'name' => 'required|max:255'
        ]);

        Publisher::where('id', $publisher->id)->update($input);

        return redirect('/admin/publishers/' . $publisher->id)->with('success', 'Penerbit berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        Publisher::destroy($publisher->id);

        return redirect('/admin/publishers')->with('success', 'Penerbit berhasil dihapus!');
    }
}
