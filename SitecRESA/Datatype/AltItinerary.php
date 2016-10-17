<?php
/**
 * Created by PhpStorm.
 * User: patriceb
 * Date: 14/10/2016
 * Time: 17:12
 */

namespace SitecRESA\Datatype;


class AltItinerary extends DatatypeAbstractFerryXML{

    /**
     * id du trajet
     * @var int
     */
    protected $_RPH;

    /**
     * if 'true', passenger space is available; when 'false', passenger space is not available.
     * @var boolean
     */
    protected $_PaxInd;

    /**
     * Arrivée
     * @var \SitecRESA\Datatype\Arrivee
     */
    protected $_Arrivee;

    /**
     * Départ
     * @var \SitecRESA\Datatype\Depart
     */
    protected $_Depart;
}