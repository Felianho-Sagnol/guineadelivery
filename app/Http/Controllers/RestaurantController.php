<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function add(Request $request){
        $imageUrl = "restaurant_avatar.jpeg";
        $images_errors_count = 0;
        $hasError=false;
        $errorMessage = "";
        // if ($request->hasFile('imageUrl')) {
        //     $file = $request->file('imageUrl');
        //     $extention = $file->getClientOriginalExtension();
        //     if(!in_array($extention,['jpg','JPG','JPEG',"PNG","GIF", 'jpeg', 'png','gif'])){
        //         $hasError=true;
        //         $errorMessage = "Le format doit être type jpg , jpeg, png ou gif";
        //     }else{
        //         $imageUrl = date("Y-m-h-i-s")."-".time().'.'.$extention;
        //         $destinationPath = public_path().'/assets/img/restaurants' ;
        //         $file->move($destinationPath,$imageUrl);
        //     }
        // }else{
        //     $hasError=true;
        //     $errorMessage = "Aucune image choisi";
        // }

        
        if ($request->hasFile('imageUrl')) {
            $file = $request->file('imageUrl');
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                $hasError = true;
                $errorMessage = "Le format doit être de type jpg, jpeg, png ou gif";
            } else {
                $fileName = date("Y-m-d-H-i-s") . "-" . uniqid() . '.' . $extension;
                if (!Storage::disk('public')->exists('restaurants')) {
                    Storage::disk('public')->makeDirectory('restaurants');
                }
                $file->storeAs('restaurants', $fileName, 'public');
                $imageUrl = Storage::disk('public')->url('restaurants/' . $fileName);
            }
        } else {
            $hasError = true;
            $errorMessage = "Aucune image choisie";
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

    public function restaurant(Request $request,$id){
        $hasError=false;
        $errorMessage = "";

        $restaurant = Restaurant::where('id',$id)->with('categories','dishes','order_types','payment_modes')->first();

        // $totalGain = Order::where([
        //     ['pdv_id',$id],
        //     ['isPaid',1],
        // ])->sum('total');
        if(empty($restaurant)){
            $hasError=true;
            $errorMessage="Aucun restaurant trouvé";
        }

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'restaurant' => $restaurant,
        ];
        return response()->json($data,200);
    }

    public function delete(Request $request,$id){
        $hasError=false;
        $errorMessage = "";
        $message = "";
        $restaurant = Restaurant::where('id',$id)->first();
        if(!empty($restaurant)){
            $imageName = basename($restaurant->imageUrl);
            $restaurant->delete();

            if ($imageName && Storage::disk('public')->exists('restaurants/' . $imageName)) {
                Storage::disk('public')->delete('restaurants/' . $imageName);
            }
            $message ="Suppression effectuée avec succès";
        }else{
            $hasError=true;
            $errorMessage="Aucun restaurant trouvé";
        }

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'message' => $message,
        ];
        return response()->json($data,200);
    }

    /*public function deleteRestaurant($restaurantId){
        $restaurant = Restaurant::find($restaurantId);

        if ($restaurant) {
            // Get the image file name from the restaurant model
            $imageName = $restaurant->imageUrl;//split by / and get last element of the array

            // Delete the restaurant record from the database
            $restaurant->delete();

            // Delete the associated image from the 'restaurants' directory
            if ($imageName && Storage::disk('public')->exists('restaurants/' . $imageName)) {
                Storage::disk('public')->delete('restaurants/' . $imageName);
            }

            return response()->json(['message' => 'Restaurant deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Restaurant not found'], 404);
        }
    }*/
}
