<h1>Studios</h1>
<?php

$serverName = "localhost";
$userName = "root";
$database = "countries";
$userPassword = "";

$conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = $conn->prepare("SELECT name,code FROM countries ORDER BY name ASC");
$requete -> execute();
$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    $html = "<select>";
    for ($i = 0 ; $i < count($resultat) ; $i++) {
        $html .= "<option value='" . $resultat[$i]['code'] . "'>";
        $html .= $resultat[$i]['name'] . " - " . $resultat[$i]['code'];
        $html .= "</option>";
    }

    $html .= "</select>";
    echo $html;
    
    // die();
    //affichage des données dans un tableau, récupération de la bdd gamelib
$serverName = "localhost";
$userName = "root";
$database = "gamelib";
$userPassword = "";

$conn2 = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$requete = $conn2->prepare("SELECT * FROM studios ORDER BY name ASC");
$requete -> execute();
$resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

$html = "<table>";
$html .= "<tr>";
$html .= "<th>ID studio</th>";
$html .= "<th>Name</th>";
$html .= "<th>Country</th>";
$html .= "</tr>";

for ($i = 0; $i < count($resultat); $i++){
    $html .= "<tr>";
    $html .= "<td>" . $resultat[$i]['id_studio'] . "</td>";
    $html .= "<td>" . $resultat[$i]['name'] . "</td>";
    $html .= "<td>" . $resultat[$i]['country'] . "</td>";
    $html .= "</tr>";
}
    $html .= "</table>";

    echo ($html);

    $conn2 = null;

    //fin du code pour affichage du tableau

    //insertion de données dans la bdd gamelib si le role de l'utilisateur le permet (studios)

if (isset($_SESSION['login']) && ($_SESSION['role'] >=3 )){
        echo "Vous avez les droits pour insérer des données.";

    if (isset($_POST['validation'])) {
        $name = htmlentities($_POST['name']) ?? '';
        $country = htmlentities(mb_strtoupper(trim($_POST['country']))) ?? '';
        
        $erreur = array();

        if (strlen($name) === 0){
            array_push($erreur, "Veuillez saisir Le nom du studio");
        }
        else
            $name = html_entity_decode($name);
            
        if (strlen($country) === 0){
            array_push($erreur, "Veuillez saisir le pays d'origine du studio");
        }
        else
            $country = html_entity_decode($country);

            //vérification de la présence d'un studio dans la bdd
        if (count($erreur) === 0) {
            $serverName = "localhost";
            $userName = "root";
            $database = "gamelib";
            $userPassword = "";

            try {
                $conn2 = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
                $conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                $requete = $conn2->prepare("SELECT * FROM studios WHERE name = '$name'");
                $requete->execute();
                $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
            //studio déja renseigné dans la bdd
                if(count($resultat) !== 0) {
                    echo "<p>Le studio est déjà enregistré</p>";
                }
            //studio non renseigné donc à insérer dans la bdd    
                else{$query = $conn2->prepare("
                    INSERT INTO studios(name, country)
                    VALUES (:name, :country)
                    ");

                    $query->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
                    $query->bindParam(':country', $country, PDO::PARAM_STR_CHAR);

                    $query->execute();
                    
                    echo "<p>Insertions effectuées</p>";
                }
            }
            catch (PDOException $e) {
                die("Erreur :  " . $e->getMessage());
            }

            $conn2 = null;
        } else {
            $messageErreur = "<ul>";
            $i = 0;
            do {
                $messageErreur .= "<li>" . $erreur[$i] . "</li>";
                $i++;
            } while ($i < count($erreur));

            $messageErreur .= "</ul>";

            echo $messageErreur;
            include 'frmStudio.php';
        }
    } 
    else {
        echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
        $name = $country = '';

        include 'frmStudio.php';
    }
}
else
    echo "Vous n'avez pas les droits";

