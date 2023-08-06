<?php

namespace App\Http\Controllers;

use App\Models\OrderType;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    public function add(Request $request){
        $hasError=false;
        $errorMessage = "";
        $message = "";
        $ordertype=null;
        

        $ordertype = new OrderType;
        $ordertype->name = $request->input('name');
        $ordertype->description = $request->input('description');
        $ordertype->fromAmount = intval($request->input('fromAmount'));
        $ordertype->restaurant_id = intval($request->input('restaurant_id'));
            
        $message="Le type de commande ".$ordertype->name." a été ajouté avec succès";
        $ordertype->save();
            
        $ordertype = OrderType::where('id',$ordertype->id)->first();

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'message' => $message,
            'orderType' => $ordertype,
        ];
        return response()->json($data,200);
    }
}
