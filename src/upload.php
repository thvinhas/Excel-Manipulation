<?php 
namespace src;
require '../vendor/autoload.php';

use src\Excel;

$target_dir = "../upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$type = $_POST['type'];

if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

    $excel = new Excel($target_file, $type);
    $excel->readFile();
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }




