<h1>Games Library</h1>

<?php
$games = "<ul class='games'>";

$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $requete = $conn->prepare("SELECT * FROM games");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
   
    for ($cnt=0; $cnt < count($resultat); $cnt++) 
    { 
        $games .= "<li>";
        $games .= "<h2>" . $resultat[$cnt]->title . "</h2>";

        $date = DateTime::createFromFormat('Y-m-j', $resultat[$cnt]->releasedate);
        $games .= "<h3>" . $date->format('d M Y') . "</h3>";
        
        $games .= "<p>" . $resultat[$cnt]->description . "</p>";
        $games .= "</li>";
    }

    $games .= "</ul>";

    echo $games;
} 

catch (PDOException $e) 
{
    die("Erreur :  " . $e->getMessage());
}