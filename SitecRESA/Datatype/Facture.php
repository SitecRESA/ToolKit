<?php
namespace SitecRESA\Datatype;
/**
 * Réservation obtenue à partir du Panier
 *
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 */
class Facture extends \SitecRESA\Datatype\SavableDatatypeAbstract{
    protected $_id;
    protected $_numeroFacture;
    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param type $id
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->facture("get",array("idRessource" => $id));
    }
   
    public function toArray() {
        return array(
            "idRessource"       => $this->_id,
            "numeroFacture"     => $this->numeroFacture
        );
    }
}
