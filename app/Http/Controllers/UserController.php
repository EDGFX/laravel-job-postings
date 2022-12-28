<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
   public function registerUser() {
    return view('users.register');
   }

   // Takes the user registration input, validates the provided fields, and stores the newly created user information into the database.
   public function storeUser(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        //Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        //Creates User After Validation Is Completed
        $user = User::create($formFields);

        //Log User In After Registration
        auth()->login($user);

        return redirect('/')->with('message', 'You have successfully registered, and are now logged in!');
   }

   public function userLogout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out successfully.');
   }

   //Show Login Form
   public function userLogin() {
        return view('users.login');
   }

   //Authenticate User
   public function authUser(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You have logged in successfully!');
        }

        return back()->withError();
   }
}
