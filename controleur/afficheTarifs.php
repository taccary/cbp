<?php

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.liaison.inc.php";

$liaisons = getLiaisonsLignes();
$tarifsLiaisons = array();
/*foreach($liaisons as $liaison){
    array_push($tarifsLiaisons['tarifs'],getTarifs($liaison['code']));
}*/
//$tarifs = getTarifsByLiaison(15);
$tarifs = getTarifs();

$categories = getCategories();
$categoriesTypes = getCategoriesTypes();
$periodes = getPeriodes();

$titre = "Tarifs des liaisons";
// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAfficheTarifs.php";
include "$racine/vue/footer.php";
?>