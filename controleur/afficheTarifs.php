<?php

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.liaison.inc.php";

$liaisons = getLiaisonsLignes();
$tarifsLiaisons = array();


$lesCategories = getCategories();
$lesPeriodes = getPeriodes();
// $categoriesTypes = getTypesBillets();

$lesTarifs = getTarifs();
if (isset($_POST['idPeriode']) && $_POST['idPeriode'] != "") {
    $idPeriode = $_POST['idPeriode'];
    $lesTarifs = getTarifsPeriode($idPeriode);
} else {
    $lesTarifs = getTarifs();
}


$titre = "Tarifs des liaisons";
// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAfficheTarifs.php";
include "$racine/vue/footer.php";
?>