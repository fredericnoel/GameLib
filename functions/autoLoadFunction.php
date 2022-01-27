<?php
$functionFiles = glob('./functions/*.php');

for ($i = 0 ; $i < count($functionFiles) ; $i++) {
    require_once $functionFiles[$i];
}