<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Waqf;
use App\Models\Member;
use App\Models\BookAuthor;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class WaqfController extends Controller
{
    public function index()
    {
        return view('admin.waqfs.index', [
            'title' => 'Semua Pewakafan',
            'waqfs' => Waqf::latest()->get()
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Waqf $waqf)
    {
        return view('admin.waqfs.show', [
            'title' => 'Pewakafan ' . strtok($waqf->member->name, ' '),
            'member' => Member::where('id', $waqf->member->id)->first(),
            'waqfs' => Waqf::latest()->where('member_id', $waqf->member->id)->get(),
            'loans' => Loan::latest()->where('member_id', $waqf->member->id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $waqf->member_id)->get(),
        ]);
    }

    public function edit(Waqf $waqf)
    {
        return view('admin.waqfs.edit', [
            'title' => 'Perbarui Pewakafan',
            'members' => Member::orderBy('name')->get(),
            'waqf' => $waqf
        ]);
    }

    public function update(Request $request, Waqf $waqf)
    {
        // Validate Book Attrs
        $request->validate([
            'member_id' => 'required',
            'waqf_date' => 'required',
            'title' => 'required|max:255',
            'soft_file' => 'mimes:pdf|max:10000',
            'abstract' => 'required',
            'page_count' => 'required|integer',
            'payment_slip' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $input = request()->except(['_method', '_token']);
        $input['librarian_id'] = auth()->user()->id;

        // Upload Cover payment_slip
        if ($img = $request->file('payment_slip')) {
            $destinationPath = public_path() . '/dist/img/waqfs/';
            $fileName = date('YmdHis') . "." . $img->getClientOriginalExtension();

            $img->move($destinationPath, $fileName);
            $input['payment_slip'] = "$fileName";
        } else {
            $input['payment_slip'] = "$waqf->payment_slip";
        }

        // Upload File
        if ($file = $request->file('soft_file')) {
            $destinationPath = public_path() . '/dist/pdf/';
            $fileName = date('YmdHis') . "." . $file->getClientOriginalExtension();

            $file->move($destinationPath, $fileName);
            $input['soft_file'] = "$fileName";
        } else {
            $input['soft_file'] = "$waqf->payment_slip";
        }

        // Insert Waqf to Table
        Waqf::where('id', $waqf->id)->update($input);

        // Redirect w/ flash
        return redirect('/admin/transactions/waqfs')->with('success', 'Wakaf berhasil diperbarui!');
    }

    public function destroy(Waqf $waqf)
    {
        Waqf::destroy($waqf->id);
        return redirect('/admin/transactions/waqfs')->with('success', 'Pewakafan berhasil dihapus!');
    }

    protected function addToBook($id)
    {
        $waqf = Waqf::where('id', $id)->first();

        $data = [
            'title' => $waqf->title,
            'collection_id' => 1,
            'waqf_id' => $waqf->id,
            'summary' => $waqf->abstract,
            'book_pdf' => $waqf->soft_file,
            'page_count' => $waqf->page_count,
            'stock' => 1,
        ];

        Book::create($data);
    }

    public function accept($id)
    {
        Waqf::where('id', $id)->update([
            'status' => 'Dikonfirmasi',
            'librarian_id' => auth()->user()->id
        ]);

        $this->addToBook($id);

        return redirect('/admin/transactions/waqfs')->with('success', 'Pewakafan berhasil dikonfirmasi!');
    }

    public function reject($id)
    {
        Waqf::where('id', $id)->update([
            'status' => 'Ditolak',
            'librarian_id' => auth()->user()->id
        ]);

        return redirect('/admin/transactions/waqfs')->with('success', 'Pewakafan berhasil ditolak!');
    }
}
