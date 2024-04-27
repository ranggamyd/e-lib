<?php

namespace App\Http\Controllers\admin;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Subject;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.members.index', [
            'title' => 'Semua Anggota',
            'members' => Member::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.members.create', [
            'title' => 'Tambah Anggota',
            'subjects' => Subject::orderBy('name')->get()
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
        $data = $request->validate([
            'name' => 'required|max:255',
            'npm' => 'required|integer|unique:members',
            'subject_id' => 'required',
            'email' => 'nullable|email:rfc,dns|unique:members',
            'avatar' => 'nullable',
            'birth_place' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'address' => 'nullable|max:255'
        ]);

        if ($data['birth_place'] || $data['birth_date']) {
            $data['birth'] = $data['birth_place'] . ', ' . date('d-m-Y', strtotime($data['birth_date']));
        }

        $data['username'] = $data['npm'];
        $data['password'] = bcrypt(strtok($data['name'], ' ') . '.' . $data['npm']);

        Member::create($data);

        return redirect('/admin/members')->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return view('admin.members.show', [
            'title' => 'Detail ' . strtok($member->name, ' '),
            'member' => $member,
            'loans' => Loan::latest()->where('member_id', $member->id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $member->id)->get(),
        ]);
    }

    public function print($id)
    {
        $member = Member::findOrFail($id);
        $pdf = PDF::loadView('admin.members.memberCard', ["members" => [$member]]);
        $pdf->setPaper('A4', '');
        return $pdf->stream($member->npm . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        return view('admin.members.edit', [
            'title' => 'Edit Anggota',
            'member' => $member,
            'subjects' => Subject::orderBy('name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|max:255',
            'npm' => 'required',
            'subject_id' => 'required',
            'email' => 'nullable|email:rfc,dns',
            'avatar' => 'nullable',
            'birth_place' => 'nullable',
            'birth_date' => 'nullable',
            'gender' => 'nullable',
            'address' => 'nullable|max:255'
        ]);

        if ($request->input('npm') != $member->npm) {
            $request->validate(['npm' => 'required|integer|unique:members']);
        }

        if ($request->input('email') != $member->email) {
            $request->validate(['email' => 'nullable|email:rfc,dns|unique:members']);
        }

        if ($request['birth_place'] || $request['birth_date']) {
            $request['birth'] = $request['birth_place'] . ', ' . $request['birth_date'];
        }

        if ($request['npm'] != $member->username) {
            $request['password'] = bcrypt(strtok($request['name'], ' ') . '.' . $request['npm']);
            $request['username'] = $request['npm'];
        }

        Member::where('id', $member->id)->update($request->except(['_method', '_token', 'birth_place', 'birth_date']));

        return redirect('/admin/members')->with('success', 'Anggota berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if ($member->avatar && $member->avatar != 'defaultAvatar.png') {
            $file_path = public_path() . "/dist/img/avatar/" . $member->avatar;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }

        Member::destroy($member->id);
        return redirect('/admin/members')->with('success', 'Anggota berhasil dihapus!');
    }
}
