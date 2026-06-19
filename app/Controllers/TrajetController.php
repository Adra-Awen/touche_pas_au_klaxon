<?php

namespace Controllers;

use Config\Database;
use PDO;
use PDOException;

/**
 * Contrôleur pour la gestion des trajets
 * Controller for managing trips
 * 
 * Gère les interactions liées aux trajets dans l'application.
 * Manages interactions related to trips in the application.
 * 
 * @package App\Controllers
 */
class TrajetController
{
    /**
     * Affiche la liste des trajets
     * Displays the list of trips
     */
    public function index()
    {
        try {
            /**Requête avec jointures nécessaires pour récupérer les informations des trajets
             * Query with necessary joins to retrieve trip information
            */
            $trajets = \Models\Trajet::getAllUpcoming();

            /** Affichage des trajets (ici, on se contente d'un simple affichage pour l'exemple)
             * Display of trips (here, we just do a simple display for the example)
            */
            echo "<h1>Liste des trajets</h1>";

            if (empty($trajets)) {
                echo "<p>Aucun trajet prévu pour le moment.</p>";
            } else {
                echo "<ul>";
                foreach ($trajets as $trajet) {
                    /** Récupération des départ
                     * Retrieving departures
                     */
                    $timestamp = strtotime($trajet['gdh_depart']);
                    $date = date('d/m/Y', $timestamp);
                    $heure = date('H:i', $timestamp);

                    /** Récupération des arrivées
                     * Retrieving arrivals
                     */
                    $timestamp = strtotime($trajet['gdh_arrivee']);
                    $heure = date('H:i', $timestamp);

                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($trajet['agence_depart']) . "</strong> - <strong>" . htmlspecialchars($trajet['agence_arrivee']) . "</strong> <br>";
                    echo " le " . $date . " à " . $heure . "<br>";
                    echo "Arrivée prévue à " . $heure . "<br>";
                    echo "Places disponibles : " . htmlspecialchars($trajet['places_disponibles']) . "/" . htmlspecialchars($trajet['places_totales']) . "<br>";
                    echo "Contact : " . htmlspecialchars($trajet['conducteur_nom']) . " " . htmlspecialchars($trajet['conducteur_prenom']) . "<br>";
                    echo "</li>";
                }
                echo "</ul>";
            }   
        } catch (PDOException $e) {
            echo "<h1>Erreur lors de la récupération des trajets :</h1>";
            echo "<p>" . $e->getMessage() . "</p>";
        } 
    }
}