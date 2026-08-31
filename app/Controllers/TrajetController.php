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
            echo "<h2>Liste des trajets</h2>";

            $trajets = Trajet::getAllUpcoming();

            if (empty($trajets)) {
                echo "<p>Aucun trajet prévu pour le moment.</p>";
            } else {
                echo "<ul>";
                foreach ($trajets as $trajet) {
                    $timestamp = strtotime($trajet['gdh_depart']);
                    $date = date('d/m/Y', $timestamp);
                    $heure = date('H:i', $timestamp);

                    /** Récupération des arrivées
                     * Retrieving arrivals
                     */
                    $timestamp = strtotime($trajet['gdh_arrivee']);
                    $heure = date('H:i', $timestamp);

                    /** 
                     * Affichage des informations du trajet
                     * @var array $trajet 
                     */
                    echo "<li>";
                    echo "<strong>" . htmlspecialchars($trajet['agence_depart']) . "</strong> - <strong>" . htmlspecialchars($trajet['agence_arrivee']) . "</strong> <br>";
                    echo " le " . $date . " à " . $heure . "<br>";
                    echo "Arrivée le " . $date . " à " . $heure . "<br>";
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

    /** 
     * Affiche le formulaire d'ajout d'un trajet
     * Displays the form to add a new trip
     * @return void
     */
    public function add()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        try {
            $agences = \Models\Agence::getAll();
                require __DIR__ . '/../Views/trajets/add.php';
            } catch (\PDOException $e) {
                echo "<h1>Erreur lors de la récupération des agences</h1>";
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            }
    }

    /** 
     * Traite l'ajout d'un nouveau trajet
     * Processes the addition of a new trip
     * @return void
     */
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        if (
            !isset(
                $_POST['id_agence_depart'], 
                $_POST['id_agence_arrivee'],  
                $_POST['gdh_depart'], 
                $_POST['gdh_arrivee'], 
                $_POST['places_totales']
                )
            ) {
                echo "<p>Tous les champs sont obligatoires.</p>";
                echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
                return;        
            }

            $id_conducteur = (int)$_SESSION['user_id'];
            $id_agence_depart = (int)$_POST['id_agence_depart'];
            $id_agence_arrivee = (int)$_POST['id_agence_arrivee'];
            $gdh_depart = $_POST['gdh_depart'];
            $gdh_arrivee = $_POST['gdh_arrivee'];
            $places_totales = (int)$_POST['places_totales'];
            
            //Vérification des agences
            if ($id_agence_depart === $id_agence_arrivee) {
                echo "<p>Erreur : Les agences de départ et d'arrivée doivent être différentes.</p>";
                echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
                return;
            }

            //Vérification des dates
            $timestamp_depart = strtotime($gdh_depart);
            $timestamp_arrivee = strtotime($gdh_arrivee);

            if ($timestamp_arrivee === false || $timestamp_arrivee === $timestamp_depart) {                
                echo "<p>Erreur : Erreur : les dates saisies ne sont pas valides.</p>";
                echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
                return;
            }
            
            if ($timestamp_arrivee <= $timestamp_depart) {                
                echo "<p>Erreur : L'heure et la date d'arrivée doivent être strictements supérieures à celles du départ.</p>";
                echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
                return;
            }

            //Vérification nombre de places
            if ($places_totales < 1 || $places_totales > 5) {
                echo "<p>Erreur : Le nombre de places doit être compris entre 1 et 5.</p>";
                echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
                return;
            }

            //Création du trajet
            try {
                $success = Trajet::create(
                    $id_conducteur,
                    $id_agence_depart,
                    $id_agence_arrivee,
                    $gdh_depart,
                    $gdh_arrivee,
                    $places_totales
                );

                if ($success) {
                    echo "<p>Le trajet a été créé avec succès.</p>";
                    echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                } else {
                    echo "<p>Erreur : Impossible de créer le trajet.</p>";
                    echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
                }

            // Gestion des exceptions PDO
            } catch (\PDOException $e) {
                echo "<h1>Erreur lors de la création du trajet :</h1>";
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
                echo "<p><a href='/trajets/add'>Retour au formulaire</a></p>";
            }

}

    /**Affiche le formulaire de modification d'un trajet
     * Displays the form to edit a trip
     * @param int $id ID du trajet à modifier
     */
    public function edit($id)
    {
        //Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        try {
            $trajet = \Models\Trajet::getById((int)$id);

            //Vérifie si le trajet existe
            if (!$trajet) {
                echo "<p>Trajet introuvable.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            // Vérifie si l'utilisateur connecté est le conducteur du trajet
                if ((int) $trajet['id_conducteur'] !== (int) $_SESSION['user_id']) {                
                echo "<p>Accès refusé. Vous n'êtes pas autorisé à modifier ce trajet.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            $agences = \Models\Agence::getAll();

            require __DIR__ . '/../Views/trajets/edit.php';

        } catch (\PDOException $e) {
            echo "<h1>Erreur lors de la récupération du trajet :</h1>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
        }
    }

    /** Traite la modification d'un trajet
     * Processes the modification of a trip
     * @param int $id ID du trajet à modifier
     */
    public function update($id)
    {
        //Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        //Vérifie que tous les champs sont remplis
        if (
            !isset(
                $_POST['id_agence_depart'], 
                $_POST['id_agence_arrivee'],  
                $_POST['gdh_depart'], 
                $_POST['gdh_arrivee'], 
                $_POST['places_totales']
            )
        ) {
            echo "<p>Tous les champs sont obligatoires.</p>";
            echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
            return;        
        }
        
        $id = (int) $id;
        $id_agence_depart = (int) $_POST['id_agence_depart'];
        $id_agence_arrivee = (int) $_POST['id_agence_arrivee'];
        $gdh_depart = $_POST['gdh_depart'];
        $gdh_arrivee = $_POST['gdh_arrivee'];
        $places_totales = (int) $_POST['places_totales'];

        try {
            //Récupère le trajet à modifier
            $trajet = \Models\Trajet::getById($id);

            // Vérifie si le trajet existe
            if (!$trajet) {
                echo "<p>Trajet introuvable.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            //Vérifie si l'utilisateur connecté est le conducteur du trajet
            if ((int) $trajet['id_conducteur'] !== (int) $_SESSION['user_id']) {
                echo "<p>Accès refusé. Vous n'êtes pas autorisé à modifier ce trajet.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            //Vérifie que les agences de départ et d'arrivée sont différentes
            if ($id_agence_depart === $id_agence_arrivee) {
                echo "<p>Erreur : Les agences de départ et d'arrivée doivent être différentes.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            //Vérifie que la date et l'heure d'arrivée sont supérieures à celles de départ
            $timestamp_depart = strtotime($gdh_depart);
            $timestamp_arrivee = strtotime($gdh_arrivee);
            if ($timestamp_arrivee <= $timestamp_depart) {
                echo "<p>Erreur : L'heure et la date d'arrivée doivent être strictement supérieures à celles du départ.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            // Vérification du nombre de places
            if ($places_totales < 1 || $places_totales > 5) {
                echo "<p>Erreur : Le nombre de places doit être compris entre 1 et 5.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            // Mise à jour du trajet
            $success = \Models\Trajet::update(
                $id,
                $id_agence_depart,
                $id_agence_arrivee,
                $gdh_depart,
                $gdh_arrivee,
                $places_totales
            );

            if ($success) {
                echo "<p>Le trajet a été modifié avec succès.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
            } else {
                echo "<p>Erreur : Impossible de modifier le trajet.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
            }
        } catch (\PDOException $e) {
            echo "<h1>Erreur lors de la modification du trajet :</h1>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
        }
    }

    /**
     * Supprime un trajet
     * Deletes a trip
     */
    public function delete($id)
    {
        // l'utilisateur doit être connecté
        if (!isset($_SESSION['user_id'])) {
            die("Accès refusé. Vous devez être connecté.");
        }

        $id = (int) $id;

        try {
            //Récupère le trajet à supprimer
            $trajet = \Models\Trajet::getById($id);

            //Vérifie que le trajet existe
            if (!$trajet) {
                echo "<p>Trajet introuvable.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            //Vérifie que l'utilisateur connecté est le conducteur du trajet
            if ((int) $trajet['id_conducteur'] !== (int) $_SESSION['user_id']) {
                echo "<p>Accès refusé. Vous n'êtes pas autorisé à supprimer ce trajet.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
                return;
            }

            //Supprimer le trajet
            if (\Models\Trajet::delete($id)) {
                echo "<p>Le trajet a été supprimé avec succès.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
            } else {
                echo "<p>Impossible de supprimer ce trajet.</p>";
                echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
            }
        } catch (\PDOException $e) {
            echo "<h1>Erreur lors de la suppression du trajet :</h1>";
            echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p><a href='/mon-espace'>Retour à votre espace</a></p>";
        }
    }
}