<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\VehicleService;
use App\Services\VehicleDetailService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $cityService, $vehicleService, $vehicleDetailService;

    public function __construct (
        CityService $cityService,
        VehicleService $vehicleService,
        VehicleDetailService $vehicleDetailService
    )
    {
        $this->cityService = $cityService;
        $this->vehicleService = $vehicleService;
        $this->vehicleDetailService = $vehicleDetailService;
    }

    public function index(Request $request)
    {
        $vehicle_details = $this->vehicleDetailService->getAllVehicleByCat(1,6);
        $fixed_vehicles = $this->vehicleDetailService->getAllVehicleByCat(2,3);
        return view('index')->with('fixed_vehicles', $fixed_vehicles)->with('vehicle_details', $vehicle_details);
    }
    public function about(Request $request)
    {
        return view('about');
    }
    public function contact(Request $request)
    {
        return view('contact');
    }
    public function getCitiesByState(Request $request)
    {
        $cities = $this->cityService->getCitiesByState($request->state_id);
        return response()->json(['status' => true, 'cities' => $cities]);
    }
    public function getVehiclesByType(Request $request)
    {
        $vehicles = $this->vehicleService->getVehiclesByType($request->type_id);
        return response()->json(['status' => true, 'vehicles' => $vehicles]);
    }
}
