<?php

namespace SitecRESA\Datatype;

/**
 * Les périodes et les tarifs pour une prestation
 *
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property-read array $periodesTarifaires liste des periodes avec les tarifs associés d'une prestation
 */
class Periodes extends DatatypeAbstract {
    protected $_periodesTarifaires;
}

