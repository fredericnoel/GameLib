<h1>Games</h1>
<?php

dump($_POST);

if (isset($_POST['inscription'])) {
    $title = htmlentities(ucfirst(mb_strtolower(trim($_POST['title'])))) ?? '';
    $releaseDate = trim($_POST['releaseDate']) ?? '';
    $description = htmlentities(trim($_POST['description'])) ?? '';

    $erreur = array();

    if (preg_match('/(*UTF8)^[[:alpha:]]+$/', html_entity_decode($title)) !== 1)
        array_push($erreur, "Veuillez saisir un titre");
    else
        $title = html_entity_decode($title);

    if (strlen($releaseDate) === 0)
        array_push($erreur, "Veuillez saisir une date de sortie");

    if (strlen($description) === 0)
        array_push($erreur, "Veuillez saisir une description");

    if (count($erreur) === 0) {

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
