<?php

namespace SitecRESA\Datatype;

/**
 * Objet représentant une condition particulière à respecter pour pouvoir réserver.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $jourArrivee un jour dans la semaine d'arrivée est obligatoire
 * @property-read int $minLOS un séjour minimum est obligatoire (LOS => length of stay)
 * @property-read int $maxLOS un séjour maximum est obligatoire (LOS => length of stay)
 * @property-read int $groupeJour l'unité de séjour utilisée => 1 = nuitée, 7 = Semaine
 * @property-read string $debut date à partir de laquelle la condition s'applique
 * @property-read string $fin date jusqu'à laquelle la condition s'applique.
 */
class ConditionTarifaire extends DatatypeAbstract{
    protected $_jourArrivee;
    protected $_minLOS;
    protected $_maxLOS;
    protected $_groupeJour;
    protected $_debut;
    protected $_fin;
}

