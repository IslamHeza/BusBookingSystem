<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_station' => $this->startStation->name,
            'end_station' => $this->endStation->name,
            'bus' => $this->bus->name,
            'available_seats' => SeatResource::collection($this->availableSeats),
        ];
    }
}
