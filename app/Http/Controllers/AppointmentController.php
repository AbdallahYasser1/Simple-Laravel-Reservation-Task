<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmnetStoreRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\AppointmentTrait;
class AppointmentController extends Controller
{
    use AppointmentTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Query Parameters to filter by date
        $date = $request->query('date');

        $appointments=Appointment::where('user_id',auth()->id());
        if($date !=null)
            $appointments->where('date',$date);
        return $appointments->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AppointmnetStoreRequest $request,User $user)
    {

        if(!$user->hasRole('Doctor'))
        return response()->json(["message"=>"The user is not a doctor"], 400);
        if(!$this->CheckDateandTime($request['date'],$request['start_time']))
            return    response()->json(["message"=>"Can not make an appointment in a past date"], 400);
        if(!User::find(auth()->id())->hasRole('Patient'))
            return response()->json(["message"=>"The user is not a patient with this identifier"], 400);
        $appointment=Appointment::create([
    'user_id'=>auth()->id(),
    'doctor_id'=>$user->id,
    'start_time'=>$request['start_time'],
    'date'=>$request['date'],

]);
return response()->json(['message'=>'Appointment Created Successfully','data'=>new AppointmentResource($appointment)]);
    }


    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
