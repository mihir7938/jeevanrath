<?php

namespace App\Services;

use App\Models\DriverDuty;

class DriverDutyService
{

    public function getAllDriverDuties($per_page = -1)
    {
        if($per_page == -1){
            return DriverDuty::orderBy('created_at', 'desc')->get();    
        }
        return DriverDuty::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getDriverDutyById($id)
    {
        return DriverDuty::find($id);
    }

    public function getDriverDutyByBookingId($booking_id)
    {
        return DriverDuty::where('booking_id', $booking_id)->first();
    }

    public function create($data)
    {
        return DriverDuty::create($data);
    }

    public function update($driver_duties, $data)
    {
        return $driver_duties->update($data);
    }

    public function delete($driver_duties)
    {
        return $driver_duties->delete($driver_duties);
    }
}
