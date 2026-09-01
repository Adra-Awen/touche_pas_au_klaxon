<?php

namespace Controllers;

/**
 * Contrôleur pour la gestion de l'administration
 * Controller for managing administration
 * 
 * Gère les interactions liées à l'administration dans l'application.
 * Manages interactions related to administration in the application.
 */

class AdminController
{
    /** Vérifie si l'utilisateur est administrateur
     * Checks if the user is an administrator
     */
    private function checkAdmin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            echo "<p>Accès refusé. Vous n'avez pas les droits d'administration.</p>";
            exit;
        }
    }

    /**
     * Affiche le tableau de bord de l'administration
     * Displays the administration dashboard
     */
    public function dashboard()
    {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();

        try {
            $users = \Models\User::getAll();
            $trajets = \Models\Trajet::getAllUpcoming();
            $agences = \Models\Agence::getAll();

            require __DIR__ . '/../Views/admin/dashboard.php';
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage());
        }   
    }

    /**
     * Affiche la liste des villes + CRUD
     * Displays the list of cities + CRUD
     */
    public function villesIndex()
    {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();

        try {
            $agences = \Models\Agence::getAll();
            require __DIR__ . '/../Views/admin/villes.php';
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des villes : " . htmlspecialchars($e->getMessage());
        }
    }

    /**
     * Affiche le formulaire d'ajout d'une agence/ville
     * Displays the form to add a new agency/city
     */
    /**Affiche le formulaire d'ajout d'une agence/ville
     * Displays the form to add a new agency/city
     * URL : http://localhost/8000/admin/villes/add
     */
    public function villesAdd()
    {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();

        echo "<h1>Ajouter une nouvelle ville</h1> 
              <form method='POST' action='/admin/villes/create'>
                  <label for='ville'>Nom de la ville :</label>
                  <input type='text' id='ville' name='ville' required placeholder='Ex: Paris'>
                  <br>
                  <button type='submit'>Ajouter</button>
              </form>";
        echo "<p><a href='/admin/villes'>Retour à la liste des villes</a></p>";
    }

    /**Traite le formulaire d'ajout d'une agence/ville
    * Processes the form to add a new agency/city
     * URL : http://localhost/8000/admin/villes/add
     */
    public function villesCreate()
    {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();

        if(isset($_POST['ville']) && !empty(trim($_POST['ville']))) {
            $ville = trim($_POST['ville']);
            try {
                if (\Models\Agence::create($ville)) {
                    echo "<p>Ville ajoutée avec succès : " . htmlspecialchars($ville) . "</p>";
                } else {
                    echo "<p>Erreur lors de l'ajout de la ville.</p>";
                }
            } catch (\PDOException $e) {
                echo "Erreur lors de l'ajout de la ville : " . htmlspecialchars($e->getMessage());
            }
        } else {
            echo "<p>Le nom de la ville est requis.</p>";
        }
    }

    /** Supprime une agence/ville et redirige vers la liste
     * Deletes an agency/city and redirects to the list
     */
    public function villesDelete($id)
    {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();

        try {
            $idAgence = (int)$id;
            \Models\Agence::villesDelete($idAgence);

            echo "<p>Ville supprimée avec succès.</p>";
            echo "<p><a href='/admin/villes'>Retour à la liste des villes</a></p>";
        } catch (\PDOException $e) {
            echo "Erreur lors de la suppression de la ville : " . htmlspecialchars($e->getMessage());
        }
    }

    /** Affiche le formulaire de modification d'une agence/ville
    * Displays the form to edit an agency/city
    */
    public function villesEdit($id)
        {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();
            try {
                $agence = \Models\Agence::getById((int)$id);
                
                if (!$agence) {
                    echo "<p>Agence introuvable.</p>";
                    return;
                }

                echo "<h2>Modifier la ville</h2>
                    <form method='POST' action='/admin/villes/update/" . $agence['id'] . "'>
                        <label for='ville'>Nom de la ville :</label>
                        <input type='text' id='ville' name='ville' value='" . htmlspecialchars($agence['ville']) . "' required>
                        <br><br>
                        <button type='submit'>Enregistrer les modifications</button>
                    </form>";
                echo "<p><a href='/admin/villes'>Retour à la liste des villes</a></p>";
                
            } catch (\PDOException $e) {
                echo "Erreur lors de la récupération de la ville : " . htmlspecialchars($e->getMessage());
            }
        }

            /** Traite le formulaire de modification d'une agence/ville
         * Processes the form to edit an agency/city
         */
        public function villesUpdate()
    {
        /** Vérifie si l'utilisateur est administrateur */
        $this->checkAdmin();

        // On récupère manuellement l'ID à la fin de l'URL (ex: /admin/villes/update/9)
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        $id = (int)end($urlParts);

        if($id > 0 && isset($_POST['ville']) && !empty(trim($_POST['ville']))) {
            $ville = trim($_POST['ville']);
            try {
                if (\Models\Agence::update($id, $ville)) {
                    echo "<p>Ville mise à jour avec succès : " . htmlspecialchars($ville) . "</p>";
                    echo "<p><a href='/admin/villes'>Retour à la liste des villes</a></p>";
                } else {
                    echo "<p>Erreur lors de la mise à jour de la ville.</p>";
                }
            } catch (\PDOException $e) {
                echo "Erreur lors de la mise à jour de la ville : " . htmlspecialchars($e->getMessage());
            }
        } else {
            echo "<p>Le nom de la ville et un ID valide sont requis.</p>";
        }
    }

    /**Affiche la liste des trajets pour l'administrateur
     * Displays the list of trips for the administrator
     */
    public function trajetsIndex()
    {
        // Vérifie que l'utilisateur est administrateur
        $this->checkAdmin();

        try {
            $trajets = \Models\Trajet::getAllUpcoming();
            require __DIR__ . '/../Views/admin/trajets.php';
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des trajets : " . htmlspecialchars($e->getMessage());
        }
    }

    /** Supprime un trajet depuis l'administration
     * Deletes a trip from the administration
     */
    public function trajetsDelete($id)
    {
        // Vérifie que l'utilisateur est administrateur
        $this->checkAdmin();

        try {
            $idTrajet = (int)$id;
            $trajet = \Models\Trajet::getById($idTrajet);
            return;

            if (!$trajet) {
                echo "<p>Trajet introuvable.</p>";
                echo "<p><a href='/admin/trajets'>Retour à la liste des trajets</a></p>";
                return;
            }

            //supprime le trajet
            if (\Models\Trajet::delete($idTrajet)) {
                echo "<p>Trajet supprimé avec succès.</p>";
            } else {
                echo "<p>Impossible de supprimer le trajet.</p>";
            }

            echo "<p><a href='/admin/trajets'>Retour à la liste des trajets</a></p>";
            } catch (\PDOException $e) {
                echo "Erreur lors de la suppression du trajet : " . htmlspecialchars($e->getMessage());
            }
        }
}