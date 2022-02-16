

<?php

$platform = "";

$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT games.title, games.releasedate, games.description, platforms.model
    FROM platforms
    INNER JOIN games_has_platforms
    ON  platforms.id_platform  = games_has_platforms.id_platform
    INNER JOIN games
    ON games_has_platforms.id_game = games.id_game
    WHERE platforms.id_platform =' " . intval($_GET["id"]) . "' ");
    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_OBJ);

    echo isset($resultat[0]) ? ("<h1>Games on " . $resultat[0]->model . "</h1>") : ("<h1>There are no games on this platform yet</h1>");


    $games = "<ul class='games'>";

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