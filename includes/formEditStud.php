<?php      
    $serverName = "localhost";
    $userName = "root";
    $database = "gamelib";
    $userPassword = "";

try{
        $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $conn->prepare("SELECT * FROM editors ORDER BY name ASC");
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

        $requete2 = $conn->prepare("SELECT * FROM studios ORDER BY name ASC");
        $requete2->execute();
        $resultat2 = $requete2->fetchAll(PDO::FETCH_ASSOC);

        $html = "<form action='index.php?page=editeur_studio' method='post'>";
        $html .="<label for='editor'>Editeur : </label>";
        $html .="<select name='editor' id='editor'>";
        
        for($i = 0 ; $i < count($resultat) ; $i++) {
            $indexEditeur = $resultat[$i]['id_editor'];
            $nameEditeur = $resultat[$i]['name'];

            $html .="<option value=$indexEditeur>$nameEditeur</option>";
           
        }
        $html .= "</select>";
        $html .="<label for='studio'>Studio : </label>";
        $html .="<select name='studio[]' id='studio' multiple>";
        
        for($i = 0 ; $i < count($resultat2) ; $i++) {
            $indexStudio = $resultat2[$i]['id_studio'];
            $nameStudio = $resultat2[$i]['name'];

            $html .="<option value=$indexStudio>$nameStudio</option>";
           
        }
        $html .= "</select>";

        $html .= "<input type='submit' value='Valider' name='linkEditor' />";
        $html .= "</form>";
        echo $html;

}
catch(PDOException $e){
die("Erreur : " . $e->getMessage());
}
$conn= null;
            