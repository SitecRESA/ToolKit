<?php

namespace SitecRESA\Datatype;

use SitecRESA\Exception\Api;
use SitecRESA\Datatype\AccesResolver;

/**
 * Datatype manipulées par le WS.
 *
 * @author Marc
 */
abstract class DatatypeAbstract {
    /**
     * @var SitecRESA\WS\Client
     */
    protected $_apiClient;

    /**
     *
     * @var string
     */
    protected $_datatype;

    /**
     *
     * @param SitecRESA\WS\Client $apiClient
     * @param array $array
     */
    public function __construct($apiClient, $array = null) {
        $this->_apiClient = $apiClient;
        if (is_array($array)) {
          // Initialize the model with the array's contents.
          $this->mapTypes($array);
        }
    }

    public function __get($name) {
        $attribut = "_".$name;

        //pas une propriété de $this
        if(!property_exists($this, $attribut)){
            throw new Api("la propriété $name n'existe pas pour ".get_class($this));
        }

        //attribut simple
        if(!$this->$attribut instanceof AccesResolver){
            return $this->$attribut;
        }

        //accès WS nécessaire
        $valeurAttribut = $this->$attribut->resolve();
        $this->$attribut = $valeurAttribut;
        return $this->$attribut;
    }


    public function __isset($name)
    {
        $attribut = "_".$name;
        if (isset($attribut)){
            return true;
        }

        return false;
    }




    /**
    * Initialize this object's properties from an array.
    *
    * @param array Used to seed this object's properties.
    * @return void
    */
    private function mapTypes(array $array) {
        foreach ($array as $key => $val) {
            $key = "_".$key;
            $this->$key = $val;
            if($this->isAssociativeArray($val)){
                $this->$key = self::createObjectFromArray($this->_apiClient, $val);
            }elseif (is_array($val)) {
                $arrayObject = array();
                foreach ($val as $arrayIndex => $arrayItem) {
                    if(is_array($arrayItem)){
                        $arrayObject[$arrayIndex] = self::createObjectFromArray($this->_apiClient, $arrayItem);//$this->mapTypes($arrayItem);
                    } else {
                        $arrayObject[$arrayIndex] = $arrayItem;
                    }
                }
                $this->$key = $arrayObject;
            }
        }
    }

   /**
    * Returns true only if the array is associative.
    * @param array $array
    * @return bool True if the array is associative.
    */
    private function isAssociativeArray($array) {
        if (!is_array($array)) {
          return false;
        }
        $keys = array_keys($array);
        foreach($keys as $key) {
          if (is_string($key)) {
            return true;
          }
        }
        return false;
    }

   /**
    * Given a variable name, discover its type.
    *
    * @param $name
    * @param $item
    * @return object The object from the item.
    */
    public static function createObjectFromArray($apiClient, array $array) {
        if(isset($array["datatype"])){
            $className = "SitecRESA\\Datatype\\".$array["datatype"];
            return new $className($apiClient, $array);
        }  else {
            throw new Api("impossible de créer une entité à partir d'un tableau qui n'a pas de clé 'datatype'");
        }
    }
}