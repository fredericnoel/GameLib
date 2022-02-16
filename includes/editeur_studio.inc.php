<?php

if(isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['role'] > 2) {
    if (isset($_POST['linkEditor'])) {
        $editor = htmlentities($_POST['editor']) ?? '';
        $studio = $_POST['studio'] ?? '';
    
        $serverName = "localhost";
        $userName = "root";
        $database = "gamelib";
        $userPassword = "root";
    
        try {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            for ($i=0; $i <count($studio) ; $i++) { 
                $astudio = explode("," , $studio[$i]);
                $aeditor = explode("," , $editor);
                $requete = $conn->prepare("SELECT * FROM editors_has_studios WHERE id_studio=$astudio[0] && id_editor = $aeditor[0]");
                $requete->execute();

                $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
            
                if(count($resultat) !== 0) {
                    echo "<p>$astudio[1] est déjà lié à $aeditor[1]</p>";
                }
                else {
                    $query = $conn->prepare("
                    INSERT INTO editors_has_studios(id_editor, id_studio)
                    VALUES (:editeur, :studio)
                    ");
        
                    $query->bindParam(':editeur', $aeditor[0], PDO::PARAM_INT);
                    $query->bindParam(':studio', $astudio[0], PDO::PARAM_INT);
                    $query->execute();
                
                    echo "<p>$astudio[1] lié à $aeditor[1]</p>";
                    
                }
            }
            $conn=null;

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
