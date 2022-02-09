<h1>Editeurs</h1>
<?php

// On recupère ici les éléments de session
// $_SESSION['role'] = 3;
// $_SESSION['login'] = TRUE;

if(isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['role'] > 2) {
    if (isset($_POST['editeur'])) {
        $country = htmlentities(mb_strtoupper(trim($_POST['country']))) ?? '';
        $name = htmlentities(ucwords(mb_strtolower(trim($_POST['name'])))) ?? '';
        $erreur = array();
    
        $pattern =  '/(*UTF8)^[[:alnum:]\-_\s]+$/';
    
        if (preg_match($pattern, html_entity_decode($name)) !== 1)
            array_push($erreur, "Veuillez saisir le nom de l'éditeur");
        else
            $name = html_entity_decode($name);
    
        if (preg_match($pattern, html_entity_decode($country)) !== 1)
            array_push($erreur, "Veuillez saisir le pays de l'éditeur");
        else
            $country = html_entity_decode($country);
       
    
        if (count($erreur) === 0) {
            $serverName = "localhost";
            $userName = "root";
            $database = "gamelib";
            $userPassword = "root"; // Mot de passe nécessaire sous Mac.
    
            try {
                $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                $query = $conn->prepare("INSERT INTO editors(name, country) VALUES (:name, :country)");
    
                $query->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
                $query->bindParam(':country', $country, PDO::PARAM_STR_CHAR);
                
                $query->execute();
    
                
                echo "<p>Insertions effectuées</p>";
               
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
            include 'frmEditeurs.php';
        }
    } else {
        echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
        $name = '';
        include 'frmEditeurs.php';
    }
}
else {
    echo "<p>Vous ne disposez pas des droits, veuillez contacter l'administrateur du site.</p>";
}



?>

