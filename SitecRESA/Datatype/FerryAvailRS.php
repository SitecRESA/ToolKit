<?php

namespace SitecRESA\Datatype;


/**
 * Class FerryAvailRS
 * Réponse au format SOAP d'une request FerryAvailRQ
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 * @package SitecRESA\Datatype
 *
 * @property array $aItineraryLeg
 */
class FerryAvailRS extends DatatypeAbstractFerryXML implements iFerryXML{

    // <editor-fold defaultstate="collapsed" desc="variables d'instance">
    /**
     * trajets
     * @var array
     */
    protected $_aItineraryLeg;
    // </editor-fold>


    /**
     * @param SimpleXMLElement $xml
     */
    public function __construct($xml) {
        $this->populate($xml);
    }


    /**
     * Permet d'obtenir la liste des trajets au format ferry xml
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id identifiant WS
     * @return \SitecRESA\Datatype\Avis
     */
    public static function FerryAvailRQ(\SitecRESA\WS\Client $apiClient) {
        return $apiClient->Ferryavailrq("get",array('format'=>'xml'));
    }

    /**
     * populate this
     * @param SimpleXMLElement $xml
     */
    public function populate($xml){
        /* @var $ItineraryLeg SimpleXMLElement  */
        foreach($xml->ItineraryLeg as $ItineraryLeg){
            $oArrivee      = new \SitecRESA\Datatype\Arrivee;
            $oDepart       = new \SitecRESA\Datatype\Depart;
            $oItineraryLeg = new \SitecRESA\Datatype\ItineraryLeg;

            $oArrivee->LocationCode = $ItineraryLeg->Arrive['LocationCode']->__toString();
            if(isset($ItineraryLeg->Arrive['ScheduledDateTime'])){
                $oArrivee->ScheduledDateTime = $ItineraryLeg->Arrive['ScheduledDateTime']->__toString();
            }
            $oDepart->LocationCode = $ItineraryLeg->Depart['LocationCode']->__toString();
            if(isset($ItineraryLeg->Depart['ScheduledDateTime'])){
                $oDepart->ScheduledDateTime  = $ItineraryLeg->Depart['ScheduledDateTime']->__toString();
            }


            $oItineraryLeg->RPH               = $ItineraryLeg['RPH']->__toString();
            $oItineraryLeg->AccomMandatoryInd = $ItineraryLeg['AccomMandatoryInd']->__toString();
            $oItineraryLeg->Depart            = $oDepart;
            $oItineraryLeg->Arrivee           = $oArrivee;

            $aAltItinerary = array();
            foreach($ItineraryLeg->AltItinerary as $AltItinerary ){
                $oArriveeAlt      = new \SitecRESA\Datatype\Arrivee;
                $oDepartAlt       = new \SitecRESA\Datatype\Depart;
                $oArriveeAlt->LocationCode           = $AltItinerary->Arrive['LocationCode']->__toString();
                $oArriveeAlt->ScheduledDateTime      = $AltItinerary->Arrive['ScheduledDateTime']->__toString();
                $oDepartAlt->LocationCode            = $AltItinerary->Depart['LocationCode']->__toString();
                $oDepartAlt->ScheduledDateTime       = $AltItinerary->Depart['ScheduledDateTime']->__toString();

                $oAltItinerary = new \SitecRESA\Datatype\AltItinerary;
                $oAltItinerary->RPH      = $AltItinerary['RPH']->__toString();
                $oAltItinerary->PaxInd   = $AltItinerary['PaxInd']->__toString();
                $oAltItinerary->Depart   = $oDepartAlt;
                $oAltItinerary->Arrivee  = $oArriveeAlt;

                $aAltItinerary[] = $oAltItinerary;
            }

            $oItineraryLeg->aAltItinerary = $aAltItinerary;
            $aItineraryLeg[] = $oItineraryLeg;
        }
        $this->aItineraryLeg = $aItineraryLeg;
    }

}