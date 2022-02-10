<?php
if(isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['role'] > 2) {
    if (isset($_POST['linkEditor'])) {
        $editor = htmlentities($_POST['editor']) ?? '';
        $studio = htmlentities($_POST['studio']) ?? '';
    
        $serverName = "localhost";
        $userName = "root";
        $database = "gamelib";
        $userPassword = "";
    
        try {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $requete = $conn->prepare("SELECT * FROM editors_has_studios WHERE id_studio=$studio");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
           
            if(count($resultat) !== 0) {
                echo "<p>Ce studio est déjà lié à un éditeur</p>";
                $conn = null;
            }
            else {
                $query = $conn->prepare("
                INSERT INTO editors_has_studios(id_editor, id_studio)
                VALUES (:editeur, :studio)
                ");
    
                $query->bindParam(':editeur', $editor, PDO::PARAM_INT);
                $query->bindParam(':studio', $studio, PDO::PARAM_INT);
                $query->execute();
              
                echo "<p>Insertions effectuées</p>";
                $conn = null;
            }
        } catch (PDOException $e) {
            die("Erreur :  " . $e->getMessage());
        }
    }else {
        echo "<h2>Merci de renseigner les bons formulaires:</h2>";
    }
    include "formEditStud.php";

}else{
    echo "<p>Vous ne disposez des droits nécessaires</p>";
}
