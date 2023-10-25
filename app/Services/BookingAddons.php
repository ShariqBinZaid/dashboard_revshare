<?php

namespace App\Services;

use App\Models\BookingAddons as BookingAddonsModel;
use Illuminate\Support\Facades\Log;

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
            Log::error('Error from BookingAddons Service: '.$e);
            throw $e;
        }
    }

    public function get($id){
        $addon = BookingAddonsModel::find($id);
        return $addon;
    }
}
