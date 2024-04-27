<?php

namespace App\Http\Controllers\admin;

use App\Models\Loan;
use App\Models\ReturnModel;
use App\Models\Waqf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'title' => 'Semua Laporan',
            'reports' => Loan::latest()->get()
        ]);
    }

    public function loans()
    {
        return view('admin.reports.loan_reports', [
            'title' => 'Laporan Peminjaman',
            'loans' => Loan::latest()->get()
        ]);
    }

    public function returns()
    {
        return view('admin.reports.return_reports', [
            'title' => 'Laporan Pengembalian',
            'returns' => ReturnModel::latest()->get()
        ]);
    }
    
    public function waqfs()
    {
        return view('admin.reports.waqf_reports', [
            'title' => 'Laporan Pewakafan',
            'waqfs' => Waqf::latest()->get()
        ]);
    }
}
