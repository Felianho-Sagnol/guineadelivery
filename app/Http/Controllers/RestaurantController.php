<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function add(Request $request){
        $imageUrl = "restaurant_avatar.jpeg";
        $images_errors_count = 0;
        $hasError=false;
        $errorMessage = "";
        if ($request->hasFile('imageUrl')) {
            $file = $request->file('imageUrl');
            $extention = $file->getClientOriginalExtension();
            if(!in_array($extention,['jpg','JPG','JPEG',"PNG","GIF", 'jpeg', 'png','gif'])){
                $hasError=true;
                $errorMessage = "Le format doit être type jpg , jpeg, png ou gif";
            }else{
                $imageUrl = date("Y-m-h-i-s")."-".time().'.'.$extention;
                $destinationPath = public_path().'/assets/img/restaurants' ;
                $file->move($destinationPath,$imageUrl);
            }
        }else{
            $hasError=true;
            $errorMessage = "Aucune image choisi";
        }
        $restaurant=null;
        if(!$hasError){
            $restaurant = new Restaurant;

            $restaurant->name= $request->input('name');
            $restaurant->phone= $request->input('phone');
            if(!empty($request->input('neighborhood'))) $restaurant->neighborhood= $request->input('neighborhood');
            if(!empty($request->input('email'))) $restaurant->email= $request->input('email');
            if(!empty($request->input('complementAddress'))) $restaurant->complementAddress= $request->input('complementAddress');
            $restaurant->description= $request->input('description');
            $restaurant->town= $request->input('town');
            $restaurant->minDeliveyFees= $request->input('minDeliveyFees');
            // $restaurant->isOpen= intval($request->input('isOpen'));
            $restaurant->discount= intval($request->input('discount'));
            $restaurant->discountFrom= intval($request->input('discountFrom'));
            $restaurant->cookMinTime= intval($request->input('cookMinTime'));
            $restaurant->minAmountToOrder= intval($request->input('minAmountToOrder'));
            $restaurant->cookMaxTime= intval($request->input('cookMaxTime'));
            $restaurant->imageUrl= $imageUrl;
            $restaurant->save();

            $restaurant = Restaurant::where('id',$restaurant->id)->first();
        }

        
        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'restaurant' => $restaurant,
        ];
        return response()->json($data,200);
    }

    public function restaurants(Request $request){
        $restaurants = Restaurant::all();

        $data = [
            'restaurants' => $restaurants,
        ];
        return response()->json($data,200);
    }
}
