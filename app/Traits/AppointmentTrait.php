<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
trait AppointmentTrait{
    public function CheckDateandTime($date,$time){
        $timeOfDate = date('Y-m-d', time());
        $DateOfAppointment= date('Y-m-d', strtotime($date));
        if ($DateOfAppointment < $timeOfDate)
            return false;
        $timeofAppointment = date('H', strtotime($time));// start time of shift
        $now = date('H', time()); // time now
        if( $DateOfAppointment == $timeOfDate && !($timeofAppointment - $now > 0) )
            return false;
        return true;
    }
}
