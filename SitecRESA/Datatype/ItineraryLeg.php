<?php
/**
 * Created by PhpStorm.
 * User: patriceb
 * Date: 14/10/2016
 * Time: 17:02
 *
 * @property int                               $RPH
 * @property boolean                           $AccomMandatoryInd
 * @property \SitecRESA\Datatype\Arrivee       $Arrivee
 * @property \SitecRESA\Datatype\Depart        $Depart
 * @property array                             $aAltItinerary
 */

namespace SitecRESA\Datatype;


class ItineraryLeg extends DatatypeAbstractFerryXML{

    /**
     * id du trajet
     * @var int
     */
    protected $_RPH;

    /**
     * When 'true', accommodation must be booked on the sailing. When 'false', accommodation is optional on the sailing.
     * @var boolean
     */
    protected $_AccomMandatoryInd;

    /**
     * Arrivée recherchée
     * @var \SitecRESA\Datatype\Arrivee
     */
    protected $_Arrivee;

    /**
     * Départ recherchée
     * @var \SitecRESA\Datatype\Depart
     */
    protected $_Depart;

    /**
     * Liste des traversées
     * @var array
     */
    protected $_aAltItinerary;

}