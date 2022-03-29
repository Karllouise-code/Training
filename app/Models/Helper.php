<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Str;
use File;
use Image;

class Helper extends Eloquent
{
    public function ImageUpload($file, $id, $foldername)
    {
        if ($file != '') {
            $destinationPath = 'uploads/' . $foldername . '/' . $id . '/';
            $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-') . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);

            if (!File::exists($destinationPath . 'thumb/')) {
                File::makeDirectory($destinationPath . 'large/', 0775);
                File::makeDirectory($destinationPath . 'medium/', 0775);
                File::makeDirectory($destinationPath . 'small/', 0775);
                File::makeDirectory($destinationPath . 'thumb/', 0775);
            }
            // for large images
            $img = Image::make($destinationPath . $fileName)->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . 'large/' . $fileName, 90);
            // for medium images
            $img = Image::make($destinationPath . $fileName)->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . 'medium/' . $fileName, 90);
            // for small images
            $img = Image::make($destinationPath . $fileName)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . 'small/' . $fileName, 90);
            // for thumbnail images
            $img = Image::make($destinationPath . $fileName)->resize(75, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath . 'thumb/' . $fileName, 90);
        } else {
            $fileName = '';
        }

        return $fileName;
    }
}

?>