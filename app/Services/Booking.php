<?php

namespace App\Services;
use App\Models\Bookings;
use App\Models\Rentals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Class Booking{
    public function storeRental($data)
    {
        DB::beginTransaction();
        try {
            $booking = new Bookings();
            $booking->user_id = Auth::id();
            $booking->datetime = $data->datetime;
            $booking->duration = $data->duration;
            $booking->insurance_amount = $data->insurance_amount;
            $booking->bookable_type = Rentals::class;
            $booking->bookable_id = $data->bookable_id;
            $booking->adults = $data->adults;
            $booking->childs = $data->childs;
            $booking->infants = $data->infants;
            $booking->rental_availability_id = $data->rental_availability_id;
            $booking->save();
            $addonService = new BookingAddons();
            if(isset($data->addons) && count($data->addons) > 0){
                foreach ($data->addons as $addon){
                    $addonService->store($addon);
                }
            }
            DB::commit();
            return $booking;
        } catch (\Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
