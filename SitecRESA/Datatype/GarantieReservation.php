<?php

namespace SitecRESA\Datatype;

/**
 * Règle de garantie demandée à la Réservation.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $texteRegle règle en français.
 */
class GarantieReservation extends DatatypeAbstract{
    protected $_idGarantieReservation;
    protected $_texteRegle;
    protected $_condition;
    protected $_valeur;
    protected $_unite;
}

