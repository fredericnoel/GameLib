<h1>Games Library</h1>

<?php
$games = "<table class='games'>
<thead>
    <tr>
        <th><a href='index.php?page=library&ascTitre=" . (isset($_GET['ascTitre']) ? ($_GET['ascTitre'] ? "0" : "1") : "1") . "'>Titre</a></th>
        <th><a href='index.php?page=library&ascDate=" . (isset($_GET['ascDate']) ? ($_GET['ascDate'] ? "0" : "1") : "1") . "'>Date de sortie</a></th>
        <th>Description</th>
    </tr>
</thead>

<tbody>";



$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";

try {

    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $requete = $conn->prepare("SELECT * FROM games" . 
        (isset($_GET['ascTitre']) ? 
            ($_GET['ascTitre'] ? " ORDER BY title ASC" : " ORDER BY title DESC") 
        : "") . 
        (isset($_GET['ascDate']) ? 
        ($_GET['ascDate'] ? " ORDER BY releasedate ASC" : " ORDER BY releasedate DESC") 
        : ""));
    
    $requete->execute();

    $conn = null;

    $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
   
    for ($cnt=0; $cnt < count($resultat); $cnt++) 
    { 
        $games .= "<tr>";
        $games .= "<td>" . $resultat[$cnt]->title . "</td>";

        $date = DateTime::createFromFormat('Y-m-j', $resultat[$cnt]->releasedate);
        $games .= "<td>" . $date->format('d M Y') . "</td>";
        
        $games .= "<td>" . $resultat[$cnt]->description . "</td>";
        $games .= "</tr>";
    }

    $games .= "</tbody>
    </table>";

    echo $games;

    echo "<a href=index.php?page=games>Ajouter un jeu</a>";
} 

catch (PDOException $e) 
{
    die("Erreur :  " . $e->getMessage());
}
