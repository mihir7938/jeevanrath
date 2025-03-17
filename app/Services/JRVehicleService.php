<?php

namespace App\Services;

use App\Models\JRVehicle;

class JRVehicleService
{

    public function getAllJRVehicles($per_page = -1)
    {
        if($per_page == -1){
            return JRVehicle::orderBy('created_at', 'desc')->get();    
        }
        return JRVehicle::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getJRVehicleById($id)
    {
        return JRVehicle::find($id);
    }

    public function create($data)
    {
        return JRVehicle::create($data);
    }

    public function update($jrvehicles, $data)
    {
        return $jrvehicles->update($data);
    }

    public function delete($jrvehicles)
    {
        return $jrvehicles->delete($jrvehicles);
    }
}
