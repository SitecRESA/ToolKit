<?php

namespace SitecRESA\Datatype;

/**
 * Pension incluse dans un tarif
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $pension nom de la pension
 * @property-read string $debut debut de validité de la pension incluse
 * @property-read string $fin   fin de validité de la pension incluse
 * 
 */
class Pension extends DatatypeAbstract {
    protected $_pension; 
    protected $_debut;
    protected $_timestampDebut;
    protected $_fin;
    protected $_timestampFin;
}

