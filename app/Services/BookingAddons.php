<?php

namespace App\Services;

use App\Services\BookingAddons as BookingAddonsModel;
Class BookingAddons{
    public function store($data){
        try {
            $addons = new BookingAddonsModel();
            $addons->booking_id = $data->booking_id;
            $addons->rental_id = $data->rental_id;
            $addons->rental_addons_id = $data->rental_addons_id;
            $addons->quantity = $data->quantity;
            $addons->amount = $data->amount;
            $addons->total = $data->total;
            $addons->save();
            return $addons;
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
