<?php

namespace SitecRESA\Datatype;

/**
 * Réservation obtenue à partir du Panier
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 */
class Reservation extends \SitecRESA\Datatype\SavableDatatypeAbstract{
    protected $_id;
    protected $_dateReservation;
    protected $_client;
    protected $_numeroTransaction;
    protected $_numeroFacture;
    protected $_idFacture;

    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param type $id
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->resa("get",array("idRessource" => $id));
    }
    /**
     * pour enregister le numéro de transaction et envoyer les mails de confirmation.
     * @param int $numeroTransaction
     * @return void|Erreur une erreur si la réservation est expirée.
     */
    public function confirmer($numeroTransaction, $aIdPaiementRecord = array()) {
        $this->_numeroTransaction = $numeroTransaction;
        if(sizeof($aIdPaiementRecord) > 0){
            $params['multiPaiement'] = \Zend_Json::encode($aIdPaiementRecord);
            $params['idRessource'] = $this->id;
            $this->_apiClient->multipaiement("put",$params);
        }
        return $this->save();
    }

    /**
     * enregistrer le numéro de transaction
     */
    public function save() {
        return $this->_apiClient->resa("put",array("idRessource" => $this->id,"numeroTransaction" => $this->numeroTransaction));
    }

    /**
     * supprimer la réservation dont le paiement n'a pas été conclu
     */
    public function delete() {
        $this->_apiClient->resa("delete",array("idRessource" => $this->id));
    }

    public function toArray() {
        return array(
            "idRessource"       => $this->_id,
            "dateReservation"   => $this->_dateReservation,
            "client"            => $this->client->toArray(),
            "numeroTransaction" => $this->numeroTransaction,
            "numeroFacture"     => $this->numeroFacture,
            "idFacture"         => $this->idFacture
        );
    }
}

