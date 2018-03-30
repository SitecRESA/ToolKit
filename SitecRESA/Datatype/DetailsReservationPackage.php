<?php

namespace SitecRESA\Datatype;

/**
 * prestation fournie par le prestataire
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property-read string $libelle => nom du package réservé
 * @property-read string $description => description  du package réservé
 * @property-read string $theme => les themes du package réservé
 * @property-read string $numeroReservation => le n° de la réservation
 * @property-read string $numeroFacture => le n° de la facture
 * @property-read string $dateReservation => la date de la réservation
 * @property-read string $heureReservation  => l'heur de la réservation
 * @property-read string $montantTotal => le montant total du package réservé
 * @property-read string $devise => EUR
 * @property-read string $CGV => url vers le pdf si le revendeur facture directement
 * @property-read string $facture => url vers la facture i le revendeur facture directement
 * @property-read string $debutSejour => date de début du séjour du package réservé
 * @property-read string $finSejour => date de fin du séjour du package réservé
 * @property-read string $type => circuit | sejour
 * @property-read string $estAnnulee => 0 ou 1
 * @property-read array  $conditionAnnulation => array de DataType ConditionRetenue
 * @property-read array  $paiement => array de DataType Paiement
 * @property-read array  $etapesReservees => array de DataTpe EtapeReservee
 *
 */
class DetailsReservationPackage extends DatatypeAbstract {
    protected $_libelle;
    protected $_description;
    protected $_theme;
    protected $_numeroReservation;
    protected $_numeroFacture;
    protected $_dateReservation;
    protected $_heureReservation;
    protected $_montantTotal;
    protected $_devise;
    protected $_CGV;
    protected $_facture;
    protected $_debutSejour;
    protected $_finSejour;
    protected $_type;
    protected $_estAnnulee;
    protected $_conditionAnnulation;
    protected $_paiement;
    protected $_etapesReservees;

}

