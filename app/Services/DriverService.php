<?php

namespace App\Services;

use App\Models\Driver;

class DriverService
{

    public function getAllDrivers($per_page = -1)
    {
        if($per_page == -1){
            return Driver::orderBy('created_at', 'desc')->get();    
        }
        return Driver::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getDriverById($id)
    {
        return Driver::find($id);
    }

    public function create($data)
    {
        return Driver::create($data);
    }

    public function update($drivers, $data)
    {
        return $drivers->update($data);
    }

    public function delete($drivers)
    {
        return $drivers->delete($drivers);
    }
}
