<?php

namespace SitecRESA\Datatype;

/**
 * Acces resolver est chargé de récupérer les données que l'objet remplace en tant que variable d'instance d'une autre entité.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read int $idRessource identifiant WS de la ressource à charger.
 */
class AccesResolver extends DatatypeAbstract{
    protected $_methode;
    protected $_verbe;
    protected $_idRessource;
    
    public function resolve($params = array()) {
        $params["idRessource"] = $this->_idRessource;
        return $this->_apiClient->__call($this->_methode, array($this->_verbe,$params));
    }
}

