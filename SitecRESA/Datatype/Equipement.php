<?php

namespace SitecRESA\Datatype;

/**
 * Equipements d'un prestataire ou d'une prestation.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $libelle nom français de l'équipement
 * @property-read string $codeota identifiant OpenTravel Alliance de l'équipement
 */
class Equipement extends DatatypeAbstract {
    protected $_codeota;
    protected $_libelle;
}

