<?php


namespace SitecRESA\Datatype;
use SitecRESA\WS\Client;
use SitecRESA\WS\ApiClient;

/**
 * Fiche descriptive d'un hôtel ou de tout autre prestataire SitecRESA.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property-read int $id identifiant de la fiche
 * @property-read string $raisonSociale nom commercial du prestataire
 * @property-read string $siteWeb url (avec HTTP) d'accès au site web du prestataire.
 * @property-read string $valueNbEtoile Traduction française du classement du prestaire (s'il existe)
 * @property-read string $nbEtoileChiffre nombre d'étoile composé comme suit 0|1|2|3|4|5
 * @property-read string $nbEtoile nombre d'étoile composé comme suit STR_nbr
 * @property-read string $description Texte français de description du prestaire
 * @property-read float $taxeSejour Taxe de séjour demandée par nuit et par personne
 * @property-read \SitecRESA\Datatype\Photo $photo 1ere photo du prestataire
 * @property-read \SitecRESA\Datatype\Adresse $adresse adresse du prestataire
 * @property-read \SitecRESA\Datatype\PositionGPS $position du prestataire.
 * @property-read \SitecRESA\Datatype\Cgv $cgv conditions générales de ventes du prestataire (nécessite un accès WS supplémentaire.)
 * @property-read array $galleriePhoto liste de toutes les photos (SitecRESA_Photo) du prestataire (dont $this->photo) (nécessite un accès WS supplémentaire.)
 * @property-read array $equipements liste de tous les équipements (SitecRESA_Equipement) du prestataire. (nécessite un accès WS supplémentaire.)
 * @property-read array $fichesPrestation liste des prestations du prestataire (les chambres d'un hôtel, par exemple). (nécessite un accès WS supplémentaire.)
 * @property-read string $checkIn Heure à partir de laquelle le client peut prendre sa prestation
 * @property-read string $checkOut Heure limite pour quitter la prestation pour le client
 * @property-read string $fraisObligatoires tous les frais obligatoires qui seront à la charge du client
 * @property-read string $servicesOptionnels tous les services optionnels qui seront éventuellement à la charge du client
 * @property-read string $animaux permet de savoir si le prestataire autorise le animaux ou non avec éventuellemnt un tarif
 * @property-read string $periodeOuverture Ouvert à l'année ou bien du ... au ...
 * @property-read array $modePaiement Tous les modes de paiement acceptés par le prestataire
 * @property-read string $_lastModified retourne le timestamp de la dernière modification. Permet par exemple de gérer du cache
 */
class FichePrestataire extends DatatypeAbstract implements Fetchable{
    const ORDRE_NBETOILE = "NbEtoile";
    const ORDRE_COMMUNE  = "Commune";
    const ORDRE_NOM      = "Nom";
    const REGIONVILLE_WILDCARD = "*";

    protected $_id;
    protected $_raisonSociale;
    protected $_siteWeb;
    protected $_nbEtoile;
    protected $_nbEtoileChiffre;
    protected $_valueNbEtoile;
    protected $_description;
    protected $_photo;
    protected $_adresse;
    protected $_taxeSejour;
    protected $_cgv;
    protected $_galleriePhoto;
    protected $_equipements;
    protected $_fichesPrestation;
    protected $_positionGPS;
    protected $_checkIn;
    protected $_checkOut;
    protected $_fraisObligatoires;
    protected $_servicesOptionnels;
    protected $_animaux;
    protected $_periodeOuverture;
    protected $_modePaiement;
    protected $_lastModified;

    /**
     * @var AccesResolver
     */
    protected $_accesCalendrier;
    /**
     * @var AccesResolver
     */
    protected $_accesPrixPlancher;

    /**
     * @var AccesResolver
     */
    protected $_accesPrestations;

    public function __construct($apiClient, $array = NULL) {
        parent::__construct($apiClient, $array);
        $this->_accesPrestations = $this->_fichesPrestation;
    }

    /**
     * prix plancher des prestations proposées (disponibles) pour une recherche de séjour donnée
     *
     * @param string $dateArrivee
     * @param string $dateDepart
     *
     * @return PrixPlancher
     */
    public function prixPlancher($dateArrivee,$dateDepart) {
        return $this->_accesPrixPlancher->resolve(array(
            'dateFin' => $dateDepart,
            'dateDebut' => $dateArrivee));
    }

    /**
     * Permet d’obtenir les disponibilités sur plusieurs semaines du prestataires
     * (compilation des disponibilités des chambres de l’prestataire)
     *
     * @param string $dateArrivee
     * @param string $dateDepart
     *
     * @return array
     */
    public function calendrierDispo($dateArrivee,$dateDepart) {
        return $this->_accesCalendrier->resolve(array(
            'dateFin' => $dateDepart,
            'dateDebut' => $dateArrivee));
    }

    /**
     * obtenir uniquement les prestations dispo
     *
     * @param string  $dateArrivee
     * @param string  $dateDepart
     * @param boolean $avecTarif
     *
     * @return array liste de FichePrestation
     */
    public function prestationsDisponibles ($dateArrivee,$dateDepart, $avecTarif = FALSE) {
        return $this->_accesPrestations->resolve(
            array(
                'dateFin' => $dateDepart,
                'dateDebut' => $dateArrivee,
                'avecTarif' => $avecTarif
            )
        );
    }

    /**
     * permet d'obtenir une liste de FichePrestataire avec lesquels vous avez un contrat.
     *
     * @param Client $apiClient
     *
     * @return \SitecRESA\Datatype\AccesResolverList
     */
    static function listePrestataires($apiClient,$withInfo = false) {
        if(!$withInfo)
        {
            return $apiClient->listeorganismes("get",array());
        }else{
            return $apiClient->listeorganismeswithinfo("get",array());
        }
    }


    /**
     * permet d'obtenir une liste de FichePrestataire à partir d'un tableau id FichePrestataire.
     *
     * @param Client $apiClient
     *
     * @return \SitecRESA\Datatype\AccesResolverList
     */
    static function listePrestatairesAggregateur($apiClient, $aIdFichePrestataire = array()) {
        if(sizeof($aIdFichePrestataire) > 0){
            $a = '{';
            foreach($aIdFichePrestataire as $key=>$idFiche){
                $a .= '"'.$key.'":"'.$idFiche.'",';
            }
            $a = substr($a,0,-1);
            $a .= '}';
        }
        $params = array(
            "idOrganisme" => $a
        );
        return $apiClient->listeorganismes("get",$params);
    }

    /**
     *
     * Permet d'obtenir la liste des prestataires disponibles aux dates fournies
     * Attention !!! la recherche ne doit pas dépasser 30 nuits (entre dateArrivee et dateDepart)
     *
     * @param Client        $apiClient
     * @param string        $dateArrivee format JJ/MM/AAAA
     * @param string        $dateDepart format JJ/MM/AAAA
     * @param int           $nbChambre nombre de chambre, si la répartition n'est pas nécessaire
     * @param int           $nbPersonne nombre de personnes totale, si la répartition n'est pas nécessaire.
     * @param array         $aRepartition tableau d'entiers. Chaque entier correspond au nombre de personne pour une chambre
     * @param array|string  $regionVille liste des villes surlesquelles filtrer.
     * @param boolean       $avecTarif permet de préciser si les hôtels doivent être réservable (avec un tarif et des conditions adéquat : séjour min., etc.) ; TRUE par défaut
     * @param string        $orderBy permet de présiser un ordre : {@see FichePrestataire::ORDRE_COMMUNE}, {@see FichePrestataire::ORDRE_NBETOILE}, {@see FichePrestataire::ORDRE_NOM}
     * @param int           $count pour faire une pagination
     * @param int           $offset pour faire une pagination
     *
     * @return \SitecRESA\Datatype\AccesResolverList
     */
    static function listePrestatairesDisponibles($apiClient, $dateArrivee = null, $dateDepart = null,
            $nbChambre = null, $nbPersonne = null, $aRepartition = NULL,
            $regionVille = self::REGIONVILLE_WILDCARD,
            $avecTarif = TRUE,
            $orderBy = NULL, $count = NULL, $offset = NULL, $sort = NULL) {

        $params = array(
            "dateDebut"   => $dateArrivee,
            "dateFin"     => $dateDepart,
            "nbChambre"   => $nbChambre,
            "nbPersonne"  => $nbPersonne,
            "repartition" => \Zend_Json::encode($aRepartition),
            "regionVille" => \Zend_Json::encode($regionVille),
            "avecTarif"   => $avecTarif,
            "orderBy"     => $orderBy,
            "count"       => $count,
            "offset"      => $offset,
            "sort"        => $sort
        );

        if(!$orderBy){
            global $apiConfig;
            $params["orderBy"] = $apiConfig["triDefault"];
        }
        if(!$sort){
            $params["sort"] = "ASC";
        }

        return $apiClient->dispoorganismes("get", $params);
    }

    /**
     *
     * Permet d'obtenir la liste des prestataires disponibles pour un aggregateur à l'aide dune liste d'id FichePrestataire
     * Attention !!! la recherche ne doit pas dépasser 30 nuits (entre dateArrivee et dateDepart)
     *
     * @param Client        $apiClient
     * @param string        $dateArrivee format JJ/MM/AAAA
     * @param string        $dateDepart format JJ/MM/AAAA
     * @param int           $nbChambre nombre de chambre, si la répartition n'est pas nécessaire
     * @param int           $nbPersonne nombre de personnes totale, si la répartition n'est pas nécessaire.
     * @param array         $aIdFichePrestataire tableau contenant l'id des hotels qui doivent être aggrégé
     * @param array         $aRepartition tableau d'entiers. Chaque entier correspond au nombre de personne pour une chambre
     * @param array|string  $regionVille liste des villes surlesquelles filtrer.
     * @param boolean       $avecTarif permet de préciser si les hôtels doivent être réservable (avec un tarif et des conditions adéquat : séjour min., etc.) ; TRUE par défaut
     * @param string        $orderBy permet de présiser un ordre : {@see FichePrestataire::ORDRE_COMMUNE}, {@see FichePrestataire::ORDRE_NBETOILE}, {@see FichePrestataire::ORDRE_NOM}
     * @param int           $count pour faire une pagination
     * @param int           $offset pour faire une pagination
     *
     * @return \SitecRESA\Datatype\AccesResolverList
     */
    static function prestatairesDisponiblesAggregateur($apiClient, $dateArrivee = null, $dateDepart = null,
                                                 $nbChambre = null, $nbPersonne = null, $aIdFichePrestataire = array(),
                                                 $aRepartition = NULL,
                                                 $regionVille = self::REGIONVILLE_WILDCARD,
                                                 $avecTarif = TRUE,
                                                 $orderBy = NULL, $count = NULL, $offset = NULL, $sort = NULL) {

        if(sizeof($aIdFichePrestataire) > 0){
            $a = '{';
                    foreach($aIdFichePrestataire as $key=>$idFiche){
                $a .= '"'.$key.'":"'.$idFiche.'",';
            }
            $a = substr($a,0,-1);
            $a .= '}';
        }

        $params = array(
            "dateDebut"   => $dateArrivee,
            "dateFin"     => $dateDepart,
            "nbChambre"   => $nbChambre,
            "nbPersonne"  => $nbPersonne,
            "repartition" => \Zend_Json::encode($aRepartition),
            "regionVille" => \Zend_Json::encode($regionVille),
            "avecTarif"   => $avecTarif,
            "orderBy"     => $orderBy,
            "count"       => $count,
            "offset"      => $offset,
            "sort"        => $sort,
            "idOrganisme" => $a
        );

        if(!$orderBy){
            global $apiConfig;
            $params["orderBy"] = $apiConfig["triDefault"];
        }
        if(!$sort){
            $params["sort"] = "ASC";
        }

        return $apiClient->dispoorganismes("get", $params);
    }

    /**
     * @param Client $apiClient
     * @param int    $id
     * @return FichePrestataire
     */
    static function fetch(Client $apiClient, $id) {
        return $apiClient->organisme("get",array("idRessource" => $id));
    }

    /**
     * Get last modified date
     *
     * @param Client $apiClient
     * @param int    $id
     *
     * @return string AAAA-MM-JJTHH:mm:SSZ (format ISO-8601)
     */
    static public function lastModified(Client $apiClient, $id)
    {
        $fiche = $apiClient->propertylastmodified("get",array("idRessource" => $id));
        return $fiche->lastModified;
    }

    /**
     * Permet d'obtenir les informations de \SitecRESA\Datatype\FichePrestataire
     * et \SitecRESA\Datatype\PrixPlancher si le 3ième paramètre est utilisé
     *
     * @param ApiClient $apiClient
     * @param $resolverList
     * @param array $aDataType => array('prixPlancher' => array('dateDebut' => '20/03/2015' ,'dateFin' => '22/03/2015');
     * @exemple \SitecRESA\Datatype\FichePrestataire::resolve($apiClient, $resolverList, $aDataType)
     * @return array
     * @throws \SitecRESA\Exception\IO
     */
    static public function resolve(ApiClient $apiClient, $resolverList, $aDataType = array())
    {
        $a = $resolverList->accesResolvers;

        if(isset($aDataType['prixPlancher'])){
            $aDataType = $aDataType['prixPlancher'];
            $aDataType['prixPlancher'] = 1;
        }

        foreach($a as $resolver)
        {
            $request = $apiClient->createRequest('GET', $apiClient::PREFIX_PATH . '/' . $resolver->methode . '/' . $resolver->verbe . '/' . $resolver->idRessource . '/format/json', $aDataType);

            $req[] = $request;

            //On envoie les requetes par 10
            if (sizeof($req) == 10) {
                $aRes = $apiClient->send($req);
                foreach ($aRes as $res) {
                    $response[] = $apiClient->doResponse($res->getBody());
                }
                $req = array();
//                break;
            }
        }
        //On envoie le reste des requetes
        if(sizeof($req)){
            $aRes = $apiClient->send($req);

            foreach ($aRes as $res) {
                $response[] = $apiClient->doResponse($res->getBody());
            }
        }
        return $response;
    }
}

