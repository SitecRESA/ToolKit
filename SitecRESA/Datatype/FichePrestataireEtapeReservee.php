<?php
namespace SitecRESA\Datatype;

/**
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property string                 $prestataireReserve => le nom de l'établissement réservé
 * @property FichePrestataire       $detailPrestataireReserve
 * @property string                 $dateArrivee => la date d'arrivée
 * @property string                 $dateDepart => la date de départ
 * @property string                 $voucher => url vers le voucher si il n'y a plus de dataType Paiment dans le cas où le revendeur facture directement
 * @property string                 $bulletin => url vers le bulletin si il n'y a plus de dataType Paiment dans le cas où le revendeur facture directement
 * @property array                  $prestationsReservees => array de DataType FichePrestationReservee
 */

class FichePrestataireEtapeReservee extends DatatypeAbstract {
    protected $_prestataireReserve;
    protected $_detailPrestataireReserve;
    protected $_dateArrivee;
    protected $_dateDepart;
    protected $_voucher = null;
    protected $_bulletin = null;
    protected $_prestationsReservees;
}
