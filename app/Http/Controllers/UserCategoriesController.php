<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\UserCategories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserCategoriesController extends Controller
{
    public function categories(Request $req)
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

    public function getcategories()
    {
        $getcategories = Categories::get();
        return response()->json(['success' => true, 'data' => $getcategories]);
    }

    public function usercategories(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'category_id' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $usercategories = UserCategories::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'User Categories Updated Successfully.']);
        } else {
            $usercategories = UserCategories::create($input);
            return response()->json(['success' => true, 'msg' => 'User Categories Created Successfully', 'data' => $usercategories]);
        }
    }

    public function getusercategories()
    {
        $getusercategories = UserCategories::with('User', 'Categories')->get();
        return response()->json(['success' => true, 'data' => $getusercategories]);
    }
}
