<?php

namespace App\Http\Controllers;

use App\Models\DoctorProfile;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function store(Request $request)
    {
        $path=cloudinary()->upload($request->file('picture')->getRealPath(),$options=["folder"=>"images"])->getSecurePath();

        $profile = UserProfile::create([
            'picture'=>$path==null?'empty':$path,
        ]);

        return $profile;
    }
}
