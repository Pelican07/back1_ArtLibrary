<?php

// check if form was submitted
if($_POST){

    include '../config_database.php';

    // to have 'Access-Control-Allow-Origin' header present on the requested resource
    header('Access-Control-Allow-Origin: http://localhost:4200', false);
    header('Access-Control-Allow-Methods: GET, POST');

    try{

    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["image"]["name"];
        $filetype = $_FILES["image"]["type"];
        $filesize = $_FILES["image"]["size"];

        $files_dest = 'upload/'.$filename;

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists($files_dest)){
                echo $filename . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["image"]["tmp_name"], $files_dest);
                // $req = $db->prepare('INSERT INTO images(img_nom, img_url) VALUES(?,?)');
                // $req->execute(array($filename, $files_dest));
                echo "Votre fichier a été téléchargé avec succès.";
            } 
        } else{
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
        }
    } else{
        echo "Error: " . $_FILES["image"]["error"];
    }

    // write update query
    // in this case, it seemed like we have so many fields to pass and
    // it is better to label them and not use question marks
    $query = "UPDATE books 
                        SET titre=:titre, nom_auteur=:nom, prenom_auteur=:prenom, resume=:resume, img_url=:lien
                        WHERE id = :id";

    // prepare query for excecution
    $stmt = $con->prepare($query);

    // posted values
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $resume = $_POST['resume'];

    // bind the parameters
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':resume', $resume);
    $stmt->bindParam(':lien', $files_dest);
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