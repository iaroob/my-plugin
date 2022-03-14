<?php

$fich = fopen("taxonomias.txt", "r");

while(!feof($fich)) {
    echo fgets($fich);
}

fclose($fich);
?>
