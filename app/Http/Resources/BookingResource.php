<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'seat' => new SeatResource($this->seat),
            'user' => new UserResource($this->user),
            'start_station' => new StationResource($this->startStation),
            'end_station' => new StationResource($this->endStation),
        ];
    }
}
