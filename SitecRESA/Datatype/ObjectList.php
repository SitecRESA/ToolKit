<?php

namespace SitecRESA\Datatype;

/**
 * Objet qui remplace les tableaux de résultats provenant des services web
 * Cet objet est itérable et accessible comme un simple tableau.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 */
class ObjectList extends DatatypeAbstract implements \ArrayAccess, \Iterator, \Countable {
    protected $_array;
    protected $_position = 0;
    protected $_count;
    
    public function __set($name, $value) {
        if(is_array($value)){
            $this->_array = $value;
        }
    }
    
    public function __get($name) {
        if($name == "array" || $name == "position" || $name == "count"){
            throw new Api("la propriété $name n'existe pas pour ".get_class($this));
        }
        parent::__get($name);
    }

    public function count() {
        if( NULL === $this->_count) {
            $this->_count = count($this->_array);
        }
        return $this->_count;
    }

    public function current() {
        return $this->_array[$this->_position];
    }

    public function key() {
        return $this->_position;
    }

    public function next() {
        ++$this->_position;
    }

    public function offsetExists($offset) {
        return isset($this->_array[$offset]);
    }

    public function offsetGet($offset) {
        return $this->_array[$offset];
    }

    public function offsetSet($offset, $value) {
        if(intval($offset) == $offset){
            $this->_array[$offset] = $value;
        }else{
            throw new Api("Vous ne pouvez pas faire de cet objet un tableau associatif. Seuls les nombres entiers sont acceptés en tant que clé.");
        }
    }

    public function offsetUnset($offset) {
        unset($this->_array[$offset]);
    }

    public function rewind() {
        $this->_position = 0;
    }

    public function valid() {
        return isset($this->_array[$this->_position]);
    }
    
    public function toArray() {
        return $this->_array;
    }
}

