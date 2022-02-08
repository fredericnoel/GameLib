<form action="index.php?page=studio" method="post" enctype="multipart/form-data">
    <ul>
        <li><label for="name">Nom :</label><input type="text" id="name" name="name" value="<?php echo $name;?>" /></li>
        <li><label for="country">Pays:</label><input type="text" id="country" name="country"  value="<?php echo $country;?>" /></li>
        <li><input type="reset" value="Effacer" /><input type="submit" value="Valider le choix" name="validation" />
    </ul>
</form>