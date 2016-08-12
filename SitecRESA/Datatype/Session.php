<?php

namespace SitecRESA\Datatype;

/**
 * Objet indiquant les disponibilités d'un produit.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read int $quantiteDispo quantité disponible
 * @property-read int $debut date debut de l'activité avec l'heure
 * @property-read array $fin date fin de l'activité avec l'heure
 * @property-read PlanTarifaire $planTarifaire plan tarifaire
 * @property-read string $dureeFormatee durée au format fr en jours,heures et minutes
 * @property-read string $duree durée en minutes
 * @property-read string $activiteLongue
 * @property-read string $illimite
 * @property-read string $prixTotal
 */
class Session extends DatatypeAbstract{
    protected $_quantiteDispo;
    protected $_debut;
    protected $_fin;
    protected $_planTarifaire;
    protected $_dureeFormatee;
    protected $_duree;
    protected $_activiteLongue;
    protected $_illimite;
    protected $_prixTotal;
}

