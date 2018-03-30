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
 * @property-read string $montantTotal => d/m/Y
 * @property-read string $devise => d/m/Y => uniquement si la prestation reserve est un hébergement
 * @property-read string $prestataireReserve duréé de la prestation uniquement si la prestation reserve est une activite
 * @property-read string $detailPrestataireReserve => le nom du tarif réservé
 * @property-read string $demandeParticuliere => le nom du type de tarif réservé (2 adultes et 1 enfant)
 * @property-read string $prestationsReserves => le nombre d'adulte
 * @property-read string $nbEnfant => le nombre d'enfant
 * @property-read string $nbBebe => le nombre de bébé
 * @property-read string $estAnnule => 0 ou 1
 *
 */
class DetailsReservation extends DatatypeAbstract {
    protected $_numeroReservation;
    protected $_numeroFacture;
    protected $_dateReservation;
    protected $_heureReservation;
    protected $_montantTotal;
    protected $_devise;
    protected $_prestataireReserve;
    protected $_detailPrestataireReserve;
    protected $_demandeParticuliere = null;
    protected $_prestationsReserves;
    protected $_estAnnulee;

}
