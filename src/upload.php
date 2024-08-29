<?php 
namespace src;
require '../vendor/autoload.php';


$target_dir = "../upload/";
$target_fileAIB = $target_dir . "AIB.csv";
$target_fileRevolut = $target_dir . "Revolut.csv";

$excel = new Excel();

if (move_uploaded_file($_FILES["fileToUploadAib"]["tmp_name"], $target_fileAIB)) {
    $excel->AIBFile($target_fileAIB);
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUploadAib"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }

if (move_uploaded_file($_FILES["fileToUploadRevolut"]["tmp_name"], $target_fileRevolut)) {
    $excel->RevolutFile($target_fileRevolut);
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUploadRevolut"]["name"])). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}
$excel->create_excel();






