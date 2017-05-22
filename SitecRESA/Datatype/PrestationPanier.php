<?php

namespace SitecRESA\Datatype;

/**
 * Fiche prestation choisie pour un séjour
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property int $id identifiant WS
 * @property int $typeTarif tarif du plan tarifaire choisi
 * @property int $quantite quantite choisie par le client. Peut changer en fonction des données du panier.
 * @property int $quantiteMax quantite maximale disponible. Information obtenue après une mise à jour du panier.
 * @property string $debut début du séjour pour la prestation
 * @property string $fin fin du séjour pour la prestation
 * @property float  $acompteDemande acompte ou ahrres demandé(es) par l'hôtel pour réserver en euros.
 * @property float  $ancienTarif celui initialement calculé, modifié depuis et disponible dans $this->_nouveauTarif
 * @property bool   $tarifPerdu le tarif recherché n'est plus disponible, le panier ne peut être réservé.
 * @property bool   $expired la prestation panier est périmée, le panier ne peut être réservé.
 * @property Tarif  $tarif tarif s'il n'a pas changé, sinon NULL.
 * @property Tarif  $nouveauTarif tarif modifié, sinon NULL.
 * @property FichePrestation $prestation prestation correspondante
 * @property FichePrestataire $prestataire prestataire correspondant
 * @property Panier $panier panier depuis lequel la prestation est à réserver
 * @property PlanTarifaire $planTarifaire plan tarifaire choisi pour réserver
 * @property int $idEtape etape d'un package
 * @property string $participants liste des noms et prénoms se chaque participant. format=> nom1|prenom1#nom2|prenom2#...#nomX|prenomX
 * @property-read array $garantieDemandee liste des règles conditionnant les montants qui peuvent être prélevé à la réservation.
 * @property-read array $conditionAnnulation liste des règles conditionnant l'annulation de la réservation de ce package.
 *
 */
class PrestationPanier extends SavableDatatypeAbstract implements Fetchable{
    protected $_id;

    protected $_timestampDebut;//obtenu à travers le ws
    protected $_timestampFin;//obtenu à travers le ws
    protected $_debut;
    protected $_fin;

    protected $_quantite;
    protected $_quantiteMax;

    protected $_idPlanTarifaire;
    protected $_ancienTarif;
    protected $_tarif;
    protected $_nouveauTarif;
    protected $_typeTarif;
    protected $_acompteDemande;

    protected $_tarifPerdu;
    protected $_expired;

    protected $_panier;
    protected $_prestation;
    protected $_prestataire;
    protected $_planTarifaire;
    protected $_garantieDemandee;
    protected $_conditionAnnulation;
    protected $_tarifPlanTarifaire;
    protected $_idEtape = null;

    protected $_nbNuit;
    protected $_nbJour;
    protected $_duree;
    protected $_participants;
    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param array $array tableau associatif avec pour clé les attributs de l'objet. Prestation peut être uniquement son identifiant
     */
    public function __construct($apiClient, $array = NULL) {
        if(isset($array["idTarif"])){
            $array["typeTarif"] = $array["idTarif"];
            unset($array["idTarif"]);
        }
        if(is_numeric($array["prestation"])){//construction par l'intégrateur
            //on construit l'acces resolver.
            $array["prestation"] = new AccesResolver($apiClient,array(
                "idRessource" => $array["prestation"],
                "verbe"       => "get",
                "methode"     => "produit",
            ));
        }
        parent::__construct($apiClient, $array);
        if($this->_timestampDebut){//depuis WS
            $debut = new \Zend_Date($this->_timestampDebut);
            $fin = new \Zend_Date($this->_timestampFin);
            $this->_debut = $debut->get(\Zend_Date::DAY."/".\Zend_Date::MONTH."/".\Zend_Date::YEAR);
            $this->_fin = $fin->get(\Zend_Date::DAY."/".\Zend_Date::MONTH."/".\Zend_Date::YEAR);
        }
    }

    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param type $id
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->produitpanier("get",array("idRessource" => $id));
    }

    /**
     * sauvegarder la prestation
     */
    public function save() {
        //post
        if(!$this->_id){
            if(!$this->panier instanceof Panier){
                throw new Api("Impossible de sauvegarder une nouvelle prestationPanier sans préciser à quel panier il est attaché.");
            }
            $location = $this->panier->save();
            if($location instanceof Erreur){
                return $location;
            }
        } else {//put
            //on ne peut enregistrer le client dans le panier qu'en PUT
            $retour = $this->_apiClient->produitpanier("put",$this->toArray());
            if($retour instanceof Erreur){
                return $retour;
            }
        }
    }

    /**
     * supprimer le prestation du panier.
     * @param \SitecRESA\Datatype\Panier $oPanier
     */
    public function delete($oPanier) {
        $this->_apiClient->produitpanier("delete",$this->toArray());
        $this->panier->synchronise();
        $oPanier->synchronise();
    }

    public function toArray() {
        $array = array(
            "idRessource"     => $this->_id,
            "idTarifType"     => $this->_typeTarif,
            "idPlanTarifaire" => $this->_idPlanTarifaire,
            "quantite"        => $this->_quantite,
            "dateDebut"       => $this->_debut,
            "dateFin"         => $this->_fin,
            "idEtape"         => $this->_idEtape
        );
        if($this->_prestation instanceof AccesResolver){
            $array["idProduit"] = $this->_prestation->idRessource;
        }elseif ($this->_prestation instanceof FichePrestation) {
            $array["idProduit"] = $this->_prestation->id;
        }else{
            throw new \SitecRESA\Exception\Api("PrestationPanier doit avoir une FichePrestation pour son attribut prestation");
        }
        return $array;
    }

    public function __get($name) {
        $retour = parent::__get($name);
        if(null === $retour && $this->_panier != null && "planTarifaire" == $name && null == $this->_planTarifaire){
            $oDispoProduit = $this->prestation->disponibilites($this->_debut, $this->_fin, $this->_prestataire->resolve());
            if($oDispoProduit instanceof AccesResolverList)
            {
                foreach($oDispoProduit as $dispoProduit){
                    foreach ($dispoProduit->plansTarifaires as /* @var $oPlanTarifaire PlanTarifaire */ $oPlanTarifaire) {
                        if($oPlanTarifaire->id == $this->_idPlanTarifaire){
                            $this->_planTarifaire = $oPlanTarifaire;
                            return $this->_planTarifaire;
                        }
                    }
                }
            }else{
                foreach ($oDispoProduit->plansTarifaires as /* @var $oPlanTarifaire PlanTarifaire */ $oPlanTarifaire) {
                    if($oPlanTarifaire->id == $this->_idPlanTarifaire){
                        $this->_planTarifaire = $oPlanTarifaire;
                        return $this->_planTarifaire;
                    }
                }
            }
        }
        return $retour;
    }


    /**
     * permet de simplement savoir si on peut réserver la prestation à l'aide de son panier.
     * @return boolean
     */
    public function isBookable() {
        return !$this->expired && !$this->tarifPerdu && $this->quantite <= $this->quantiteMax;
    }

    /**
     *
     * @return float montant de l'acompte
     */
//    public function getAcompteDemande() {
//        return $this->_apiClient->garantieRetenue("get",array(
//            "idRessource" => $this->_idPlanTarifaire,
//            "idTypeTarif" => $this->_typeTarif,
//            "dateDebut"   => $this->_debut,
//            "dateFin"     => $this->_fin,
//            "quantite"    => $this->_quantite))->montantGarantie;
//    }
}