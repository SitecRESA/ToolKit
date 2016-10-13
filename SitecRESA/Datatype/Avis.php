<?php

namespace SitecRESA\Datatype;


/**
 * Avis d'une réservation
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property int                    $idAvis
 * @property Sitec_Facture          $facture
 * @property Sitec_FicheOrganisme   $ficheOrganisme
 * @property string                 $status Active | Moderated | Litigious | Pending | SentToTripAdvisor | NotPublished
 * @property string                 $language
 * @property string                 $title
 * @property string                 $content
 * @property string                 $accommodationName
 * @property int                    $intId
 * @property string                 $id
 * @property int                    $yearOfVisit
 * @property string                 $journeyType Couple | Family | By myself | Business | With friends | Others
 * @property date                   $creationDate
 * @property boolean                $isAccommodationRecommended True | False
 * @property int                    $overallRating [1..5]
 * @property int                    $valueForMoneyRating [1..5]
 * @property int                    $locationRating [1..5]
 * @property int                    $atmosphereRating [1..5]
 * @property int                    $activitiesRating [1..5]
 * @property int                    $serviceRating [1..5]
 * @property int                    $mealsRating [1..5]
 * @property int                    $cleanlinessRating [1..5]
 * @property int                    $roomsRating   [1..5]
 * @property string                 $reviewerDisplayName
 * @property string                 $reviewerEmail
 * @property string                 $reviewerCountry
 * @property string                 $pros
 * @property string                 $cons
 * @property array                  $commentaires
 */
class Avis extends DatatypeAbstract{

    // <editor-fold defaultstate="collapsed" desc="variables d'instance">

    /**
     * status de l'avis
     * @var string Active | Moderated | Litigious | Pending | SentToTripAdvisor | NotPublished
     */
    protected $_status;

    /**
     * langue du commentaire
     * @var string
     */
    protected $_language;

    /**
     * Titre du commentaire
     * @var string
     */
    protected $_title;

    /**
     * contenu du commentaire
     * @var string
     */
    protected $_content;

    /**
     * nom du prestataire
     * @var string
     */
    protected $_accommodationName;


    /**
     * année du commentaire
     * @var int
     */
    protected $_yearOfVisit;

    /**
     * type de Séjour
     * @var string Couple | Family | By myself | Business | With friends | Others
     */
    protected $_journeyType;

    /**
     * date de création du commentaire
     * @var date
     */
    protected $_creationDate;

    /**
     * Le voyageur recommande-t-il l’établissement ?
     * @var boolean True | False
     */
    protected $_isAccommodationRecommended;

    /**
     * Note Globale
     * @var int [1..5]
     */
    protected $_overallRating;

    /**
     * Note Qualité / Prix
     * @var int [1..5]
     */
    protected $_valueForMoneyRating;

    /**
     * Note Situation géographique / Localisation
     * @var int [1..5]
     */
    protected $_locationRating;

    /**
     * Note Cadre / Charme
     * @var int [1..5]
     */
    protected $_atmosphereRating;

    /**
     * Note Equipements / Activités
     * @var int [1..5]
     */
    protected $_activitiesRating;

    /**
     * Note Accueil & Service
     * @var int [1..5]
     */
    protected $_serviceRating;

    /**
     * Note Nourriture / Repas
     * @var int [1..5]
     */
    protected $_mealsRating;

    /**
     * Note Propreté
     * @var int [1..5]
     */
    protected $_cleanlinessRating;

    /**
     * Note Confort / Chambres
     * @var int [1..5]
     */
    protected $_roomsRating;

    /**
     * Prénom / Pseudo du voyageur
     * @var string
     */
    protected $_reviewerDisplayName;


    /**
     * Pays d'origine du client
     * @var string
     */
    protected $_reviewerCountry;

    /**
     * Les Plus de l’établissement
     * @var string
     */
    protected $_pros;

    /**
     * Les Moins de l’établissement
     * @var string
     */
    protected $_cons;

    /**
     * Liste des commentaires. Doit contenir des Sitec_CommentaireAvis
     * @var array
     */
    protected $_commentaires;

    // </editor-fold>

    /**
     * Permet d'obtenir un avis depuis son ID WS
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id identifiant WS
     * @return \SitecRESA\Datatype\Avis
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->client("get",array("idRessource" => $id));
    }
}