<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;


class AuthController extends Controller
{
    use ResponseTrait;
    public function login(AuthRequest $request)
    {

        $user = User::where([
            ['email', $request->email]
        ])->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $user->token = $request->token;
            $user->save();

            $accessToken = $user->createToken('authToken')->accessToken;

            return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
                'token' => $accessToken,
                'user' => $user
            ]]);

        }
        
         return   $this->returnError( $this->badRequest, 'Invalid Credentials!' );
 
    }


    public function sociallogin(Request $request)
    {

        $user = User::where([
            ['email', $request->email]
        ])->first();

        if ($user ) {

            $accessToken = $user->createToken('authToken')->accessToken;

            $user->token = $request->token;
            $user->save();

            return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
                'token' => $accessToken,
                'user' => $user
            ]]);
        }
        

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'image'=>'',
            'password' => Hash::make('1234'),
        ]);

        // assign new role to the user
        $role = $user->assignRole('Member');

            
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
            'token' => $accessToken,            
            'user' => $user
        ]]);

    }



    public function profile(Request $request)
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $permission = $user->getAllPermissions();

        return response([
            'user' => $user,
            'success' => 1,
        ]);
    }


    public function changePassword(Request $request)
    {
        // match old password
        if (Hash::check($request->old_password, Auth::user()->password)) {
            User::find(auth()->user()->id)
            ->update([
                'password' => Hash::make($request->password),
            ]);


            return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
                'user' => Auth::user()
            ]]);
        }

        return response([
            'message' => 'Password not matched!',
            'status' => 0,
        ]);
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        // check unique email except this user
        if (isset($request->email)) {
            $check = User::where('email', $request->email)
                     ->where('id', '!=', $user->id)
                     ->first();

            if ($check) {
                return response([
                    'message' => 'The email address is already used!',
                    'success' => 0,
                ]);
            }
        }

        $user->update(
            $request->only([
                'name',
                'email',
            ])
        );

        
        return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
            'user' => Auth::user()
        ]]);
    }

    public function updateImage( Request $request  ){

        $user = Auth::user();
        //dd($request->image);
        
        $user->image = "0";
        $user->save();
        if( $request->image != "0" ){
            $user->image = (string)$request->image;
        }
        $user->save();


        return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
            'user' => Auth::user()
        ]]);

    }


    public function logout(Request $request)
    {
        $user = Auth::user()->token()->revoke();

        return $this->returnSuccessMessage($this->success,'Logged out succesfully');

        
    }

    public function register(Request $request)
    {
        try{

            

            
            $validator = \Validator::make($request->all(), [
                'name' => 'required | string ',
            'email' => 'required | email | unique:users',
            'password' => 'required ',
            ]);        
            
            if ($validator->fails()) {    
            return  $this->returnError( $this->badRequest, $validator->messages() );
            }
            // store user information
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // assign new role to the user
        $role = $user->assignRole('Member');

            
        $accessToken = $user->createToken('authToken')->accessToken;

            return response(['status' => true,'code' => 200,'msg' => 'success', 'data' => [
                'token' => $accessToken,
                
                'user' => $user
            ]]);

    
        }catch (Exception $ex) {

        }
        
    
    }
}
