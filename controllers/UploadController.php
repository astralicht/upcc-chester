<?php

namespace Main\Controllers;

use Main\Models\UpdateModel;

session_start();

class UploadController {
    
    // Uses POST HTTP request type
    function image($data) {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['name'];
        $fileError = $_FILES['file']['name'];
        $fileType = $_FILES['file']['name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'png', 'webp');
        if (!in_array($fileActualExt, $allowed)) echo "Invalid file type!";
        if (!$fileError === 0) echo "There was an error uploading your file";
        if ($fileSize < 10000000000) echo "The file that you are trying to upload is too big";
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;

        $fileDestination = 'uploads/img/' . $fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
        header("Location: index.php?uploadsuccess");
    }
    
}
