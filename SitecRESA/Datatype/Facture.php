<?php
namespace SitecRESA\Datatype;
/**
 * Facture obtenue à partir du Panier
 *
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 */
class Facture  extends DatatypeAbstract implements Fetchable{
    protected $_id;
    protected $_idReservation;
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
            "idReservation"       => $this->_idReservation,
            "numeroFacture"     => $this->numeroFacture
        );
    }

}