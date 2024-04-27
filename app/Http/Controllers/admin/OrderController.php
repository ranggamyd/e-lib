<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
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
        return view('admin.orders.index', [
            'title' => 'Semua Pengajuan',
            'orders' => Order::orderByRaw("FIELD(status, \"Pending\", \"Accepted\", \"Rejected\")")->latest()->get(),
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'title' => 'Pengajuan ' . strtok($order->member->name, ' '),
            'member' => Member::where('id', $order->member->id)->first(),
            'orders' => Order::latest()->where('member_id', $order->member_id)->get(),
            'loans' => Loan::latest()->where('member_id', $order->member->id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $order->member_id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('admin.orders.edit', [
            'title' => 'Edit Pengajuan',
            'order' => Order::where('id', $order->id)->first(),
            'members' => Member::orderBy('name')->get(),
            'books' => Book::where('stock', '>=', 0)->orderBy('title')->get()
        ]);
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
        $data = $request->validate([
            'member_id' => 'required',
            'book_id' => 'required',
            'status' => 'required',
        ]);

        $data = [
            'member_id' => $request->input('member_id'),
            'book_id' => $request->input('book_id'),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
            'librarian_id' => auth()->user()->id
        ];

        Order::where('id', $order->id)->update($data);

        $newStatus = $request->input('status');
        if ($newStatus != $order->status && $newStatus == 'Accepted') {
            $this->addToLoan($order->id);
        };

        return redirect('admin/transactions/orders')->with('success', 'Pengajuan berhasil diperbarui!');
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
        return redirect('/admin/transactions/orders')->with('success', 'Pengajuan berhasil dihapus!');
    }

    protected function addToLoan($id)
    {
        $order = Order::where('id', $id)->first();

        $data = [
            'member_id' => $order->member_id,
            'book_id' => $order->book_id,
            'borrow_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+7 day')),
            'status' => 'Dipinjam',
            'librarian_id' => auth()->user()->id
        ];

        Loan::create($data);
        Book::where('id', $order->book_id)->update(['stock' => $order->book->stock - 1]);
    }

    public function accept($id)
    {
        Order::where('id', $id)->update([
            'status' => 'Accepted',
            'librarian_id' => auth()->user()->id
        ]);

        $this->addToLoan($id);

        return redirect('/admin/transactions/orders')->with('success', 'Pengajuan berhasil diterima!');
    }

    public function reject($id)
    {
        Order::where('id', $id)->update([
            'status' => 'Rejected',
            'librarian_id' => auth()->user()->id
        ]);

        return redirect('/admin/transactions/orders')->with('success', 'Pengajuan berhasil ditolak!');
    }

    public function destroyAll($id)
    {
        Order::where('member_id', $id)->delete();
        return redirect('/admin/transactions/orders')->with('success', 'Pengajuan berhasil dihapus!');
    }
}
