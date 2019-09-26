<?php
// include database connection
include '../config_database.php';

// to have 'Access-Control-Allow-Origin' header present on the requested resource
header('Access-Control-Allow-Origin: http://localhost:4200', false);
header('Access-Control-Allow-Methods: GET, POST');

// delete message prompt will be here

// select all data
$query = "SELECT m_id, titre_film, nom_realisateur, prenom_realisateur, annee, resume_film FROM movies ORDER BY m_id DESC";
$stmt = $con->prepare($query);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($results);
echo $json;
?>