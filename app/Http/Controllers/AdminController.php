<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\VendorRequest;
use App\Http\Requests\DriverRequest;
use App\Services\UploadImageService;
use App\Services\EnquiryService;
use App\Services\PackageGridService;
use App\Services\PackageCategoryService;
use App\Services\PackageService;
use App\Services\AssignPackageService;
use App\Services\ChargeService;
use App\Services\AccountService;
use App\Services\DailyEntryService;
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
    private $imageService, $enquiryService, $packageGridService, $packageCategoryService, $packageService, $assignPackageService, $chargeService, $accountService, $dailyEntryService, $cityService, $typeService, $vehicleService, $categoryService, $vehicleDetailService, $driverService, $vendorService, $companyService, $jRVehicleService, $userService, $whatsappService;

    public function __construct ( 
        UploadImageService $imageService,
        EnquiryService $enquiryService,
        PackageGridService $packageGridService,
        PackageCategoryService $packageCategoryService,
        PackageService $packageService,
        AssignPackageService $assignPackageService,
        ChargeService $chargeService,
        AccountService $accountService,
        DailyEntryService $dailyEntryService,
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
        $this->packageGridService = $packageGridService;
        $this->packageCategoryService = $packageCategoryService;
        $this->packageService = $packageService;
        $this->assignPackageService = $assignPackageService;
        $this->chargeService = $chargeService;
        $this->accountService = $accountService;
        $this->dailyEntryService = $dailyEntryService;
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
        $total_enquiry = $this->enquiryService->getTotalEnquiries();
        $total_pending_inquiry = $this->enquiryService->getTotalInquiriesByStatus(0);
        $total_inprocess_inquiry = $this->enquiryService->getTotalInquiriesByStatus(1);
        $total_booking_confirmed = $this->enquiryService->getTotalInquiriesByStatus(2);
        $total_trip_confirmed = $this->enquiryService->getTotalInquiriesByStatus(3);
        $total_cancelled_inquiry = $this->enquiryService->getTotalInquiriesByStatus(4);
        $total_duties = $this->enquiryService->getTotalDuties();
        $total_not_duty_closed = $this->enquiryService->getTotalDutiesByStatus(0);
        $total_duty_closed = $this->enquiryService->getTotalDutiesByStatus(1);
        return view('admin.index')->with('total_enquiry', $total_enquiry)->with('total_pending_inquiry', $total_pending_inquiry)->with('total_inprocess_inquiry', $total_inprocess_inquiry)->with('total_booking_confirmed', $total_booking_confirmed)->with('total_trip_confirmed', $total_trip_confirmed)->with('total_cancelled_inquiry', $total_cancelled_inquiry)->with('total_duties', $total_duties)->with('total_not_duty_closed', $total_not_duty_closed)->with('total_duty_closed', $total_duty_closed);
    }
    public function confirmedInquiry(Request $request)
    {
        $status = array(2,3);
        $duty_closed = 0;
        $enquiries = $this->enquiryService->getAllEnquiriesByStatus($status, $duty_closed);
        return view('admin.confirmed')->with('enquiries', $enquiries);
    }
    public function fetchInquiries(Request $request)
    {
        $enquiries = $this->enquiryService->getAllEnquiriesByFilter($request);
        return view('admin.search-result')->with('enquiries', $enquiries)->render();
    }
    public function getPackagesByCategory(Request $request)
    {
        $packages = $this->packageService->getPackagesByCategory($request->category_id);
        return response()->json(['status' => true, 'packages' => $packages]);
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
            $companies = $this->accountService->getAllAccounts();
            $package_categories = $this->packageCategoryService->getAllPackageCategories();
            $packages = $this->packageService->getPackagesByCategory($enquiry->package_category_id);
            return view('admin.edit-enquiry')->with('enquiry', $enquiry)->with('vendors', $vendors)->with('drivers', $drivers)->with('companies', $companies)->with('package_categories', $package_categories)->with('packages', $packages);
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
            if($request->company_name) {
                $data['company_name'] = $request->company_name;
            }
            if($request->user_type == 'Company') {
                $data['booker_name'] = $request->booker_name;
                $data['booker_mobile'] = $request->booker_mobile;
            }
            if($request->status == '2') {
                $account_data = $this->accountService->getAccountById($request->account);
                $data['package_company_id'] = $request->account;
                $data['package_company_name'] = $account_data->name;
            }
            if($request->status == '3') {
                $account_data = $this->accountService->getAccountById($request->account);
                $vendor_data = $this->vendorService->getVendorById($request->vendor);
                $driver_data = $this->driverService->getDriverById($request->driver);
                $package_category_data = $this->packageCategoryService->getPackageCategoryById($request->category);
                $package_data = $this->packageService->getPackageById($request->package_name);
                $data['package_company_id'] = $request->account;
                $data['package_company_name'] = $account_data->name;
                $data['vendor_id'] = $request->vendor;
                $data['vendor_name'] = $vendor_data->name;
                $data['driver_id'] = $request->driver;
                $data['driver_name'] = $driver_data->name;
                $data['package_category_id'] = $request->category;
                $data['package_category_name'] = $package_category_data->name;
                $data['package_id'] = $request->package_name;
                $data['package_name'] = $package_data->name;
                $data['vehicle'] = $request->car;
                $data['vehicle_number'] = $request->vehicle_number;
                $start_date = strtotime(date('Y-m-d', strtotime(strtr($request->journey_date, '/', '-'))));
                $end_date = strtotime(date('Y-m-d', strtotime(strtr($request->end_journey_date, '/', '-'))));
                $date_array = array();
                for ($i = $start_date;$i <= $end_date;$i += (86400)){
                    $day = date('Y-m-d', $i);
                    $date_array[] = $day;
                }
                if(count($date_array) > 1) {
                    foreach($date_array as $d) {
                        $journey = date('Y-m-d', strtotime(strtr($d, '/', '-')));
                        $check_entry = $this->dailyEntryService->checkEntryExists($enquiry->id, $journey);
                        if($check_entry == 0) {
                            $entry_data['enquiry_id'] = $enquiry->id;
                            $entry_data['booking_id'] = $enquiry->booking_id;
                            $entry_data['journey_date'] = $d;
                            $this->dailyEntryService->create($entry_data);
                        }
                    }
                }
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
            $data['vehicle_name'] = $request->vehicle_type;
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
        $status_id = "-1";
        if( $request->has('status') ) {
            $status_id = $request->input('status');
            $status = array($status_id);
            $duty_closed = 0;
            $enquiries = $this->enquiryService->getAllEnquiriesByStatus($status, $duty_closed);
        } else {
            $enquiries = $this->enquiryService->getAllEnquiries();
        }
        return view('admin.all')->with('enquiries', $enquiries)->with('status_id', $status_id);
    }
    public function reports(Request $request)
    {
        $enquiries = $this->enquiryService->getAllReports();
        return view('admin.reports')->with('enquiries', $enquiries);
    }
    public function fetchReports(Request $request)
    {
        $enquiries = $this->enquiryService->getAllReportsByFilter($request);
        return view('admin.fetch-reports')->with('enquiries', $enquiries)->render();
    }
    public function accounts(Request $request)
    {
        $accounts = $this->accountService->getAllAccounts();
        return view('admin.companies.index')->with('accounts', $accounts);
    }
    public function addAccount(Request $request)
    {
        return view('admin.companies.add');
    }
    public function saveAccount(Request $request)
    {
        $data['name'] = $request->name;
        $data['acc_id'] = $request->acc_id;
        $data['mobile_number'] = $request->mobile_number;
        $this->accountService->create($data);
        $request->session()->put('message', 'Company has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.accounts');
    }
    public function editAccount(Request $request, $id)
    {
        try{
            $account = $this->accountService->getAccountById($id);
            if(!$account){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.companies.edit')->with('account', $account);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.accounts');
        }
    }
    public function updateAccount(Request $request)
    {
        try{
            $account = $this->accountService->getAccountById($request->id);
            if(!$account){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $data['acc_id'] = $request->acc_id;
            $data['mobile_number'] = $request->mobile_number;
            $this->accountService->update($account, $data);
            $request->session()->put('message', 'Company has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.accounts');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.accounts');
        }
    }
    public function deleteAccount(Request $request, $id)
    {
        try{
            $account = $this->accountService->getAccountById($id);
            if(!$account){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->accountService->delete($account);
            $request->session()->put('message', 'Company has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.accounts');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.accounts');
        }
    }
    public function packageCategories(Request $request)
    {
        $package_categories = $this->packageCategoryService->getAllPackageCategories();
        return view('admin.package_categories.index')->with('package_categories', $package_categories);
    }
    public function addPackageCategory(Request $request)
    {
        return view('admin.package_categories.add');
    }
    public function savePackageCategory(Request $request)
    {
        $data['name'] = $request->name;
        $this->packageCategoryService->create($data);
        $request->session()->put('message', 'Package Category has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.package.categories');
    }
    public function editPackageCategory(Request $request, $id)
    {
        try{
            $package_category = $this->packageCategoryService->getPackageCategoryById($id);
            if(!$package_category){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.package_categories.edit')->with('package_category', $package_category);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.package.categories');
        }
    }
    public function updatePackageCategory(Request $request)
    {
        try{
            $package_category = $this->packageCategoryService->getPackageCategoryById($request->id);
            if(!$package_category){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->packageCategoryService->update($package_category, $data);
            $request->session()->put('message', 'Package Category has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.package.categories');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.package.categories');
        }
    }
    public function deletePackageCategory(Request $request, $id)
    {
        try{
            $package_category = $this->packageCategoryService->getPackageCategoryById($id);
            if(!$package_category){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->packageCategoryService->delete($package_category);
            $request->session()->put('message', 'Package Category has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.package.categories');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.package.categories');
        }
    }
    public function getPackages()
    {
        $packages = $this->packageService->getAllPackages();
        return view('admin.packages.index')->with('packages', $packages);
    }
    public function addPackage()
    {
        $package_categories = $this->packageCategoryService->getAllPackageCategories();
        return view('admin.packages.add')->with('package_categories', $package_categories);;
    }
    public function savePackage(Request $request)
    {
        $data = $request->all();
        $data['category_id'] = $request->package_category;
        $this->packageService->create($data);
        $request->session()->put('message', 'Packege has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.packages');
    }
    public function editPackage(Request $request, $id)
    {
        try{
            $package = $this->packageService->getPackageById($id);
            if(!$package){
                throw new BadRequestException('Invalid Request id');
            }
            $package_categories = $this->packageCategoryService->getAllPackageCategories();
            return view('admin.packages.edit')->with('package', $package)->with('package_categories', $package_categories);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.packages');
        }
    }
    public function updatePackage(Request $request)
    {
        try{
            $package = $this->packageService->getPackageById($request->id);
            if(!$package){
                throw new BadRequestException('Invalid Request id');
            }
            $data = $request->all();
            $data['category_id'] = $request->package_category;
            $this->packageService->update($package, $data);
            $request->session()->put('message', 'Packege has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.packages');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.packages');
        }
    }
    public function deletePackage(Request $request, $id)
    {
        try{
            $package = $this->packageService->getPackageById($id);
            if(!$package){
                throw new BadRequestException('Invalid Request id.');
            }
            $this->packageService->delete($package);
            $request->session()->put('message', 'Packege has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.packages');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.packages');
        }
    }
    public function assignPackages(Request $request)
    {
        $accounts = $this->accountService->getAllAccounts();
        $company = '';
        $packages = [];
        return view('admin.assign_packages.index')->with('accounts', $accounts)->with('company', $company)->with('packages', $packages);
    }
    public function fetchPackages(Request $request)
    {
        $company_id = $request->company_id;
        $company = $this->accountService->getAccountById($company_id);
        $packages = $this->packageService->getAllPackagesOrderByName();
        return view('admin.assign_packages.result')->with('company', $company)->with('packages', $packages)->render();
    }
    public function updateAssignPackages(Request $request)
    {
        try{
            foreach ($request->package as $key => $row) {
                $data['company_id'] = $request->company;
                $data['package_id'] = $row['id'];
                $data['rate'] = $row['rate'];
                $data['ex_km_rate'] = $row['ex_km_rate'];
                $data['ex_hr_rate'] = $row['ex_hr_rate'];
                if ($row['status'] == 'yes') {
                    $assign_package = $this->assignPackageService->getAssignPackageById($row['assign_id']);
                    $this->assignPackageService->update($assign_package, $data);
                } else {
                    $this->assignPackageService->create($data);
                }
            }
            $request->session()->put('message', 'Package has been assigned successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.packages.assign');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.packages.assign');
        }
    }
    public function charges(Request $request)
    {
        $charges = $this->chargeService->getAllCharges();
        return view('admin.charges.index')->with('charges', $charges);
    }
    public function addCharge(Request $request)
    {
        return view('admin.charges.add');
    }
    public function saveCharge(Request $request)
    {
        $data['name'] = $request->name;
        $this->chargeService->create($data);
        $request->session()->put('message', 'Charge has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('admin.charges');
    }
    public function editCharge(Request $request, $id)
    {
        try{
            $charge = $this->chargeService->getChargeById($id);
            if(!$charge){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.charges.edit')->with('charge', $charge);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.charges');
        }
    }
    public function updateCharge(Request $request)
    {
        try{
            $charge = $this->chargeService->getChargeById($request->id);
            if(!$charge){
                throw new BadRequestException('Invalid Request id');
            }
            $data['name'] = $request->name;
            $this->chargeService->update($charge, $data);
            $request->session()->put('message', 'Charge has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.charges');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.charges');
        }
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
    public function saveDriver(DriverRequest $request)
    {
        $data = $request->all();
        $role_id = Role::USER_ROLE_ID;
        $category_id = 2;
        $password = 'jr'.substr($request->mobile_number, -3);
        $user = $this->userService->create($request, $role_id, $password, $category_id);
        $user_id = $user->id;
        $data['user_id'] = $user_id;
        $data['vendor_id'] = $request->vendor;
        $data['type'] = 'Driver';
        $data['mobile_number'] = $request->mobile_number;
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
    public function saveVendor(VendorRequest $request)
    {
        $data = $request->all();
        $role_id = Role::USER_ROLE_ID;
        $category_id = 1;
        $password = 'vendor'.substr($request->mobile_number, -3);
        $user = $this->userService->create($request, $role_id, $password, $category_id);
        $user_id = $user->id;
        $data['user_id'] = $user_id;
        $data['name'] = $request->name;
        $data['mobile_number'] = $request->mobile_number;
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
            $data['email'] = $request->email;
            $this->vendorService->update($vendor, $data);
            $user_id = $vendor->user_id;
            $user = $this->userService->getUserById($user_id);
            $userdata['name'] = $request->name;
            $userdata['email'] = $request->email;
            $userdata['status'] = $request->active;
            $this->userService->update($user, $userdata);
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
        return view('admin.db_companies.index')->with('companies', $companies);
    }
    public function addCompany(Request $request)
    {
        return view('admin.db_companies.add');
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
            return view('admin.db_companies.edit')->with('company', $company);
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
            $assign_package = $this->assignPackageService->getAssignPackageByCompany($enquiry->package_company_id, $enquiry->package_id);
            $charges = $this->chargeService->getAllCharges();
            $package_data = $this->packageGridService->getPackageByEnqIdByFlag($enquiry->id, 1);
            $extra_km = $this->packageGridService->getPackageByEnqIdByFlag($enquiry->id, 2);
            $extra_hr = $this->packageGridService->getPackageByEnqIdByFlag($enquiry->id, 3);
            $charge_grid = $this->packageGridService->getChargesByEnqId($enquiry->id);
            return view('admin.approve-invoices')->with('enquiry', $enquiry)->with('companies', $companies)->with('assign_package', $assign_package)->with('charges', $charges)->with('package_data', $package_data)->with('extra_km', $extra_km)->with('extra_hr', $extra_hr)->with('charge_grid', $charge_grid);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.invoices');
        }
    }
    public function fetchPackagesByCategory(Request $request)
    {
        $enquiry = $this->enquiryService->getClosedDutyById($request->enquiry_id);
        $category_id = $request->category_id;
        $packages = $this->packageService->getPackagesByCategory($category_id);
        $package_grid = [];
        $total_packages = count($package_grid);
        return view('admin.package-grid')->with('enquiry', $enquiry)->with('category_id', $category_id)->with('packages', $packages)->with('package_grid', $package_grid)->with('total_packages', $total_packages)->render();
    }
    public function fetchRateByPackage(Request $request)
    {
        $package = $this->packageService->getPackageById($request->package_id);
        return response()->json(['status' => true, 'package' => $package]);
    }
    public function updateInvoice(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getClosedDutyById($request->id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            if($enquiry->duty_approved == 1) {
                $data['final_remarks'] = $request->final_remarks;
                $this->enquiryService->update($enquiry, $data);
            } else {
                $enquiry->packages()->delete();
                $total_amount = 0;
                foreach ($request->package as $key => $row) {
                    if($row['rate']) {
                        $total_amount = $total_amount + $row['amount'];
                        $grid_data['enquiry_id'] = $enquiry->id;
                        if($row['flag'] == 0) {
                            $grid_data['package_id'] = NULL;
                            $grid_data['charge_id'] = $row['charge_id'];
                        } else {
                            $grid_data['package_id'] = $request->package_id;
                            $grid_data['charge_id'] = NULL;
                        }
                        $grid_data['flag'] = $row['flag'];
                        $grid_data['rate'] = $row['rate'];
                        $grid_data['amount'] = $row['amount'];
                        $grid_data['remarks'] = $row['remarks'];
                        $this->packageGridService->create($grid_data);
                    }
                }
                if($request->duty_approved) {
                    $data['duty_approved'] = 1;
                    $data['duty_approved_date'] = date('Y-m-d', strtotime(strtr($request->duty_approved_date, '/', '-')));
                }
                $company = $this->companyService->getCompanyById($request->company_name);
                $data['company_id'] = $request->company_name;
                $data['db_name'] = $company->db_name;
                $data['total_amount'] = $total_amount;
                /*if($enquiry->total_kilometer == '') {
                    $data['total_kilometer'] = ($enquiry->duty_closed_kilometer - $enquiry->duty_on_kilometer);
                }*/
                $this->enquiryService->update($enquiry, $data);
            }
            $request->session()->put('message', 'Package has been updated successfully.');
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
        $journey_type = 'oncall';
        if( $request->has('status') ) {
            $duty_closed = $request->input('status');
            $bookings = $this->enquiryService->getAllEnquiriesByStatus($status, $duty_closed, $journey_type);
        } else {
            $bookings = $this->enquiryService->getAllEnquiriesByStatus($status, $duty_closed = '', $journey_type);
            $duty_closed = '-1';
        }
        return view('admin.duty')->with('bookings', $bookings)->with('duty_closed', $duty_closed);
    }
    public function fetchDuties(Request $request)
    {
        $status = array(3);
        $bookings = $this->enquiryService->getAllDutiesByFilter($request, $status);
        return view('admin.duty-search-result')->with('bookings', $bookings)->render();
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
            $total_kilometer = ($request->duty_closed_kilometer - $request->duty_on_kilometer);
            $package = $this->packageService->getPackageById($enquiry->package_id);
            $extra_kilometer = 0;
            if($package->package_km) {
                $extra_km = $total_kilometer - $package->package_km;
                if ($extra_km > 0) {
                    $extra_kilometer = $extra_km;
                }
            }
            $total_time = (strtotime($request->duty_end_time) - strtotime($request->duty_start_time));
            $hours = floor($total_time / 3600);
            $mins = floor(($total_time - ($hours*3600)) / 60);
            $min_hr = $mins / 60;
            $extra_time = 0;
            if($package->package_hr) {
                $extra_hr = $hours - $package->package_hr;
                $extra_hr = $extra_hr + round($min_hr, 2);
                if ($extra_hr > 0) {
                    $extra_time = $extra_hr;
                }
            }
            $data['total_kilometer'] = $total_kilometer;
            $data['extra_kilometer'] = $extra_kilometer;
            $data['extra_time'] = $extra_time;
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
    public function entries(Request $request)
    {
        $packages = $this->enquiryService->getMonthlyPackags();
        return view('admin.entries.index')->with('packages', $packages);
    }
    public function addEntries(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $daily_entries = $this->dailyEntryService->getDailyEntriesByEnqId($id);
            $package = $this->packageService->getPackageById($enquiry->package_id);
            return view('admin.entries.add-entry')->with('enquiry', $enquiry)->with('daily_entries', $daily_entries)->with('package', $package);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.entries');
        }
    }
    public function saveEntries(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($request->enquiry_id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $difference = 0;
            $extra_km = 0;
            $ot_hrs = 0;
            foreach ($request->entry as $key => $row) {
                $data['starting_kilometer'] = $row['starting_kilometer'];
                $data['closing_kilometer'] = $row['closing_kilometer'];
                $data['difference'] = $row['total_km'];
                $data['extra_km'] = $row['extra_km'];
                $data['in_time'] = $row['in_time'];
                $data['out_time'] = $row['out_time'];
                $data['ot_hrs'] = $row['extra_time'];
                $data['remarks'] = $row['remarks'];
                $journey_date = date('Y-m-d', strtotime(strtr($row['journey_date'], '/', '-')));
                if(isset($row['entry_id'])) {
                    $entry = $this->dailyEntryService->getDailyEntryById($row['entry_id']);
                    $this->dailyEntryService->update($entry, $data);
                } else {
                    $data['enquiry_id'] = $enquiry->id;
                    $data['booking_id'] = $enquiry->booking_id;
                    $data['journey_date'] = $journey_date;
                    $this->dailyEntryService->create($data);
                }
                $difference = $difference + $row['total_km'];
                $extra_km = $extra_km + $row['extra_km'];
                $ot_hrs = $ot_hrs + $row['extra_time'];
            }
            $edata['end_journey_date'] = $journey_date;
            $edata['total_kilometer'] = $difference;
            if($enquiry->package_category_id == 3) {
                $package = $this->packageService->getPackageById($enquiry->package_id);
                if($package->package_km) {
                    $extra_kilometer = $difference - $package->package_km;
                    if ($extra_kilometer > 0) {
                        $extra_km = $extra_kilometer;
                    }
                }
            }
            $edata['extra_kilometer'] = $extra_km;
            $edata['extra_time'] = $ot_hrs;
            $this->enquiryService->update($enquiry, $edata);
            $request->session()->put('message', 'Entry has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.entries');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.entries');
        }
    }
    public function editEntries(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id.');
            }
            return view('admin.entries.edit-entry')->with('enquiry', $enquiry);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.entries');
        }
    }
    public function updateEntries(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($request->id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id.');
            }
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
            $data['duty_closed'] = 0;
            if($request->duty_closed) {
                $data['duty_closed'] = 1;
            }
            $this->enquiryService->update($enquiry, $data);
            $request->session()->put('message', 'Duty details has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.entries');
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.entries');
        }
    }
    public function listDailyEntries(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $daily_entries = $this->dailyEntryService->getDailyEntriesByEnqId($id);
            $difference = 0;
            $extra_km = 0;
            $extra_ot = 0;
            foreach ($daily_entries as $entries) {
                $difference = $difference + $entries->difference;
                $extra_km = $extra_km + $entries->extra_km;
                $extra_ot = $extra_ot + $entries->ot_hrs;
            }
            if($enquiry->package_category_id == 3) {
                $package = $this->packageService->getPackageById($enquiry->package_id);
                if($package->package_km) {
                    $extra_kilometer = $difference - $package->package_km;
                    if ($extra_kilometer > 0) {
                        $extra_km = $extra_kilometer;
                    }
                }
            }
            return view('admin.entries.list')->with('enquiry', $enquiry)->with('daily_entries', $daily_entries)->with('difference', $difference)->with('extra_km', $extra_km)->with('extra_ot', $extra_ot);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->route('admin.entries');
        }
    }
    public function fetchDailyEntries(Request $request)
    {
        $daily_entries = $this->dailyEntryService->getAllEntriesByFilter($request);
        $difference = 0;
        $extra_km = 0;
        $extra_ot = 0;
        foreach ($daily_entries as $entries) {
            $difference = $difference + $entries->difference;
            $extra_km = $extra_km + $entries->extra_km;
            $extra_ot = $extra_ot + $entries->ot_hrs;
        }
        return view('admin.entries.fetch-result')->with('daily_entries', $daily_entries)->with('difference', $difference)->with('extra_km', $extra_km)->with('extra_ot', $extra_ot)->render();
    }
    public function addDailyEntries(Request $request, $id)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.entries.add')->with('enquiry', $enquiry);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function saveDailyEntries(Request $request)
    {
        try{
            $enquiry = $this->enquiryService->getMonthlyPackageById($request->id);
            if(!$enquiry){
                throw new BadRequestException('Invalid Request id');
            }
            $journey_date = date('Y-m-d', strtotime(strtr($request->journey_date, '/', '-')));
            $check_entry = $this->dailyEntryService->checkEntryExists($request->id, $journey_date);
            if($check_entry > 0) {
                throw new BadRequestException('Data of '.$request->journey_date.' is already inserted');
            }
            $data = $request->all();
            $data['enquiry_id'] = $enquiry->id;
            $data['booking_id'] = $enquiry->booking_id;
            $data['journey_date'] = $journey_date;
            $data['difference'] = $request->closing_kilometer - $request->starting_kilometer;
            $this->dailyEntryService->create($data);
            $edata['duty_closed'] = 0;
            $this->enquiryService->update($enquiry, $edata);
            $request->session()->put('message', 'Entry has been inserted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.entries.list', ['id' => $enquiry->id]);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function editDailyEntries(Request $request, $id)
    {
        try{
            $daily_entry = $this->dailyEntryService->getDailyEntryById($id);
            if(!$daily_entry){
                throw new BadRequestException('Invalid Request id');
            }
            return view('admin.entries.edit')->with('daily_entry', $daily_entry);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function updateDailyEntries(Request $request)
    {
        try{
            $daily_entry = $this->dailyEntryService->getDailyEntryById($request->id);
            if(!$daily_entry){
                throw new BadRequestException('Invalid Request id');
            }
            $data = $request->all();
            $data['difference'] = $request->closing_kilometer - $request->starting_kilometer;
            $this->dailyEntryService->update($daily_entry, $data);
            $enquiry = $this->enquiryService->getEnquiryById($daily_entry->enquiry_id);
            $edata['duty_closed'] = 0;
            $this->enquiryService->update($enquiry, $edata);
            $request->session()->put('message', 'Entry has been updated successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.entries.list', ['id' => $daily_entry->enquiry_id]);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function deleteDailyEntries(Request $request, $id)
    {
        try{
            $daily_entry = $this->dailyEntryService->getDailyEntryById($id);
            if(!$daily_entry){
                throw new BadRequestException('Invalid Request id');
            }
            $enquiry_id = $daily_entry->enquiry_id;
            $this->dailyEntryService->delete($daily_entry);
            $request->session()->put('message', 'Entry has been deleted successfully.');
            $request->session()->put('alert-type', 'alert-success');
            return redirect()->route('admin.entries.list', ['id' => $enquiry_id]);
        }catch(\Exception $e){
            $request->session()->put('message', $e->getMessage());
            $request->session()->put('alert-type', 'alert-warning');
            return redirect()->back();
        }
    }
    public function whatsapp(Request $request)
    {	
		$qrcode_image = '';
		$session_id = '';
        $active_whatsapp_number = '';
        $active_session_id = '';
        $active = $this->whatsappService->getActiveSession();
        if(isset($active->session_id)) {
            $result = $this->whatsappService->checkStatus($active->session_id);
        }
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