<?php
if($_POST){

// include database connection
include '../config_database.php';

// to have 'Access-Control-Allow-Origin' header present on the requested resource
header('Access-Control-Allow-Origin: http://localhost:4200', false);
header('Access-Control-Allow-Methods: GET, POST');

try{

// insert query
$query = "INSERT INTO books SET titre=:titre, nom_auteur=:nom, prenom_auteur=:prenom, resume=:resume";
// prepare query for execution
$stmt = $con->prepare($query);
// posted values
$titre = $_POST['titre'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$resume = $_POST['resume'];
// bind the parameters
$stmt->bindParam(':titre', $titre);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':resume', $resume);
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