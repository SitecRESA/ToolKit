<?php

namespace SitecRESA\Datatype;

/**
 * représentation d'une photo, l'objet permet d'obtenir les différentes urls des différentes qualités disponibles.
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read string $url url vers le resize 600x600 px;
 * @property-read string $urlOver url vers le over 300x300 px
 * @property-read string $thumbnails url vers le thumbnail 150x150 px
 * @property-read string $urlVignette url vers la Vignette 140x140 px
 * @property-read string $urlMiniature url vers la mignature 50x50 px
 * @property-read string $description Description de la photo (attention, il ne s’agit pas de HTML, il faut gérer les retours chariot)
 */
class Photo extends DatatypeAbstract {
    protected $_url;
    protected $_urlOver;
    protected $_thumbnails;
    protected $_urlVignette;
    protected $_urlMiniature;
    protected $_description;
}

