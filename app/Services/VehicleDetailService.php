<?php

namespace App\Services;

use App\Models\VehicleDetails;
use Illuminate\Http\Request;

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
    public function getAllVehicleByCat($cat_id, $per_page = -1)
    {
        if($per_page == -1){
            return VehicleDetails::orderBy('created_at', 'desc')->where('category_id', $cat_id)->get();    
        }
        return VehicleDetails::orderBy('created_at', 'desc')->where('category_id', $cat_id)->paginate($per_page);
    }
    public function getRentalResults(Request $request, $cat_id)
    {
        $query = VehicleDetails::where('category_id', $cat_id);
        if($request->has('state') && $request->state){
            $query = $query->where('state_id', $request->state);
        }
        if($request->has('city') && $request->city){
            $query = $query->where('city_id', $request->city);
        }
        if($request->has('type') && $request->type){
            $query = $query->where('type_id', $request->type);
        }
        if($request->has('vehicle_name') && $request->vehicle_name){
            $query = $query->where('vehicle_id', $request->vehicle_name);
        }
        return $query->select('*')->get();
    }
    public function getFixedResults(Request $request, $cat_id)
    {
        $query = VehicleDetails::where('category_id', $cat_id);
        if($request->has('state') && $request->state){
            $query = $query->where('state_id', $request->state);
        }
        if($request->has('city') && $request->city){
            $query = $query->where('city_id', $request->city);
        }
        return $query->select('*')->get();
    }
}
