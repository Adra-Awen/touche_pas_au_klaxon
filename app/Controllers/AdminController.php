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
    /**
     * Affiche le tableau de bord de l'administration
     * Displays the administration dashboard
     */
    public function dashboard()
    {
        echo "<h1>Bienvenue dans le panneau d'administration</h1>
              <p>Bienvenue Admin</p>";
    }

    /**
     * Affiche la liste des villes + CRUD
     * Displays the list of cities + CRUD
     */
    public function villesIndex()
    {
        try {
            $agences = \Models\Agence::getAll();
            echo "<h1>Liste des villes</h1>";
            if (empty($agences)) {
                echo "<p>Aucune agence trouvée.</p>";
                return;
            } else {
                echo "<ul>";
                foreach ($agences as $agence) {
                    echo "<li>" . htmlspecialchars($agence['ville']) . "</li>";
                    echo "<a href='/admin/villes/delete/" . urlencode($agence['id']) . "'>Supprimer</a>";
                    echo "<a href='/admin/villes/update/" . urlencode($agence['id']) . "'>Modifier</a>";
                }
                echo "</ul>";
            }
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
            try {
                $agence = \Models\Agence::findById((int)$id);
                
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
        public function villesUpdate($id)
        {
            if(isset($_POST['ville']) && !empty(trim($_POST['ville']))) {
                $ville = trim($_POST['ville']);
                try {
                    if (\Models\Agence::update((int)$id, $ville)) {
                        echo "<p>Ville mise à jour avec succès : " . htmlspecialchars($ville) . "</p>";
                    } else {
                        echo "<p>Erreur lors de la mise à jour de la ville.</p>";
                    }
                } catch (\PDOException $e) {
                    echo "Erreur lors de la mise à jour de la ville : " . htmlspecialchars($e->getMessage());
                }
            } else {
                echo "<p>Le nom de la ville est requis.</p>";
            }
        } 
}