<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use \App\Traits\AppointmentTrait;
class AdminAppointmentController extends Controller
{    use AppointmentTrait;
    function GetDoctorSheet(Request $request , User $user){
        if($user==null) return response()->json(["error"=>'Appointment not found '] , '404');
        if(!$user->hasRole('Doctor')) return response()->json(["error"=>'User is not a doctor '] , '404');
        // Query Parameters to filter by date
        $date = $request->query('date');
        $appointments=Appointment::where('doctor_id',$user->id);
        if($date !=null)
            $appointments->where('date',$date);
        return response()->json(['data'=>$appointments->get()],200);
    }
function storeAppointment(Request $request, User $user){
    if($user==null) {return response()->json(["error"=>'Doctor not found '] , '404');}
    if(!$user->hasRole('Doctor')) return response()->json(["error"=>'User is not a doctor '] , '404');
    if(!User::find($request['user_id'])->hasRole('Patient'))
        return response()->json(["message"=>"The user is not a Patient"], 400);
    if(!$this->CheckDateandTime($request['date'],$request['start_time']))
        return    response()->json(["message"=>"Can not make an appointment in a past date"], 400);
    $appointment=Appointment::create([
        'user_id'=>$request['user_id'],
        'doctor_id'=>$user->id,
        'start_time'=>$request['start_time'],
        'date'=>$request['date'],

    ]);
    return response()->json(['message'=>'Appointment Created Successfully','data'=>new AppointmentResource($appointment)]);

}
function destroy(Appointment $appointment){
    if($appointment==null) return response()->json(["error"=>'Appointment not found '] , '404');
    $appointment->delete();
    return response()->json(['message'=>'Successfully Deleted'],200);
}
function update(Request $request ,Appointment $appointment){
    if($appointment==null) return response()->json(["error"=>'Appointment not found '] , '404');
    if(!$this->CheckDateandTime($request['date'],$request['start_time']))
        return    response()->json(["message"=>"Can not make an appointment in a past date"], 400);

    $appointment->fill($request->all())->save();
    return response()->json(['message'=>'Successfully Updated','data'=>$appointment],200);

}
}
