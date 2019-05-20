<?php
include "db_connect.php";


if (isset($_POST["checkbox"])) {
    $target_dir = "D:\OSPanel\domains\Runal\backend\img\about\about/";

}else  {
    $target_dir = "D:\OSPanel\domains\Runal\backend\img\about\header/";

}
$target_file = $target_dir . basename($_FILES["filename"]["name"]);

$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    $check = getimagesize($_FILES["filename"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "<h2>" . "File is not image" . "</h2>";
    }
    if (file_exists($target_file)) {
        $errors[] = "<h2>" . "File is already exist" . "</h2>";
    }
    if ($_FILES["filename"]["size"] > 5000000) {
        $errors[] = "<h2>" . "File is very large" . "</h2>";
    }
    if ($_FILES["filename"]["size"] < 2000) {
        $errors[] = "<h2>" . "File is very small" . "</h2>";
    }
    if ($imageFileType != "jpg") {
        $errors[] = "<h2>" . "Only JPG" . "</h2>";
    }

    if (!empty($errors)) {
        echo $errors['0'];
    } else {
        $format = ['jpg'];
        $newFilename = (1) . '.' . end($format);
        if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_dir . $newFilename)) {
            echo "<h2>" . "File has been uploaded" . "</h2>";
        }
    }

