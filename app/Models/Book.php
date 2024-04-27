<?php

namespace App\Models;

use App\Models\User;
use App\Models\Waqf;
use App\Models\Publisher;
use App\Models\BookAuthor;
use App\Models\Collection;
use App\Models\BookCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['collection', 'book_categories', 'book_authors', 'publisher', 'waqf', 'librarian'];

    function collection()
    {
        return $this->belongsTo(Collection::class, 'collection_id')->withDefault();
    }

    function book_categories()
    {
        return $this->hasMany(BookCategory::class, 'book_id');
    }

    function book_authors()
    {
        return $this->hasMany(BookAuthor::class, 'book_id');
    }

    function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id')->withDefault();
    }

    function waqf()
    {
        return $this->belongsTo(Waqf::class, 'waqf_id')->withDefault();
    }

    function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id')->withDefault();
    }
}
