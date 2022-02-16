<?php
function getStudios(bool $triCroissant) : string
{
    $tri = "";
    if ($triCroissant){
        $tri = "ASC";
    }else {
        $tri = "DESC";
    }
    $connHandler = new Sql();
    $resultats = $connHandler->select("SELECT * FROM studios ORDER BY name " . $tri );

    $text = "";

    for ($cnt=0; $cnt < count($resultats); $cnt++) 
    { 
        $text .= "<option value='" . $resultats[$cnt]->id_studio . "'>";
        $text .= $resultats[$cnt]->name;
        $text .= "</option>";
    }

    return $text;

}
