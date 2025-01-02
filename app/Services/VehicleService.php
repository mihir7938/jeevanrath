<?php

namespace App\Services;

use App\Models\Vehicle;

class VehicleService
{

    public function getAllVehicles($per_page = -1)
    {
        if($per_page == -1){
            return Vehicle::orderBy('created_at', 'desc')->get();    
        }
        return Vehicle::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getVehicleById($id)
    {
        return Vehicle::find($id);
    }

    public function create($data)
    {
        return Vehicle::create($data);
    }

    public function update($vehicles, $data)
    {
        return $vehicles->update($data);
    }

    public function delete($vehicles)
    {
        return $vehicles->delete($vehicles);
    }

    public function getVehiclesByType($type_id){
        return Vehicle::where('type_id', $type_id)->get();
    }
}
