<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Requests\API\V1\Auth\OTP\EmailOTPRequest;
use App\Http\Requests\API\V1\Auth\OTP\ValidateEmailOTPRequest;
use App\Http\Resources\API\V1\User\UserResource;
use App\Models\OTP;
use App\Models\User;
use App\Notifications\SendOtpNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OTPController extends Controller
{
    use APIResponse;

    public function generateEmailOTP(User $user)
    {

        if (!$user->email) {
            $user = request()->user();
        }

        OTP::query()
            ->where('identifier', $user->email)
            ->where('valid', true)
            ->delete();

        $otp = $this->generate(6);

        OTP::create([
            'identifier' => $user->email,
            'otp' => $otp,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);

        $user->notify(new SendOtpNotification($otp));

        return $this->success(201, 'otp created successfully', []);
    }

    public function validateEmailOTP(ValidateEmailOTPRequest $request)
    {
        $otp = OTP::where('identifier', $request->user()->email)->where('otp', $request->validated('otp'))->first();

        if ($otp == null) {
            return $this->error(404, 'not found', ['otp' => 'otp does not exist']);
        }

        if (!$otp->valid) {
            return $this->error(403, 'not found', ['otp' => 'otp is not valid']);
        }

        $now = Carbon::now();

        $validity = $otp->expire_at;

        if (strtotime($validity) < strtotime($now)) {
            $otp->delete();

            return $this->error(419, 'expired', ['otp' => 'otp expired']);
        }

        $otp->valid = false;

        $otp->save();

        $request->user()->email_verified_at = Carbon::now();
        $request->user()->save();

        return $this->success(202, 'success', [
            'otp' => 'otp validated successfully',
            'user' => UserResource::make($request->user())
        ]);
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
