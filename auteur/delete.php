<?php
// include database connection
include '../config_database.php';

// to have 'Access-Control-Allow-Origin' header present on the requested resource
header('Access-Control-Allow-Origin: http://localhost:4200', false);
header('Access-Control-Allow-Methods: GET, POST');

try {

// get record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

// delete query
$query = "DELETE FROM auteurs WHERE a_id = ?";
$stmt = $con->prepare($query);
$stmt->bindParam(1, $id);

if($stmt->execute()){
// redirect to read records page and
// tell the user record was deleted
echo json_encode(array('result'=>'success'));
}else{
echo json_encode(array('result'=>'fail'));
}
}

// show error
catch(PDOException $exception){
die('ERROR: ' . $exception->getMessage());
}
?>