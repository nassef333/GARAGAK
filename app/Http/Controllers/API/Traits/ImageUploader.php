<?php

namespace App\Http\Controllers\API\Traits;

use Intervention\Image\Facades\Image;

trait ImageUploader
{
    public function uploadImage($request, $key, $path)
    {
        $img = $request->file($key);

        if ($img) {

            $stored_img_name = explode('.', $img->getClientOriginalName())[0] . '-' . time() .  '.' . $img->getClientOriginalExtension();

            $img->storeAs($path, $stored_img_name);

            return $stored_img_name;
        }
        return null;
    }

    public function uploadMultipleImages($img, $path)
    {
        $stored_img_name = explode('.', $img->getClientOriginalName())[0] . '-' . time() . '-' .
            $img->getClientOriginalExtension() . '.' . $img->getClientOriginalExtension();

        $img->storeAs($path, $stored_img_name);

        return $stored_img_name;
    }
}
