<?php

namespace SitecRESA\Datatype;

/**
 * prestation fournie par le prestataire d'activités
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property-read int $id identifiant WS
 * @property-read string $libelle nom
 * @property-read string $description descrition
 * @property-read string $equipement equipement
 * @property-read string $equipementNonFournis equipement nonFournis
 * @property-read string $securite securite
 * @property-read string $conditionsParticulieres conditions particulieres
 * @property-read string $documentsObligatoires documents obligatoires
 * @property-read \SitecRESA\Datatype\PositionGPS $lieuActivite coordonnées GPS du lieux de l'activité
 * @property-read array $encadrants liste des encadrants
 * @property-read \SitecRESA\Datatype\Photo $photo première photo
 * @property-read \SitecRESA\Datatype\AccesResolverList $galleriePhoto tableau de photos (SitecRESA\Datatype\Photo). (Accès WS)
 *
 */
class FichePrestationActivite extends DatatypeAbstract implements Fetchable {
    protected $_id;
    protected $_libelle;
    protected $_description;
    protected $_equipement;
    protected $_equipementNonFournis;
    protected $_securite;
    protected $_conditionsParticulieres;
    protected $_documentsObligatoires;
    protected $_lieuActivite;
    protected $_encadrants;
    protected $_photo;
    protected $_galleriePhoto;
    /**
     * @var \SitecRESA\Datatype\AccesResolver
     */
    private $_dispoProduit;


    /**
     * permet d'obtenir les disponibilités de la prestation
     *
     * @param string $dateDebut format JJ/MM/AAAA
     * @param string $dateFin format JJ/MM/AAAA
     * @param \SitecRESA\Datatype\FichePrestataire $fichePrestataire
     * @return DisponibiliteProduit objet DisponibiliteProduit
     */
    public function disponibilites($dateDebut, $dateFin, FichePrestataire $fichePrestataire) {
        return $this->_dispoProduit->resolve(array("dateDebut" => $dateDebut,"dateFin" => $dateFin,"organisme" => $fichePrestataire->id));
    }

    /**
     *
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id
     * @return \SitecRESA\Datatype\FichePrestationActivite
     */
    static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->produit("get",array("idRessource" => $id));
    }

}

