<?php

namespace SitecRESA\Datatype;

/**
 * position GPS projection WGS84 (compatible GPS / Google Maps)
 *
 * @author Marc FRICOU <marc.fricou@sitec.Fr>
 * 
 * @property-read float $latitudeWGS84 latitude sur la projection WGS84
 * @property-read float $longitudeWGS84 longitude sur la projection WGS84
 * @property-read float $altitude
 */
class PositionGPS extends DatatypeAbstract{
    protected $_latitudeWGS84;
    protected $_longitudeWGS84;
    protected $_altitude;
}

