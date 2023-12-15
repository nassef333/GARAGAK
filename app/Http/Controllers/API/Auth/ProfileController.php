<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Traits\APIResponse;
use App\Http\Controllers\API\Traits\ImageUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\UpdateProfileRequest;
use App\Http\Requests\API\V1\Auth\UploadProfileImageRequest;
use App\Http\Resources\API\V1\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    use APIResponse, ImageUploader;

    public function update(UpdateProfileRequest $request)
    {
        $request->user()->fill($request->validated());

        $request->user()->save();

        return $this->success(202, "updated successfully", UserResource::make($request->user()));
    }
    public function show(Request $request)
    {
        return $this->success(200, "success", UserResource::make($request->user()));
    }
    public function updateImage(UploadProfileImageRequest $request)
    {

        $image = $this->uploadImage($request, 'image', "public/uploads/users/{$request->user()->id}/profile");

        if ($request->user()->image) {

            Storage::delete("public/uploads/users/{$request->user()->id}/profile/{$request->user()->image}");

            $request->user()->image = $image;

            $request->user()->save();
            Image::make("storage/uploads/users/{$request->user()->id}/profile/{$request->user()->image}")
                ->resize(400, 400, function ($c) {
                    $c->aspectRatio();
                })
                // ->crop(400, 200, 0, 0)
                ->save();

            return $this->success(202, "updated successfully", $request->user());
        }

        $request->user()->image = $image;

        $request->user()->save();

        Image::make("storage/uploads/users/{$request->user()->id}/profile/{$request->user()->image}")
            ->resize(400, 400, function ($c) {
                $c->aspectRatio();
            })
            // ->crop(400, 200, 0, 0)
            ->save();

        return $this->success(202, "updated successfully", null, UserResource::make($request->user()));
    }
}
