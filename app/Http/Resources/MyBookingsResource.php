<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MyBookingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $cost = $this->bookable->price * $this->duration;
        if(count($this->addons) > 0){
            foreach($this->addons as $addon){
                $cost += $addon->total;
            }
        }

        return [
            'name' => $this->bookable->title,
            'location' => $this->bookable->locations,
            'booking_no' => $this->booking_code,
            'scheduled' => Carbon::createFromFormat('Y-m-d H:i:s', $this->datetime)->format('M d, Y'),
            'time_from' => Carbon::createFromFormat('Y-m-d H:i:s', $this->datetime)->format('h:i A'),
            'time_to' => Carbon::createFromFormat('Y-m-d H:i:s', $this->datetime)->addHours($this->duration)->format('h:i A'),
            'insurance' => $this->insurance_amount > 0 ? 'Yes' : 'No',
            'cost' => $cost
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
