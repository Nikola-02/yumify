<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends OsnovniController
{
    public function userLocation(){
        return response()->json(User::find(session()->get('user')->id));
    }

    public function updateLocation(Request $request){
        $request->validate([
            'location'=>'required'
        ]);

        try {
            User::find(session()->get('user')->id)->update([
                'order_location'=>$request->location
            ]);

            $this->log_action_for_user('User location updated.');

            return response()->json(['message'=>'Successfully updated your primary location.']);
        }catch (\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }

    //Admin panel
    public function create(){
        return view('pages.admin.users.create', ['roles'=>Role::all()]);
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
            'role_id'=>'required'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        try {
            User::create($formFields);

            $this->log_action_for_user('New User created.');

            return redirect('/admin/users')->with(['message'=>'Successfully created.']);
        }catch(\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    public function edit(Request $request, User $user){
        return view('pages.admin.users.edit', ['user'=>$user, 'roles'=>Role::all()]);
    }

    public function update(Request $request, User $user){
        $formFields = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'role_id'=>'required'
        ]);

        if($request->password){
            $passwordValidation = $request->validate([
                'password' => 'required|min:6|regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
            ]);

            $formFields['password'] = bcrypt($passwordValidation['password']);
        }

        try {
            $user->update($formFields);

            $this->log_action_for_user('User updated.');

            return redirect('/admin/users')->with(['message'=>'Successfully updated.']);
        }catch (\Exception $ex){
            return back()->with(['error'=>'Error occured in database.']);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            $this->log_action_for_user('User deleted.');

            return response()->json($this->data_for_table('users'));
        }catch(\Exception $ex){
            return response()->json($ex->getMessage());
        }
    }
}
