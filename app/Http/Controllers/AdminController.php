<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadImageService;
use App\Services\CityService;
use App\Services\TypeService;
use App\Services\VehicleService;
use App\Services\CategoryService;
use App\Services\CarService;
use App\Models\State;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AdminController extends Controller 
{
    private $imageService, $cityService, $typeService, $vehicleService, $categoryService, $carService;

    public function __construct ( 
        UploadImageService $imageService,
        CityService $cityService,
        TypeService $typeService,
        VehicleService $vehicleService,
        CategoryService $categoryService,
        CarService $carService
    )
    {
        $this->imageService = $imageService;
        $this->cityService = $cityService;
        $this->typeService = $typeService;
        $this->vehicleService = $vehicleService;
        $this->categoryService = $categoryService;
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
    public function editCity(Request $request, $id)
    {
        try{
            $city = $this->cityService->getCityById($id);
            if(!$city){
                throw new BadRequestException('Invalid Request id');
            }
            $states = State::all();
            return view('admin.cities.edit')->with('city', $city)->with('states', $states);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cities');
        }
    }
    public function updateCity(Request $request)
    {
        try{
            $city = $this->cityService->getCityById($request->id);
            if(!$city){
                throw new BadRequestException('Invalid Request id');
            }
            $data['state_id'] = $request->state;
            $data['name'] = $request->city;
            $this->cityService->update($city, $data);
            $request->session()->put('message', 'City has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.cities');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.cities');
        }
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
    public function types(Request $request)
    {
        $types = $this->typeService->getAllTypes();
        return view('admin.types.index')->with('types', $types);
    }
    public function addType(Request $request)
    {
        return view('admin.types.add');
    }
    public function saveType(Request $request)
    {
        $data['name'] = $request->type;
        $this->typeService->create($data);
        $request->session()->put('message', 'Vehicle Type has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.types');
    }
    public function editType(Request $request, $id)
    {
        try{
            $type = $this->typeService->getTypeById($id);
            if(!$type){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.types.edit')->with('type', $type);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.types');
        }
    }
    public function updateType(Request $request)
    {
        try{
            $type = $this->typeService->getTypeById($request->id);
            if(!$type){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->type;
            $this->typeService->update($type, $data);
            $request->session()->put('message', 'Vehicle Type has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.types');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.types');
        }
    }
    public function deleteType(Request $request, $id)
    {
        try{
            $type = $this->typeService->getTypeById($id);
            if(!$type){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->typeService->delete($type);
            $request->session()->put('message', 'Vehicle Type has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.types');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.types');
        }
    }
    public function vehicles(Request $request)
    {
        $vehicles = $this->vehicleService->getAllVehicles();
        return view('admin.vehicles.index')->with('vehicles', $vehicles);
    }
    public function addVehicle(Request $request)
    {
        $types = $this->typeService->getAllTypes();
        return view('admin.vehicles.add')->with('types', $types);
    }
    public function saveVehicle(Request $request)
    {
        $data['type_id'] = $request->type;
        $data['name'] = $request->name;
        $this->vehicleService->create($data);
        $request->session()->put('message', 'Vehicle has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.vehicles');
    }
    public function editVehicle(Request $request, $id)
    {
        try{
            $vehicle = $this->vehicleService->getVehicleById($id);
            if(!$vehicle){
                throw new BadRequestException('Invalid Request id');
            }
            $types = $this->typeService->getAllTypes();
            return view('admin.vehicles.edit')->with('vehicle', $vehicle)->with('types', $types);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.vehicles');
        }
    }
    public function updateVehicle(Request $request)
    {
        try{
            $vehicle = $this->vehicleService->getVehicleById($request->id);
            if(!$vehicle){
                throw new BadRequestException('Invalid Request id');
            }
            $data['type_id'] = $request->type;
            $data['name'] = $request->name;
            $this->vehicleService->update($vehicle, $data);
            $request->session()->put('message', 'Vehicle has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.vehicles');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.vehicles');
        }
    }
    public function deleteVehicle(Request $request, $id)
    {
        try{
            $vehicle = $this->vehicleService->getVehicleById($id);
            if(!$vehicle){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->vehicleService->delete($vehicle);
            $request->session()->put('message', 'Vehicle has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.vehicles');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.vehicles');
        }
    }
    public function categories(Request $request)
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.categories.index')->with('categories', $categories);
    }
    public function addCategory(Request $request)
    {
        return view('admin.categories.add');
    }
    public function saveCategory(Request $request)
    {
        $data['name'] = $request->name;
        $this->categoryService->create($data);
        $request->session()->put('message', 'Category has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.categories');
    }
    public function editCategory(Request $request, $id)
    {
        try{
            $category = $this->categoryService->getCategoryById($id);
            if(!$category){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.categories.edit')->with('category', $category);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.categories');
        }
    }
    public function updateCategory(Request $request)
    {
        try{
            $category = $this->categoryService->getCategoryById($request->id);
            if(!$category){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->categoryService->update($category, $data);
            $request->session()->put('message', 'Category has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.categories');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.categories');
        }
    }
    public function deleteCategory(Request $request, $id)
    {
        try{
            $category = $this->categoryService->getCategoryById($id);
            if(!$category){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->categoryService->delete($category);
            $request->session()->put('message', 'Category has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.categories');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.categories');
        }
    }
    public function cars(Request $request)
    {
        $cars = $this->carService->getAllCars();
        return view('admin.cars.index')->with('cars', $cars);
    }
    public function addCar(Request $request)
    {
        $states = State::all();
        $types = $this->typeService->getAllTypes();
        return view('admin.cars.add')->with('states', $states)->with('types', $types);
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