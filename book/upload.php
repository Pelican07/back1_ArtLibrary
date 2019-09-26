<?php
    // affichage détail des données qui transitent
    var_dump($_FILES);

    // lien vers ma base de données
    require '../config_database.php';

    // Vérifier si le formulaire a été soumis
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Vérifie si le fichier a été uploadé sans erreur.
        if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["image"]["name"];
            $filetype = $_FILES["image"]["type"];
            $filesize = $_FILES["image"]["size"];

            $files_dest = 'upload/'.$_FILES["image"]["name"];

            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
    
            // Vérifie la taille du fichier - 5Mo maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
    
            // Vérifie le type MIME du fichier
            if(in_array($filetype, $allowed)){
                // Vérifie si le fichier existe avant de le télécharger.
                if(file_exists("upload/" . $_FILES["image"]["name"])){
                    echo $_FILES["image"]["name"] . " existe déjà.";
                } else{
                    move_uploaded_file($_FILES["image"]["tmp_name"], "upload/" . $_FILES["image"]["name"]);
                    $req = $db->prepare('INSERT INTO images(img_nom, img_url) VALUES(?,?)');
                    $req->execute(array($filename, $files_dest));
                    echo "Votre fichier a été téléchargé avec succès.";
                } 
            } else{
                echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
            }
        } else{
            echo "Error: " . $_FILES["image"]["error"];
        }
    }
?>
