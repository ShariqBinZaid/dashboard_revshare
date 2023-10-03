<?php

namespace App\Http\Controllers;

use App\Models\RentalAddons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RentalAddonsResource;

class RentalAddonsController extends Controller
{
    public function index()
    {
        $data['rentaladdons'] = RentalAddons::all();
        return view('rentaladdons.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $rentals = RentalAddons::get();
        return new RentalAddonsResource($rentals);
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $rentals = RentalAddons::all();
            return new RentalAddonsResource($rentals);
        } else {
            $rentals = RentalAddons::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $rentals]);
        }
    }

    public function destroy(Request $req, $id)
    {
        RentalAddons::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Rentals Addons Deleted']);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $rentals = RentalAddons::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Addons Updated Successfully.']);
        } else {
            $rentals = RentalAddons::create($input);
            return response()->json(['success' => true, 'msg' => 'Rentals Addons Created Successfully']);
        }
    }
}
