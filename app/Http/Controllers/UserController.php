<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UploadImageService;
use App\Services\EmailService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $imageService, $emailService, $userService;

    public function __construct (
        UploadImageService $imageService,
        EmailService $emailService,
        UserService $userService
    )
    {
        $this->imageService = $imageService;
        $this->emailService = $emailService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        return view('users.index');
    }
}