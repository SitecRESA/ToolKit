<?php

namespace SitecRESA\Datatype;

/**
 * Objet indiquant les disponibilités d'un produit.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read int $quantiteDispo quantité disponible
 * @property-read array $plansTarifaires liste de plans tarifaires
 * @property-read string $dureeFormatee durée au format fr en jours,heures et minutes
 * @property-read string $duree durée en minutes
 * @property-read string $idPrestation
 */
class DisponibiliteProduit extends DatatypeAbstract{
    protected $_quantiteDispo;
    protected $_plansTarifaires;
    protected $_dureeFormatee;
    protected $_duree;
    protected $_idPrestation;

}

