<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.liaison.inc.php";

if (isset($_GET['id'])){
    $idSecteur = $_GET['id'];
    $nomSecteur = getSecteurById($idSecteur)['nom'];
    $titre = "Liaisons du secteur ". $nomSecteur;
    $secteurs = getLiaisonsBySecteur($idSecteur);
} else {
    $titre = "Liaisons par secteur";
    $secteurs = getLiaisons();
}

// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAfficheLiaisons.php";
include "$racine/vue/footer.php";
?>

