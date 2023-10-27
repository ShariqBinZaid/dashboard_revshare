<?php

namespace App\Http\Controllers;

use App\Models\Tours;
use App\Models\TourImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TourImagesResource;
use App\Models\ToursImages;

class ToursImagesController extends Controller
{
    public function index()
    {
        $data['tourimages'] = ToursImages::all();
        $data['tours'] = Tours::all();
        return view('toursimages.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $tourimages = TourImages::get();
        return new TourImagesResource($tourimages);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'image' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->file('image')) {
            unset($input['image']);
            $input += ['image' => $this->updateprofile($req, 'image', 'profileimage')];
        }

        unset($input['_token']);

        if (@$input['id']) {
            $tourimages = ToursImages::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Tours Images Updated Successfully.']);
        } else {
            $tourimages = ToursImages::create($input);
            return response()->json(['success' => true, 'msg' => 'Tours Images Created Successfully', 'data' => $tourimages]);
        }
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $tourimages = ToursImages::all();
            return new TourImagesResource($tourimages);
        } else {
            $tourimages = ToursImages::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $tourimages]);
        }
    }

    public function destroy(Request $req, $id)
    {
        ToursImages::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Tours Images Deleted']);
    }
}
