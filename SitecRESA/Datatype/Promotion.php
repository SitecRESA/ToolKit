<?php

namespace SitecRESA\Datatype;

/**
 * Ensemble de conditions et d'avantages décrivant un tarif pour une chambre
 *
 * @author Damien Cayzac <damien.cayzac@sitec.fr>
 *
 * @property-read string $label titre français de la promotion
 * @property-read string $produit le nom du produit en promotion
 * @property-read string $tarif le tarif en promotion
 * @property-read string $remise la remise accordée
 * @property-read string $texte nom + produit + remise
 * @property-read string $disponible attribut optionnel, la promotion est valable jusqu'à cette date. Peut être null (pas de limite)
 * @property-read string $conditionMin attribut optionnel, nombre de nuits minimum pour bénéficier de la promotion
 * @property-read string $conditionMax attribut optionnel, nombre de nuits a ne pas dépasser pour bénéficier de la promotion
 * @property-read array $periodes liste des periodes en promotion
 */
class Promotion extends DatatypeAbstract {
    protected $_label;
    protected $_produit;
    protected $_tarif;
    protected $_remise;
    protected $_texte;
    protected $_disponible;
    protected $_conditionMin;
    protected $_conditionMax;
    protected $_periodes;
}

