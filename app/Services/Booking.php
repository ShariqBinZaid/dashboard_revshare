<?php

namespace App\Services;

use App\Models\Bookings;
use App\Models\RentalAddons;
use App\Models\RentalAvailability;
use App\Models\Rentals;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Booking
{
    public function store($data, $model)
    {
        DB::beginTransaction();
        try {
            $booking = new Bookings();
            $booking->user_id = Auth::id();
            $booking->booking_code = rand('1000000', '9999999');
            $booking->datetime = Carbon::createFromFormat('Y-m-d H:i:s', $data->datetime)->format('Y-m-d H:i:s');
            $booking->duration = $data->duration;
            $booking->comments = $data->comments;
            $booking->insurance_amount = $data->insurance_amount;
            $booking->bookable_type = $model;
            $booking->bookable_id = $data->bookable_id;
            $booking->booking_status = 'Confirmed';
            $booking->adults = $data->adults;
            $booking->childs = $data->childs;
            $booking->infants = $data->infants;
            $booking->rental_availability_id = $data->rental_availability_id;
            $booking->save();
            $addonService = new BookingAddons();
            if (isset($data->addons) && count($data->addons) > 0) {
                foreach ($data->addons as $addon => $quantity) {
                    $getAddon = RentalAddons::find($addon);
                    $total = $getAddon->price * $quantity;
                    $addonData = [
                        'booking_id' => $booking->id,
                        'rental_id' => $data->bookable_id,
                        'rental_addons_id' => $addon,
                        'quantity' => $quantity,
                        'amount' => $getAddon->price,
                        'total' => $total
                    ];
                    $addonService->store((object)$addonData);
                }
            }
            DB::commit();
            return $booking;
        } catch (\Exception $e) {
            Log::debug('Error from Rental Store: '.$e);
            DB::rollBack();
            throw $e;
        }
    }

    public function rentalAvailability($rental_id, array $dates, $hour)
    {
        try {
            if (!empty($dates)) {
                $hourToTime = Carbon::createFromFormat('H:i:s', $hour)->format('H:i:s');
                $selectedDates = [];
                foreach ($dates as $date) {
                    $parseDate = Carbon::parse($date);
                    if($parseDate->gt(Carbon::now())) {
                        //Getting rental availability
                        $dateToDay = Carbon::createFromFormat('Y-m-d', $date)->format('D');
                        $rental_availability = RentalAvailability::whereRentalId($rental_id)->where('day', $dateToDay)->where('from', '<=', $hourToTime)->where('to', '>=', $hourToTime)->first();
                        if ($rental_availability) {
                            array_push($selectedDates, ['id' => $rental_availability->id, 'date' => $date]);
                        }
                    }
                }
                if(!empty($selectedDates)){
                    return $selectedDates[0];
                } else {
                    return false;
                }
            }
            return false;
        } catch (\Exception $e) {
            Log::debug('Error from Rental Availability: '.$e);
            throw $e;
        }
    }
}
