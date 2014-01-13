<?php

namespace SitecRESA\Datatype;

/**
 * Objet regroupant tous les paramètres invalides empêchant le déroulement normal de la requête.
 * Les propriétés de cet objet sont dynamiques et dépendent du contexte de l'erreur. Elles ont pour nom les paramètres en erreur.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 */
class ErreurValidation extends DatatypeAbstract{
    
    protected $_champs;
    
    public function __set($name, $value) {
        $name = substr($name, 1);//on retire _
        $this->_champs[$name] = $value;
    }
    public function __get($name) {
        if(isset($this->_champs[$name])){
           return $this->_champs[$name]; 
        }
        parent::__get($name);
    }
    
    /**
     * permet de parcourir les erreurs à l'aide d'un tableau associatif
     * la clé représente le paramètre en erreur, la valeur est l'erreur de validation explicité en Français
     * @return array
     */
    public function toArray() {
        return $this->_champs;
    }
}

