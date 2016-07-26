<?php
namespace SitecRESA\Datatype;

/**
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property string           $produit libellé de lma fichePrestation
 * @property bool             $dispo le produit est disponible ou non
 */

class FichePrestataireEtape extends FichePrestataire {
    protected $_dispo;

    /**
     * Permet d'obtenir les produits etapes d'un contenu etape
     *
     * @param int idEtape
     * @param int idContenuEtape
     * @param string d/m/Y
     *
     * @return ObjectList
     */
    public function getProduitsEtape($idEtape,$idContenuEtape, $date = null) {
        return $this->_apiClient->produitsetape("get",array(
            'idRessource' => $this->id,
            'idEtape' => $idEtape,
            'idContenuEtape' => $idContenuEtape,
            'dateDebut' => $date)
        );
    }
}
