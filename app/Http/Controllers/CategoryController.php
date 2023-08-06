<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function add(Request $request){
        $imageUrl = "";
        $hasError=false;
        $errorMessage = "";
        $message = "";
        $category=null;
        if ($request->hasFile('imageUrl')) {
            $file = $request->file('imageUrl');
            $extension = $file->getClientOriginalExtension();
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array(strtolower($extension), $allowedExtensions)) {
                $hasError = true;
                $errorMessage = "Le format doit être de type jpg, jpeg, png ou gif";
            } else {
                $fileName = date("Y-m-d-H-i-s") . "-" . uniqid() . '.' . $extension;
                if (!Storage::disk('public')->exists('categories')) {
                    Storage::disk('public')->makeDirectory('categories');
                }
                $file->storeAs('categories', $fileName, 'public');
                $imageUrl = Storage::disk('public')->url('categories/' . $fileName);
            }
        } else {
            $hasError = true;
            $errorMessage = "Aucune image choisie";
        }

        if(!$hasError){
            $category = new Category;
            $category->title = $request->input('title');
            $category->imageUrl = $imageUrl;
            $category->restaurant_id = $request->input('restaurant_id');
            
            $message="La catégorie ".$category->title." a été ajoutée avec succès";
            $category->save();
            
            $category = Category::where('id',$category->id)->first();
        }

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'message' => $message,
            'category' => $category,
        ];
        return response()->json($data,200);
    }

    public function delete(Request $request,$categoryId,$restaurantId){
        $hasError=false;
        $errorMessage = "";
        $message = "";
        $category = Category::where([
            ['restaurant_id',$restaurantId],
            ['id',$categoryId],
        ])->first();
        if(!empty($category)){
            $dishes = $category->dishes;
            if(count($dishes) ==0) {
                $imageName = basename($category->imageUrl);
                $category->delete();

                if ($imageName && Storage::disk('public')->exists('categories/' . $imageName)) {
                    Storage::disk('public')->delete('categories/' . $imageName);
                }
                $message ="Suppression effectuée avec succès";
            }else{
                $hasError=true;
                $errorMessage="Des plats existants sont réliés à cette catégorie, ne peut donc être supprimée";
            }
        }else{
            $hasError=true;
            $errorMessage="Aucune catégorie trouvée";
        }

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'message' => $message,
        ];
        return response()->json($data,200);
    }

}
