<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadImageService;
use App\Services\EmailService;
use App\Services\UserService;
use App\Services\EnquiryService;
use App\Services\DriverDutyService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $imageService, $emailService, $userService, $enquiryService, $driverDutyService;

    public function __construct (
        UploadImageService $imageService,
        EmailService $emailService,
        UserService $userService,
        EnquiryService $enquiryService,
        DriverDutyService $driverDutyService
    )
    {
        $this->imageService = $imageService;
        $this->emailService = $emailService;
        $this->userService = $userService;
        $this->enquiryService = $enquiryService;
        $this->driverDutyService = $driverDutyService;
    }

    public function index(Request $request)
    {
        $driver_id = Auth::user()->drivers->id;
        $duty_closed = 0;
        $bookings = $this->enquiryService->assignedBookingsToDriver($driver_id, $duty_closed);
        $booking_data = '';
        return view('users.add-details')->with('bookings', $bookings)->with('booking_data', $booking_data);
    }

    public function fetchDetails(Request $request)
    {
        $booking_id = $request->booking_id;
        $booking_data = $this->enquiryService->getEnquiryByBookingId($booking_id);
        return view('users.fetch-details')->with('booking_data', $booking_data)->render();
    }

    public function saveDuty(Request $request)
    {
        $enquiry = $this->enquiryService->getEnquiryById($request->id);
        if($request->journey == 'start') {
            $data['start_point_kilometer'] = $request->start_point_kilometer;
            $data['duty_on_kilometer'] = $request->duty_on_kilometer;
            $data['duty_start_time'] = $request->duty_start_time;
            $this->enquiryService->update($enquiry, $data);
        } else {
            $data['duty_closed_kilometer'] = $request->duty_closed_kilometer;
            $data['duty_end_time'] = $request->duty_end_time;
            $data['end_point_kilometer'] = $request->end_point_kilometer;
            if($request->end_duty_date) {
                $data['end_duty_date'] = date('Y-m-d', strtotime(strtr($request->end_duty_date, '/', '-')));
            }
            if($request->has('image')){
                $filename = $this->imageService->uploadFile($request->image, "assets/duties");
                $data['image'] = '/duties/'.$filename;
            }
            if($request->duty_closed) {
                $data['duty_closed'] = 1;
            }
            $this->enquiryService->update($enquiry, $data);
        }
        $request->session()->put('message', 'Data has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('users.index');
    }

    public function reports(Request $request)
    {
        $driver_id = Auth::user()->drivers->id;
        $duty_closed = 1;
        $bookings = $this->enquiryService->assignedBookingsToDriver($driver_id, $duty_closed);
        return view('users.reports')->with('bookings', $bookings);
    }
}