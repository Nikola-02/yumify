<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends OsnovniController
{

    public function login(){
        return view('pages.auth.login');
    }

    public function performLogin(LoginUserRequest $request){
        $formFields = $request->validated();

        $user = User::where('email', $formFields['email'])->with('role')->first();

        if ($user && Hash::check($formFields['password'], $user->password)) {

            session()->put('user', $user);

            $this->log_action_for_user('Logged in');

            return redirect(route('home'))->with('success_login', 'Successfully logged in.');
        } else {
            return back()->with('bad_credentials', 'Invalid credentials.');
        }
    }

    public function logout(){
        $this->log_action_for_user('Logged out');
        session()->forget('user');
        return redirect(route('home'))->with('success_login', 'Successfully logged out.');
    }


    public function register(){
        return view('pages.auth.register');
    }

    public function store(RegisterUserRequest $request){
        $userRoleId = 1;
        $formFields = $request->validated();
        $formFields['role_id'] = $userRoleId;

        $formFields['password'] = bcrypt($formFields['password']);

        try {
            User::create($formFields);

            $this->log_action_for_user('Registered');

            return redirect(route('login'))->with('userCreated', 'User created successfully.');
        }catch(\Exception $ex){
            return back()->with('registrationError', 'Error occurred in database.');
        }

    }
}
