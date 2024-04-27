<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Order;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $loans = Loan::all();
        $borrowedPercentage = 0;
        $latePercentage = 0;

        $borrowed = Loan::where('status', 'Dipinjam')->get();

        if ($borrowed->count() !== 0) {
            $borrowedPercentage = $borrowed->count() / $loans->count() * 100;
        }

        $late = Loan::where(DB::raw('DATE_ADD(borrow_date, INTERVAL +1 MONTH)'), '<', now())
            ->orWhere(DB::raw('DATE_ADD(borrow_date, INTERVAL +1 MONTH)'), '<', 'return_date')
            ->orderByDesc('borrow_date')
            ->get();
        if ($late->count() !== 0) {
            $latePercentage = $late->count() / $loans->count() * 100;
        }

        $cMembers = Member::latest()->get();
        $books = Book::latest()->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'orders' => Order::where('status', 'Accepted')->get()->count(),
            'borrowedPercentage' => $borrowedPercentage,
            'latePercentage' => $latePercentage,
            'cMembers' => $cMembers,
            'members' => Member::whereExists(function ($query) {
                $query->select(Loan::raw(1))
                    ->from('loans')
                    ->whereColumn('loans.member_id', 'members.id');
            })->orderBy('name')->get(),
            'books' => $books,
            'orders' => Order::orderByRaw("FIELD(status, \"Pending\", \"Accepted\", \"Rejected\")")->latest()->get(),
            'loans' => Loan::latest()->get()
        ]);
    }
}
