<form action="index.php?page=contact" method="post">
    <ul>
        <li><label for="name">Nom :</label><input type="text" id="name" name="name" value="<?php echo $name;?>" /></li>
        <li><label for="firstname">Prénom :</label><input type="text" id="firstname" name="firstname"  value="<?php echo $firstname;?>" /></li>
        <li><label for="mail">e-mail :</label><input type="text" id="mail" name="mail"  value="<?php echo $mail;?>" /></li>
        <li><label for="message">Votre message :</label><textarea id="message" name="message"  value="<?php echo $message;?>"></textarea></li>
        <li><input type="reset" value="Effacer" /><input type="submit" value="Envoyer !" name="contact" /></li>
    </ul>
</form>