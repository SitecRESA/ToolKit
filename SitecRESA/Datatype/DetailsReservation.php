<?php

namespace SitecRESA\Datatype;

/**
 * prestation fournie par le prestataire
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property-read string $numeroReservation identifiant WS
 * @property-read string $numeroFacture nom français
 * @property-read string $dateReservation français
 * @property-read string $heureReservation  => du d/m/Y au d/m/Y
 * @property-read string $montantTotal => le montant total de la réservation
 * @property-read string montantTotalRetenuSiAnnulation => le montant total retenu de l'annulation calculé par rapport au jour courant
 * @property-read string montantTotalRetenuAnnulation => le montant total de l'annulation une fois la réservation annulée
 * @property-read string montantRembourse => le montant total à rembourser suite à une annulation
 * @property-read string $idReservation=> id servant à annuler une réservation
 * @property-read string $devise
 * @property-read string $prestataireReserve la raison sociale
 * @property-read string $detailPrestataireReserve => les informations prestataire
 * @property-read string $demandeParticuliere
 * @property-read string $prestationsReserves => tableau de FichePrestationReservee
 * @property-read string $nbEnfant => le nombre d'enfant
 * @property-read string $nbBebe => le nombre de bébé
 * @property-read string $estAnnule => 0 ou 1
 * @property-read string $CGV => chemin vers les CGV pdf
 * @property-read string $facture => chemin vers la facture pdf
 * @property-read string $voucher => chemin vers le voucher pdf
 * @property-read string $bulletinInscription => 0 ou 1
 * @property-read string $avoir => chemin vers l'avoir pdf
 *
 */
class DetailsReservation extends DatatypeAbstract {
    protected $_numeroReservation;
    protected $_numeroFacture;
    protected $_dateReservation;
    protected $_heureReservation;
    protected $_montantTotal;
    protected $_montantTotalRetenuSiAnnulation = null;
    protected $_montantTotalRetenuAnnulation = null;
    protected $_montantRembourse = null;
    protected $_idReservation;
    protected $_devise;
    protected $_prestataireReserve;
    protected $_detailPrestataireReserve;
    protected $_demandeParticuliere = null;
    protected $_prestationsReserves;
    protected $_estAnnulee;
    protected $_CGV;
    protected $_facture;
    protected $_voucher;
    protected $_bulletinInscription;
    protected $_avoir;
}

