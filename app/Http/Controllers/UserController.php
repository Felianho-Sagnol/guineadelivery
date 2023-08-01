<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function fakeAdminMaker(){
        $user = new Admin;

        $user->firstname = "Sagno";
        $user->lastname = "Félix";
        $user->phone = "+224625248758";
        $user->email = "sagno@gmail.test";
        $user->password = sha1("01010101");
        $user->role = "super-admin";

        $user->save();
    }
}
