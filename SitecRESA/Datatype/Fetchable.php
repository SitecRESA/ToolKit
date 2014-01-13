<?php

namespace SitecRESA\Datatype;

/**
 * interface pour les datatype accessibles par un fetch depuis leur ID
 * 
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 */
interface Fetchable {
    /**
     * récupère l'entité à partir de son ID WS
     * @param \SitecRESA\WS\Client $apiClient client auparavant instancié
     * @param int $id
     * @return DatatypeAbstract
     */
    static function fetch(\SitecRESA\WS\Client $apiClient, $id);
}

