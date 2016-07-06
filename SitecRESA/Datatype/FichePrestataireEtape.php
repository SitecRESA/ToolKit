<?php
namespace SitecRESA\Datatype;
use SitecRESA\WS\Client;
use SitecRESA\WS\ApiClient;

class FichePrestataireEtape extends FichePrestataire {
    protected $_produitsEtape;

    /**
     * Permet d’obtenir les produits etapes d'un contenu etape
     *
     * @param int idContenuEtape
     *
     * @return array
     */
    public function getProduitsEtape($idContenuEtape) {
        return $this->_produitsEtape->resolve(array(
            'idContenuEtape' => $idContenuEtape)
        );
    }
}
