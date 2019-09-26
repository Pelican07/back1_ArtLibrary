<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=art-library-crud', 'root', '');

    } catch(PDOException $e){
        die('Erreur: '.$e->getMessage());
    }
?>