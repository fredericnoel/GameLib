<h1>Studios</h1>
<?php
if (isset($_POST['inscription'])) {
    $name = mb_strtoupper(trim($_POST['name'])) ?? '';
    $country = htmlentities(ucfirst(mb_strtolower(trim($_POST['country'])))) ?? '';

    $erreur = array();

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($name)) !== 1)
        array_push($erreur, "Veuillez saisir le nom du studio");
    else
        $name = html_entity_decode($name);

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($country)) !== 1)
        array_push($erreur, "Veuillez saisir le pays d'origine du studio");
    else
        $country = html_entity_decode($country);


        if (count($erreur) === 0) {
            $serverName = "localhost";
            $userName = "root";
            $database = "gamelib";
            $userPassword = "";
    
            try {
                $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $password = password_hash($password, PASSWORD_DEFAULT);
    
                $query = $conn->prepare("
                    INSERT INTO users(id_studio, name, country)
                    VALUES (:id, :name, :country)
                ");
    
                $id = null;
                $query->bindParam(':id', $id);
                $query->bindParam(':name', $name);
                $query->bindParam(':country', $country);

                $query->execute();
                echo "<p>Insertions effectuées</p>";
            } catch (PDOException $e) {
                die("Erreur :  " . $e->getMessage());
            }
    
            $conn = null;
        } 
        else {
            $messageErreur = "<ul>";
            $i = 0;
            do {
                $messageErreur .= "<li>" . $erreur[$i] . "</li>";
                $i++;
            } while ($i < count($erreur));
    
            $messageErreur .= "</ul>";
    
            echo $messageErreur;
        }
    } 
    else {
        echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
        $name = $country =  '';
    }

require_once './includes/frmStudio.php';