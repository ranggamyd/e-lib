<?php

namespace App\Http\Controllers\frontend;

use App\Models\Loan;
use App\Models\Waqf;
use App\Models\Member;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WaqfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->guard('members')->user()->id;

        return view('transactions.waqfs', [
            'title' => 'Pewakafan Buku',
            'member' => Member::where('id', $id)->first(),
            'waqfs' => Waqf::latest()->where('member_id', $id)->get(),
            'loans' => Loan::latest()->where('member_id', $id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transactions.waqfs-create', [
            'title' => 'Wakafkan Buku',
            'members' => Member::orderBy('name')->get()
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
            'member_id' => 'required',
            'waqf_date' => 'required',
            'title' => 'required|max:255',
            'soft_file' => 'required|mimes:pdf|max:10000',
            'abstract' => 'required',
            'page_count' => 'required|integer',
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $input = $request->all();

        // Upload Cover payment_slip
        if ($img = $request->file('payment_slip')) {
            $destinationPath = public_path() . '/dist/img/waqfs/';
            $fileName = date('YmdHis') . "." . $img->getClientOriginalExtension();

            $img->move($destinationPath, $fileName);
            $input['payment_slip'] = "$fileName";
        }

        // Upload File
        if ($file = $request->file('soft_file')) {
            $destinationPath = public_path() . '/dist/pdf/';
            $fileName = date('YmdHis') . "." . $file->getClientOriginalExtension();

            $file->move($destinationPath, $fileName);
            $input['soft_file'] = "$fileName";
        }

        // Insert Waqf to Table
        Waqf::create($input);

        // Redirect w/ flash
        return redirect('/transactions/waqfs')->with('success', 'Wakaf berhasil diajukan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Waqf  $waqf
     * @return \Illuminate\Http\Response
     */
    public function show(Waqf $waqf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waqf  $waqf
     * @return \Illuminate\Http\Response
     */
    public function edit(Waqf $waqf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Waqf  $waqf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waqf $waqf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waqf  $waqf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waqf $waqf)
    {
        // Waqf::destroy($waqf->id);
        // return redirect('/transactions/waqfs')->with('success', 'Wakaf berhasil dihapus!');
    }
}
