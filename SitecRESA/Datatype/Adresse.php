<?php

namespace SitecRESA\Datatype;

/**
 * Adresse détaillée
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $adresseLigne1 première ligne d'adresse
 * @property-read string $adresseLigne2 seconde ligne d'adresse
 * @property-read string $codePostal 
 * @property-read string $commune 
 * @property-read string $pays
 */
class Adresse extends DatatypeAbstract{
    protected $_adresseLigne1;
    protected $_adresseLigne2;
    protected $_codePostal;
    protected $_commune;
    protected $_pays;
}

