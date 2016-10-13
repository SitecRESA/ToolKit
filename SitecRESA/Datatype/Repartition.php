<?php
namespace SitecRESA\Datatype;

/**
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 * @property array           $produitsEtape
 * @property int             $adulte le nombre d'adulte
 * @property int             $enfant le nombre d'enfant
 */

class Repartition extends DatatypeAbstract {
    protected $_nbAdulte;
    protected $_nbEnfant;
    protected $_produitsEtape;
}
