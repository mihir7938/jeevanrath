<?php

namespace App\Services;

use App\Models\Car;

class CarService
{

    public function getAllCars($per_page = -1)
    {
        if($per_page == -1){
            return Car::orderBy('created_at', 'desc')->get();    
        }
        return Car::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getCarById($id)
    {
        return Car::find($id);
    }

    public function create($data)
    {
        return Car::create($data);
    }

    public function update($cars, $data)
    {
        return $cars->update($data);
    }

    public function delete($cars)
    {
        return $cars->delete($cars);
    }
}
