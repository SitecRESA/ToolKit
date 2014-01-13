<?php

namespace SitecRESA\Datatype;

/**
 * Ensemble de conditions et d'avantages décrivant un tarif pour une chambre
 *
 * @author Marc FRICOU <marc.fricou@sitec.fr>
 * 
 * @property-read int $id identifiant du plan tarifaire
 * @property-read string $label titre français
 * @property-read string $description description française
 * @property-read bool $annulable indique si le plan tarifaire est annulable.
 * @property-read array $tarifs liste des tarifs disponibles
 * @property-read array $pensions pensions disponible (peut changer au cours du séjour, une seule est potentiellement disponible pour un jour donné).
 * @property-read array $garantieDemandee liste des règles conditionnant les montants qui peuvent être prélevé à la réservation.
 * @property-read array $conditionAnnulation liste des règles conditionnant l'annulation de la réservation de ce plan tarifaire.
 * @property-read array $conditionsTarifaireNonRespectees cette variable (tableau de {@see Datatype\ConditionTarifaire} si différente de NULL indique que le tarif n'est disponible qu'à certaines conditions.
 */
class PlanTarifaire extends DatatypeAbstract {
    protected $_id;
    protected $_label;
    protected $_description;
    protected $_annulable;
    protected $_tarifs;
    protected $_pensions;
    protected $_garantieDemandee;
    protected $_conditionAnnulation;
    protected $_conditionsTarifaireNonRespectees;
}

