<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorAccountRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Models\DoctorProfile;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $doctors=User::where('profileable_type','App\Models\DoctorProfile')->with(['profileable'])->get();

        return response()->json(['doctors'=>$doctors->count()==0?'There is no doctors at this moment': $doctors],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DoctorAccountRequest $request)
    {
        $doctor= new DoctorProfileController;
        $doctor= $doctor->store($request);
        $doctor->save();
        $user = new User;
        $user->email = $request['email'];
        $user->name = $request['name'];
        $user-> password = $request['password'];
        $doctor->profile()->save($user);
        $user->save();
        $user->assignRole('Doctor');
        return response()->json(["message" => "User Created Successfully.","user"=>$user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDoctorRequest $request, User $user)
    {
        if($user==null) return response()->json('User not found ' , '404');
        if(!$user->hasRole('Doctor')) return response()->json(["error"=>'User is not a doctor '] , '404');
        if ($request->hasFile('picture')) {
            $path = cloudinary()->upload($request->file('picture')->getRealPath(), $options = ["folder" => "images"])->getSecurePath();
        }
        $Profile_Request = [
            'experience' => $request['experience'] == null ? $user->profileable->experience : $request['experience'],
            'specialization' => $request['specialization'] == null ? $user->profileable->specialization : $request['specialization'],
            'experience_years' => $request['experience_years'] == null ? $user->profileable->experience_years : $request['experience_years'],
            'picture' => $request['picture'] == null ? $user->profileable->picture : $path
        ];
        $user->fill($request->all())->save();
        $user->profileable()->update($Profile_Request);
        return response()->json(['message'=>'Successfully Updated'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy( $id)
    {
        $user=User::find($id);
        if(!$user->hasRole('Doctor')) return response()->json(["error"=>'User is not a doctor '] , '404');
        if($user==null) return response()->json(["error"=>'User not found '] , '404');
    $user->profileable()->delete();
$user->delete();
        return response()->json(['message'=>'Successfully Deleted'],200);

    }
}
