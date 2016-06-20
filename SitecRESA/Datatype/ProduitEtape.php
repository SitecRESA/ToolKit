<?php
/**
 * User: patriceb
 * Date: 20/06/2016
 * Time: 10:08
 */

namespace SitecRESA\Datatype;

/**
 * @author Patrice BRUN <patrice.brun@sitec.fr>
 *
 * @property string           $produit libellé de lma fichePrestation
 * @property FichePrestataire $ficheOrganisme prestataire correspondant
 * @property string           $session libelle de la session
 * @property int              $jourSession jour de la semaine [0..6]
 */

class ProduitEtape extends SavableDatatypeAbstract implements Fetchable{

    protected $_produit;
    protected $_ficheOrganisme;
    protected $_session;
    protected $_jourSession;

    /**
     *
     * @param  \SitecRESA\WS\Client $apiClient
     * @param  int $id
     * @return self
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->produitetape("get",array("idRessource"=> $id));
    }

    public function save() {

    }

    public function toArray() {

    }

}