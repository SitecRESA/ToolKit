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
 * @property int    $id identifiant unique
 * @property string $libelle nom
 * @property string $description description
 * @property int    $ordre position de l'étape dans le package
 * @property array  $produitsEtape les produits d'une étape

 */

class ContenuEtape extends SavableDatatypeAbstract {

    protected $_id;
    protected $_libelle;
    protected $_description;
    protected $_ordre;
    protected $_produitsEtape;

    public function save() {

    }

    public function toArray() {

    }

}