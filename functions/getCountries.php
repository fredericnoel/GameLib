<?php

function getCountries()
{
    $serverName = "localhost";
    $userName = "root";
    $database = "countries";
    $userPassword = "";
    
    $connCountries = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $connCountries->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $requeteContinents = $connCountries->prepare("SELECT * FROM continents ORDER BY name ASC");
    $requeteContinents -> execute();
    $resultatContinents = $requeteContinents->fetchAll(PDO::FETCH_ASSOC);
    
        $html = "<select name='country[]'>";
        for ($i = 0 ; $i < count($resultatContinents) ; $i++) {
            $requeteCountries = $connCountries->prepare("SELECT name,code  FROM countries WHERE continent_code = 
                '". $resultatContinents[$i]['code']."' ORDER BY name ASC");
            $requeteCountries -> execute();
            $resultatCountries = $requeteCountries->fetchAll(PDO::FETCH_ASSOC);
            
            $html .= "<optgroup label='" . $resultatContinents[$i]['name'] . "'>";
    
            for ($j = 0 ; $j < count($resultatCountries) ; $j++) {
                $html .= "<option value='" . $resultatCountries[$j]['code'] . "'>";
                $html .= $resultatCountries[$j]['name'] . " - " . $resultatCountries[$j]['code'];
            
                $html .= "</option>";
            }
            $html .= "</optgroup>";
        }
        $html .= "</select>";
        return $html;
}