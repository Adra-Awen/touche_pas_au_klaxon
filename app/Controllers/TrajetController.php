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
            // 1. Connexion à la base de données
            $db = Database::getConnection();

            // 2. Requête avec jointures nécessaires pour récupérer les informations des trajets
            $queryStr = "SELECT
                        t.id, /** t = table des trajets */ 
                        t.gdh_depart,
                        t.gdh_arrivee,
                        t.places_totales,
                        t.places_disponibles,
                        a_dep.ville AS agence_depart, /** a = table agences */
                        a_arr.ville AS agence_arrivee,
                        u.nom AS conducteur_nom, /** u = table users */
                        u.prenom AS conducteur_prenom
                    FROM trajets t
                    INNER JOIN agences a_dep ON t.id_agence_depart= a_dep.id
                    INNER JOIN agences a_arr ON t.id_agence_arrivee = a_arr.id
                    INNER JOIN users u ON t.id_conducteur = u.id
                    WHERE t.gdh_depart >= NOW() /** Filtre pour ne récupérer que les trajets à venir */ 
                    ORDER BY t.gdh_depart ASC"; /** Tri par date de départ croissante */
            
            $stmt = $db->query($queryStr);
            $trajets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 3. Affichage des trajets (ici, on se contente d'un simple affichage pour l'exemple)
            echo "<h1>Liste des trajets</h1>";

            if (empty($trajets)) {
                echo "<p>Aucun trajet prévu pour le moment.</p>";
            } else {
                echo "<ul>";
                foreach ($trajets as $trajet) {
                    $timestamp = strtotime($trajet['gdh_depart']);
                    $date = date('d/m/Y', $timestamp);
                    $heure = date('H:i', $timestamp);

                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($trajet['agence_depart']) . "</strong> à <strong>" . htmlspecialchars($trajet['agence_arrivee']) . "</strong>";
                    echo " le " . $date . " à " . $heure . "<br>";
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