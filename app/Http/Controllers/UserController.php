<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadImageService;
use App\Services\EmailService;
use App\Services\UserService;
use App\Services\EnquiryService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $imageService, $emailService, $userService, $enquiryService;

    public function __construct (
        UploadImageService $imageService,
        EmailService $emailService,
        UserService $userService,
        EnquiryService $enquiryService
    )
    {
        $this->imageService = $imageService;
        $this->emailService = $emailService;
        $this->userService = $userService;
        $this->enquiryService = $enquiryService;
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
        return view('users.fetch-details')->with('booking_data', $booking_data)->render();
    }
}