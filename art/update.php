<?php

// check if form was submitted
if($_POST){
include 'config/database.php';

// to have 'Access-Control-Allow-Origin' header present on the requested resource
header('Access-Control-Allow-Origin: http://localhost:4200', false);
header('Access-Control-Allow-Methods: GET, POST');

try{
// write update query
// in this case, it seemed like we have so many fields to pass and
// it is better to label them and not use question marks
$query = "UPDATE arts 
                    SET titre_oeuvre=:titre,   annee=:annee, details=:details
                    WHERE a_id = :id";

// prepare query for excecution
$stmt = $con->prepare($query);

// posted values
$id = $_POST['id'];
$titre = $_POST['titre']; 
$annee = $_POST['annee'];
$details = $_POST['details'];

// bind the parameters
$stmt->bindParam(':titre', $titre);
$stmt->bindParam(':annee', $annee);
$stmt->bindParam(':details', $details);
$stmt->bindParam(':id', $id);

// Execute the query
if($stmt->execute()){
echo json_encode(array('result'=>'success'));
}else{
echo json_encode(array('result'=>'fail'));
}

}

// show errors
catch(PDOException $exception){
die('ERROR: ' . $exception->getMessage());
}
}
?>