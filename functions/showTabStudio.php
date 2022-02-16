<?php

function showTabStudio()
{
$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";
    
$connStudio = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
$connStudio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = $connStudio->prepare("SELECT * FROM studios ORDER BY name ASC");
$requete -> execute();
$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

$html = "<table>";
$html .= "<tr>";
$html .= "<th>ID studio</th>";
$html .= "<th>Name</th>";
$html .= "<th>Country</th>";
$html .= "</tr>";

for ($i = 0; $i < count($resultat); $i++){
    $html .= "<tr>";
    $html .= "<td>" . $resultat[$i]['id_studio'] . "</td>";
    $html .= "<td>" . $resultat[$i]['name'] . "</td>";
    $html .= "<td>" . $resultat[$i]['country'] . "</td>";
    $html .= "</tr>";
}
    $html .= "</table>";

    return ($html);

}