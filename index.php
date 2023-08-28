<?php
require_once "getRacine.php";
require_once "infoBDD.inc.php";
require_once "$racine/controleur/controleurPrincipal.php";

if (isset($_GET["action"])){
    $action = $_GET["action"];
}
else{
    $action = "defaut";
}

$fichier = controleurPrincipal($action);
require "$racine/controleur/$fichier";
?>
     