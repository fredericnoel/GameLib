<form method="post" action="index.php?page=games">
    <ul>
        <li><label for="title"> Titre : </label>
            <input type="texte" id="title" name="title" value="<?php echo $title;?>"><br></li>

        <li><label for="releaseDate"> Date de sortie : </label><input type="date" id="releaseDate" name="releaseDate"
                value="<?php echo $releaseDate;?>"><br></li>

        <li><label for="description"> Description : </label>
            <textarea id="description" name="description" value="<?php echo $description;?>"></textarea><br></li>

        <li><input type="reset" value="Effacer">
            <input type="submit" value="Valider" name="validation"></li>
    </ul>
</form>
