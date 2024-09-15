<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ImageService
{
    protected $imageStoragePath = 'storage/avatars';
    protected $userDefaultImage = 'userdefault.png';

    public function handleImageStore($request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move(public_path($this->imageStoragePath), $filename);
            return $filename;
        }
        return $this->userDefaultImage;
    }

    public function handleImageUpdate($request, $data)
    {
        if ($request->hasFile('image')) {
            $oldImage = public_path($this->imageStoragePath . '/' . $data->image);

            if ($data->image != $this->userDefaultImage && File::exists($oldImage)) {
                File::delete($oldImage);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $file->move(public_path($this->imageStoragePath), $filename);
            return $filename;
        }
        return $data->image;
    }

    public function handleImageDelete($imageName)
    {
        if ($imageName != $this->userDefaultImage) {
            $filePath = public_path($this->imageStoragePath . '/' . $imageName);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }
    
}