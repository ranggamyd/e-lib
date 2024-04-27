<?php

namespace App\Http\Controllers\admin;

use App\Models\Loan;
use App\Models\Member;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReturnController extends Controller
{
    public function index()
    {
        return view('admin.returns.index', [
            'title' => 'Semua Pengembalian',
            'returns' => ReturnModel::where('status', 'Dikembalikan')->latest()->get()
        ]);
    }

    public function show(ReturnModel $return)
    {
        return view('admin.returns.show', [
            'title' => 'Pengembalian ' . strtok($return->member->name, ' '),
            'member' => Member::where('id', $return->member->id)->first(),
            'loans' => Loan::latest()->where('member_id', $return->member->id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $return->member_id)->get(),
        ]);
    }
}
