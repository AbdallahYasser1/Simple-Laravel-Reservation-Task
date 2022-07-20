<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorProfileRequest;
use App\Models\DoctorProfile;
use App\Models\Profile;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{

    public function store(Request $request)
    {
        $path=cloudinary()->upload($request->file('picture')->getRealPath(),$options=["folder"=>"images"])->getSecurePath();
        $request['date']= date('Y-m-d');
        error_log($request['date']);
        $profile = DoctorProfile::create([
            'picture'=>$path,
            'experience_years'=>$request['experience_years'],
            'specialization'=>$request['specialization'],
            'experience'=>$request['experience'],

        ]);

     return $profile;
    }
}
