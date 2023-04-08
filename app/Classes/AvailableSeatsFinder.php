<?php

namespace App\Classes;

use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class AvailableSeatsFinder
{
    public function getAvailableSeats(Trip $trip, $startStationOrder, $endStationOrder)
    {
        $bookings = $trip->bookings()->get();
        $seats = $trip->bus->seats()->get();
        $bookedSeatIds = $bookings->pluck('seat_id')->toArray();
        $availableSeats = $seats->whereNotIn('id', $bookedSeatIds);

        foreach ($bookedSeatIds as $key => $seatId) {
            //get seat bookings
            $bookings = $trip->bookings()->join('station_trip', 'bookings.end_station_id', '=', 'station_trip.station_id')
                ->orderBy('station_trip.order')
                ->where('seat_id', $seatId)
                ->get();

            $maxEndOfPreviousBooking = null;
            $minStartOfNextBookings = null;

            foreach ($bookings as $booking) {
                //get the station order of booking start station id
                $startOrder = DB::table('station_trip')
                    ->where('trip_id', $booking->trip_id)
                    ->where('station_id', $booking->start_station_id)
                    ->pluck('order')
                    ->first();

                //get the station order of booking end station id
                $endOrder = DB::table('station_trip')
                    ->where('trip_id', $booking->trip_id)
                    ->where('station_id', $booking->end_station_id)
                    ->pluck('order')
                    ->first();

                if ($endOrder <= $startStationOrder && $endOrder >= $maxEndOfPreviousBooking) {
                    $maxEndOfPreviousBooking = $endOrder;
                }

                if ($startOrder >= $endStationOrder && $startOrder >= $minStartOfNextBookings) {
                    // $minBooking = $booking;
                    $minStartOfNextBookings = $startOrder;
                }
            }

            if ($maxEndOfPreviousBooking != null && $minStartOfNextBookings != null) {
                if ($startStationOrder >= $maxEndOfPreviousBooking && $endStationOrder <= $minStartOfNextBookings) {
                    $seat = $seats->where('id', $seatId)->first();
                    $availableSeats->push($seat);
                }
            }
        }

        //return distinct seats
        $availableSeats = $availableSeats->unique();
        return $availableSeats;
    }
}
