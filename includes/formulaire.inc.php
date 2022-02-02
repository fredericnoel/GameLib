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
            echo "Connexion OK";

            $conn->beginTransaction();

            $sql1 = "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp)
            VALUES (NULL, 'DURAND', 'Michel', 'michel@durand.com', '1234')";
            $conn->exec($sql1);
            $sql2 = "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp)
            VALUES (NULL, 'DUPONT', 'René', 'renedu 27@gmail.com', 'bibiche')";
            $conn->exec($sql2);

            $conn->commit();
            echo "<p>Insertions effectuées</p>";
        }
        catch(PDOException $e){
            $conn->rollBack();
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

        echo password_hash($password,  PASSWORD_DEFAULT);



    }
} else {
    echo "Merci de renseigner le formulaire";
    $nom = $prenom = $email = '';
}


include 'frmFormulaire.php';
