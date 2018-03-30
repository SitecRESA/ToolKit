<?php
/**
 * User: patriceb
 * Date: 20/06/2016
 * Time: 10:08
 */

namespace SitecRESA\Datatype;

/**
 * @author Patrice BRUN <patrice.brun@sitec.fr>
 *
 * @property string        $libelle => nom
 * @property string        $description => description
 * @property string        $nbDeNuits => nombre de nuits
 * @property string        $ordre => position de l'étape dans le package
 * @property string        $ville => ville de l'étape
 * @property PositionGPS   $positionGPS => de la ville de l'étape
 * @property array         $prestatairesReserves => array de DataType FichePrestataireEtapeReservee
 */

class EtapeReservee extends DatatypeAbstract {

    protected $_libelle;
    protected $_description;
    protected $_nbDeNuits;
    protected $_ordre;
    protected $_ville;
    protected $_positionGPS;
    protected $_prestatairesReserves;
}