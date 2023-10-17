<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoriesResource;

class CategoriesController extends Controller
{
    public function index()
    {
        $data['categories'] = Categories::all();
        return view('categories.index')->with($data);
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $categories = Categories::get();
        return new CategoriesResource($categories);
    }

    public function store(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'image' => 'required',
            'title' => 'required',

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
            $categories = Categories::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Categories Updated Successfully.']);
        } else {
            $categories = Categories::create($input);
            return response()->json(['success' => true, 'msg' => 'Categories Created Successfully', 'data' => $categories]);
        }
    }

    public function show($id)
    {
        if ($id ==  "all") {
            $categories = Categories::all();
            return new CategoriesResource($categories);
        } else {
            $categories = Categories::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $categories]);
        }
    }

    public function destroy(Request $req, $id)
    {
        Categories::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Categories Deleted']);
    }
}
