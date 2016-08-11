<?php
namespace SitecRESA\Datatype;

/**
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property array           $produitsEtape
 * @property bool            $dispo le produit est disponible ou non
 */

class FichePrestataireEtape extends FichePrestataire {
    protected $_dispo;
    protected $_produitsEtape;
}
