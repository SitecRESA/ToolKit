<?php

namespace SitecRESA\Datatype;

use SitecRESA\Exception\Api;

/**
 * Une classe SavableDatatype est une classe qui peut être sauvegardée.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 */
abstract class SavableDatatypeAbstract extends DatatypeAbstract{
    //protected $_modifiedFields = array();
    
    public function __set($name, $value) {
        $attribut = "_".$name;
        
        //pas une propriété de $this
        if(!property_exists($this, $attribut)){
            throw new Api("Impossible de setter, la propriété $name n'existe pas pour ".get_class($this));
        }
        
        $this->$attribut = $value;
    }
    
    /**
     * sauvegarder l'objet
     */
    abstract public function save();
    
    /**
     * obtenir une représentation sous forme de tableau associatif
     * @return array
     */
    abstract public function toArray();
}

