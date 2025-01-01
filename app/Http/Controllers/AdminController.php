<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadImageService;
use App\Services\CityService;
use App\Services\CarService;
use App\Models\State;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AdminController extends Controller 
{
    private $imageService, $cityService, $carService;

    public function __construct ( 
        UploadImageService $imageService,
        CityService $cityService,
        CarService $carService
    )
    {
        $this->imageService = $imageService;
        $this->cityService = $cityService;
        $this->carService = $carService;
    }

    public function index(Request $request)
    {
        return view('admin.index');
    }
    public function cities(Request $request)
    {
        $cities = $this->cityService->getAllCities();
        return view('admin.cities.index')->with('cities', $cities);
    }
    public function addCity(Request $request)
    {
        $states = State::all();
        return view('admin.cities.add')->with('states', $states);
    }
    public function saveCity(Request $request)
    {
        $data = $request->all();
        $data['state_id'] = $request->state;
        $data['name'] = $request->city;
        $this->cityService->create($data);
        $request->session()->put('message', 'City has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.cities');
    }
    public function deleteCity(Request $request, $id)
    {
        try{
            $city = $this->cityService->getCityById($id);
            if(!$city){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->cityService->delete($city);
            $request->session()->put('message', 'City has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.cities');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cities');
        }
    }
    public function cars(Request $request)
    {
        $cars = $this->carService->getAllCars();
        return view('admin.cars.index')->with('cars', $cars);
    }
    public function addCar(Request $request)
    {
        return view('admin.cars.add');
    }
    public function saveCar(Request $request)
    {
        $data['car_name'] = $request->car_name;
        $data['rate'] = $request->rate;
        $data['taxi_doors'] = $request->taxi_doors;
        $data['passengers'] = $request->passengers;
        $data['luggage_carry'] = $request->luggage_carry;
        $data['air_condition'] = $request->air_condition;
        $data['gps_navigation'] = $request->gps_navigation;
        $filename = $this->imageService->uploadFile($request->image, "assets/cars");
        $data['car_image'] = '/cars/'.$filename;
        $this->carService->create($data);
        $request->session()->put('message', 'Car details has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.cars.add');
    }
    public function editCar(Request $request, $id)
    {
        try{
            $car = $this->carService->getCarById($id);
            if(!$car){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.cars.edit')->with('car', $car);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cars');
        }
    }
    public function updateCar(Request $request)
    {
        try{
            $car = $this->carService->getCarById($request->id);
            if(!$car){
                throw new BadRequestException('Invalid Request id');
            }
            $data['car_name'] = $request->car_name;
            $data['rate'] = $request->rate;
            $data['taxi_doors'] = $request->taxi_doors;
            $data['passengers'] = $request->passengers;
            $data['luggage_carry'] = $request->luggage_carry;
            $data['air_condition'] = $request->air_condition;
            $data['gps_navigation'] = $request->gps_navigation;
            if($request->has('image')){
                $filepath = public_path('assets/' . $car->car_image);
                $this->imageService->deleteFile($filepath);
                $filename = $this->imageService->uploadFile($request->image, "assets/cars");
                $data['car_image'] = '/cars/'.$filename;
            }
            $this->carService->update($car, $data);
            $request->session()->put('message', 'Car details has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.cars');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cars');
        }
    }
    public function deleteCar(Request $request, $id)
    {
        try{
            $car = $this->carService->getCarById($id);
            if(!$car){
                throw new BadRequestException('Invalid Request id.');
            }
            $filepath = public_path('assets/' . $car->car_image);
            $this->imageService->deleteFile($filepath);
            $this->carService->delete($car);
            $request->session()->put('message', 'Car has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.cars');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cars');
        }
    }
}