<form action="index.php?page=studio" method="post">
    <ul>
        <li>
            <label for="name">Nom :</label>
        <input type="text" id="name" name="name" value="<?php echo $name;?>" />
    </li>
        <li>
            <label for="country">Pays:</label>
            <select name="country" id="country">
                <option value="">France - FR</option>
            </select>
        </li>
        <li>
            <input type="reset" value="Effacer" />
            <input type="submit" value="Valider le choix" name="validation" />
        </li>
    </ul>
</form>