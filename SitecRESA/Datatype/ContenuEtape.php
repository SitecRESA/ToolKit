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
 * @property int    $ordre position de l'étape dans le package
 * @property array  $fichesPrestataireEtape array de fichePrestataire d'une étape
 * @property int    $jourSession indice de la semaine [0..6]

 */

class ContenuEtape extends DatatypeAbstract {
    protected $_id;
    protected $_libelle;
    protected $_ordre;
    protected $_fichesPrestataireEtape;
    protected $_jourSession;
}
