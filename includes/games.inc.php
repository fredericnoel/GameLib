<h1>Games</h1>
<?php

if (isset($_POST['validation'])) {

    $title = htmlentities(trim($_POST['title'])) ?? '';
    $releaseDate = trim($_POST['releaseDate']) ?? '';
    $description = htmlentities(trim($_POST['description'])) ?? '';
    $studios = $_POST['studios'] ?? [];

    $erreur = array();

    if (strlen($title) === 0)
        array_push($erreur, "Veuillez saisir un titre");

    if (strlen($releaseDate) === 0)
        array_push($erreur, "Veuillez saisir une date de sortie");

    if (strlen($description) === 0)
        array_push($erreur, "Veuillez saisir une description");
    
    if (count($studios) === 0)
        array_push($erreur, "Veuillez saisir un ou plusieurs studios");

    if (count($erreur) === 0) {
        $serverName = "localhost";
        $userName = "root";
        $database = "gamelib";
        $userPassword = "";

        try {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $requete = $conn->prepare("SELECT * FROM games WHERE title='$title'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
            
            if(count($resultat) !== 0) {
                echo "<p>Le titre du jeu est déjà enregistrée dans la base de données</p>";
            }

            else {
                try{
                    $gameQuery = "
                    INSERT INTO games(title, releasedate, description)
                    VALUES ('$title', '$releaseDate', '$description')
                    ";

                    $conn->beginTransaction();
                    $conn->exec($gameQuery);
                    
                    $game = $conn->lastInsertId();

                    for ($cnt=0; $cnt < count($studios); $cnt++) 
                    { 
                        $gameStudioQuery = "
                        INSERT INTO studios_has_games(id_studio, id_game)
                        VALUES ('$studios[$cnt]', '$game')
                        ";
                        $conn->exec($gameStudioQuery);
                    }

                    $conn->commit();
                }
                catch(PDOException $e){
                    $conn->rollBack();
                    die("Erreur :  " . $e->getMessage());
                }

                $gameQuery = "
                INSERT INTO games(title, releasedate, description)
                VALUES ('$title', '$releaseDate', '$description')
                ";
                
                echo "<p>Insertions effectuées</p>";
            }
        } catch (PDOException $e) {
            die("Erreur :  " . $e->getMessage());
        }

        $conn = null;
        
        $title = $releaseDate = $description = '';
        include 'frmGames.php';

    } else {
        $messageErreur = "<ul>";
        $i = 0;
        do {
            $messageErreur .= "<li>" . $erreur[$i] . "</li>";
            $i++;
        } while ($i < count($erreur));

        $messageErreur .= "</ul>";

        echo $messageErreur;
        include 'frmGames.php';
    }
} else {
    echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
    $title = $releaseDate = $description = '';
    include 'frmGames.php';
}
