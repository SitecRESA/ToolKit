<?php

namespace SitecRESA\Datatype;

/**
 * Mode de Paiement d'un prestataire.
 *
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property-read string $libelle nom français de l'équipement
 * @property-read string $codeota identifiant OpenTravel Alliance de l'équipement
 */
class ModePaiement extends DatatypeAbstract {
    protected $_codeota;
    protected $_libelle;
}

