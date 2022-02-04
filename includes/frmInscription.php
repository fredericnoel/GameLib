<form action="index.php?page=inscription" method="post" enctype="multipart/form-data">
    <label for="name">Nom :</label><input type="text" id="name" name="name" value="<?php echo $name;?>" /><br />
    <label for="firstname">Prénom :</label><input type="text" id="firstname" name="firstname"  value="<?php echo $firstname;?>" /><br />
    <label for="email">e-mail :</label><input type="text" id="email" name="email"  value="<?php echo $email;?>" /><br />
    <label for="pseudo">Pseudo :</label><input type="text" id="pseudo" name="pseudo"  value="<?php echo $pseudo;?>" /><br />
    <label for="password">Mot de passe :</label><input type="password" id="password" name="password" /><br />
    <label for="passwordverif">Vérification mot de passe :</label><input type="password" id="passwordverif" name="passwordverif" /><br />
    <label for="bio">Bio :</label><input type="text" id="bio" name="bio"  value="<?php echo $bio;?>" /><br />
    <label for="avatar">Avatar :</label><input type="file" id="avatar" name="avatar" /><br />
    <input type="reset" value="Effacer" />
    <input type="submit" value="S'inscrire" name="inscription" />
</form>