<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal_information extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cedula','name', 'last_name', 'cel','photo', 'address','comments',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
