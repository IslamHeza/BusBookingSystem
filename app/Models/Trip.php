<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_station_id',
        'end_station_id',
        'bus_id',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function stations()
    {
        return $this->belongsToMany(Station::class)->withPivot('order', 'distance_from_start_station')->orderBy('order');
    }
}
