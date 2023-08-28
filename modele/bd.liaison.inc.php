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
            JOIN port PD on PD.nom_court=L.portDepart 
            JOIN port PA on PA.nom_court=L.portArrivee
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
            JOIN port PD on PD.nom_court=L.portDepart 
            JOIN port PA on PA.nom_court=L.portArrivee");
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
            JOIN port PD on PD.nom_court=L.portDepart 
            JOIN port PA on PA.nom_court=L.portArrivee where L.code=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getTarifsbyPeriode($idPeriode){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT libelleCategorie as categorie, libelleTypeBillet as type, tarif, libellePeriode as periode FROM tarification t JOIN periode p ON t.idPeriode=p.idPeriode JOIN type_billet tb ON (t.idCategorie, t.idTypebillet) = (tb.idCategorie, tb.idTypebillet) JOIN categorie c ON t.idCategorie = c.idCategorie ORDER BY t.idCategorie, t.idTypebillet WHERE idPeriode:idPeriode");
            $req->bindValue(':idPeriode', $idPeriode, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[$ligne['categorie']][$ligne['type']][$ligne['periode']] = $ligne['tarif'];
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
            $req = $cnx->prepare("SELECT libelleCategorie as categorie, libelleTypeBillet as type, tarif, libellePeriode as periode FROM tarification t JOIN periode p ON t.idPeriode=p.idPeriode JOIN type_billet tb ON (t.idCategorie, t.idTypebillet) = (tb.idCategorie, tb.idTypebillet) JOIN categorie c ON t.idCategorie = c.idCategorie ORDER BY t.idCategorie, t.idTypebillet");

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

    /**
     * getTarifsPeriode : Retourne l'ensemble des tarifs pour une periode donnée
     *
     * @param string $idPeriode
     * @return array
     */
    function getTarifsPeriode(string $idPeriode) : array {
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT libelleCategorie as categorie, libelleTypeBillet as type, tarif, libellePeriode as periode FROM tarification t JOIN periode p ON t.idPeriode=p.idPeriode JOIN type_billet tb ON (t.idCategorie, t.idTypebillet) = (tb.idCategorie, tb.idTypebillet) JOIN categorie c ON t.idCategorie = c.idCategorie WHERE t.idPeriode=:idPeriode ORDER BY t.idCategorie, t.idTypebillet");
            $req->bindValue(':idPeriode', $idPeriode, PDO::PARAM_STR);
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

    /**
     * getPeriodes : Retourne l'ensemble des periodes
     *
     * @return array
     */
    function getPeriodes() :array {
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

    /**
     * getCategories : Retourne l'ensemble des categories
     *
     * @return array
     */
    function getCategories() :array {
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

    /**
     * getTypesBillets : Retourne l'ensemble des types de billets avec leur categorie
     *
     * @return array
     */
    function getTypesBillets() : array{
        //$resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM type_billet JOIN categorie ON type_billet.idCategorie = categorie.idCategorie");
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

    /**
     * getTraverseesByLiaisonAndDate : Retourne l'ensemble des traversées pour une liaison et une date données
     *
     * @param integer $idLiaison
     * @param string $date
     * @return array
     */
    function getTraverseesByLiaisonAndDate(int $idLiaison, string $date) : array {
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

    /**
     * getPlacesTraverseesByLiaisonAndDate : Retourne l'ensemble des traversées pour une liaison et une date données avec le nb de places totales pour chaque categorie dans ce bateau
     * retourne un tableau associatif de la forme [numTraversee][lettreCategorie] = nbPlacesMax
     * 
     * @param [type] $idLiaison
     * @param [type] $date
     * @return array
     */
    function getPlacesTraverseesByLiaisonAndDate(int $idLiaison, string $date) : array {
        
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT num, idBateau FROM traversee T where codeLiaison=:idLiaison AND date=:date");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->bindValue(':date', $date, PDO::PARAM_STR);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $req2 = $cnx->prepare("SELECT * FROM contenance_bateau where idBateau=:id");
                $req2->bindValue(':id', $ligne['idBateau'], PDO::PARAM_INT);
                $req2->execute();              
                $ligne2 = $req2->fetch(PDO::FETCH_ASSOC);
                while ($ligne2) {

                    $resultat[$ligne['num']][$ligne2['lettreCategorie']] = intval($ligne2['capaciteMax']);                   
                    $ligne2 = $req2->fetch(PDO::FETCH_ASSOC);
                }
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    /**
     * getPlacesReservesTraversees : Compte le nb de place reservées dans detail_reservation pour chaque traversée et categorie
     * retourne un tableau associatif de la forme [numTraversee][lettreCategorie] = nbPlacesReservees
     *
     * @return array
     */
    function getPlacesReservesTraversees() : array {
        $resultat = array();
        try {
            
            // code à écrire

        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
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