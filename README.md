SitecRESA-ToolKit
=============

APIs to implement booking engine in frontend web site (need access grant with apikey)

Pré-requis
=============

 - PHP 5.3.8
 - extension cURL et JSON


Installation
=============
### Installer composer
    curl -sS https://getcomposer.org/installer | php
### ajouter sitecresa/toolkit 
il s'agit d'une dépendance dans votre composer.json

    "require": {
        "sitecresa/toolkit":"*"
    }


Configuration
=============

### url

url d'accès aux services web https://resav2.sitec.fr par défaut.
ce paramètre servira aux tests fonctionnels sur l'environnement de recette

### apiKey et secretKey

merci d'écrire un e-mail à technique-web@sitec.fr ou de téléphoner au 0495236805 afin d'expliquer
votre projet et obtenir l'autorisation d'accès aux services

### triDefault

tri a utiliser par défaut lors d'une recherche de disponibilités.
Commune, NbEtoile et Nom sont disponible.


Exemple
=============

Un fichier d'exemples est disponible à la racine : exemple.php
Le dossier doc contient la documentation de l'API en HTML. Pointez votre navigateur
sur doc/index.php
