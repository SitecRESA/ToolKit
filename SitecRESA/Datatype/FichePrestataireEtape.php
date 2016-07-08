<?php
namespace SitecRESA\Datatype;

/**
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property string           $produit libellé de lma fichePrestation
 * @property ObjectList       $produitsEtape
 * @property bool             $dispo le produit est disponible ou non
 */

class FichePrestataireEtape extends FichePrestataire {
    protected $_produitsEtape;
    protected $_dispo;

    /**
     * Permet d'obtenir les produits etapes d'un contenu etape
     *
     * @param int idEtape
     * @param int idContenuEtape
     * @param string d/m/Y
     *
     * @return array
     */
    public function getProduitsEtape($idEtape,$idContenuEtape, $date = null) {
        return $this->_produitsEtape->resolve(array(
            'idEtape' => $idEtape,
            'idContenuEtape' => $idContenuEtape,
            'dateDebut' => $date)
        );
    }
}
