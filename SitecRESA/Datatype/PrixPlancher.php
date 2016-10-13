<?php

namespace SitecRESA\Datatype;

/**
 * Représentation du prix plancher d'une FichePrestataire
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read float  $prixPlancher prix minimal pour le séjour donné. Exprimé en Euros
 * @property-read int    $unite nombre d'unités
 * @property-read string $uniteFR description française de l'unité du prix plancher ( "/ nuits" ou "/ semaine")
 *
 */
class PrixPlancher extends DatatypeAbstract{
    protected $_prixPlancher;
    protected $_unite;
    protected $_uniteFR;
}

