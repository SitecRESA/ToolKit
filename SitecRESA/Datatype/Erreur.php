<?php

namespace SitecRESA\Datatype;

/**
 * Erreur qui peut être gérée. Elle intègre les erreurs de validation
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr
 * 
 * @property-read array $errors liste de {@see SitecRESA\Datatype\ErreurValidation}
 */
class Erreur extends DatatypeAbstract {
    protected $_errors;
    protected $_source;
}

