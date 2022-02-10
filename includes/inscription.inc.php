<h1>Inscription</h1>
<?php
if (isset($_POST['inscription'])) {
    $name = htmlentities(mb_strtoupper(trim($_POST['name']))) ?? '';
    $firstname = htmlentities(ucfirst(mb_strtolower(trim($_POST['firstname'])))) ?? '';
    $email = trim(mb_strtolower($_POST['email'])) ?? '';
    $password = htmlentities(trim($_POST['password'])) ?? '';
    $passwordverif = htmlentities(trim($_POST['passwordverif'])) ?? '';
    $pseudo = htmlentities(trim($_POST['pseudo'])) ?? '';
    $bio = htmlentities(trim($_POST['bio'])) ?? '';

    $erreur = array();

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($name)) !== 1)
        array_push($erreur, "Veuillez saisir votre nom");
    else
        $name = html_entity_decode($name);

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($firstname)) !== 1)
        array_push($erreur, "Veuillez saisir votre prénom");
    else
        $firstname = html_entity_decode($firstname);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (strlen($password) === 0)
        array_push($erreur, "Veuillez saisir un mot de passe");

    if (strlen($passwordverif) === 0)
        array_push($erreur, "Veuillez saisir la vérification de votre mot de passe");

    if ($password !== $passwordverif)
        array_push($erreur, "Vos mots de passe ne correspondent pas");

    if (strlen($pseudo) === 0)
        array_push($erreur, "Veuillez saisir un pseudo");

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $fileName = $_FILES['avatar']['name'];
        $fileType = $_FILES['avatar']['type'];
        $fileTmpName = $_FILES['avatar']['tmp_name'];
        
        $tableauTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($fileType, $tableauTypes)) {
            $path = getcwd() . "/avatars/";
            $date = date('Ymdhis');
            $fileName = $date . $fileName;
            $fileNameFinal = $path . $fileName;
            $fileNameFinal = str_replace("\\", "/", $fileNameFinal);
        }
        else {
            array_push($erreur, "Erreur type MIME");
        }
    } else {
        $fileUploadError = $_FILES['avatar']['error'];
        switch($fileUploadError) {
            case 1 :
                $fileUploadErrorMessage = "La taille du fichier téléchargé excède la valeur de upload_max_filesize.";
            break;
            case 2 :
                $fileUploadErrorMessage = "La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.";
            break;
            case 3 :
                $fileUploadErrorMessage = "Le fichier n'a été que partiellement téléchargé.";
            break;
            case 4 :
                $fileUploadErrorMessage = "Aucun fichier n'a été téléchargé.";
            break;
            case 6 :
                $fileUploadErrorMessage = "Un dossier temporaire est manquant.";
            break;
            case 7 :
                $fileUploadErrorMessage = "Échec de l'écriture du fichier sur le disque.";
            break;
            case 8 :
                $fileUploadErrorMessage = "Une extension PHP a arrêté l'envoi de fichier.";
            break;
        }

        array_push($erreur, "Erreur upload : " . $fileUploadErrorMessage);
    }

    if (count($erreur) === 0) {
        $serverName = "localhost";
        $userName = "root";
        $database = "gamelib";
        $userPassword = "";

        try {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $requete = $conn->prepare("SELECT * FROM users WHERE email='$email'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
           
            if(count($resultat) !== 0) {
                echo "<p>Votre adresse est déjà enregistrée dans la base de données</p>";
            }

            else {
                $pseudo = html_entity_decode($pseudo);
                $query = $conn->prepare("
                INSERT INTO users(name, firstname, email, pseudo, password, bio, avatar)
                VALUES (:name, :firstname, :email, :pseudo, :password, :bio, :avatar)
                ");

                $query->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
                $query->bindParam(':firstname', $firstname, PDO::PARAM_STR_CHAR);
                $query->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
                $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR_CHAR);
                $query->bindParam(':password', $password);
                $query->bindParam(':bio', $bio);
                $query->bindParam(':avatar', $fileNameFinal);
                $query->execute();

                move_uploaded_file($fileTmpName, $path . $fileName);
                
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
        include 'frmInscription.php';
    }
} else {
    echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
    $name = $firstname = $email = $pseudo = $bio = '';
    include 'frmInscription.php';
}
    
