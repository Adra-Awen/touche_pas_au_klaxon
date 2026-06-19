<?php

namespace Controllers;

use Config\Database;
use PDO;
use PDOException;
use Models\Trajet;

/**
 * Contrôleur pour la gestion des trajets
 * Controller for managing trips
 * 
 * Gère les interactions liées aux trajets dans l'application.
 * Manages interactions related to trips in the application.
 * @package App\Controllers
 */
class TrajetController
{
    /**
     * Affiche la liste des trajets à venir sur la page d'accueil
     * Displays the list of upcoming trips on the homepage
     * @return void
     */
    public function index()
    {
        try {
            $trajets = \Models\Trajet::getAllUpcoming();
            echo "<h2>Trajets à venir</h2>";

            if (empty($trajets)) {
                echo "<p>Aucun trajet prévu pour le moment.</p>";
            } else {
                echo "<ul>";
                foreach ($trajets as $trajet) {
                    /** 
                     * Extraction des départs
                     * @var array $trajet 
                     */
                    $timestamp = strtotime($trajet['gdh_depart']);
                    $date = date('d/m/Y', $timestamp);
                    $heure = date('H:i', $timestamp);

                    /** 
                     * Extraction des arrivées
                     * @var array $trajet 
                     */
                    $timestamp = strtotime($trajet['gdh_arrivee']);
                    $heure_arrivee = date('H:i', $timestamp);

                    /** 
                     * Affichage des informations du trajet
                     * @var array $trajet 
                     */
                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($trajet['agence_depart']) . "</strong> - <strong>" . htmlspecialchars($trajet['agence_arrivee']) . "</strong>" . "<br>";
                    echo " le " . $date . " à " . $heure . "<br>";
                    echo "Arrivée prévue à " . $heure_arrivee . "<br>";
                    echo "Places disponibles : " . htmlspecialchars($trajet['places_disponibles']) . "<br>";
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