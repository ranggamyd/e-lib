<?php

namespace App\Http\Controllers\frontend;

use App\Models\Loan;
use App\Models\Order;
use App\Models\Member;
use App\Models\ReturnModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->guard('members')->user()->id;

        return view('transactions.orders', [
            'title' => 'Pengajuan Pinjaman',
            'member' => Member::where('id', $id)->first(),
            'orders' => Order::latest()->where('member_id', $id)->get(),
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            'member_id' => auth()->guard('members')->user()->id,
            'book_id' => $request->input('book_id'),
        ];

        Order::create($data);

        return redirect('/transactions/orders')->with('success', 'Berhasil mengajukan pinjaman!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        Order::destroy($order->id);
        return redirect('/transactions/orders')->with('success', 'Pengajuan Pinjaman berhasil dihapus!');
    }
}
