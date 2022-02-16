
<h1>Platforms</h1>

<?php
$platforms = "<ul class='platforms'>";

$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT * FROM platforms");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
    
    for ($cnt=0; $cnt < count($resultat); $cnt++) 
    { 
    
        $platforms .= "<li><a href='index.php?page=platformGames&id=" . $resultat[$cnt]->id_platform . "'>";
        $platforms .= "<h2>" . $resultat[$cnt]->model . "</h2>";

        $platforms .= "<h3>" . $resultat[$cnt]->manufacturer . "</h3>";

        
        $platforms .= "</a></li>";
    }

    $platforms .= "</ul>";

    echo $platforms;
} 

catch (PDOException $e) 
{
    die("Erreur :  " . $e->getMessage());
} 
