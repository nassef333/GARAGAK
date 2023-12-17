<?php

namespace App\Http\Controllers\API\Auth;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Http\Resources\API\V1\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIResponse;

    private $otp_generator;

    public function __construct()
    {
        $this->otp_generator = new OTPController();
    }

    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $token = $request->user()->createToken("{$request->user()->email}")->plainTextToken;

        return $this->success(200, "login.success", [
            'token' => $token,
            'user' => UserResource::make($request->user())
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1,
            'phone' => $request->phone,
        ]);

        $userFolder = storage_path("app/public/uploads/users/{$user->id}");
        File::makeDirectory($userFolder, 0777, true, true);

        $token = $user->createToken("{$user->email}")->plainTextToken;

        // $this->otp_generator->generateEmailOTP($user);

        return $this->success(200, "register success", [
            'token' => $token,
            'user' => UserResource::make($user)
        ]);
    }

    public function user(Request $request)
    {
        return $this->success(200, "user success", ['user' => UserResource::make($request->user())]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->success(200, "user logout success", []);
    }
}
