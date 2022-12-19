<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        return view('register');
    }

    public function store(Request $request) {
        //Validate all form fields for correct parameters described below prior to submission.
        $formFields = $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('listings', 'company')],
            'password' => 'required',
            'password2' => 'required'
        ]);

        User::create($formFields);

        //After form is validated and submitted, redirect user to the home page.
        return redirect('/')->with('message', 'You Have Registered Created Successfully!');
    }
}
