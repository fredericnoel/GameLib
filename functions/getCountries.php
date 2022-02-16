<?php

function getCountries()
{
    $serverName = "localhost";
    $userName = "root";
    $database = "countries";
    $userPassword = "";
    
    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $requete = $conn->prepare("SELECT * FROM continents ORDER BY name ASC");
    $requete -> execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    
        $html = "<select>";
        for ($i = 0 ; $i < count($resultat) ; $i++) {
            $requete2 = $conn->prepare("SELECT name,code  FROM countries WHERE continent_code = 
                '". $resultat[$i]['code']."' ORDER BY name ASC");
            $requete2 -> execute();
            $resultat2 = $requete2->fetchAll(PDO::FETCH_ASSOC);
            
            $html .= "<optgroup label='" . $resultat[$i]['name'] . "'>";
    
            for ($j = 0 ; $j < count($resultat2) ; $j++) {
                $html .= "<option value='" . $resultat2[$j]['code'] . "'>";
                $html .= $resultat2[$j]['name'] . " - " . $resultat2[$j]['code'];
            
                $html .= "</option>";
            }
            $html .= "</optgroup>";
        }
        $html .= "</select>";
        return $html;
}