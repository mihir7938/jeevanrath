<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\TypeService;
use App\Services\VehicleService;
use App\Services\VehicleDetailService;
use App\Models\State;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $cityService, $typeService, $vehicleService, $vehicleDetailService;

    public function __construct (
        CityService $cityService,
        TypeService $typeService,
        VehicleService $vehicleService,
        VehicleDetailService $vehicleDetailService
    )
    {
        $this->cityService = $cityService;
        $this->typeService = $typeService;
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
    public function searchRental(Request $request)
    {
        $states = State::all();
        $types = $this->typeService->getAllTypes();
        $vehicle_details = $this->vehicleDetailService->getAllVehicleByCat(1);
        return view('search-rental')->with('states', $states)->with('types', $types)->with('vehicle_details', $vehicle_details);
    }
    public function getRentalResults(Request $request)
    {
        $vehicle_details = $this->vehicleDetailService->getRentalResults($request, 1);
        return view('search.rental')->with('vehicle_details', $vehicle_details)->render();
    }
    public function searchFixed(Request $request)
    {
        $states = State::all();
        $vehicle_details = $this->vehicleDetailService->getAllVehicleByCat(2);
        return view('search-fixed')->with('states', $states)->with('vehicle_details', $vehicle_details);
    }
    public function getFixedResults(Request $request)
    {
        $vehicle_details = $this->vehicleDetailService->getFixedResults($request, 2);
        return view('search.fixed')->with('vehicle_details', $vehicle_details)->render();
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
