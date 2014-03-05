<?php


namespace SitecRESA\Datatype;
use SitecRESA\WS\Client;

/**
 * Fiche descriptive d'un hôtel ou de tout autre prestataire SitecRESA.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property-read int $id identifiant de la fiche
 * @property-read string $raisonSociale nom commercial du prestataire
 * @property-read string $siteWeb url (avec HTTP) d'accès au site web du prestataire.
 * @property-read string $valueNbEtoile Traduction française du classement du prestaire (s'il existe)
 * @property-read string $description Texte français de description du prestaire
 * @property-read float $taxeSejour Taxe de séjour demandée par nuit et par personne
 * @property-read \SitecRESA\Datatype\Photo $photo 1ere photo du prestataire
 * @property-read \SitecRESA\Datatype\Adresse $adresse adresse du prestataire
 * @property-read \SitecRESA\Datatype\PositionGPS $position du prestataire.
 * @property-read \SitecRESA\Datatype\Cgv $cgv conditions générales de ventes du prestataire (nécessite un accès WS supplémentaire.)
 * @property-read array $galleriePhoto liste de toutes les photos (SitecRESA_Photo) du prestataire (dont $this->photo) (nécessite un accès WS supplémentaire.)
 * @property-read array $equipements liste de tous les équipements (SitecRESA_Equipement) du prestataire. (nécessite un accès WS supplémentaire.)
 * @property-read array $fichesPrestation liste des prestations du prestataire (les chambres d'un hôtel, par exemple). (nécessite un accès WS supplémentaire.)
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
    protected $_accesPrestation;

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
    static function listePrestataires($apiClient) {
        return $apiClient->listeorganismes("get",array());
    }

    /**
     *
     * Permet d'obtenir la liste des prestataires disponibles aux dates fournies
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
    static function listePrestatairesDisponibles($apiClient, $dateArrivee, $dateDepart,
            $nbChambre = 1, $nbPersonne = 2, $aRepartition = NULL,
            $regionVille = self::REGIONVILLE_WILDCARD,
            $avecTarif = TRUE,
            $orderBy = NULL, $count = NULL, $offset = NULL) {

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
            "offset"      => $offset
        );

        if(!$orderBy){
            global $apiConfig;
            $params["orderBy"] = $apiConfig["triDefault"];
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
}

