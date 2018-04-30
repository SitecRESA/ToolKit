<?php

namespace SitecRESA\Datatype;


/**
 * Client d'une réservation
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property int $id
 * @property string $email
 * @property string $email2
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 * @property Adresse $adresse
 * @property ObjectList $reservations => array de DataType DetailsReservation et/ou DetailsReservationPackage
 */
class Client extends SavableDatatypeAbstract implements Fetchable{
    protected $_id;
    protected $_email;
    protected $_email2;
    protected $_nom;
    protected $_prenom;
    protected $_telephone;
    /**
     *
     * @var Adresse
     */
    protected $_adresse;

    /**
     *
     * @var ObjectList
     */
    protected $_reservations;
    
    
    /**
     * Créer un client à partir d'un tableau associatif ou à partir d'un nom / prénom / email
     * @param type $apiClient
     * @param array|string $arrayOuNom tableau clé / valeur des propriétés du client ou nom du client
     * @param string $prenom [OPTIONNEL] prénom du client
     * @param string $email [OPTIONNEL] email du client
     * @param string $email2[OPTIONNEL] email de confirmation du client. Si non null doit être identique au mail
     * @throws \LogicException si vous ne respectez pas l'une des deux manières d'instancier l'objet
     */
    public function __construct($apiClient, $arrayOuNom, $prenom = NULL, $email = NULL,$email2 = NULL) {
        
        if(is_string($arrayOuNom) && $arrayOuNom && $prenom && $email) {//construct à partir de nom, prenom, e-mail, e-mail2
            $arrayOuNom = array("nom" => $arrayOuNom, "prenom" => $prenom, "email" => $email ,"email2" => $email2);
        }
        
        if(is_array($arrayOuNom)){//construction à la manière de faire un restGET
            parent::__construct($apiClient, $arrayOuNom);
        } else {
            throw new \LogicException("Un client peut être instancié à l'aide d'un tableau clé - valeur ou alors son nom, son prénom , son mail et son email de confirmation");
        }
    }
    
    /**
     * sauvegarder le client
     * @return \SitecRESA\Datatype\Erreur|NULL rien si tout se passe bien une {@see Erreur} sinon.
     * @throws \SitecRESA\Exception\Api
     */
    public function save(){
        if(!isset($this->_id)){//un post est nécessaire
            $location = $this->_apiClient->client("post", $this->toArray());
            if($location instanceof Erreur){
                return $location;
            }
            $aPart = explode("/", $location);
            $indexGet = array_search("get", $aPart);
            $this->_id = $aPart[$indexGet+1];
        }
        
        if(isset($this->_id) && isset($this->_adresse)) {//put nécessaire
            if(!$this->_adresse instanceof Adresse){
                throw new \SitecRESA\Exception\Api("this->adresse n'est pas un objet de type Adresse, impossible de sauvegarder !");
            }
            $location = $this->_apiClient->client("put", $this->toArray());
            if($location instanceof Erreur){
                return $location;
            }
        }
    }
    
    
    public function toArray(){
        $array = array(
            "idRessource" => $this->_id,
            "firstname" => $this->prenom,
            "lastname"  => $this->nom,
            "email"     => $this->email,
            "email2"    => $this->email2,
            "phone"     => $this->telephone
        );
        
        if($this->_adresse instanceof Adresse){
            $array["adresse"] = $this->_adresse->adresseLigne1;
            $array["zip"]     = $this->_adresse->codePostal;
            $array["city"]    = $this->_adresse->commune;
            $array["country"]    = $this->_adresse->pays;
        }
        return $array;
    }

    /**
     * Permet d'obtenir un client depuis son ID WS
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id identifiant WS
     * @return \SitecRESA\Datatype\Client
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->client("get",array("idRessource" => $id));
    }
}
