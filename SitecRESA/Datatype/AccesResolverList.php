<?php

namespace SitecRESA\Datatype;

use ArrayAccess;
use Countable;
use Iterator;
use SitecRESA\Datatype\AccesResolver;
/**
 * Objet itératif et accessible comme un tableau permettant de gérer une liste d'accesResolver.
 *
 * @author Marc
 */
class AccesResolverList extends \SitecRESA\Datatype\DatatypeAbstract implements ArrayAccess, Countable, Iterator {
    /**
     *
     * @var AccesResolver 
     */
    protected $_accesResolvers = array();
    protected $_count;
    protected $_position = 0;
    
    // <editor-fold defaultstate="collapsed" desc="Iterator Methods">
    public function count(){
        if(NULL === $this->_count){
            $this->_count = count($this->_accesResolvers);
        }
        return $this->_count;
    }
    
    public function current(){
        $object = $this->_accesResolvers[$this->_position];
        $this->replaceAccesResolver($object, $this->_position);
        return $this->_accesResolvers[$this->_position];
    }
    
    public function key(){
        return $this->_position;
    }
    
    public function next(){
        ++$this->_position;
    }
    
    public function rewind(){
        $this->_position = 0;
    }

    public function valid() {
        return isset($this->_accesResolvers[$this->_position]);
    }
    // </editor-fold>
    
    // <editor-fold defaultstate="collapsed" desc="ArrayAccess methods">
    public function offsetExists($offset){
        return isset($this->_accesResolvers[$offset]);
    }
    
    public function offsetGet($offset){
        $this->replaceAccesResolver($this->_accesResolvers[$offset], $offset);
        return $this->_accesResolvers[$offset];
    }
    
    public function offsetSet($offset, $value){
        if(intval($offset) == $offset){
            $this->_accesResolvers[$offset] = $value;
        }else{
            throw new Api("Vous ne pouvez pas faire de cet objet un tableau associatif. Seuls les nombres entiers sont acceptés en tant que clé.");
        }
    }
    
    public function offsetUnset($offset){
        unset($this->_accesResolvers[$offset]);
    }
    // </editor-fold>

    private function replaceAccesResolver($accesResolver, $position) {
        if($accesResolver instanceof AccesResolver){
            $accesResolver = $accesResolver->resolve();
            $accesResolvers = $this->_accesResolvers;
            //offset est égal à position +1 => offset commence à 1 tandis que la position commence à 0
            array_splice($accesResolvers, $position, 1, array($accesResolver));
            
            $this->_accesResolvers = $accesResolvers;
        }
    }
    
    public function toArray() {
        return $this->_accesResolvers;
    }
}

