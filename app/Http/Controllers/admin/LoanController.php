<?php

namespace App\Http\Controllers\admin;

use App\Models\Book;
use App\Models\Loan;
use App\Models\ReturnModel;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.loans.index', [
            'title' => 'Semua Pinjaman',
            'loans' => Loan::latest()->get(),
            'create_loan_books' => Book::where('stock', '>', 0)->orderBy('title')->get(),
            'create_loan_members' => Member::orderBy('name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.loans.create', [
            'title' => 'Tambah Pinjaman',
            'books' => Book::where('stock', '>', 0)->orderBy('title')->get(),
            'members' => Member::orderBy('name')->get()
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
        $request->validate([
            'member_id' => 'required',
            'borrow_date' => 'required',
            'borrowed_books' => 'required',
        ]);

        $bbs = $request->input('borrowed_books');
        $unique = array_unique($bbs, SORT_REGULAR);

        if (count($unique) != count($bbs)) {
            throw ValidationException::withMessages(['borrowed_books' => "Tidak dapat meminjam buku yang sama lebih dari 1"]);
        }

        foreach ($request->input('borrowed_books') as $books) {
            foreach ($books as $book) {
                $validatedLoan = [
                    'member_id' => $request->input('member_id'),
                    'book_id' => $book,
                    'borrow_date' => $request->input('borrow_date'),
                    // 'return_date' => date('Y-m-d', strtotime('+1 month', strtotime($request->input('borrow_date')))),
                    'status' => 'Dipinjam'
                ];

                $loan = Loan::create($validatedLoan);
                Book::where('id', $book)->update(['stock' => $loan->book->stock - 1]);
            };
        };

        return redirect('/admin/transactions/loans')->with('success', 'Pinjaman baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return view('admin.loans.show', [
            'title' => 'Pinjaman ' . strtok($loan->member->name, ' '),
            'member' => Member::where('id', $loan->member->id)->first(),
            'loans' => Loan::latest()->where('member_id', $loan->member->id)->get(),
            'returns' => ReturnModel::latest()->where('member_id', $loan->member_id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        return view('admin.loans.edit', [
            'title' => 'Perbarui Pinjaman',
            'books' => Book::where('stock', '>', 0)->orderBy('title')->get(),
            'members' => Member::orderBy('name')->get(),
            'loan' => $loan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    protected function updateStock($req, $loan)
    {
        $status = $loan->status;
        $newStatus = $req->input('status');

        if ($newStatus != $status && $newStatus == 'Dipinjam') {
            Book::where('id', $loan->book->id)->update(['stock' => $loan->book->stock - 1]);
        } elseif ($newStatus != $status && $newStatus == 'Dikembalikan') {
            Book::where('id', $loan->book->id)->update(['stock' => $loan->book->stock + 1]);
        }

        $book_id = $loan->book->id;
        $newBook_id = $req->input('book_id');

        if ($newBook_id != $book_id) {
            Book::where('id', $book_id)->update(['stock' =>  $loan->book->stock + 1]);

            $updatedBook = Book::where('id', $newBook_id)->first();
            Book::where('id', $newBook_id)->update(['stock' => $updatedBook->stock - 1]);
        }
    }

    public function checkFine($returnDate, $borrowDate) {
        $fine = 0;
        $dueDate = Carbon::parse($borrowDate)->addWeeks(2);
    
        if ($returnDate > $dueDate) {
            $daysLate = Carbon::parse($dueDate)->diffInDays(Carbon::parse($returnDate));
            $fine = $daysLate * 1000; // tarif denda per hari adalah Rp 1.000
        }
    
        return $fine;
    }
    

    public function update(Request $request, Loan $loan)
    {
        $this->updateStock($request, $loan);

        $data = $request->validate([
            'member_id' => 'required',
            'book_id' => 'required',
            'borrow_date' => 'required',
            'return_date' => 'nullable',
            'status' => 'required'
        ]);

        $data = [
            'member_id' => $request->input('member_id'),
            'book_id' => $request->input('book_id'),
            'borrow_date' => $request->input('borrow_date'),
            'return_date' => $request->input('return_date'),
            'status' => $request->input('status'),
            'charges' => $this->checkFine($request->input('return_date'), $request->input('borrow_date')),
            'librarian_id' => auth()->user()->id
        ];

        Loan::where('id', $loan->id)->update($data);

        return redirect('/admin/transactions/loans')->with('success', 'Pinjaman baru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        Loan::destroy($loan->id);
        return redirect('/admin/transactions/loans')->with('success', 'Pinjaman berhasil dihapus!');
    }

    protected function addToReturn($id)
    {
        $loan = Loan::where('id', $id)->first();

        $data = [
            'member_id' => $loan->member_id,
            'book_id' => $loan->book_id,
            'borrow_date' => $loan->borrow_date,
            'due_date' => $loan->due_date,
            'return_date' => date('Y-m-d'),
            'status' => 'Dikembalikan',
            'charges' => $this->checkFine(date('Y-m-d'), $loan->borrow_date),
            'librarian_id' => auth()->user()->id
        ];

        ReturnModel::create($data);
        Book::where('id', $loan->book->id)->update(['stock' => $loan->book->stock + 1]);
    }

    public function return($id)
    {
        Loan::where('id', $id)->update([
            'status' => 'Dikembalikan',
            'librarian_id' => auth()->user()->id
        ]);

        $this->addToReturn($id);

        return redirect('/admin/transactions/loans')->with('success', 'Pinjaman berhasil dikembalikan!');
    }

    public function destroyAll($id)
    {
        Loan::where('member_id', $id)->delete();

        return redirect('/admin/transactions/loans')->with('success', 'Pinjaman berhasil dihapus!');
    }
}
