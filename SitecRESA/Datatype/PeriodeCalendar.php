<?php

namespace SitecRESA\Datatype;

/**
 * Periode décrivant l'état d'une disponibilité
 * Cette période est conforme 
 *
 * @author Marc FIRCOU <marc.fricou@site.fr>
 * 
 * @property-read string $title titre utilisable dans le DOM HTML
 * @property-read string $className nom de classe CSS utilisable
 * @property-read string $start date format AAAA-MM-JJ
 * @property-read string $end date format AAAA-MM-JJ
 */
class PeriodeCalendar extends DatatypeAbstract{
    protected $_title;
    protected $_className;
    protected $_start;
    protected $_end;
}

