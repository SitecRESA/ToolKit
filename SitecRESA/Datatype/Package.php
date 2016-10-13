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
 * @property int    $nbNuits nombre de nuits
 * @property int    $nbJours nombre de jours
 * @property-read \SitecRESA\Datatype\AccesResolverList $galleriePhoto tableau de photos (SitecRESA\Datatype\Photo). (Accès WS)
 * @property-read \SitecRESA\Datatype\Photo $photo première photo
 * @property-read array $categorie liste des catégories associées à ce package
 * @property-read array $garantieDemandee liste des règles conditionnant les montants qui peuvent être prélevé à la réservation.
 * @property-read array $conditionAnnulation liste des règles conditionnant l'annulation de la réservation de ce package.
 * @property-read string $dateArrivee date d'arrivée (début)
 * @property-read string $dateDepart  date de départ (fin)
 * @property-read int $nbAdulte  nombre d'adulte total suite à une recherche de dispo
 * @property-read int $nbEnfnat  nombre d'enfant total suite à une recherche de dispo
 */

class Package extends DatatypeAbstract implements Fetchable{

    protected $_id;
    protected $_libelle;
    protected $_description;
    protected $_prix;
    protected $_jourArrivee;
    protected $_theme;
    protected $_etapes;
    protected $_nbNuits;
    protected $_nbJours;
    protected $_galleriePhoto;
    protected $_photo;
    protected $_categorie;
    protected $_garantieDemandee;
    protected $_conditionAnnulation;
    protected $_dateArrivee;
    protected $_dateDepart;
    protected $_nbAdulte;
    protected $_nbEnfant;

    /**
     *
     * @param  \SitecRESA\WS\Client $apiClient
     * @param  int $id
     * @return self
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->package("get",array("idRessource"=> $id));
    }

    /**
     *
     * @param  \SitecRESA\WS\Client $apiClient
     * @param  int $idPackage
     * @param  string $date date de recherche de dispo d/m/Y
     * @param  array $aAdulte tableau d'adulte par chambre
     * @param  array $aEnfant tableau d'enfant par chambre
     * @return self
     */
    public static function disponibilite(\SitecRESA\WS\Client $apiClient,$idPackage,$date,$aAdulte,$aEnfant) {
        return $apiClient->package("get",array("idRessource"=> $idPackage,"dateDebut"=>$date,"adulte"=>json_encode($aAdulte),"enfant"=>json_encode($aEnfant)));
    }

}