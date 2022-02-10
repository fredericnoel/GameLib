<?php
function getStudios() : string
{
    $connHandler = new Sql();
    $resultats = $connHandler->select("SELECT * FROM studios");

    $text = "";

    dump($resultats);

    for ($cnt=0; $cnt < count($resultats); $cnt++) 
    { 
        $text .= "<option value='" . $resultats[$cnt]->id_studio . "'>";
        $text .= $resultats[$cnt]->name;
        $text .= "</option>";
    }

    return $text;

}
