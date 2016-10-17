<?php
/**
 * Created by PhpStorm.
 * User: patriceb
 * Date: 14/10/2016
 * Time: 17:03
 *
 * Arrivée d'un trajet
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property String $LocationCode
 * @property String $ScheduledDateTime
 */

namespace SitecRESA\Datatype;


class Arrivee extends DatatypeAbstractFerryXML{
    /**
     * Code de la ville d'arrivée
     * @var String
     */
    protected  $_LocationCode;

    /**
     * date et heure d'arrivée au format ISO 8601 (ex: 2016-10-14T00:00:00)
     * @var String
     */
    protected  $_ScheduledDateTime;
}