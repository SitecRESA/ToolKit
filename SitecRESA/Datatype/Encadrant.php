<?php
namespace SitecRESA\Datatype;
/**
 * Encadrant d'une activité
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property string $email
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 */
class Encadrant extends DatatypeAbstract implements Fetchable{
    protected $_email;
    protected $_nom;
    protected $_prenom;
    protected $_telephone;
    /**
     * Permet d'obtenir un client depuis son ID WS
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id identifiant WS
     * @return \SitecRESA\Datatype\Encadrant
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->client("get",array("idRessource" => $id));
    }
}
