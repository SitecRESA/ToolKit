<?php

namespace SitecRESA\Datatype;

use SitecRESA\Exception\Api;
use SitecRESA\Datatype\AccesResolver;

/**
 * Datatype manipulées par le WS.
 *
 * @author Patrice
 */
abstract class DatatypeAbstractFerryXML extends DatatypeAbstract {

    /**
     * Methode magique __set()
     *
     * Fixe la valeur de la propriété appelée
     *
     * @param string $property
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function __set($property,$value) {
        $attribut = "_".$property;
        //pas une propriété de $this
        if(!property_exists($this, $attribut)){
            throw new Api("la propriété $property n'existe pas pour ".get_class($this));
        }else{
            $this->$attribut = $value;
        }
    }
}