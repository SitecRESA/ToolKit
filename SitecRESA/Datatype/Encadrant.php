<?php
<<<<<<< HEAD

namespace SitecRESA\Datatype;


=======
namespace SitecRESA\Datatype;
>>>>>>> refs/remotes/origin/master
/**
 * Encadrant d'une activité
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
<<<<<<< HEAD
 * 
=======
 *
>>>>>>> refs/remotes/origin/master
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
<<<<<<< HEAD


=======
>>>>>>> refs/remotes/origin/master
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