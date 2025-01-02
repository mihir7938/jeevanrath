<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\VehicleService;
use App\Services\CarService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $cityService, $vehicleService, $carService;

    public function __construct (
        CityService $cityService,
        VehicleService $vehicleService,
        CarService $carService
    )
    {
        $this->cityService = $cityService;
        $this->vehicleService = $vehicleService;
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        $cars = $this->carService->getAllCars();
        return view('index')->with('cars', $cars);
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
