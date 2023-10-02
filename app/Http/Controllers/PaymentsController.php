<?php

namespace App\Http\Controllers;

use App\Models\BankDetails;
use App\Models\CardDetails;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentsController extends Controller
{
    public function payments(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'payment_type' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        $input += ['user_id' => Auth::user()->id];

        if (@$input['id']) {
            $rentalreviews = Payments::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Payments Updated Successfully.']);
        } else {
            $rentalreviews = Payments::create($input);
            return response()->json(['success' => true, 'msg' => 'Payments Created Successfully']);
        }
    }

    public function getpayments()
    {
        $getpayments = Payments::with('User')->get();
        return response()->json(['success' => true, 'data' => $getpayments]);
    }

    public function bank(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'holder_name' => 'required',
            'account_number' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $bank = BankDetails::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Bank Details Updated Successfully.']);
        } else {
            $bank = BankDetails::create($input);
            return response()->json(['success' => true, 'msg' => 'Bank Details Created Successfully']);
        }
    }

    public function getbank()
    {
        $getbank = BankDetails::with('Payment')->get();
        return response()->json(['success' => true, 'data' => $getbank]);
    }

    public function card(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'payment_id' => 'required',
            'holder_name' => 'required',
            'card_number' => 'required',
            'expiry_date' => 'required',
            'cvv' => 'required',
        ]);

        // dd($input);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        unset($input['_token']);

        if (@$input['id']) {
            $bank = CardDetails::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Card Updated Successfully.']);
        } else {
            $bank = CardDetails::create($input);
            return response()->json(['success' => true, 'msg' => 'Card Created Successfully']);
        }
    }

    public function getcard()
    {
        $getcard = CardDetails::with('Payment')->get();
        return response()->json(['success' => true, 'data' => $getcard]);
    }
}
