<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function add(Request $request){
        $imageUrl = "";
        $hasError=false;
        $errorMessage = "";
        $message = "";
        $dish=null;
        if ($request->hasFile('imageUrl')) {
            $file = $request->file('imageUrl');
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                $hasError = true;
                $errorMessage = "Le format doit être de type jpg, jpeg, png ou gif";
            } else {
                $fileName = date("Y-m-d-H-i-s") . "-" . uniqid() . '.' . $extension;
                if (!Storage::disk('public')->exists('dishes')) {
                    Storage::disk('public')->makeDirectory('dishes');
                }
                $file->storeAs('dishes', $fileName, 'public');
                $imageUrl = Storage::disk('public')->url('dishes/' . $fileName);
            }
        } else {
            $hasError = true;
            $errorMessage = "Aucune image choisie";
        }

        if(!$hasError){
            $dish = new Dish;
            $dish->name = $request->input('name');
            $dish->price = intval($request->input('price'));
            $dish->imageUrl = $imageUrl;
            $dish->restaurant_id = $request->input('restaurant_id');

            if (!empty($request->input('category_id'))) $dish->category_id = intval($request->input('category_id'));
            $dish->cookMinTime = intval($request->input('cookMinTime'));
            $dish->cookMaxTime = intval($request->input('cookMaxTime'));
            if (!empty($request->input('description'))) {
                $dish->description = $request->input('description');
            }
            $message="Le plat ".$dish->name." a été ajouté avec succès";
            $dish->save();

            $dish = Dish::where('id',$dish->id)->first();
        }

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'message' => $message,
            'dish' => $dish,
        ];
        return response()->json($data,200);
    }
}
