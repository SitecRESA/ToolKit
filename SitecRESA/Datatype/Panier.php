<?php

namespace SitecRESA\Datatype;

/**
 * Panier permettant de faire une réservation et de gérer des prestations et plusieurs séjours
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property int $id
 * @property int $idReservation, id de la réservation quand elle a été faite.
 * @property string $commentaire commentaire éventuel de l'internaute
 * @property SitecRESA\Datatype\Client $client
 * @property array $prestationsPanier liste des prestations à réserver (ajoutez-en à l'aide de addPrestationPanier)
 * @property float $montantTotal total des prestations dans le panier.
 * @property int $quantite quantité totale de prestations dans le panier.
 */
class Panier extends SavableDatatypeAbstract implements Fetchable{
    const PANIER_RESERVATION_TPE = "tpe";
    const PANIER_RESERVATION_ONLINE = "online";

    protected $_id;
    protected $_idReservation;
    protected $_client;
    protected $_prestationsPanier = array();
    protected $_paiements = array();
    protected $_montantTotal;
    protected $_ancienMontantTotal;
    protected $_nouveauMontantTotal;
    protected $_tarifsPerdu;
//    protected $__problemesValidite;
    protected $_quantite;

    public function __construct($apiClient, $array = NULL) {
        parent::__construct($apiClient, $array);
        $apiClient->setPanier($this);
    }

    public function __set($name, $value) {
        if("prestationsPanier" == $name){
            throw new \SitecRESA\Exception\Api("Vous ne pouvez pas setter Panier::prestationsPanier, utilisez Reservation::addPrestationPanier()");
        }
        parent::__set($name, $value);
    }

    /**
     * réserver la prestation
     * @param string $commentaire commentaire du client
     * @param string $ccNumber numéro de la carte bleue
     * @param string $ccType type de la carte bleue ('Visa','American Express','Mastercard', etc.)
     * @param string $ccName nom figurant sur la carte
     * @param string $ccMonth mois d'expiration de la carte
     * @param string $ccYear année d'expiration de la carte
     * @param string $ccCcv trois dernier chiffres au dos de la carte.
     * @return \SitecRESA\Datatype\Erreur|\SitecRESA\Datatype\Reservation rien si tout s'est déroulé correctement, une {@see \SitecRESA\Datatype\Erreur} Sinon
     * @throw \SitecRESA\Exception\Api si le type de transaction n'est pas reconnu ou si vous n'avez pas donner de client au panier.
     */
    public function reserver($commentaire,
            $ccNumber = null,
            $ccType   = null,
            $ccName   = null,
            $ccMonth  = null,
            $ccYear   = null,
            $ccCcv    = null) {
        $params = $this->bookParams($commentaire);
        $params["ccNumber"] = $ccNumber;
        $params["ccType"]    = $ccType;
        $params["ccName"]   = $ccName;
        $params["ccMonth"]  = $ccMonth;
        $params["ccYear"]   = $ccYear;
        $params["ccCcv"]    = $ccCcv;

        $location = $this->_apiClient->resaPanier("post",$params);
        if($location instanceof Erreur) {
            return $location;
        }
        $aPart = explode("/", $location);
        $indexGet = array_search("get", $aPart);
        $this->_idReservation = $aPart[$indexGet+1];
        return $this->_apiClient->resa("get",array("idRessource" => $this->_idReservation));
    }

    protected function bookParams($commentaire,$typeTransaction = self::PANIER_RESERVATION_TPE){
        if(!$this->client instanceof Client){
            throw new \SitecRESA\Exception\Api("Impossible de pré-réserver ou de réserver ce panier, il n'y a pas de client associé.");
        }
        $params = array();
        $params["comment"]           = \urlencode($commentaire);
        $params["identifiantPanier"] = $this->_id;
        $params["idClient"]          = $this->client->id;
        $params["transaction"]       = $typeTransaction;
        return $params;
    }

    /**
     *
     * @param string $commentaire
     * @param int    $expiration en minutes, 15 par défaut
     * @return \SitecRESA\Datatype\Erreur|\SitecRESA\Datatype\Reservation
     * @throws \SitecRESA\Exception\Api
     */
    public function prebook($commentaire, $expiration = 15) {
        $params = $this->bookParams($commentaire, self::PANIER_RESERVATION_ONLINE);
        $params["expiration"]  = $expiration;

        if(sizeof($this->_paiements) >= 2){
            /** @var Paiement $paiement */
            $i=0;
            foreach($this->_paiements as $paiement){
                if($i != 0) {
                    $aPaiement[$i][]['montant'] = $paiement->montant;
                    $aPaiement[$i][]['dateApplication'] = $paiement->dateApplication;
                }
                $i++;
            }
            $params['multiPaiement'] = \Zend_Json::encode($aPaiement);
        }

        $location = $this->_apiClient->resaPanier("post",$params);
        if($location instanceof Erreur) {
            return $location;
        }
        $aPart = explode("/", $location);
        $indexGet = array_search("get", $aPart);
        $this->_idReservation = $aPart[$indexGet+1];

        return $this->_apiClient->resa("get",array("idRessource" => $this->_idReservation));
    }

    /**
     * Uniquement si le revendeur facture et que sa politique de garantie est de type avantSejour et que les regles sont basés sur du pourcentage
     * @return tableau de DataType\Paiement
     */
    public function multiPaiement(){

        $montantPanier = $this->montantTotal;
        $montant = 0;
        $montantPreleve = 0;
        /** @var PrestationPanier $prestationPanier */
        foreach($this->prestationsPanier as $prestationPanier){
            $i=1;
            $dateValidePrecedent = null;
            $garantiePrecedente = null;
//            $oGarantie = $prestationPanier->planTarifaire->garantieDemandee;
            foreach($prestationPanier->planTarifaire->garantieDemandee as $oGarantie){
                $debutSejour = new \Zend_Date($prestationPanier->debut);
                $now = new \Zend_Date();
                $now->set(00, \Zend_Date::HOUR);
                $now->set(00, \Zend_Date::MINUTE);
                $now->set(00, \Zend_Date::SECOND);
                if($oGarantie->condition == -1){
                    $condition = 0;
                }else{
                    $condition = $oGarantie->condition;
                }
                $dateValide = $debutSejour->subDayOfYear($condition);

                if($dateValide >= $now){

                    if($i == 1){
                        $dateValidePrecedent = $dateValide;
                        $garantiePrecedente = $oGarantie;
                        $dateValide = $now;

                    }elseif($i == sizeof($prestationPanier->planTarifaire->garantieDemandee))
                        {
                        $dateValide = $debutSejour->subDayOfYear($garantiePrecedente->condition);
                        }
                        else{
                            $dateValide = $dateValidePrecedent;
                            $dateValidePrecedent = $dateValide;
                            $garantiePrecedente = $oGarantie;
                        }

                    $i++;
                    if($oGarantie->unite == "%"){
                        $montant = ($montantPanier * $oGarantie->valeur / 100) - $montantPreleve;
                        $montantPreleve += $montant;
                    }
                    $paiement = new Paiement($montant,$dateValide);
                    $this->addPaiement($paiement);
                }
            }
        }
        return $this->_paiements;
    }

    /**
     *
     * @return Erreur|NULL un objet {@see Erreur} si il manque des paramètres (CB, Client, etc.)<br>
     * NULL si rien d'important est survenu
     * @throws \SitecRESA\Exception\Api si le panier est vide
     */
    public function save() {
        if(empty($this->_prestationsPanier)){
            throw new \SitecRESA\Exception\Api("Rien dans le panier !");
        }

        if($this->_client instanceof Client && null == $this->_client->id){
            if(($retour = $this->_client->save()) && $retour instanceof Erreur){
                return $retour;
            }
        }
        $vientDePoster = false;
        //post
        if(!$this->_id){
            $location = $this->_apiClient->panier("post",$this->toArray());
            if($location instanceof Erreur){
                return $location;
            }
            //on récupère l'id à partir du header location
            $aPart = explode("/", $location);
            $indexGet = array_search("get", $aPart);
            $this->_id = $aPart[$indexGet+1];
            $vientDePoster = true;
            $this->synchronise();
        }

        //put
        if(($this->_client instanceof Client && $this->_id) || (!$vientDePoster && $this->_id)) {
            //on ne peut enregistrer le client dans le panier qu'en PUT
            $retour = $this->_apiClient->panier("put",$this->toArray());
            if($retour instanceof Erreur){
                return $retour;
            }

            if(!$vientDePoster){//alors, il faut mettre à jour le panier.
                $this->synchronise();
            }
        }
    }

    public function synchronise() {
        $oNouveauPanier = self::fetch($this->_apiClient, $this->_id);
        $this->_quantite = $oNouveauPanier->quantite;
        $this->_prestationsPanier = $oNouveauPanier->prestationsPanier;
        $this->_montantTotal = $oNouveauPanier->montantTotal;
    }

    public function toArray() {
        $array = array(
            "idRessource"    => $this->_id,
        );
        if($this->_client instanceof Client){
            $array["idClient"] = $this->_client->id;
        }
        $aListeProduitsOrganisme = array();
        /* @var $oPrestationPanier PrestationPanier */
        foreach ($this->prestationsPanier as $oPrestationPanier) {
            if(null === $oPrestationPanier->id){
                $aListeProduitsOrganisme[] = $oPrestationPanier->toArray();
            }
        }
        $array["listeProduitsOrganisme"] = \Zend_Json::encode($aListeProduitsOrganisme);
        return $array;
    }

    /**
     * Teste la validité du panier à réserver
     * @return boolean
     */
    public function testReservation() {
        /* @var $oPrestationPanier PrestationPanier */
        foreach ($this->prestationsPanier as $oPrestationPanier){
            if(!$oPrestationPanier->isBookable()){
                return false;
            }
        }
        return true;
    }

    /**
     * Permet de connaître la quantité de toutes les prestations toutes formes confondues dans la réservation
     * @return int
     */
    public function quantiteTotaleFichePrestationInPanier() {

        $quantite = 0;

        /* @var $oPrestationPanier PrestationPanier */
        foreach ($this->_prestationsPanier as $oPrestationPanier) {
            $quantite += $oPrestationPanier->quantite;
        }

        return $quantite;
    }
    /**
     * Permet de connaître la quantité d'une prestation toutes formes confondues présente dans la réservation
     * @param FichePrestation|int $fichePrestation identifiant WS ou objet FichePrestation
     * @return int
     */
    public function quantiteFichePrestationInPanier($fichePrestation) {
        if($fichePrestation instanceof FichePrestation){
            $fichePrestation = $fichePrestation->id;
        }
        $quantite = 0;
        /* @var $oPrestationPanier PrestationPanier */
        foreach ($this->_prestationsPanier as $oPrestationPanier) {
            if($oPrestationPanier->prestation->id == $fichePrestation){
                $quantite += $oPrestationPanier->quantite;
            }
        }
        return $quantite;
    }

    /**
     * permet d'ajouter une prestation à la réservation.
     * @param \SitecRESA\Datatype\PrestationPanier $prestation
     */
    public function addPrestationPanier(PrestationPanier $prestation) {
        $prestation->panier = $this;
        $aPrestaitonExistante = array();
        if(!empty($this->_prestationsPanier))
        {
            foreach($this->_prestationsPanier as $prestationPanier)
            {
                $aPrestaitonExistante[] = $prestationPanier;
            }
        }
        $this->_prestationsPanier = array();
        array_push($aPrestaitonExistante,$prestation);
        $this->_prestationsPanier = $aPrestaitonExistante;
    }

    /**
     * permet d'ajouter une prestation à la réservation.
     * @param \SitecRESA\Datatype\PrestationPanier $prestation
     */
    public function addPaiement(Paiement $paiement) {
        $paiement->panier = $this;
        $aPaiementExistant = array();
        if(!empty($this->_paiements))
        {
            foreach($this->_paiements as $paiementPanier)
            {
                $aPaiementExistant[] = $paiementPanier;
            }
        }
        $this->_paiements = array();
        array_push($aPaiementExistant,$paiement);
        $this->_paiements = $aPaiementExistant;
    }

    /**
     * Retourne le tarifs (tarif Brut et tarif Promotionnel) totaux du panier
     * @return array
     */
    public function tarifTotal() {
        $tarifTotalPromo =$tarifTotal = 0;
        /* @var $oPrestationPanier \SitecRESA\Datatype\PrestationPanier */
        foreach ($this->_prestationsPanier as $oPrestationPanier) {
            $tarifTotal += $oPrestationPanier->tarif->prix*$oPrestationPanier->quantite;
            if(NULL != $oPrestationPanier->tarif->prixPromo){
                $tarifTotalPromo += $oPrestationPanier->tarif->prixPromo*$oPrestationPanier->quantite;
            }else{
                $tarifTotalPromo += $oPrestationPanier->tarif->prix*$oPrestationPanier->quantite;
            }
        }
        return array("brut" => $tarifTotal,"promotionnel" => $tarifTotalPromo);
    }
    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param type $id
     * @return self
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->panier("get",array("idRessource"=> $id));
    }

    /**
     * calcul de l'acompte demandé pour la réservation du panier (purement informatif)
     * @return float
     */
    public function acompteTotalDemande() {
        $acompteTotal = 0;
        foreach ($this->prestationsPanier as $oPrestation) {
            $acompteTotal += $oPrestation->acompteDemande;
        }
        return $acompteTotal;
    }
}