<?php

namespace App\Http\Controllers\frontend;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $id = auth()->guard('members')->user()->id;

        return view('profile.index', [
            'title' => 'Profil Saya',
            'member' => Member::where('id', $id)->first(),
            'borrowedBooks' => Loan::where('member_id', $id)->get()
        ]);
    }
}
