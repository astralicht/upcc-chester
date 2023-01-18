<?php

namespace Main\Controllers;

use Main\Models\UpdateModel;

session_start();

class UploadController {
    
    // Uses POST HTTP request type
    function image() {
        $file = $_FILES["image-input"];
        $data = $_POST;

        $fileName = $file["name"];
        $fileTempName = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        $imageType = $data["image-type"]; //image type is either user or product

        $fileExt = explode(".", $fileName);
        $fileExt = strtolower(end($fileExt));
        $allowed = ["jpg", "png", "webp"];

        if (!in_array($fileExt, $allowed)) {
            echo "That image format is not supported!";
            return;
        }

        if ($fileError !== 0) {
            echo "There was an error uploading your file";
            return;
        }

        if ($fileSize > 10000000) {
            echo "The file that you are trying to upload is too big";
            return;
        }

        $fileNameNew = uniqid("", true) . "." . $fileExt;

        $fileDestination = "uploads/img/" . $fileNameNew;
        move_uploaded_file($fileTempName, $fileDestination);

        $UpdateModel = new UpdateModel();
        $response = $UpdateModel->updateImageData($fileDestination, $fileName, $imageType, $data["id"]);
        
        if ($response["status"] === 200) unlink($data["old-image-path"]);

        if (strtoupper($imageType) === "USER") {
            header("Location: ../" . strtolower($_SESSION["type"]) . "/edit-info?id=" . $data["id"]);
        }

        if (strtoupper($imageType) === "PRODUCT") {
            header("Location: ../" . strtolower($_SESSION["type"]) . "/edit-product?id=" . $data["id"]);
        }

        if (strtoupper($imageType) === "SHOP") {
            header("Location: ../" . strtolower($_SESSION["type"]) . "/edit-shop?id=" . $data["id"]);
        }
    }
    
}
