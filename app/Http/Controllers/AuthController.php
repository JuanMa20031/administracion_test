<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
            
        $user = User::where('username',$request->username)->first();

        if(!$user){         
            return redirect("login")->withErrors('El usuario no existe');
        }

        if($request->password != $user->password){
            return redirect("login")->withErrors('Contraseña incorrecta');
        }

        Auth::login($user);
        return redirect()->route('logistica');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}