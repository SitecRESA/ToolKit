<?php

namespace SitecRESA\Datatype;


/**
 * Réponse au format SOAP d'une request FerryAvailRQ
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property int                    $idAvis
 */
class FerryAvailRS {

    // <editor-fold defaultstate="collapsed" desc="variables d'instance">
    /**
     * ID de l'avis
     * @var int
     */
    protected $_idAvis;
    // </editor-fold>

    /**
     * Permet d'obtenir une réponse
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id identifiant WS
     * @return \SitecRESA\Datatype\Avis
     */
    public static function FerryAvailRQ(\SitecRESA\WS\Client $apiClient) {
        return $apiClient->FerryavailrqController("get");
    }

}