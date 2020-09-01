<?php

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.liaison.inc.php";
$secteurs = getSecteurs();
$categories = getCategories();

if (isset($_GET['secteur'])){
    $secteurSelectionne = getSecteurById($_GET['secteur']);
    $liaisons = getLiaisonsBySecteurLignes($_GET['secteur']);
}

$dateTraversee = date("Y-m-d");
if (isset($_POST['liaison']) && isset($_POST['date'])){
    $idLiaison = $_POST['liaison'];
    $dateTraversee = $_POST['date'];
    $LiaisonSelectionnee = getLiaisonById($idLiaison);
    $traversees = getTraverseesByLiaisonAndDate($idLiaison, $dateTraversee);
    $placesCapacite = getPlacesTraverseesByLiaisonAndDate($idLiaison, $dateTraversee);
    $placesReservees = getPlacesReservesTraversees();
    // $placesDispo = getPlacesDispoTraverseesByLiaisonAndDate($idLiaison, $dateTraversee);
}

$titre = "Horaires des traversées";
// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAfficheTraversees.php";
include "$racine/vue/footer.php";

?>