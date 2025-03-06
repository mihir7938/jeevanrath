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
        $bookings = $this->enquiryService->assignedBookingsToDriver($driver_id);
        return view('users.index')->with('bookings', $bookings);
    }

    public function addDetails(Request $request)
    {
        $booking_data = '';
        return view('users.add-details')->with('booking_data', $booking_data);
    }

    public function fetchDetails(Request $request)
    {
        $booking_id = $request->booking_id;
        $booking_data = $this->enquiryService->getEnquiryByBookingId($booking_id);
        $driver_duty_data = $this->driverDutyService->getDriverDutyByBookingId($booking_id);
        return view('users.fetch-details')->with('booking_data', $booking_data)->with('driver_duty_data', $driver_duty_data)->render();
    }

    public function saveDuty(Request $request)
    {
        if($request->journey == 'start') {
            $data['driver_id'] = Auth::user()->drivers->id;
            $data['booking_id'] = $request->booking_id;
            $data['start_kilometre'] = $request->start_kilometre;
            $data['start_date'] = $request->start_date;
            $data['start_time'] = $request->start_time;
            $this->driverDutyService->create($data);
        } else {
            $driver_duty = $this->driverDutyService->getDriverDutyById($request->id);
            $data['end_kilometre'] = $request->end_kilometre;
            $data['end_date'] = date('Y-m-d', strtotime(strtr($request->end_date, '/', '-')));
            $data['end_time'] = $request->end_time;
            $filename = $this->imageService->uploadFile($request->image, "assets/duties");
            $data['image'] = '/duties/'.$filename;
            $this->driverDutyService->update($driver_duty, $data);
        }
        $request->session()->put('message', 'Data has been added successfully.');
        $request->session()->put('alert-type', 'alert-success');
        return redirect()->route('users.details.add');
    }
}