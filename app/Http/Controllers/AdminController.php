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
use App\Services\VendorService;
use App\Services\CompanyService;
use App\Services\JRVehicleService;
use App\Services\UserService;
use App\Services\WhatsappService;
use App\Models\State;
use App\Models\Role;
use App\Models\Whatsapp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AdminController extends Controller 
{
    private $imageService, $enquiryService, $cityService, $typeService, $vehicleService, $categoryService, $vehicleDetailService, $driverService, $vendorService, $companyService, $jRVehicleService, $userService, $whatsappService;

    public function __construct ( 
        UploadImageService $imageService,
        EnquiryService $enquiryService,
        CityService $cityService,
        TypeService $typeService,
        VehicleService $vehicleService,
        CategoryService $categoryService,
        VehicleDetailService $vehicleDetailService,
        DriverService $driverService,
        VendorService $vendorService,
        CompanyService $companyService,
        JRVehicleService $jRVehicleService,
        UserService $userService,
        WhatsappService $whatsappService
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
        $this->vendorService = $vendorService;
        $this->companyService = $companyService;
        $this->jRVehicleService = $jRVehicleService;
        $this->userService = $userService;
        $this->whatsappService = $whatsappService;
    }

    public function index(Request $request)
    {
        $status = array(2,3);
        $enquiries = $this->enquiryService->getAllEnquiriesByStatus($status);
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
            $vendors = $this->vendorService->getAllVendors();
            $drivers = $this->driverService->getAllDrivers();
            return view('admin.edit-enquiry')->with('enquiry', $enquiry)->with('vendors', $vendors)->with('drivers', $drivers);
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
                $data['booker_name'] = $request->booker_name;
                $data['booker_mobile'] = $request->booker_mobile;
            }
            if($request->status == '3') {
                $vendor_data = $this->vendorService->getVendorById($request->vendor);
                $driver_data = $this->driverService->getDriverById($request->driver);
                $data['vendor_id'] = $request->vendor;
                $data['vendor_name'] = $vendor_data->name;
                $data['driver_id'] = $request->driver;
                $data['driver_name'] = $driver_data->name;
                $data['vehicle_number'] = $request->vehicle_number;
            }
            $data['name'] = $request->name;
            $data['mobile_number'] = $request->mobile;
            $data['pickup_from'] = $request->pickup_from;
            $data['drop_to'] = $request->drop_to;
            $data['journey_date'] = date('Y-m-d', strtotime(strtr($request->journey_date, '/', '-')));
            $data['end_journey_date'] = date('Y-m-d', strtotime(strtr($request->end_journey_date, '/', '-')));
            $diff = strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $request->end_journey_date)))) - strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $request->journey_date))));
            $total_days = floor($diff / (60 * 60 * 24));
            $data['total_days'] = $total_days + 1;
            $data['vehicle_name'] = $request->car;
            $data['journey_type'] = $request->journey_type;
            $data['pickup_time'] = $request->pickup_time;
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
        $vendors = $this->vendorService->getAllVendors();
        return view('admin.drivers.add')->with('vendors', $vendors);
    }
    public function saveDriver(UserRequest $request)
    {
        $data = $request->all();
        $role_id = Role::USER_ROLE_ID;
        $password = 'jr'.substr($request->phone, -3);
        $user = $this->userService->create($request, $role_id, $password);
        $user_id = $user->id;
        $data['user_id'] = $user_id;
        $data['vendor_id'] = $request->vendor;
        $data['type'] = 'Driver';
        $data['mobile_number'] = $request->phone;
        if($request->has('id_proof_document')){
            $filename = $this->imageService->uploadFile($request->id_proof_document, "assets/drivers");
            $data['id_proof_document'] = '/drivers/'.$filename;
        }
        $this->driverService->create($data);
        $request->session()->put('message', 'Driver has been added successfully.');
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
            $vendors = $this->vendorService->getAllVendors();
            return view('admin.drivers.edit')->with('driver', $driver)->with('vendors', $vendors);
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
            $data['type'] = 'Driver';
            $data['vendor_id'] = $request->vendor;
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
            $request->session()->put('message', 'Driver has been updated successfully.');
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
            $request->session()->put('message', 'Driver has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.drivers');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.drivers');
        }
    }
    public function vendors(Request $request)
    {
        $vendors = $this->vendorService->getAllVendors();
        return view('admin.vendors.index')->with('vendors', $vendors);
    }
    public function addVendor(Request $request)
    {
        return view('admin.vendors.add');
    }
    public function saveVendor(Request $request)
    {
        $data = $request->all();
        $data['name'] = $request->name;
        $data['mobile_number'] = $request->phone;
        $data['email'] = $request->email;
        $this->vendorService->create($data);
        $request->session()->put('message', 'Vendor has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.vendors');
    }
    public function editVendor(Request $request, $id)
    {
        try{
            $vendor = $this->vendorService->getVendorById($id);
            if(!$vendor){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.vendors.edit')->with('vendor', $vendor);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.vendors');
        }
    }
    public function updateVendor(Request $request)
    {
        try{
            $vendor = $this->vendorService->getVendorById($request->id);
            if(!$vendor){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $data['mobile_number'] = $request->mobile_number;
            $data['email'] = $request->email;
            $this->vendorService->update($vendor, $data);
            $request->session()->put('message', 'Vendor has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.vendors');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.vendors');
        }
    }
    public function deleteVendor(Request $request, $id)
    {
        try{
            $vendor = $this->vendorService->getVendorById($id);
            if(!$vendor){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->vendorService->delete($vendor);
            $request->session()->put('message', 'Vendor has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.vendors');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.vendors');
        }
    }
    public function companies(Request $request)
    {
        $companies = $this->companyService->getAllCompanies();
        return view('admin.companies.index')->with('companies', $companies);
    }
    public function addCompany(Request $request)
    {
        return view('admin.companies.add');
    }
    public function saveCompany(Request $request)
    {
        $data['name'] = $request->name;
        $data['db_name'] = $request->db_name;
        $this->companyService->create($data);
        $request->session()->put('message', 'Company has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.companies');
    }
    public function editCompany(Request $request, $id)
    {
        try{
            $company = $this->companyService->getCompanyById($id);
            if(!$company){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.companies.edit')->with('company', $company);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.companies');
        }
    }
    public function updateCompany(Request $request)
    {
        try{
            $company = $this->companyService->getCompanyById($request->id);
            if(!$company){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $data['db_name'] = $request->db_name;
            $this->companyService->update($company, $data);
            $request->session()->put('message', 'Company has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.companies');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.companies');
        }
    }
    public function deleteCompany(Request $request, $id)
    {
        try{
            $company = $this->companyService->getCompanyById($id);
            if(!$company){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->companyService->delete($company);
            $request->session()->put('message', 'Company has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.companies');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.companies');
        }
    }
    public function jRVehicles(Request $request)
    {
        $jrvehicles = $this->jRVehicleService->getAllJRVehicles();
        return view('admin.jrvehicles.index')->with('jrvehicles', $jrvehicles);
    }
    public function addJRVehicle(Request $request)
    {
        $states = State::all();
        return view('admin.jrvehicles.add')->with('states', $states);
    }
    public function saveJRVehicle(Request $request)
    {
        $data['vehicle_name'] = $request->vehicle_name;
        $data['owner_name'] = $request->owner_name;
        $data['mobile_number'] = $request->phone;
        $data['alternative_number'] = $request->alternative_number;
        $data['city_id'] = $request->city;
        $data['vehicle_number'] = $request->vehicle_number;
        $this->jRVehicleService->create($data);
        $request->session()->put('message', 'Vehicle has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.jrvehicles');
    }
    public function editJRVehicle(Request $request, $id)
    {
        try{
            $jrvehicle = $this->jRVehicleService->getJRVehicleById($id);
            if(!$jrvehicle){
                throw new BadRequestException('Invalid Request id');
            }
            $states = State::all();
            $cities = $this->cityService->getCitiesByState($jrvehicle->cities->state_id);
            return view('admin.jrvehicles.edit')->with('jrvehicle', $jrvehicle)->with('states', $states)->with('cities', $cities);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.jrvehicles');
        }
    }
    public function updateJRVehicle(Request $request)
    {
        try{
            $jrvehicle = $this->jRVehicleService->getJRVehicleById($request->id);
            if(!$jrvehicle){
                throw new BadRequestException('Invalid Request id');
            }
            $data['vehicle_name'] = $request->vehicle_name;
            $data['owner_name'] = $request->owner_name;
            $data['mobile_number'] = $request->phone;
            $data['alternative_number'] = $request->alternative_number;
            $data['city_id'] = $request->city;
            $data['vehicle_number'] = $request->vehicle_number;
            $this->jRVehicleService->update($jrvehicle, $data);
            $request->session()->put('message', 'Vehicle has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.jrvehicles');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.jrvehicles');
        }
    }
    public function deleteJRVehicle(Request $request, $id)
    {
        try{
            $jrvehicle = $this->jRVehicleService->getJRVehicleById($id);
            if(!$jrvehicle){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->jRVehicleService->delete($jrvehicle);
            $request->session()->put('message', 'Vehicle has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.jrvehicles');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.jrvehicles');
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
            $filename1 = $this->imageService->uploadFile($request->image1, "assets/vehicles/fixed");
            $data['fixed_image_1'] = '/vehicles/fixed/'.$filename1;
            if($request->has('image2')){
                $filename2 = $this->imageService->uploadFile($request->image2, "assets/vehicles/fixed");
                $data['fixed_image_2'] = '/vehicles/fixed/'.$filename2;
            }
            if($request->has('image3')){
                $filename3 = $this->imageService->uploadFile($request->image3, "assets/vehicles/fixed");
                $data['fixed_image_3'] = '/vehicles/fixed/'.$filename3;
            }
            if($request->has('image4')){
                $filename4 = $this->imageService->uploadFile($request->image4, "assets/vehicles/fixed");
                $data['fixed_image_4'] = '/vehicles/fixed/'.$filename4;
            }
            if($request->has('image5')){
                $filename5 = $this->imageService->uploadFile($request->image5, "assets/vehicles/fixed");
                $data['fixed_image_5'] = '/vehicles/fixed/'.$filename5;
            }
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
                if($request->has('image1')){
                    $filepath1 = public_path('assets/' . $vehicle_detail->fixed_image_1);
                    $this->imageService->deleteFile($filepath1);
                    $filename1 = $this->imageService->uploadFile($request->image1, "assets/vehicles/fixed");
                    $data['fixed_image_1'] = '/vehicles/fixed/'.$filename1;
                }
                if($request->has('image2')){
                    $filepath2 = public_path('assets/' . $vehicle_detail->fixed_image_2);
                    $this->imageService->deleteFile($filepath2);
                    $filename2 = $this->imageService->uploadFile($request->image2, "assets/vehicles/fixed");
                    $data['fixed_image_2'] = '/vehicles/fixed/'.$filename2;
                }
                if($request->has('image3')){
                    $filepath3 = public_path('assets/' . $vehicle_detail->fixed_image_3);
                    $this->imageService->deleteFile($filepath3);
                    $filename3 = $this->imageService->uploadFile($request->image3, "assets/vehicles/fixed");
                    $data['fixed_image_3'] = '/vehicles/fixed/'.$filename3;
                }
                if($request->has('image4')){
                    $filepath4 = public_path('assets/' . $vehicle_detail->fixed_image_4);
                    $this->imageService->deleteFile($filepath4);
                    $filename4 = $this->imageService->uploadFile($request->image4, "assets/vehicles/fixed");
                    $data['fixed_image_4'] = '/vehicles/fixed/'.$filename4;
                }
                if($request->has('image5')){
                    $filepath5 = public_path('assets/' . $vehicle_detail->fixed_image_5);
                    $this->imageService->deleteFile($filepath5);
                    $filename5 = $this->imageService->uploadFile($request->image5, "assets/vehicles/fixed");
                    $data['fixed_image_5'] = '/vehicles/fixed/'.$filename5;
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
    public function invoices(Request $request)
    {
        $bookings = $this->enquiryService->getClosedDutyData();
        return view('admin.invoices')->with('bookings', $bookings);
    }
    public function approveInvoice(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getClosedDutyById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $companies = $this->companyService->getAllCompanies();
            return view('admin.approve-invoices')->with('enquiry', $enquiry)->with('companies', $companies);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.invoices');
        }
    }
    public function updateInvoice(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getClosedDutyById($request->id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $data['duty_approved'] = $request->status;
            $company = $this->companyService->getCompanyById($request->company_name);
            $data['company_id'] = $request->company_name;
            $data['db_name'] = $company->db_name;
            $this->enquiryService->update($enquiry, $data);
            $request->session()->put('message', 'Duty has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.invoices');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.invoices');
        }
    }
    public function duty(Request $request)
    {
        $status = array(3);
        $bookings = $this->enquiryService->getAllEnquiriesByStatus($status);
        return view('admin.duty')->with('bookings', $bookings);
    }
    public function editDuty(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getTripConfirmedById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.edit-duty')->with('enquiry', $enquiry);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.duty');
        }
    }
    public function updateDuty(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getTripConfirmedById($request->id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $data['start_point_kilometer'] = $request->start_point_kilometer;
            $data['duty_on_kilometer'] = $request->duty_on_kilometer;
            $data['duty_start_time'] = $request->duty_start_time;
            $data['duty_end_time'] = $request->duty_end_time;
            $data['duty_closed_kilometer'] = $request->duty_closed_kilometer;
            $data['end_point_kilometer'] = $request->end_point_kilometer;
            $data['end_duty_date'] = date('Y-m-d', strtotime(strtr($request->end_duty_date, '/', '-')));
            $data['fastag_amount'] = $request->fastag_amount;
            if($request->has('image')){
                $filepath = public_path('assets/' . $enquiry->image);
                $this->imageService->deleteFile($filepath);
                $filename = $this->imageService->uploadFile($request->image, "assets/duties");
                $data['image'] = '/duties/'.$filename;
            }
            if($request->has('fastag_image')){
                $filepath2 = public_path('assets/' . $enquiry->fastag_image);
                $this->imageService->deleteFile($filepath2);
                $filename2 = $this->imageService->uploadFile($request->fastag_image, "assets/fastag");
                $data['fastag_image'] = '/fastag/'.$filename2;
            }
            $data['remarks'] = $request->remarks;
            if($request->duty_closed) {
                $data['duty_closed'] = 1;
            }
            $this->enquiryService->update($enquiry, $data);
            $request->session()->put('message', 'Duty details has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.duty');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.duty');
        }
    }
    public function whatsapp(Request $request)
    {	
		$qrcode_image = '';
		$session_id = '';
        $active_whatsapp_number = '';
        $active_session_id = '';
        $active = $this->whatsappService->getActiveSession();
        $result = $this->whatsappService->checkStatus($active->session_id);
        if(isset($result->status) && $result->status == 'active') {
            $active_whatsapp_number = substr($active->whatsapp_number, 2);
            $active_session_id = $active->session_id;
        }
        return view('admin.whatsapp')->with('qrcode_image', $qrcode_image)->with('session_id', $session_id)->with('active_whatsapp_number', $active_whatsapp_number)->with('active_session_id', $active_session_id);
    }
    public function showQRCode(Request $request)
    {
        $session_id = 'jeevanrath'.rand(1000,9999);
        $result = $this->whatsappService->createSession($session_id);
		$qrcode_image = '';
        if($result->success == 1) {
			sleep(15);
            $response = $this->whatsappService->getQR($session_id);
			$data = json_decode($response);
			if(!isset($data->error)) {
				$qrcode_image = 'data:image/jpg;base64,'.base64_encode($response);
			}
        }
		return view('admin.qr-code')->with('qrcode_image', $qrcode_image)->with('session_id', $session_id)->render();
    }
	public function checkStatus(Request $request)
    {
		$session_id = $request->session_id;
        $result = $this->whatsappService->checkStatus($session_id);
        if($result->status == 'active') {
            $session_exists = $this->whatsappService->checkSessionExists($session_id);
            if($session_exists) {
                $whatsapp = $this->whatsappService->getWhatsappBySession($session_id);
                $data['status'] = 1;
                $this->whatsappService->update($whatsapp, $data);
            } else {
                Whatsapp::query()->update(['status' => 0]);
                $data['user_id'] =  Auth::user()->id;
                $data['session_id'] = $session_id;
                $data['whatsapp_number'] = $result->user;
                $data['status'] = 1;
                $this->whatsappService->create($data);
            }
			return response()->json(['status' => true]);
        } else {
			return response()->json(['status' => false]);
		}
    }
    public function sendMessage(Request $request)
    {
        $active = $this->whatsappService->getActiveSession();
        $session_id = $active->session_id;
        $mobile_number = '91'.$request->mobile;
        $message = '*Hi*,\nTest message sent';
        $response = $this->whatsappService->sendMessage($session_id, $mobile_number, $message);
        if(isset($response->success) && $response->success == 1) {
            $request->session()->put('message', 'Test message sent successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.whatsapp');
        } else {
            $request->session()->put('message', $response->error);
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.whatsapp');
        }
    }
}