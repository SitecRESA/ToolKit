<?php

namespace SitecRESA\Datatype;

/**
 * Règle de conditions d'annulation 
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $texteRegle règle en français.
 * @property-read int $nbJourPrecedentSejour utilisez nbJourPrecedentSejour, valeur et unite pour personnaliser vos textes.
 * @property-read int $valeur utilisez nbJourPrecedentSejour, valeur et unite pour personnaliser vos textes.
 * @property-read string $unite utilisez nbJourPrecedentSejour, valeur et unite pour personnaliser vos textes.
 */
class ConditionRetenue extends DatatypeAbstract{
    protected $_texteRegle;
    protected $_nbJourPrecedentSejour;
    protected $_valeur;
    protected $_unite;
}

