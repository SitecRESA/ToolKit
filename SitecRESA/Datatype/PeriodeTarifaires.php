<?php

namespace SitecRESA\Datatype;

/**
 * Les périodes tarifaires et les tarifs pour une chambre
 *
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property-read string    $periode contient la date de début et de fin de la période
 * @property-read string    $unite nuitée / semaine.
 * @property-read int       $jourArrivee de 1 pour lundi à 7 pour dimanche
 * @property-read int       $minLos nombre de nuitée / semaine minimum
 * @property-read int       $maxLos nombre de nuitée / semaine maximum ou NULL
 * @property-read array     $ tarifs (tableau de {@see Datatype\Tarif}
 */
class PeriodeTarifaires extends DatatypeAbstract {
    protected $_periode;
    protected $_unite;
    protected $_jourArrivee;
    protected $_minLos;
    protected $_maxLos;
    protected $_tarifs;
}

