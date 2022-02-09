<h1>Game</h1>
<?php
$game = "";

$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $requete = $conn->prepare("SELECT * FROM games WHERE id_game = " .  $_GET['id']);
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
   
    for ($cnt=0; $cnt < count($resultat); $cnt++) 
    { 
        $game .= "<h2><a href='index.php?page=game&id=" . $resultat[$cnt]->id_game . "'>" . $resultat[$cnt]->title . "</a></h2>";

        $date = DateTime::createFromFormat('Y-m-j', $resultat[$cnt]->releasedate);
        $game .= "<h3>" . $date->format('d M Y') . "</h3>";
        
        $game .= "<p>" . $resultat[$cnt]->description . "</p>";
    }


    echo $game;
} 

catch (PDOException $e) 
{
    die("Erreur :  " . $e->getMessage());
}