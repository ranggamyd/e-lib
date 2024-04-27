<?php

namespace App\Http\Controllers\frontend;

use App\Models\Loan;
use App\Models\Member;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoanController extends Controller
{
    public function index()
    {
        $id = auth()->guard('members')->user()->id;
        $member = Member::where('id', $id)->first();

        return view('transactions.loans', [
            'title' => 'Daftar Pinjaman ' . strtok($member->name, ' '),
            'member' => $member,
            'loans' => Loan::latest()->where('member_id', $id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $id)->get(),
        ]);
    }

    public function return()
    {
        $id = auth()->guard('members')->user()->id;

        return view('transactions.returns', [
            'title' => 'Buku yang sudah dikembalikan',
            'member' => Member::where('id', $id)->first(),
            'loans' => Loan::latest()->where('member_id', $id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $id)->get(),
        ]);
    }
}
