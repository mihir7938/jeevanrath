<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UploadImageService;
use App\Services\EnquiryService;
use App\Services\CityService;
use App\Services\TypeService;
use App\Services\VehicleService;
use App\Services\CategoryService;
use App\Services\VehicleDetailService;
use App\Services\DriverService;
use App\Services\UserService;
use App\Models\State;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AdminController extends Controller 
{
    private $imageService, $enquiryService, $cityService, $typeService, $vehicleService, $categoryService, $vehicleDetailService, $driverService, $userService;

    public function __construct ( 
        UploadImageService $imageService,
        EnquiryService $enquiryService,
        CityService $cityService,
        TypeService $typeService,
        VehicleService $vehicleService,
        CategoryService $categoryService,
        VehicleDetailService $vehicleDetailService,
        DriverService $driverService,
        UserService $userService
    )
    {
        $this->imageService = $imageService;
        $this->enquiryService = $enquiryService;
        $this->cityService = $cityService;
        $this->typeService = $typeService;
        $this->vehicleService = $vehicleService;
        $this->categoryService = $categoryService;
        $this->vehicleDetailService = $vehicleDetailService;
        $this->driverService = $driverService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $enquiries = $this->enquiryService->getAllEnquiriesByStatus(2);
        return view('admin.index')->with('enquiries', $enquiries);
    }
    public function fetchInquiries(Request $request)
    {
        $enquiries = $this->enquiryService->getAllEnquiriesByFilter($request);
        return view('admin.search-result')->with('enquiries', $enquiries)->render();
    }
    public function editInquiry(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getEnquiryById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $drivers = $this->driverService->getAllDrivers();
            return view('admin.edit-enquiry')->with('enquiry', $enquiry)->with('drivers', $drivers);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.inquiries.all');
        }
    }
    public function updateInquiry(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getEnquiryById($request->id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $data['status'] = $request->status;
            if($request->user_type == 'Company') {
                $data['company_name'] = $request->company_name;
            }
            if($request->status == '2') {
                $data['driver_id'] = $request->driver;
                $data['vehicle_number'] = $request->vehicle_number;
                $data['pickup_location'] = $request->pickup_location;
                $data['pickup_time'] = $request->pickup_time;
                $data['end_journey_date'] = date('Y-m-d', strtotime(strtr($request->end_journey_date, '/', '-')));
                $diff = strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $request->end_journey_date)))) - strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $request->journey_date))));
                $total_days = floor($diff / (60 * 60 * 24));
                $data['total_days'] = $total_days + 1;
            }
            $data['name'] = $request->name;
            $data['journey_date'] = date('Y-m-d', strtotime(strtr($request->journey_date, '/', '-')));
            $data['mobile_number'] = $request->mobile;
            $data['email'] = $request->email;
            $data['pickup_from'] = $request->pickup_from;
            $data['drop_to'] = $request->drop_to;
            $data['vehicle_name'] = $request->car;
            $data['journey_type'] = $request->journey_type;
            $this->enquiryService->update($enquiry, $data);
            $request->session()->put('message', 'Inquiry has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.inquiries.all');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.inquiries.all');
        }
    }
    public function deleteInquiry(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getEnquiryById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->enquiryService->delete($enquiry);
            $request->session()->put('message', 'Inquiry has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.index');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.index');
        }
    }
    public function allInquiry(Request $request)
    {
        $enquiries = $this->enquiryService->getAllEnquiries();
        return view('admin.all')->with('enquiries', $enquiries);
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
    public function drivers(Request $request)
    {
        $drivers = $this->driverService->getAllDrivers();
        return view('admin.drivers.index')->with('drivers', $drivers);
    }
    public function addDriver(Request $request)
    {
        return view('admin.drivers.add');
    }
    public function saveDriver(UserRequest $request)
    {
        $data = $request->all();
        $role_id = Role::USER_ROLE_ID;
        $password = 'jr'.substr($request->phone, -3);
        $user = $this->userService->create($request, $role_id, $password);
        $user_id = $user->id;
        $data['user_id'] = $user_id;
        $data['mobile_number'] = $request->phone;
        $filename = $this->imageService->uploadFile($request->id_proof_document, "assets/drivers");
        $data['id_proof_document'] = '/drivers/'.$filename;
        $this->driverService->create($data);
        $request->session()->put('message', 'Driver/Vendor has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.drivers');
    }
    public function editDriver(Request $request, $id)
    {
        try{
            $driver = $this->driverService->getDriverById($id);
            if(!$driver){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.drivers.edit')->with('driver', $driver);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.drivers');
        }
    }
    public function updateDriver(Request $request)
    {
        try{
            $driver = $this->driverService->getDriverById($request->id);
            if(!$driver){
                throw new BadRequestException('Invalid Request id');
            }
            $data['type'] = $request->type;
            $data['name'] = $request->name;
            $data['address'] = $request->address;
            $data['alternative_number'] = $request->alternative_number;
            $data['id_proof'] = $request->id_proof;
            if($request->has('id_proof_document')){
                $filepath = public_path('assets/' . $driver->id_proof_document);
                $this->imageService->deleteFile($filepath);
                $filename = $this->imageService->uploadFile($request->id_proof_document, "assets/drivers");
                $data['id_proof_document'] = '/drivers/'.$filename;
            }
            $this->driverService->update($driver, $data);
            $user_id = $driver->user_id;
            $user = $this->userService->getUserById($user_id);
            $userdata['name'] = $request->name;
            $userdata['email'] = $request->email;
            $userdata['status'] = $request->active;
            $this->userService->update($user, $userdata);
            $request->session()->put('message', 'Driver/Vendor has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.drivers');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.drivers');
        }
    }
    public function deleteDriver(Request $request, $id)
    {
        try{
            $driver = $this->driverService->getDriverById($id);
            if(!$driver){
                throw new BadRequestException('Invalid Request id.');
            }
            $filepath = public_path('assets/' . $driver->id_proof_document);
            $this->imageService->deleteFile($filepath);
            $this->driverService->delete($driver);
            $user = $this->userService->getUserById($driver->user_id);
            $this->userService->delete($user);
            $request->session()->put('message', 'Driver/Vendor has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.drivers');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.drivers');
        }
    }
    public function getUsers()
    {
        $role_id = Role::ADMIN_ROLE_ID;
        $users = $this->userService->getAllUsers($role_id);
        return view('admin.users.index')->with('users', $users);
    }
    public function addUser()
    {
        return view('admin.users.add');
    }
    public function saveUser(UserRequest $request)
    {
        $role_id = Role::ADMIN_ROLE_ID;
        $user = $this->userService->create($request, $role_id);
        $request->session()->put('message', 'Admin has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.users');
    }
    public function editUser(Request $request, $id)
    {
        try{
            $user = $this->userService->getUserById($id);
            if(!$user){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.users.edit')->with('user', $user);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.users');
        }
    }
    public function updateUser(Request $request)
    {
        try{
            $user = $this->userService->getUserById($request->id);
            if(!$user){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['status'] = $request->active;
            $this->userService->update($user, $data);
            $request->session()->put('message', 'Admin has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.users');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.users');
        }
    }
    public function changePassword(Request $request, $id)
    {
        try{
            $user = $this->userService->getUserById($id);
            if(!$user){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.users.change-password')->with('user', $user);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function updateChangePassword(Request $request)
    {
        try {
            $user = $this->userService->getUserById($request->id);
            if ($user) {
                $data['password'] = Hash::make($request->password);
                $this->userService->update($user, $data);
                $request->session()->put('message', 'Password has been changed successfully.');
                $request->session()->put('alert-type', 'alert-success');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function allVehicles(Request $request)
    {
        $categories = $this->categoryService->getAllCategories();
        $vehicles = '';
        $category_id = '';
        return view('admin.vehicle_details.index')->with('categories', $categories)->with('vehicles', $vehicles)->with('category_id', $category_id);
    }
    public function fetchListByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $vehicles = '';
        if($category_id == 1) {
            $vehicles = $this->vehicleDetailService->getAllVehicleByCat($category_id);
        } elseif($category_id == 2) {
            $vehicles = $this->vehicleDetailService->getAllVehicleByCat($category_id);
        }
        return view('admin.vehicle_details.list')->with('category_id', $category_id)->with('vehicles', $vehicles)->render();
    }
    public function addVehicleDetails(Request $request)
    {
        $states = State::all();
        $types = $this->typeService->getAllTypes();
        $categories = $this->categoryService->getAllCategories();
        $category_id = '';
        return view('admin.vehicle_details.add')->with('states', $states)->with('types', $types)->with('categories', $categories)->with('category_id', $category_id);
    }
    public function saveVehicleDetails(Request $request)
    {
        $data['state_id'] = $request->state;
        $data['city_id'] = $request->city;
        $data['category_id'] = $request->category;
        if($request->category == 1) {
            $data['type_id'] = $request->type;
            $data['vehicle_id'] = $request->vehicle_name;
            $data['rate'] = $request->rate;
            $data['taxi_doors'] = $request->taxi_doors;
            $data['passengers'] = $request->passengers;
            $data['luggage_carry'] = $request->luggage_carry;
            $data['air_condition'] = $request->air_condition;
            $data['gps_navigation'] = $request->gps_navigation;
            $filename = $this->imageService->uploadFile($request->image, "assets/vehicles/rental");
            $data['vehicle_image'] = '/vehicles/rental/'.$filename;
        } elseif($request->category == 2) {
            $data['origin_trip'] = $request->origin_trip;
            $data['return_trip'] = $request->return_trip;
            $data['vehicle1'] = $request->vehicle1;
            $data['rate1'] = $request->rate1;
            $data['vehicle2'] = $request->vehicle2;
            $data['rate2'] = $request->rate2;
            $data['vehicle3'] = $request->vehicle3;
            $data['rate3'] = $request->rate3;
            $data['vehicle4'] = $request->vehicle4;
            $data['rate4'] = $request->rate4;
            $data['vehicle5'] = $request->vehicle5;
            $data['rate5'] = $request->rate5;
            $filename = $this->imageService->uploadFile($request->image, "assets/vehicles/fixed");
            $data['vehicle_image'] = '/vehicles/fixed/'.$filename;
        }
        $this->vehicleDetailService->create($data);
        $request->session()->put('message', 'Vehicle details has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.details.add');
    }
    public function editVehicleDetails(Request $request, $id)
    {
        try{
            $vehicle_detail = $this->vehicleDetailService->getVehicleDetailById($id);
            if(!$vehicle_detail){
                throw new BadRequestException('Invalid Request id');
            }
            $states = State::all();
            $cities = $this->cityService->getCitiesByState($vehicle_detail->state_id);
            $types = $this->typeService->getAllTypes();
            $vehicles = $this->vehicleService->getVehiclesByType($vehicle_detail->type_id);
            $categories = $this->categoryService->getAllCategories();
            $category_id = '';
            return view('admin.vehicle_details.edit')->with('vehicle_detail', $vehicle_detail)->with('states', $states)->with('cities', $cities)->with('types', $types)->with('vehicles', $vehicles)->with('categories', $categories)->with('category_id', $category_id);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.details');
        }
    }
    public function updateVehicleDetails(Request $request)
    {
        try{
            $vehicle_detail = $this->vehicleDetailService->getVehicleDetailById($request->id);
            if(!$vehicle_detail){
                throw new BadRequestException('Invalid Request id');
            }
            $data['state_id'] = $request->state;
            $data['city_id'] = $request->city;
            $data['category_id'] = $request->category_id;
            if($request->category_id == 1) {
                $data['type_id'] = $request->type;
                $data['vehicle_id'] = $request->vehicle_name;
                $data['rate'] = $request->rate;
                $data['taxi_doors'] = $request->taxi_doors;
                $data['passengers'] = $request->passengers;
                $data['luggage_carry'] = $request->luggage_carry;
                $data['air_condition'] = $request->air_condition;
                $data['gps_navigation'] = $request->gps_navigation;
                if($request->has('image')){
                    $filepath = public_path('assets/' . $vehicle_detail->vehicle_image);
                    $this->imageService->deleteFile($filepath);
                    $filename = $this->imageService->uploadFile($request->image, "assets/vehicles/rental");
                    $data['vehicle_image'] = '/vehicles/rental/'.$filename;
                }
            } elseif($request->category_id == 2) {
                $data['origin_trip'] = $request->origin_trip;
                $data['return_trip'] = $request->return_trip;
                $data['vehicle1'] = $request->vehicle1;
                $data['rate1'] = $request->rate1;
                $data['vehicle2'] = $request->vehicle2;
                $data['rate2'] = $request->rate2;
                $data['vehicle3'] = $request->vehicle3;
                $data['rate3'] = $request->rate3;
                $data['vehicle4'] = $request->vehicle4;
                $data['rate4'] = $request->rate4;
                $data['vehicle5'] = $request->vehicle5;
                $data['rate5'] = $request->rate5;
                if($request->has('image')){
                    $filepath = public_path('assets/' . $vehicle_detail->vehicle_image);
                    $this->imageService->deleteFile($filepath);
                    $filename = $this->imageService->uploadFile($request->image, "assets/vehicles/fixed");
                    $data['vehicle_image'] = '/vehicles/fixed/'.$filename;
                }
            }
            $this->vehicleDetailService->update($vehicle_detail, $data);
            $request->session()->put('message', 'Vehicle details has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.details.edit', ['id' => $request->id]);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.details');
        }
    }
    public function deleteVehicleDetails(Request $request, $id)
    {
        try{
            $vehicle_detail = $this->vehicleDetailService->getVehicleDetailById($id);
            if(!$vehicle_detail){
                throw new BadRequestException('Invalid Request id.');
            }
            $filepath = public_path('assets/' . $vehicle_detail->vehicle_image);
            $this->imageService->deleteFile($filepath);
            $this->vehicleDetailService->delete($vehicle_detail);
            $request->session()->put('message', 'Vehicle detail has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.details');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.details');
        }
    }
    public function fetchDetailsByCategory(Request $request)
    {
        $category_id = $request->category_id;
        $types = $this->typeService->getAllTypes();
        return view('admin.vehicle_details.details-form')->with('category_id', $category_id)->with('types', $types)->render();
    }
}