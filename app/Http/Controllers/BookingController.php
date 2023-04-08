<?php

namespace App\Http\Controllers;

use App\Classes\AvailableSeatsFinder;
use App\Http\Resources\BookingResource;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Models\Station;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getAvailableSeats(Request $request)
    {
        //validate request
        $this->validate($request, [
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|integer|exists:stations,id',
        ]);

        //get start station and end station from request
        $startStationId = $request->input('start_station_id');
        $endStationId = $request->input('end_station_id');

        //check if start station and end station are the same
        if ($startStationId == $endStationId) {
            return response()->json(['message' => 'Start station and end station can not be the same'], 400);
        }

        //check if start station and end station are valid
        $startStation = Station::find($startStationId);
        $endStation = Station::find($endStationId);
        if (!$startStation || !$endStation) {
            return response()->json(['message' => 'Start station or end station is not valid'], 400);
        }

        //get trips that connected between start station and end station
        $connectedTrips = $startStation->trips()->whereHas('stations', function ($query) use ($endStation) {
            $query->where('station_id', $endStation->id);
        })->get();

        //check if start station and end station are connected
        if ($connectedTrips->isEmpty()) {
            return response()->json(['message' => 'Start station and end station are not connected'], 400);
        }

        //get available seats for each trip
        $tripsWithSeats = [];
        foreach ($connectedTrips as $trip) {
            $startOrder = $trip->stations()->where('station_id', $startStation->id)->first()->pivot->order;
            $endOrder = $trip->stations()->where('station_id', $endStation->id)->first()->pivot->order;
            if ($startOrder < $endOrder) {
                $seatsFinder = new AvailableSeatsFinder();
                $availableSeats = $seatsFinder->getAvailableSeats($trip, $startOrder, $endOrder);
                if (!empty($availableSeats)) {
                    $trip->availableSeats = $availableSeats;
                    $tripsWithSeats[] = $trip;
                }
            }
        }

        if (empty($tripsWithSeats)) {
            return response()->json(['message' => 'Sorry , there is no available trips'], 400);
        }

        return response()->json(TripResource::collection($tripsWithSeats), 200);
    }

    public function BookSeat(Request $request)
    {
        //validate request
        $this->validate($request, [
            'trip_id' => 'required|exists:trips,id',
            'seat_id' => 'required|exists:seats,id',
            'start_station_id' => 'required|exists:stations,id',
            'end_station_id' => 'required|integer|exists:stations,id',
        ]);

        //get trip and seat from request
        $tripId = $request->input('trip_id');
        $seatId = $request->input('seat_id');
        $startStationId = $request->input('start_station_id');
        $endStationId = $request->input('end_station_id');

        //get start station and end station from request
        $startStationId = $request->input('start_station_id');
        $endStationId = $request->input('end_station_id');

        //check if start station and end station are the same
        if ($startStationId == $endStationId) {
            return response()->json(['message' => 'Start station and end station can not be the same'], 400);
        }

        //check if start station and end station are valid
        $startStation = Station::find($startStationId);
        $endStation = Station::find($endStationId);
        if (!$startStation || !$endStation) {
            return response()->json(['message' => 'Start station or end station is not valid'], 400);
        }

        //check if trip has the these stations and the order is correct
        $trip = Trip::find($tripId);
        $startOrder = $trip->stations()->where('station_id', $startStation->id)->first()->pivot->order;
        $endOrder = $trip->stations()->where('station_id', $endStation->id)->first()->pivot->order;
        if ($startOrder > $endOrder) {
            return response()->json(['message' => 'Start station and end station are not connected'], 400);
        }

        //check if seat is available
        $seatsFinder = new AvailableSeatsFinder();
        $availableSeats = $seatsFinder->getAvailableSeats($trip, $startOrder, $endOrder);

        //check if seat is in available seats
        if (!in_array($seatId, $availableSeats->pluck('id')->toArray())) {
            return response()->json(['message' => 'Sorry , this seat is not available'], 400);
        }

        $user = auth()->user();

        //create booking 
        $booking = $trip->bookings()->create([
            'seat_id' => $seatId,
            'start_station_id' => $startStation->id,
            'end_station_id' => $endStation->id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'message' => 'Seat is booked successfully',
            'data' => new BookingResource($booking)
        ], 200);
    }
}
