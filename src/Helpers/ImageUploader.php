<?php

namespace Inventory\Helpers;

class ImageUploader
{
    public static function upload($file, $directory = 'products')
    {
        $target_dir = __DIR__ . "/../../public/uploads/{$directory}/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            throw new \Exception("File is not an image.");
        }

        // Check file size
        if ($file["size"] > 500000) {
            throw new \Exception("Sorry, your file is too large.");
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            throw new \Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Generate unique filename
        $new_filename = uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return "/uploads/{$directory}/" . $new_filename;
        } else {
            throw new \Exception("Sorry, there was an error uploading your file.");
        }
    }
}