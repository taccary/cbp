<?php

include_once "bd.inc.php";

    function getSecteurs(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM secteur");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getSecteurById($id) {

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM secteur WHERE id=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPorts(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM port");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPortById($id) {

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT nom FROM port WHERE id=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getLiaisons(){
        //$resultat = array();
        try {
            $secteurs = getSecteurs();
            foreach ($secteurs as $secteur) {
                $resultat[$secteur['id']]['nom'] = $secteur['nom'];
                $resultat[$secteur['id']]['liaisons'] = array();
                $resultat[$secteur['id']]['liaisons'] = getLiaisonsBySecteurLignes($secteur['id']);
            }
            
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonsBySecteur($idSecteur){
        //$resultat = array();
        try {
            $resultat[$idSecteur]['nom'] = getSecteurById($idSecteur)['nom'];
            $resultat[$idSecteur]['liaisons'] = getLiaisonsBySecteurLignes($idSecteur);

        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getLiaisonsBySecteurLignes($idSecteur){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT L.code, L.distance, PD.nom as portDepart, PA.nom as portArrivee FROM liaison L 
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee
            where L.codeSecteur=:idSecteur");
            $req->bindValue(':idSecteur', $idSecteur, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonsLignes(){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT L.code, L.codeSecteur, L.distance, PD.nom as portDepart, PA.nom as portArrivee FROM liaison L 
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonById($id) {
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT L.code, S.nom, L.distance, PD.nom as portDepart, PA.nom as portArrivee FROM liaison L INNER JOIN secteur S on L.codeSecteur=S.id
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee where L.code=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getTarifsbyLiaison($idLiaison){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM tarification where codeLiaison=:idLiaison");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[$ligne['lettreCategorie']][$ligne['numType']][$ligne['dateDeb']] = $ligne['tarif'];
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getTarifs(){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM tarification");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[$ligne['codeLiaison']][$ligne['lettreCategorie']][$ligne['numType']][$ligne['dateDeb']] = $ligne['tarif'];
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPeriodes(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM periode");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getCategories(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM categorie");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getCategoriesTypes(){
        //$resultat = array();

        try {
            $categories = getCategories();
            foreach ($categories as $categorie){
                $resultat[$categorie['lettre']]['lettre'] =  $categorie['lettre'];
                $resultat[$categorie['lettre']]['libelle'] =  $categorie['libelle'];
                $cnx = getPDO();
                $req = $cnx->prepare("SELECT * FROM type WHERE lettreCategorie=:idCategorie");
                $req->bindValue(':idCategorie', $categorie['lettre'], PDO::PARAM_STR);
                $req->execute();

                $ligne = $req->fetch(PDO::FETCH_ASSOC);
                while ($ligne) {
                    $resultat[$categorie['lettre']]['types'][]= $ligne;
                    $ligne = $req->fetch(PDO::FETCH_ASSOC);
                }
            }
            
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getTraverseesByLiaisonAndDate($idLiaison, $date){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM traversee T JOIN bateau B ON B.id=T.idBateau
            where codeLiaison=:idLiaison
            AND date=:date
            ORDER BY heure");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->bindValue(':date', $date, PDO::PARAM_STR);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getPlacesDispoTraverseesByLiaisonAndDate($idLiaison, $date){

        // pour chaque traversée, pour chaque categorie aller compter : nb de place dans de ce bateau dans contenance_bateau et soustraire le nb de places déja reservées dans reservation jointure avec détails reservation
        /*$resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM traversee T JOIN bateau B ON B.id=T.idBateau
            where codeLiaison=:idLiaison
            AND date=:date
            ORDER BY heure");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->bindValue(':date', $date, PDO::PARAM_STR);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }*/


        return $resultat;
    }


if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "getLiaisons() : \n";
    print_r(getLiaisons());

    echo "getLiaisonsBySecteur(3) \n";
    print_r(getLiaisonsBySecteur(3));

}
?>