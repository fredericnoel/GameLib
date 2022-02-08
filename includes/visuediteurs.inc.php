<?php

$serverName = "localhost";
$userName = "root";
$database = "GameLib";
$userPassword = "root"; // Mot de passe nécessaire sous Mac.

try{
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT * FROM editors ORDER BY name ASC");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    $html = "<table>";
    $html .= "<tr>";
    $html .= "<th>ID</th>";
    $html .= "<th>Nom</th>";
    $html .= "<th>Pays</th>";
    $html .= "</tr>";

    for($i = 0 ; $i < count($resultat) ; $i++) {
        $html .= "<tr>";
        
        foreach($resultat[$i] as $key=>$value) {
                $html .= "<td>";
                $html .= $value;
                $html .= "</td>";
            }
        $html .= "</tr>";
        }

    $html .= "</table>";

    echo $html;
    }

catch(PDOException $e){
    die("Erreur :  " . $e->getMessage());
}
