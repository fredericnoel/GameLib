<form method="post" action="index.php?page=games">
    <ul>
        <li><label for="title"> Titre : </label>
            <input type="texte" id="title" name="title" value="<?php echo $title;?>"></li>

        <li><label for="releaseDate"> Date de sortie : </label><input type="date" id="releaseDate" name="releaseDate"
                value="<?php echo $releaseDate;?>"></li>

        <li><label for="description"> Description : </label>
            <textarea id="description" name="description"><?php echo $description;?></textarea></li>

        <li><label for="studios[]"> Studios : </label>
            <select range="studio" id="studio" name="studios[]" multiple>
            <?php echo getStudios($_GET['ascGames'] ?? "1");?>
		    </select>
            <?php echo "<a href='index.php?page=games&ascGames=" . (isset($_GET['ascGames']) ? ($_GET['ascGames'] ? "0" : "1") : "1") . "'><div class='triBtn'>Tri</div></a>";?>
        </li>
        
        <li><input type="reset" value="Effacer">
            <input type="submit" value="Valider" name="validation"></li>
    </ul>
</form>
<a href="index.php?page=library">Voir tous les jeux</a>
