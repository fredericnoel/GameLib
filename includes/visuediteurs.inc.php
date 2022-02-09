<?php

$serverName = "localhost";
$userName = "root";
$database = "GameLib";
$userPassword = ""; // Mot de passe nécessaire sous Mac.

// Tri par Ascendant et descendant
if ((!isset($_GET['filter'])) || (isset($_GET['filter']) && $_GET['filter']!==('ASC'))) 
    $filtre = 'ASC';
else $filtre = 'DESC';

// Tri par nom ou par pays
$tabCategorie = array('id_editor','name','country');

if ((!isset($_GET['cat'])) || (!in_array($_GET['cat'], $tabCategorie)))
    $categorie = 'name';
else $categorie=$_GET['cat'];
 
try{
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT * FROM editors ORDER BY $categorie $filtre");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    $html = "<table>";
    $html .= "<tr>";
    $html .= "<th><a href=\"index.php?page=visuediteurs&filter=$filtre&cat=id_editor\">ID</a></th>";
    $html .= "<th><a href=\"index.php?page=visuediteurs&filter=$filtre&cat=name\">Nom</a></th>";
    $html .= "<th><a href=\"index.php?page=visuediteurs&filter=$filtre&cat=country\">Pays</a></th>";
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
?>
