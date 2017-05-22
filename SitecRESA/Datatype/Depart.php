<?php
/**
 * Class Depart
 * @package SitecRESA\Datatype
 * Created by PhpStorm.
 * User: patriceb
 * Date: 14/10/2016
 * Time: 17:03
 *
 * @property String $LocationCode
 * @property String $ScheduledDateTime
 * @property Number ScheduledDateTimeStamp
 */

namespace SitecRESA\Datatype;

class Depart extends DatatypeAbstractFerryXML{
    /**
     * Code de la ville de départ
     * @var String
     */
    protected  $_LocationCode;

    /**
     * date et heure de départ au format ISO 8601 (ex: 2016-10-14T00:00:00)
     * @var Number
     */
    protected  $_ScheduledDateTime;

    /**
     * date et heure de départ au format timestamp
     * @var Number
     */
    protected  $_ScheduledDateTimeStamp;
}