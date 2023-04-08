<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate_number',
        'number_of_seats',
    ];

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}
