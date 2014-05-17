<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=medical', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>