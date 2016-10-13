<?php
namespace SitecRESA\Datatype;
/**
 * Encadrant d'une activité
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property string $commune
 * @property PositionGPS $positionGPS
 */
class Ville extends DatatypeAbstract{
    protected $_commune;
    protected $_positionGPS;
}
