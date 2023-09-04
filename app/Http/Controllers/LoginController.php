<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    function index()
    {
        return view('login');
    }

    function home()
    {
        return view('home');
    }

    function checklogin(Request $req)
    {

        $this->validate($req, [
            'username'  =>  'required',
            'password'  =>  'required'
        ],
        [
            'required' => 'Les deux champs sont obligatoires'
        ]);

        $user_data = array(
            'username' =>  $req->get('username'),
            'password' =>  $req->get('password'),
        );

        if (Auth::attempt($user_data)) {
            return redirect('/salle');
        } else {
            return back()->with('error', 'Informations incorrectes');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('login');
    }


    function changer_password(Request $request){

        $_user = auth()->user();
        if(Hash::check($request->old_pass,$_user->password)){
            $__user = User::where('username',$_user->username)->get('*')->first();
            $__user->update([
                'password' => bcrypt($request->new_pass)
            ]);
            
            session()->flash('password-changed', 'Le Mot de passe est bien modifié!');
            return redirect()->back();
        }
        else{

            session()->flash('password-incorrect', 'Mot de passe incorrect!');

            return redirect()->back();
        }

    }

    function changer_username(Request $request){

        $_user = auth()->user();
        if($request->old_username == $_user->username){

            $__user = User::where('username',$_user->username)->get('*')->first();
            $__user->update([
                'username' => $request->new_username
            ]);
            
            session()->flash('username-changed', 'Le Nom d\'Utilisateur est bien modifié!');
            return redirect()->back();
        }
        else{

            session()->flash('username-incorrect', 'Le Nom d\'Utilisateur est incorrect!');

            return redirect()->back();
        }

    }
}
