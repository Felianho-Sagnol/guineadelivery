<?php

namespace App\Http\Controllers;

use App\Models\PaymentMode;
use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    public function add(Request $request){
        $hasError=false;
        $errorMessage = "";
        $message = "";
        $paymentmode=null;
        

        $paymentmode = new PaymentMode;
        $paymentmode->name = $request->input('name');
        $paymentmode->description = $request->input('description');
        $paymentmode->slug = "-";
        $paymentmode->restaurant_id = intval($request->input('restaurant_id'));
            
        $message="Le mode de payement ".$paymentmode->name." a été ajouté avec succès";
        $paymentmode->save();
            
        $paymentmode = PaymentMode::where('id',$paymentmode->id)->first();

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'message' => $message,
            'paymentMode' => $paymentmode,
        ];
        return response()->json($data,200);
    }
}
