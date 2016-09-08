<?php

namespace SitecRESA\Datatype;

/**
 * tarif
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read int $id identifiant WS => A fournir lors de la réservation
 * @property-read float $prix prix au tarif normal
 * @property-read float $prixPromo prix promotionnel, peut être NULL
 * @property-read string $label nom du tarif
 * @property-read string $description description du tarif
 * @property-read int $nbAdulte nombre d'adultes pour obtenir le tarif
 * @property-read int $nbEnfant
 * @property-read int $nbBebe
 * @property-read int $ageMaxEnfant age maximum (inclus) pour considerer la personne comme un enfant
 * @property-read int $ageMaxBebe
 * @property-read int $quantiteDemandee
 */
class Tarif extends DatatypeAbstract{
    protected $_id;
    protected $_label;
    protected $_description;
    protected $_prix;
    protected $_prixPromo;
    protected $_nbAdulte;
    protected $_nbEnfant;
    protected $_nbBebe;
    protected $_ageMaxBebe;
    protected $_ageMaxEnfant;
    protected $_quantiteDemandee;
}