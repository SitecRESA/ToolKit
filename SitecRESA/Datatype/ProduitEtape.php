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
 * @property string           $produit libellé de lma fichePrestation
 * @property FichePrestation  $fichePrestation prestation correspondante
 * @property PlanTarifaire    $planTarifaire
 * @property string           $duree durée format fr
 * @property int              $id jour de la semaine [0..6]
 * @property int              $jourSession jour de la semaine [0..6]
 * @property int              $quantiteDispo si recherche dispo alors nombre de produit disponible
 * @property string           $heureDebut heure de debut
 * @property bool             $dispo le produit est disponible ou non
 * @property string           $dateArrivee  format d/m/Y si une recherche de dispo sur le package est effectuée
 * @property string           $dateDepart  format d/m/Y si une recherche de dispo sur le package est effectuée
 * @property decimal          $prixToal corespond au prix du planTarifiare x nombre de nuit de l'étape si hébergement ou au prix si activité si une recherche de dispo sur le package est effectuée
 */

class ProduitEtape extends DatatypeAbstract implements Fetchable{

    protected $_id;
    protected $_produit;
    protected $_fichePrestation;
    protected $_planTarifaire;
    protected $_duree;
    protected $_jourSession;
    protected $_heureDebut;
    protected $_categorie;
    protected $_dispo;
    protected $_dateArrivee;
    protected $_dateDepart;
    protected $_prixTotal;
    protected $_quantiteDispo;

    /**
     *
     * @param  \SitecRESA\WS\Client $apiClient
     * @param  int $id
     * @return self
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->produitetape("get",array("idRessource"=> $id));
    }
}