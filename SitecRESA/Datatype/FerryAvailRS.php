<?php

namespace SitecRESA\Datatype;


/**
 * Class FerryAvailRS
 * Réponse au format SOAP d'une request FerryAvailRQ
 * La liste des traversées disponibles contient toutes les traversées de même sens pour un même ensemble de routes
 * (appelé destination) que la route demandée et qui peuvent accueillir les nombres de passagers et de véhicules
 * demandés. Les traversées jusqu’à 7 jours par rapport à la date demandée et dans la limite de 20 maximum sont retournées.
 * A titre d’exemple, une demande Marseille - Bastia pourra avoir en réponse des traversées Marseille - Ajaccio mais aussi
 * Nice – Calvi. En revanche, il n’y aura pas de Marseille – Tunis (autre destination) ou de Bastia – Marseille (sens différent).
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
     * La liste des traversées disponibles contient toutes les traversées de même sens pour un même ensemble de routes
     * (appelé destination) que la route demandée et qui peuvent accueillir les nombres de passagers et de véhicules
     * demandés. Les traversées jusqu’à 7 jours par rapport à la date demandée et dans la limite de 20 maximum sont retournées.
     * A titre d’exemple, une demande Marseille - Bastia pourra avoir en réponse des traversées Marseille - Ajaccio mais aussi
     * Nice – Calvi. En revanche, il n’y aura pas de Marseille – Tunis (autre destination) ou de Bastia – Marseille (sens différent).
     *
     * Si $oAller et $oRetour sont != null alors on obtient en plus  la liste des installations disponibles
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param \SitecRESA\Datatype\ItineraryLeg $oAller
     * @param \SitecRESA\Datatype\ItineraryLeg $oRetour
     */
    public static function FerryAvailRQ(\SitecRESA\WS\Client $apiClient,\SitecRESA\Datatype\ItineraryLeg $oAller=null,\SitecRESA\Datatype\ItineraryLeg $oRetour=null) {
        if(null === $oDepart && null === $oArrivee){
            return $apiClient->Ferryavailrq("get",array('format'=>'xml'));
        }else if(null === $oDepart || null === $oArrivee){
            throw new \SitecRESA\Exception\Api("Le départ et l'arrivée ne doivent pas êtres null ou les 2 doivent être null.");
        }else{
            return $apiClient->Ferryavailrq("get",array('format'=>'xml','allerDepartLocationCode'=>$oAller->Depart->LocationCode,
                'allerDepartScheduledDateTime'=>$oAller->Depart->ScheduledDateTimeStamp,
                'allerArriveLocationCode'=>$oAller->Arrivee->LocationCode,

                'retourDepartLocationCode'=>$oRetour->Depart->LocationCode,
                'retourDepartScheduledDateTime'=>$oRetour->Depart->ScheduledDateTimeStamp,
                'retourArriveLocationCode'=>$oRetour->Arrivee->LocationCode));
        }


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


            $oArrivee->LocationCode = $ItineraryLeg->Arrive['LocationCode']->__toString();
            if(isset($ItineraryLeg->Arrive['ScheduledDateTime'])){
                $sDateTime = $ItineraryLeg->Arrive['ScheduledDateTime']->__toString();
                $oDate     = new \DateTime($sDateTime);
                $oArrivee->ScheduledDateTimeStamp = $oDate->getTimestamp();
                $oArrivee->ScheduledDateTime = $sDateTime;
            }
            $oDepart->LocationCode = $ItineraryLeg->Depart['LocationCode']->__toString();
            if(isset($ItineraryLeg->Depart['ScheduledDateTime'])){
                $sDateTime = $ItineraryLeg->Depart['ScheduledDateTime']->__toString();
                $oDate     = new \DateTime($sDateTime);
                $oDepart->ScheduledDateTimeStamp = $oDate->getTimestamp();
                $oDepart->ScheduledDateTime  = $sDateTime;
            }

            $oItineraryLeg = new \SitecRESA\Datatype\ItineraryLeg($oArrivee,$oDepart);
            $oItineraryLeg->RPH               = $ItineraryLeg['RPH']->__toString();
            $oItineraryLeg->AccomMandatoryInd = $ItineraryLeg['AccomMandatoryInd']->__toString();

            $aAltItinerary = array();
            foreach($ItineraryLeg->AltItinerary as $AltItinerary ){
                $oArriveeAlt                         = new \SitecRESA\Datatype\Arrivee;
                $oDepartAlt                          = new \SitecRESA\Datatype\Depart;

                $oArriveeAlt->LocationCode           = $AltItinerary->Arrive['LocationCode']->__toString();
                $sArrivee                            = $AltItinerary->Arrive['ScheduledDateTime']->__toString();
                $oDate                               = new \DateTime($sArrivee);
                $oArriveeAlt->ScheduledDateTime      = $sArrivee;
                $oArriveeAlt->ScheduledDateTimeStamp = $oDate->getTimestamp();

                $oDepartAlt->LocationCode            = $AltItinerary->Depart['LocationCode']->__toString();
                $sDepart                             = $AltItinerary->Depart['ScheduledDateTime']->__toString();
                $oDate                               = new \DateTime($sDepart);
                $oDepartAlt->ScheduledDateTime       = $sDepart;
                $oDepartAlt->ScheduledDateTimeStamp  = $oDate->getTimestamp();

                $oAltItinerary = new \SitecRESA\Datatype\AltItinerary;
                $oAltItinerary->RPH      = $AltItinerary['RPH']->__toString();
                $oAltItinerary->PaxInd   = $AltItinerary['PaxInd']->__toString();
                $oAltItinerary->Depart   = $oDepartAlt;
                $oAltItinerary->Arrivee  = $oArriveeAlt;

                $aAltItinerary[]         = $oAltItinerary;
            }

            $oItineraryLeg->aAltItinerary = $aAltItinerary;
            $aItineraryLeg[]              = $oItineraryLeg;
        }
        $this->aItineraryLeg = $aItineraryLeg;
    }

}