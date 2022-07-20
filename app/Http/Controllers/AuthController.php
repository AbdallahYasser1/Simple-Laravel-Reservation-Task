<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorAccountRequest;
use App\Http\Requests\DoctorProfileRequest;
use App\Http\Requests\UserAccountRequest;
use App\Http\Resources\AuthResource;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $credentials= $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $user= Auth::loginUsingId($user->id);
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = ['user'=>new AuthResource($user), 'token' => $token];
            return $response;
        }
        return response()->json(["message" => "The user was not found or the password was incorrect."], 401);

    }

public function PatientSignUp(UserAccountRequest $request){
    $patient_profile=new UserProfileController;
    $patient_profile= $patient_profile->store($request);
    $patient_profile->save();
    $user = new User;
    $user->email = $request['email'];
    $user->name = $request['name'];
    $user-> password = $request['password'];
    $patient_profile->profile()->save($user);
    $user->save();
    $user->assignRole('Patient');
    return response()->json(["message" => "User Created Successfully.","user"=>$user], 201);
}

}
