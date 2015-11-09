<?php

namespace SitecRESA\Datatype;

/**
 * Fiche prestation choisie pour un séjour
 *
 * @author Damien CAYZAC <damien.cayzac@sitec.fr>
 *
 *
 */
class Paiement extends DatatypeAbstract{

    protected $_montant;
    protected $_dateApplication;

    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param array $array tableau associatif avec pour clé les attributs de l'objet. Prestation peut être uniquement son identifiant
     */
    public function __construct($montant, $dateApplication) {
        $dateApplication = new \Zend_Date($dateApplication);
        $this->_dateApplication = $dateApplication->get(\Zend_Date::YEAR."-".\Zend_Date::MONTH."-".\Zend_Date::DAY);
        $this->_montant = $montant;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->_montant;
    }

    /**
     * @param mixed
     */
    public function setMontant($montant)
    {
        $this->_montant = $montant;
    }

    /**
     * @return string
     */
    public function getDateApplication()
    {
        return $this->_dateApplication;
    }

    /**
     * @param string $dateApplication
     */
    public function setDateApplication($dateApplication)
    {
        $this->_dateApplication = $dateApplication;
    }


}
