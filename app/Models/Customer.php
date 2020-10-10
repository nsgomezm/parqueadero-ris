<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cedula', 'name', 'last_name', 'cel', 'address', 'comments', 'parking_id',
    ];

    public function parking(){
        return $this->belongsTo(Parking::class);
    }

}
