SitecRESA-API
=============

API to implement booking engine in frontend web site (need access grant with apikey)

Pré-requis
=============

 - PHP 5.3.1
 - autoriser set_include_path à PHP (nécessaire à la ligne 52 de SitecRESA/WS/Client.php)
 - extension cURL et JSON


Installation
=============

utilisez composer


Configuration
=============

##### url

url d'accès aux services web https://resav2.sitec.fr par défaut.
ce paramètre servira aux tests fonctionnels sur l'environnement de recette

##### apiKey et secretKey

merci d'écrire un e-mail à technique-web@sitec.fr ou de téléphoner au 0495236805 afin d'expliquer
votre projet et obtenir l'autorisation d'accès aux services

##### triDefault

tri a utiliser par défaut lors d'une recherche de disponibilités.
Commune, NbEtoile et Nom sont disponible.


Exemple
=============

Un fichier d'exemples est disponible à la racine : exemple.php
Le dossier doc contient la documentation de l'API en HTML. Pointez votre navigateur
sur doc/index.php
