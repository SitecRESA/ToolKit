<?php

namespace SitecRESA\Datatype;

/**
 * prestation fournie par le prestataire
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 *
 * @property-read int $id identifiant WS
 * @property-read string $libelle nom français
 * @property-read string $description français
 * @property-read int $adulteMin nombre minimal d'adulte
 * @property-read int $adulteMax nombre maxi d'adulte
 * @property-read \SitecRESA\Datatype\Photo $photo première photo
 * @property-read \SitecRESA\Datatype\AccesResolverList $galleriePhoto tableau de photos (SitecRESA\Datatype\Photo). (Accès WS)
 * @property-read \SitecRESA\Datatype\AccesResolverList $equipementscategorieproduit tableau d'équipement (SitecRESA\Datatype\Equipement). (Accès WS)
 *
 */
class FichePrestation extends DatatypeAbstract implements Fetchable {
    protected $_id;
    protected $_libelle;
    protected $_description;
    protected $_adulteMin;
    protected $_adulteMax;
    protected $_photo;
    protected $_galleriePhoto;
    /**
     * @var \SitecRESA\Datatype\AccesResolver
     */
    protected $_dispoProduit;
    protected $_equipementscategorieproduit;

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
     * @return \SitecRESA\Datatype\FichePrestation
     */
    static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->produit("get",array("idRessource" => $id));
    }

    /**
     * Get last modified date
     *
     * @param Client $apiClient
     * @param int    $id
     *
     * @return string AAAA-MM-JJTHH:mm:SSz (format ISO-8601)
     */
    static public function lastModified(Client $apiClient, $id)
    {
        $fiche = $apiClient->tourproductlastmodified("get",array("idRessource" => $id));
        return $fiche->lastModified;
    }
}

