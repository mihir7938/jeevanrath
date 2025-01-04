<?php

namespace App\Services;

use App\Models\VehicleDetails;

class VehicleDetailService
{

    public function getAllVehicleDetails($per_page = -1)
    {
        if($per_page == -1){
            return VehicleDetails::orderBy('created_at', 'desc')->get();    
        }
        return VehicleDetails::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getVehicleDetailById($id)
    {
        return VehicleDetails::find($id);
    }

    public function create($data)
    {
        return VehicleDetails::create($data);
    }

    public function update($vehicle_details, $data)
    {
        return $vehicle_details->update($data);
    }

    public function delete($vehicle_details)
    {
        return $vehicle_details->delete($vehicle_details);
    }
}
