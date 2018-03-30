<?php

namespace SitecRESA\Datatype;

/**
 * prestation fournie par le prestataire
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property-read string $quantite nombre de prestation réservée
 * @property-read string $libelle nom français
 * @property-read string $description desciption français
 * @property-read string $periode  => du d/m/Y au d/m/Y
 * @property-read string $debutPrestation => d/m/Y
 * @property-read string $finPrestation => d/m/Y => uniquement si la prestation reserve est un hébergement
 * @property-read string $dureePrestation duréé de la prestation uniquement si la prestation reserve est une activite
 * @property-read string $libelleTarif => le nom du tarif réservé
 * @property-read array $conditionAnnulation => array de DataType ConditionRetenue | null si c'est un package qui est réservé
 * @property-read string $repartition => le nom du type de tarif réservé (2 adultes et 1 enfant)
 * @property-read string $nbAdulte => le nombre d'adulte
 * @property-read string $nbEnfant => le nombre d'enfant
 * @property-read string $nbBebe => le nombre de bébé
 * @property-read string $estAnnule => 0 ou 1
 *
 */
class FichePrestationReservee extends DatatypeAbstract {
    protected $_quantite;
    protected $_libelle;
    protected $_description;
    protected $_periode;
    protected $_debutPrestation;
    protected $_finPrestation = null;
    protected $_dureePrestation = null;
    protected $_libelleTarif;
    protected $_conditionAnnulation = null;
    protected $_repartition;
    protected $_nbAdulte;
    protected $_nbEnfant;
    protected $_nbBebe;
    protected $_estAnnule;
}

