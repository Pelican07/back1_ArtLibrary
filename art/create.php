<?php
if($_POST){

// include database connection
include '../config_database.php';

// to have 'Access-Control-Allow-Origin' header present on the requested resource
header('Access-Control-Allow-Origin: http://localhost:4200', false);
header('Access-Control-Allow-Methods: GET, POST');

try{

// insert query
$query = "INSERT INTO arts SET titre_oeuvre=:titre, annee=:annee,details=:details, id_auteurs=1";
// prepare query for execution
$stmt = $con->prepare($query);
// posted values
$titre = $_POST['titre'];
$annee = $_POST['annee'];
$details = $_POST['details'];
// bind the parameters
$stmt->bindParam(':titre', $titre);
$stmt->bindParam(':annee', $annee);
$stmt->bindParam(':details', $details);
// Execute the query
if($stmt->execute()){
echo json_encode(array('result'=>'success'));
}else{
echo json_encode(array('result'=>'fail'));
}
}
// show error
catch(PDOException $exception){
die('ERROR: ' . $exception->getMessage());
}
}
?>