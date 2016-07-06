<?php

namespace SitecRESA\Datatype;


/**
 * Avis d'une réservation
 *
 * @author Patrice Brun <patrice.brun@sitec.fr>
 *
 * @property int            $idCommentaireAvis
 * @property string         $subject
 * @property string         $comment
 * @property string         $commenter
 * @property date           $creationDate
 * @property boolean        $isPublic
 * @property Sitec_Avis     $avis
 */

class CommentaireAvis extends DatatypeAbstract{

    // <editor-fold defaultstate="collapsed" desc="variables d'instance">
    /**
     * ID du commentaire de l'avis
     * @var int
     */
    protected $_idCommentaireAvis;

    /**
     * sujet du commentaire de l'avis
     * @var string
     */
    protected $_subject;

    /**
     * Réponse Textuelle du commentaire de l'avis
     * @var string
     */
    protected $_comment;

    /**
     * Nom de l'entité ayant répondu
     * @var string
     */
    protected $_commenter;

    /**
     * Date d’ajout de la Réponse
     * @var date
     */
    protected $_creationDate;

    /**
     * True : Réponse Publique / False : Réponse Privée
     * @var boolean
     */
    protected $_isPublic;

    /**
     * Avis parent
     * @var Sitec_Avis
     */
    protected $_avis;
    // </editor-fold>

    /**
     * Permet d'obtenir un avis depuis son ID WS
     * @param \SitecRESA\WS\Client $apiClient
     * @param int $id identifiant WS
     * @return \SitecRESA\Datatype\CommentaireAvis
     */
    public static function fetch(\SitecRESA\WS\Client $apiClient, $id) {
        return $apiClient->client("get",array("idRessource" => $id));
    }
}