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
 * @property int         $id identifiant unique
 * @property string      $libelle nom
 * @property string      $description description
 * @property int         $nbDeNuits nombre de nuits
 * @property int         $ordre position de l'étape dans le package
 * @property array       $contenusEtape liste les composants d'une étape
 * @property string      $ville ville de l'étape
 * @property PositionGPS $positionGPS de la ville de l'étape

 */

class Etape extends SavableDatatypeAbstract implements Fetchable{

    protected $_id;
    protected $_libelle;
    protected $_description;
    protected $_nbDeNuits;
    protected $_ordre;
    protected $_contenusEtape ;
    protected $_ville;
    protected $_positionGPS;

    /**
     *
     * @param  \SitecRESA\WS\Client $apiClient
     * @param  int $id
     * @return self
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->contenustape("get",array("idRessource"=> $id));
    }

    public function save() {

    }

    public function toArray() {

    }

}