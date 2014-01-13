<?php

namespace SitecRESA\Datatype;

/**
 * Objet indiquant les disponibilités d'un produit.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read int $quantiteDispo quantité disponible
 * @property-read array $plansTarifaires liste de plans tarifaires
 */
class DisponibiliteProduit extends DatatypeAbstract{
    protected $_quantiteDispo;
    protected $_plansTarifaires;
}

