<h1>Games</h1>
<?php

dump($_POST);

if (isset($_POST['validation'])) {
    $titleWords = explode(" ", mb_strtolower(trim($_POST['title']))  ?? '');
    $title = "";
    for ($cnt=0; $cnt < count($titleWords); $cnt++) { 
        $titleWords[$cnt] = ucfirst($titleWords[$cnt]);
        $title .= " " .$titleWords[$cnt];
    }
    
    $title = htmlentities($title);
    $releaseDate = trim($_POST['releaseDate']) ?? '';
    $description = htmlentities(trim($_POST['description'])) ?? '';

    $erreur = array();

    if (strlen($title) === 0)
        array_push($erreur, "Veuillez saisir un titre");
    else
        $title = html_entity_decode($title);

    if (strlen($releaseDate) === 0)
        array_push($erreur, "Veuillez saisir une date de sortie");

    if (strlen($description) === 0)
        array_push($erreur, "Veuillez saisir une description");

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
                $query = $conn->prepare("
                INSERT INTO games(title, releasedate, description)
                VALUES (:title, :releaseDate, :description)
                ");

                $query->bindParam(':title', $title, PDO::PARAM_STR_CHAR);
                $query->bindParam(':releaseDate', $releaseDate);
                $query->bindParam(':description', $description, PDO::PARAM_STR_CHAR);
                $query->execute();
                
                echo "<p>Insertions effectuées</p>";
            }
        } catch (PDOException $e) {
            die("Erreur :  " . $e->getMessage());
        }

        $conn = null;
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
