<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index', [
            'title' => 'Semua Admin',
            'users' => User::orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('administrator');

        return view('admin.users.create', [
            'title' => 'Tambah Admin',
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
        $this->authorize('administrator');

        $data = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'nullable|email:rfc,dns|unique:users',
            'avatar' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'address' => 'nullable|max:255',
            'role' => 'nullable',
        ]);

        if ($data['birth_place'] || $data['birth_date']) {
            $data['birth'] = $data['birth_place'] . ', ' . date('d-m-Y', strtotime($data['birth_date']));
        }

        $data['password'] = bcrypt($data['username']);

        User::create($data);

        return redirect('/admin/users')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'title' => 'Detail ' . strtok($user->name, ' '),
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('administrator');

        return view('admin.users.edit', [
            'title' => 'Edit Admin',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('administrator');

        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'nullable|email:rfc,dns',
            'avatar' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'address' => 'nullable|max:255',
            'role' => 'nullable',
        ]);

        if ($request->input('username') != $user->username) {
            $request->validate(['username' => 'required|unique:users']);
        }

        if ($request->input('email') != $user->email) {
            $request->validate(['email' => 'nullable|email:rfc,dns|unique:users']);
        }

        if ($request['birth_place'] || $request['birth_date']) {
            $request['birth'] = $request['birth_place'] . ', ' . $request['birth_date'];
        }

        $request['password'] = bcrypt($request['username']);

        User::where('id', $user->id)->update($request->except(['_method', '_token', 'birth_place', 'birth_date']));

        return redirect('/admin/users')->with('success', 'Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('administrator');

        if ($user->avatar && $user->avatar != 'defaultAvatar.png') {
            $file_path = public_path() . "/dist/img/avatar/" . $user->avatar;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        User::destroy($user->id);
        return redirect('/admin/users')->with('success', 'Admin berhasil dihapus!');
    }
}
