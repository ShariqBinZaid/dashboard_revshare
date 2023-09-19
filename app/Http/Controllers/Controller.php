<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function updateprofile(Request $request, $file, $folderName = 'profileimage')
    {
        $p = $request->input();
        $path = '';
        $file_name = '';
        if ($request->file($file)) {

            $request->validate([
                $file => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imagePath = $request->file($file);
            $imageName = $imagePath->getClientOriginalName();
            $fileName =  time() . str_replace(' ', '', $imageName);
            $file_name =  $folderName . '/' . $fileName;
            $path = $request->file($file)->storeAs('public/' . $folderName, $fileName);
        }
        return $file_name;
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
