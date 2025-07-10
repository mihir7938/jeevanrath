<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CityService;
use App\Services\TypeService;
use App\Services\VehicleService;
use App\Services\VehicleDetailService;
use App\Services\EnquiryService;
use App\Services\EmailService;
use App\Services\WhatsappService;
use App\Models\State;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    private $cityService, $typeService, $vehicleService, $vehicleDetailService, $enquiryService, $emailService, $whatsappService;

    public function __construct (
        CityService $cityService,
        TypeService $typeService,
        VehicleService $vehicleService,
        VehicleDetailService $vehicleDetailService,
        EnquiryService $enquiryService,
        EmailService $emailService,
        WhatsappService $whatsappService
    )
    {
        $this->cityService = $cityService;
        $this->typeService = $typeService;
        $this->vehicleService = $vehicleService;
        $this->vehicleDetailService = $vehicleDetailService;
        $this->enquiryService = $enquiryService;
        $this->emailService = $emailService;
        $this->whatsappService = $whatsappService;
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
    public function sendEnquiry(Request $request)
    {
        try{
            $ajax_data = $request->all();        
            $enqData=  array();
            parse_str($ajax_data['data'], $enqData);
            $data['user_type'] = $enqData['user_type'];
            if($enqData['company_name']) {
                $data['company_name'] = $enqData['company_name'];
            }
            if($enqData['user_type'] == 'Company') {
                $data['booker_name'] = $enqData['booker_name'];
                $data['booker_mobile'] = $enqData['booker_mobile'];
            }
            $data['name'] = $enqData['name'];
            $data['mobile_number'] = $enqData['mobile'];
            $data['pickup_from'] = $enqData['pickup_location'];
            $data['drop_to'] = $enqData['drop_location'];
            $data['journey_date'] = date('Y-m-d', strtotime(strtr($enqData['journey_start_date'], '/', '-')));
            $data['end_journey_date'] = date('Y-m-d', strtotime(strtr($enqData['journey_end_date'], '/', '-')));
            $diff = strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $enqData['journey_end_date'])))) - strtotime(date("Y-m-d", strtotime(str_replace('/', '-', $enqData['journey_start_date']))));
            $total_days = floor($diff / (60 * 60 * 24));
            $data['total_days'] = $total_days + 1;
            $data['vehicle_name'] = $enqData['car'];
            $data['journey_type'] = $enqData['journey_type'];
            $data['pickup_time'] = $enqData['pickup_time'];
            if($enqData['mobile']) {
                $mobile = $enqData['mobile'];
            } else {
                $mobile = $enqData['booker_mobile'];
            }
            $booking_id = $this->enquiryService->getBookingId($mobile);
            $data['booking_id'] = $booking_id;
            $this->enquiryService->create($data);
            $admin_email = env('ADMIN_EMAIL');
            $subject = 'New Inquiry Submission';
            $result = [
                'booking_id' => $booking_id,
                'user_type' => $enqData['user_type'],
                'company_name' => $enqData['company_name'],
                'name' => $enqData['name'],
                'mobile_number' => $enqData['mobile'],
                'journey_date' => $enqData['journey_start_date'],
                'end_journey_date' => $enqData['journey_end_date'],
                'pickup_from' => $enqData['pickup_location'],
                'drop_to' => $enqData['drop_location'],
                'booker_name' => $enqData['booker_name'],
                'booker_mobile' => $enqData['booker_mobile'],
                'vehicle_name' => $enqData['car'],
                'journey_type' => $enqData['journey_type'],
                'pickup_time' => $enqData['pickup_time'],
            ];
            $this->emailService->sendEmail('emails.enquiry', $result, $admin_email, $subject);
            /*$whatsapp = $this->whatsappService->getActiveSession();
            $session_id = $whatsapp->session_id;
            $check = $this->whatsappService->checkStatus($session_id);
            if(isset($check->status) && $check->status == 'active') {
                $mobile_number = '91'.env('ADMIN_MOBILE');
                $message = '>>> *New Inquiry* <<<';
                $message .= '\n\n*Booking ID* : '.$booking_id;
                $message .= '\n*User* : '.$enqData['user_type'];
                if($enqData['company_name']) {
                    $message .= '\n*Company* : '.$enqData['company_name'];
                }
                if($enqData['user_type'] == 'Company') {
                    $message .= '\n*Guest* : '.$enqData['name'];
                    $message .= '\n*M* : '.$enqData['mobile'];
                    $message .= '\n*Booker* : '.$enqData['booker_name'];
                    $message .= '\n*M* : '.$enqData['booker_mobile'];
                } else {
                    $message .= '\n*Guest* : '.$enqData['name'];
                    $message .= '\n*M* : '.$enqData['mobile'];
                }
                $message .= '\n*Start* : '.$enqData['journey_start_date'];
                $message .= '\n*End* : '.$enqData['journey_end_date'];
                $message .= '\n*Pickup* : '.$enqData['pickup_location'];
                $message .= '\n*Pickup Time* : '.$enqData['pickup_time'];
                $message .= '\n*Drop* : '.$enqData['drop_location'];
                $message .= '\n*Vehicle* : '.$enqData['car'];
                $message .= '\n*Journey Type* : '.$enqData['journey_type'];
                $response = $this->whatsappService->sendMessage($session_id, $mobile_number, $message);
            }*/
            return response()->json(['status' => true]);
        }catch(\Exception $e){
            return response()->json(['status' => false]);
        }
    }
}
