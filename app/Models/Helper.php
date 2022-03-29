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
            //public/uploads/customer/12 -> the path is something like this
            $destinationPath = 'uploads/' . $foldername . '/' . $id . '/';
            $filename =
                Str::slug(
                    pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    '-'
                ) .
                '.' .
                $file->getClientOriginalExtension();
            $file->move($destinationPath, $filename);

            if (!File::exists($destinationPath . 'thumb/')) {
                File::makeDirectory($destinationPath . 'large/', 0775);
                File::makeDirectory($destinationPath . 'medium/', 0775);
                File::makeDirectory($destinationPath . 'small/', 0775);
                File::makeDirectory($destinationPath . 'thumb/', 0775);
            }

            //large image
            $img = Image::make($destinationPath . $filename)->resize(
                '1200',
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->save($destinationPath . 'large/' . $filename, 90);
            //medium image
            $img = Image::make($destinationPath . $filename)->resize(
                600,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->save($destinationPath . 'medium/' . $filename, 90);
            //small image
            $img = Image::make($destinationPath . $filename)->resize(
                300,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->save($destinationPath . 'small/' . $filename, 90);
            //thumb image
            $img = Image::make($destinationPath . $filename)->resize(
                75,
                null,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->save($destinationPath . 'thumb/' . $filename, 90);
        } else {
            $filename = '';
            return $filename;
        }
    }
}