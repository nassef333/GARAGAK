<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\OTP\PasswordOTPRequest;
use App\Http\Requests\API\V1\Auth\OTP\ResetPasswordRequest;
use App\Http\Requests\API\V1\Auth\OTP\ValidatePasswordOTPRequest;
use App\Models\PasswordOTP;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use App\Notifications\SendResetPasswordOTP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    use APIResponse;

    public function generatePasswordOTP(PasswordOTPRequest $request)
    {
        $user = User::where('email', $request->validated('email'))->first();

        if ($user == null) {
            return $this->error(404, 'not found', ['message' => 'something went wrong']);
        }

        PasswordOTP::query()
            ->where('identifier', $user->email)
            ->delete();

        $otp = $this->generate(6);

        PasswordOTP::create([
            'identifier' => $user->email,
            'otp' => $otp,
            'expire_at' => Carbon::now()->addMinutes(5)
        ]);

        $user->notify(new SendResetPasswordOTP($otp));

        return $this->success(201, 'otp created successfully', []);
    }

    public function validatePasswordOTP(ValidatePasswordOTPRequest $request)
    {

        $user = User::where('email', $request->validated('email'))->first();

        $otp = PasswordOTP::where('identifier', $user->email)->where('otp', $request->validated('otp'))->first();

        if ($user == null) {
            return $this->error(404, 'not found', ['message' => 'something went wrong']);
        }

        if ($otp == null) {
            return $this->error(404, 'not found', ['otp' => 'otp does not exist']);
        }

        if ($otp->valid != true) {
            return $this->error(404, 'not found', ['otp' => 'otp does not exist']);
        }

        $now = Carbon::now();

        $validity = $otp->expire_at;

        if (strtotime($validity) < strtotime($now)) {
            $otp->delete();
            return $this->error(419, 'expired', ['otp' => 'otp expired']);
        }

        $otp->valid = false;
        $otp->save();
        return $this->success(202, 'success', ['otp' => 'otp validated successfully']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $user = User::where('email', $request->validated('email'))->first();

        $otp = PasswordOTP::where('identifier', $user->email)->where('otp', $request->validated('otp'))->first();

        if ($user == null) {
            return $this->error(404, 'not found', ['message' => 'something went wrong']);
        }

        if ($otp == null) {
            return $this->error(404, 'not found', ['otp' => 'otp does not exist']);
        }

        if ($otp->valid != false) {
            return $this->error(404, 'not found', ['message' => 'something went wrong']);
        }

        $user->update([
            "password" => Hash::make($request->validated('password'))
        ]);

        $otp->delete();

        return $this->success(202, 'success', ['message' => 'password updated successfully go login']);
    }

    public function generate($length)
    {
        $otp = '';

        for ($i = 0; $i < $length; $i++) {
            $otp .= mt_rand(0, 9);
        }
        return $otp;
    }
}
