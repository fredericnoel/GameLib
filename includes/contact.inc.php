<?php
if (isset($_POST['contact'])) {
    $name = htmlentities(trim($_POST['name'])) ?? '';
    $firstname = htmlentities(trim($_POST['firstname'])) ?? '';
    $mail = htmlentities(trim($_POST['mail'])) ?? '';
    $message = htmlentities(trim($_POST['mail'])) ?? '';;

    $erreur = array();

    if (strlen($name) === 0)
        array_push($erreur, "Veuillez saisir votre nom");

    if (strlen($firstname) === 0)
        array_push($erreur, "Veuillez saisir votre prénom");

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        array_push($erreur, "Veuillez saisir un e-mail valide");

    if (strlen($message) === 0)
        array_push($erreur, "Veuillez saisir un message");

    if (count($erreur) === 0) {

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

        include 'frmContact.php';
    }
} else {
    echo "Merci de renseigner le formulaire";
    $name = $firstname = $mail = $message = '';
    include 'frmContact.php';
}
