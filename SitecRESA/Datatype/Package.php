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
 * @property int    $id identifiant unique
 * @property string $libelle nom
 * @property string $description description
 * @property float  $prix prix
 * @property int    $jourArrivee jour d'arrivée 0|1|2|3|4|5|6
 * @property string $theme
 * @property array  $etapes liste des étapes

 */

class Package extends SavableDatatypeAbstract implements Fetchable{

    protected $_id;
    protected $_libelle;
    protected $_description;
    protected $_prix;
    protected $_jourArrivee;
    protected $_theme;
    protected $_etapes;
    /**
     *
     * @param  \SitecRESA\WS\Client $apiClient
     * @param  int $id
     * @return self
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->package("get",array("idRessource"=> $id));
    }

    public function save() {

    }

    public function toArray() {

    }

}