<h1>Login</h1>
<?php
if (isset($_POST['envoi'])) {
    $mail = htmlentities(trim($_POST['mail'])) ?? '';
    $mdp = htmlentities(trim($_POST['mdp'])) ?? '';

    $erreur = array();

    if (strlen($mail) === 0)
        array_push($erreur, "Veuillez saisir votre nom");

    if (strlen($mdp) === 0)
        array_push($erreur, "Veuillez saisir un mot de passe");

    if (count($erreur) === 0) {
        try{
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //$estcequilestdanslabase = $conn->query("SELECT * FROM utilisateurs WHERE mail='$mail'");
            //$nombreLignes = $estcequilestdanslabase->fetchColumn();

            $requete = $conn->prepare("SELECT * FROM users WHERE email='$mail'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
           
            if(count($resultat) === 0) {
                echo "Pas de résultat avec votre login/mot de passe";
            }

            else {
                $mdpRequete = $resultat[0]->password;
                if(password_verify($mdp, $mdpRequete)) {
                    if(!isset($_SESSION['login'])) {
                        $_SESSION['login'] = true;
                        $_SESSION['nom'] = $resultat[0]->name;
                        $_SESSION['prenom'] = $resultat[0]->firstname;
                        $_SESSION['role'] = $resultat[0]->id_role;
                        $_SESSION['pseudo'] = $resultat[0]->pseudo;
                        echo "<script>
                        document.location.replace('http://localhost/GameLib/');
                        </script>";
                    }
                    else {
                        echo "<p>Vous êtes déjà connecté, donc vous navez rien à faire ici";
                    }
                }
                else {
                    echo "Bien tenté, mais non";
                }
            }
                
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
    echo "<h2>Merci de renseigner le formulaire&nbsp;:</h2>";
    $mail = $mdp = '';
}

include 'frmLogin.php';
