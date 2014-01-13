<?php
/*****************************/
/*  instancier un Client WS  */
/*****************************/
//if you don't have an autoloader
//require_once dirname(__FILE__).'/SitecRESA/WS/Client.php';
//not mandatory, create an alias.
//use SitecRESA\Datatype;
//$apiClient = new \SitecRESA\WS\Client(array("apiKey" => "API_KEY", "secretKey" => "SECRET_KEY", "url" => "http://resav2.sitec.fr"));

/*****************************/
/*   gestion d'un portail    */
/*****************************/
//$resultat = Datatype\FichePrestataire::listePrestatairesDisponibles($apiClient, "04/07/2013", "07/07/2013", 1, 1, NULL, NULL, TRUE);

/*****************************/
/* fetch et SavableDatatype  */
/*****************************/
////les Datatypes qui hérite de SavableDatatypeAbstract peuvent être instanciés à partir de l'identifiant récupéré auparavant
////c'est le cas notament du panier.
//$oPanier = Datatype\Panier::fetch($apiClient, "39f33d2b312373c3fd828f6b5959c8b3");  /* @var $oPanier Datatype\Panier */

/*****************************/
/*  prestationsDisponibles   */
/*****************************/
//FichePrestataire possède une méthode prestationsDisponibles qui permet de récupérer les prestations dispo suivant des critères
//Datatype\FichePrestataire::fetch($apiClient, ID)->prestationsDisponibles(DEBUT, FIN);

/*****************************/
/*     disponibilités        */
/*****************************/
////Pour connaître la quantité et les tarifs disponible d'une prestation, il faut encore passer par une autre étape : disponibilités
//$iterable = Datatype\FichePrestataire::fetch($apiClient, ID)->prestationsDisponibles(DEBUT, FIN);
//$iterable[0]->disponibilites(...);

/*****************************/
/*     Creer un panier       */
/*****************************/
//Pour pouvoir réserver une prestation, il faut passer par un panier.
//$oPanier = new Datatype\Panier($apiClient);//ne nécessite pas d'autres paramètres
/* @var $oPanier \SitecRESA\Datatype\Panier */
/*****************************/
/* ajouter des prestations   */
/*****************************/
////A chaque prestation ajoutée par l'internaute, vous pouvez créer une prestation Panier, à moins évidemment que l'internaute ait la possibilité de demander une quantite
////Le panier se chargera de gérer ces prestations pour en faire un tableau cohérent
//$oPrestationPanier = new Datatype\PrestationPanier($apiClient, array(
//        "debut"           => "01/08/2013",
//        "fin"             => "04/08/2013",
//        "prestation"      => FICHE_PRESTATION_ID, 
//        "idTarif"         => DISPONIBILITE_PRODUIT_TARIF_ID, 
//        "idPlanTarifaire" => DISPONIBILITE_PRODUIT_PLANTARIFARE_ID,
//        "quantite"        => 1 //ou la quantité donnée par l'internaute
//    )
//);
//$oPanier->addPrestationPanier($oPrestationPanier);
//$oPanier->save();
//
////Il est aussi possible de créer une prestation de la sauvegarder elle
//$oPrestationPanier = new Datatype\PrestationPanier($apiClient, array(
//        "debut"           => "01/08/2013",
//        "fin"             => "04/08/2013",
//        "prestation"      => FICHE_PRESTATION_ID, 
//        "idTarif"         => DISPONIBILITE_PRODUIT_TARIF_ID, 
//        "idPlanTarifaire" => DISPONIBILITE_PRODUIT_PLANTARIFARE_ID,
//        "quantite"        => 1 //ou la quantité donnée par l'internaute
//    )
//);
//$oPrestation->panier = $oPanier;
//$oPrestation->save();
//
/*****************************/
/* modifier des prestations  */
/*****************************/
////récupérer l'instance de la prestation modifiée.
//$oPrestation = Datatype\PrestationPanier::fetch($apiClient, PRESTATION_PANIER_ID);
////modifier la quantité ou même les dates
//$oPrestation->debut    = "JJ/MM/AAAA";
//$oPrestation->fin      = "JJ/MM/AAAA";
//$oPrestation->quantite = X;
////l'internaute peut être guidé sur les quantités possibles à l'aide de la variable d'instance "quantiteMax" de PrestationPanier
////n'oubliez pas de sauvegarder
//$oPrestation->save()

/*****************************/
/* supprimer des prestations */
/*****************************/
////prestation panier est pour le moment le seul datatype qu'il est possible de supprimer
//$oPrestation->delete();

/*****************************/
/*     gestion du panier     */
/*****************************/
////Le panier met automatiquement à jour son tableau de prestationPanier :
////   - ajouter deux prestationsPanier identiques (dates, tarifs, prestation, etc.) ne fera qu'augmenter la quantité réservée.
////   - VOUS DEVEZ SYSTEMATIQUEMENT UTILISER CE TABLEAU POUR CONSTRUIRE L'INTERFACE DE VOTRE PANIER

/*****************************/
/*   gestion des invalidité  */
/*****************************/
////Le panier peut être invalidé :
////   - par l'hôtelier qui a fait une modification dans son backoffice
////   - par la réservation simultanée par un autre internaute
////PrestationPanier possède plusieurs variables d'instance permettant d'informer l'internaute de l'invalidité de la prestation
////   - le tarif peut avoir changé (en bien ou en mal)
////   - il peut simplement ne plus être disponible.
////   - la quantité dans le panier peut être supérieure à l'offre.
////Dans les deux derniers cas, il ne sera pas possible de réserver et faire appel à reserver() renverra un objet Erreur.



/*****************************/
/*     réserver le panier    */
/*****************************/
////vous devez tout d'abord fournir un client
//$oClient = new Datatype\Client($apiClient, "FRICOU","Marc","marc.fricou@sitec.fr","marc.fricou@sitec.fr");
//$oClient->adresse = new Datatype\Adresse($apiClient, array("adresseLigne1" => "ZI Vazzio","adresseLigne2" => "","commune" => "Ajaccio","codePostal" => "20090"));
//$oClient->telephone = "0495236824";
//$retour = $oClient->save();
//if($retour instanceof Datatype\Erreur){
////    traitement particulier de l'erreur rencontrée
//}
//$oPanier->client = $oClient;

//// il existe ensuite deux manières de réserver : par TPE, vous devez alors fournir une carte bleue au système
//TPE
//jeu de données de carte bleue d'exemple passant les contrôles.
//$ccCcv = 111;
//$ccMonth = 03;
//$ccName = "Marc FRICOU";
//$ccNumber = 4972030196799111;
//$ccType = "Visa";
//$ccYear = 2023;
//$oReservation = $oPanier->reserver("Ceci est un commentaire client", Datatype\Panier::PANIER_RESERVATION_TPE, $ccNumber, $ccType, $ccName, $ccMonth, $ccYear, $ccCcv);
//if($oReservation instanceof Datatype\Erreur){
////    traitement particulier de l'erreur rencontrée
//}
////Cette méthode vous enverra un objet Erreur si vous tentez de réserver un panier invalide ou si la carte bleue possède une invalidité.

////il est possible aussi de réserver "online" à l'aide d'un module bancaire (Paybox, Payline, O-Zone, etc.)
//$oReservation = $oPanier->reserver("Ceci est un commentaire client", Datatype\Panier::PANIER_RESERVATION_ONLINE);//pas de paramètres de carte bleue
////vous pouvez rediriger vers le module de paiement. Vous devez vous arranger pour concerver l'id de la réservation.
////Au retour, si le paiement à fonctionné
//$oReservation = \SitecRESA\Datatype\Reservation::fetch($apiClient,IDRESERVATION);
//$oReservation->numeroTransaction = NUMERO;
//$oReservation->save();
//Si le paiement n'a pas fonctionné, annuler la réservation
//$oReservation->delete();

//$oPrestationPanier = new Datatype\PrestationPanier($client, array("prestation" => $resu[0]->id, "idTarif" => $oDispo->plansTarifaires[0]->tarifs[0]->id, "idPlanTarifaire" => $oDispo->plansTarifaires[0]->id,"quantite" => 10));
//	#DATE DE SEJOUR
//	
//	$date_debut = "06/06/2013";
//	$date_fin = "07/06/2013";
//	
//	#si le formulaire de resa est valider
//        #creation de mon client
//        $oClient = new Datatype\Client($client, "FRICOU","Marc","marc.fricou@sitec.fr");
//        $oClient->telephone = "0672206497";
//        $oClient->save();
//        #creation de mon panier pour tester mes hebergements reserver 
//        $oPanier = new Datatype\Panier($client, 
//        array(
//            "dateDebut"        => $date_debut,
//            "dateFin"          => $date_fin,
//            "ccNumber"         => "",
//            "ccType"           => "",
//            "ccName"           => "",
//            "ccMonth"          => "",
//            "ccYear"           => "",
//            "ccCcv"            => "",
//            "commentaire"      => "Ca fonctionne",
//            "client"           => $oClient,
//            "fichePrestataire" => $fichePrestataire,
//        )
//);

/*****************************/
/*          prebook          */
/*****************************/

//$resultat = Datatype\FichePrestataire::listePrestatairesDisponibles($apiClient, "21/12/2013", "22/12/2013", 1, 1, NULL, array('Ajaccio'), TRUE,"Nom",40,0);
//$ficheOrganisme = $resultat[0];
//$prestations = $ficheOrganisme->prestationsDisponibles("04/12/2013", "07/12/2013");
//$dispoProduit = $prestations[0]->disponibilites("04/12/2013", "07/12/2013",$ficheOrganisme);
//$oPrestationPanier = new Datatype\PrestationPanier($apiClient,array(
//    "debut"           => "04/12/2013",
//    "fin"             => "07/12/2013",
//    "prestation"      => $prestations[0]->id, 
//    "idTarif"         => $dispoProduit->plansTarifaires[0]->tarifs[0]->id,
//    "idPlanTarifaire" => $dispoProduit->plansTarifaires[0]->id,
//    "quantite"        => 1 //ou la quantité donnée par l'internaute
//));
//$oPanier = new Datatype\Panier($apiClient);
//$oPanier->addPrestationPanier($oPrestationPanier);
//$oPanier->save();
//$oPanier->client = Datatype\Client::fetch($apiClient, 4168);
//$retour = $oPanier->prebook("commentaire",60);