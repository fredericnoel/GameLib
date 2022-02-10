<?php
        
    $serverName = "localhost";
    $userName = "root";
    $database = "gamelib";
    $userPassword = "";

    try{
        $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $requete = $conn->prepare("SELECT * FROM editors ORDER BY name ASC");
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        // $idEditor = $resultat['id_editor'];
        // $nameEditor = $resultat['name'];
        // $nameCountry = $resultat['country'];

        $html = "<form method='post' action='index.php?page=visuediteurs'>";
        $html .= "<ul>";
        $html .= "<li><label for='editor'>Editeurs : </label>";
        $html .= "<select name='editor' id='editor'>";



        $html .= "</select></li></ul></form>";
        
        dump($resultat);


                        // $html = "<option value='$idEditor'>$nameEditor ($nameCountry)</option>";

                        // for($i = 0 ; $i < count($resultat) ; $i++) { 
                            // foreach($resultat[$i] as $key=>$value) {
                            // $html = "<option value='$idEditor'>$nameEditor ($nameCountry)</option>";
                            // }
                            // }
                            echo $html;
                            }

                            catch(PDOException $e){
                            die("Erreur : " . $e->getMessage());
                            }

                            $conn= null;

?>

            
</li>
        <li><label for="studio">Studio : </label>
            <select name="studio" id="studio">
                <option value="France">France </option>
                <option value="Afghanistan">Afghanistan </option>
            </select>
        </li>
        <li><input type="submit" value="Envoyer" name="envoi" /></li>
    </ul>
</form>