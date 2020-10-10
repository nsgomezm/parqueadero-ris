<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parking extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    protected $fillable = [
        'nit','name', 'cel', 'address', 'user_id',
    ];
}
