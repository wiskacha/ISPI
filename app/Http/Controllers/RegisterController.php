<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    public function show(){
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function register(RegisterRequest $request){
        $persona = Persona::create($request->validated());
        $user = User::create($request->validated());

        return redirect('/login')->with('success','Cuenta creada satisfactoriamente');
    }
}
