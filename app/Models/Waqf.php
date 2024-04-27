<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Waqf extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $load = ['member', 'librarian'];

    function member()
    {
        return $this->belongsTo(Member::class, 'member_id')->withDefault();
    }

    function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id')->withDefault();
    }
}
