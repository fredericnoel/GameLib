<?php

$serverName = "localhost";
$userName = "root";
$database = "GameLib";
$userPassword = "root"; // Mot de passe nécessaire sous Mac.


// Tri par Ascendant et descendant
if (!isset($_GET['filter'])){
    $_GET['filter']='ASC';
}
$filtre = $_GET['filter'];

// Tri par nom ou par pays
if (!isset($_GET['cat'])){
    $_GET['cat']='name';
}
$categorie = $_GET['cat'];

function triTab($filtre) {
  if ($filtre === 'ASC')
    $filtre = 'DESC';
else {
    $filtre = 'ASC';
}
    return $filtre;
}


$tri = triTab($filtre);


try{
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT * FROM editors ORDER BY $categorie $tri");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    $html = "<table>";
    $html .= "<tr>";
    $html .= "<th><a href=\"index.php?page=visuediteurs&filter=$tri&cat=id_editor\">ID</a></th>";
    $html .= "<th><a href=\"index.php?page=visuediteurs&filter=$tri&cat=name\">Nom</a></th>";
    $html .= "<th><a href=\"index.php?page=visuediteurs&filter=$tri&cat=country\">Pays</a></th>";
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
