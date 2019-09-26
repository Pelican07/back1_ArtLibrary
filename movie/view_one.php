<?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

//include database connection
include '../config_database.php';

// to have 'Access-Control-Allow-Origin' header present on the requested resource
header('Access-Control-Allow-Origin: http://localhost:4200', false);
header('Access-Control-Allow-Methods: GET, POST');

// read current record's data
try {
    // prepare select query
    $query = "SELECT m_id, titre_film, nom_realisateur, prenom_realisateur, annee, resume_film FROM movies WHERE m_id = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
 
    // this is the first question mark
    $stmt->bindParam(1, $id);
 
    // execute our query
    $stmt->execute();
 
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $json = json_encode($row);
echo $json;
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>