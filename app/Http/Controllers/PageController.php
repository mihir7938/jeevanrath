<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CarService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $carService;

    public function __construct (
        CarService $carService
    )
    {
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
}
