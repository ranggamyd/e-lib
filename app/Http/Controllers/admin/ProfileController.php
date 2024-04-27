<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        
        return view('admin.profile.index', [
            'title' => 'Profile ' . strtok($user->name, ' '),
            'user' => $user,
        ]);
    }
}
