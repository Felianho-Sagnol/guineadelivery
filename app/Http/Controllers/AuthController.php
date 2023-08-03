<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function test(Request $request){
        $this->fakeAdminMaker();
        $data = [
            "name"=>"test",
        ];
        return response()->json($data,200);
    }

    public function login(Request $request){
        $admin = Admin::where([
            ['phone',$request->input('phone')],
            ['role',$request->input('role')],
        ])->with('restaurant')->first();

        $errorMessage = null;
        $hasError=false;

        if (empty($admin)) {
            $errorMessage = "Aucun compte trouvé avec ces informations";
            $hasError=true;
        } else {
            if ($admin->password != sha1($request->input('password'))) {
                $errorMessage = "Mot de passe incorrecte.";
                $hasError=true;
            } else{
                if($admin->password=="admin"){

                }
            }
        }

        $data = [
            "hasError"=>$hasError,
            'errorMessage' => $errorMessage,
            'user' => $admin,
        ];
        return response()->json($data,200);
    }

    public function fakeAdminMaker(){
        $user = new Admin;

        $user->firstname = "Sagno";
        $user->lastname = "Félix";
        $user->phone = "+224625248758";
        $user->email = "sagno@gmail.test";
        $user->password = sha1("01010101");
        $user->role = "super-admin";
        $user->token = "-";

        $user->save();
    }
}
