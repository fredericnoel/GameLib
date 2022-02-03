<?php
if (isset($_POST['frm'])) {
    $nom = htmlentities(trim($_POST['nom'])) ?? '';
    $prenom = htmlentities(trim($_POST['prenom'])) ?? '';
    $email = htmlentities(trim($_POST['email'])) ?? '';
    $password = htmlentities(trim($_POST['password'])) ?? '';
    $passwordverif = htmlentities(trim($_POST['passwordverif'])) ?? '';

    $erreur = array();

    if (strlen($nom) === 0)
        array_push($erreur, "Veuillez saisir votre nom");

    elseif (!ctype_alpha($nom))
        array_push($erreur, "Veuillez saisir des caractères alphabétiques");

    if (strlen($prenom) === 0)
        array_push($erreur, "Veuillez saisir votre prénom");

    elseif (!ctype_alpha($prenom))
        array_push($erreur, "Veuillez saisir des caractères alphabétiques");

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (strlen($password) === 0)
        array_push($erreur, "Veuillez saisir un mot de passe");

    if (strlen($passwordverif) === 0)
        array_push($erreur, "Veuillez saisir la vérification de votre mot de passe");

    if ($password !== $passwordverif)
        array_push($erreur, "Vos mots de passe ne correspondent pas");

    if (count($erreur) === 0) {
        $serverName = "localhost";
        $userName = "root";
        $database = "formulaire";
        $userPassword = "";

        try{
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $query = $conn->prepare("
                INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp)
                VALUES (:id, :nom, :prenom, :email, :password)
            ");

            $query->bindValue(':id', null);
            $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $query->bindValue(':nom', $nom);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $password);
            $query->execute();

            echo "<p>Insertions effectuées</p>";
        }
        catch(PDOException $e){
            die("Erreur :  " . $e->getMessage());
        }

        $conn = null;
    } else {
        $messageErreur = "<ul>";
        $i = 0;
        do {
            $messageErreur .= "<li>";
            $messageErreur .= $erreur[$i];
            $messageErreur .= "</li>";
            $i++;
        } while ($i < count($erreur));

        $messageErreur .= "</ul>";

        echo $messageErreur;
    }
} else {
    echo "Merci de renseigner le formulaire";
    $nom = $prenom = $email = '';
}

include 'frmFormulaire.php';
