<?php

namespace App\Models;

use App\Models\Book;
use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['member', 'book', 'librarian'];

    /**
     * Get the member that owns the Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id')->withDefault();
    }

    /**
     * Get the book that owns the Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id')->withDefault();
    }

    /**
     * Get the librarian that owns the Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id')->withDefault();
    }
}
