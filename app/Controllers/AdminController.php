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
                    echo "<a href='/admin/villes/edit/" . urlencode($agence['id']) . "'>Modifier</a>";
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

    /** Affiche la liste des utilisateurs
     * Displays the list of users
     */
    public function usersIndex()
    {
        try {
            $users = \Models\User::getAll();
            echo "<h2>Liste des utilisateurs</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Email</th><th>Role</th><th>Actions</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($user['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($user['telephone']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                echo "<td><a href='/admin/users/edit/" . $user['id'] . "'>Modifier</a> | <a href='/admin/users/delete/" . $user['id'] . "'>Supprimer</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<p><a href='/admin/users/add'>Ajouter un nouvel utilisateur</a></p>";
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération des utilisateurs : " . htmlspecialchars($e->getMessage());
        }
    }

    /**
     * Affiche le formulaire d'ajout d'un utilisateur
     * Displays the form to add a new user
     */
    public function usersAdd()
    {
        echo "<h2>Ajouter un nouvel utilisateur</h2>
            <form method='POST' action='/admin/users/create'>
                <label for='nom'>Nom :</label>
                <input type='text' id='nom' name='nom' required>
                <br><br>
                <label for='prenom'>Prénom :</label>
                <input type='text' id='prenom' name='prenom' required>
                <br><br>
                <label for='telephone'>Téléphone :</label>
                <input type='text' id='telephone' name='telephone'>
                <br><br>
                <label for='email'>Email :</label>
                <input type='email' id='email' name='email' required>
                <br><br>
                <label for='mdp'>Mot de passe :</label>
                <input type='password' id='mdp' name='mdp' required>
                <br><br>
                <label for='role'>Rôle :</label>
                <select id='role' name='role'>
                    <option value='user'>Utilisateur</option>
                    <option value='admin'>Administrateur</option>
                </select>
                <br><br>
                <button type='submit'>Ajouter l'utilisateur</button>
            </form>";
        echo "<p><a href='/admin/users'>Retour à la liste des utilisateurs</a></p>";
    }

    /**
     * Traite le formulaire d'ajout d'un utilisateur
     * Processes the form to add a new user
     */
    public function usersCreate()
    {
        if (
            isset($_POST['nom']) && !empty(trim($_POST['nom'])) &&
            isset($_POST['prenom']) && !empty(trim($_POST['prenom'])) &&
            isset($_POST['email']) && !empty(trim($_POST['email'])) &&
            isset($_POST['mdp']) && !empty($_POST['mdp'])
        ) {
            $nom = trim($_POST['nom']);
            $prenom = trim($_POST['prenom']);
            $telephone = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
            $email = trim($_POST['email']);
            $mdp = $_POST['mdp'];
            $role = isset($_POST['role']) ? $_POST['role'] : 'user';

            try {
                if (\Models\User::create($nom, $prenom, $telephone, $email, $mdp, $role)) {
                    echo "<p style='color: green;'>Utilisateur créé avec succès !</p>";
                    echo "<p><a href='/admin/users'>Retour à la liste des utilisateurs</a></p>";
                } else {
                    echo "<p style='color: red;'>Erreur lors de la création de l'utilisateur.</p>";
                }
            } catch (\PDOException $e) {
                echo "Erreur BDD : " . htmlspecialchars($e->getMessage());
            }
        } else {
            echo "<p style='color: red;'>Le nom, le prénom, l'email et le mot de passe sont obligatoires.</p>";
            echo "<p><a href='/admin/users/add'>Réessayer</a></p>";
        }
    }

    /**
     * Traite le formulaire de modification d'un utilisateur
     * Processes the form to edit a user
     */
public function usersUpdate()
    {
        if (isset($_POST['id']) && isset($_POST['email']) && !empty(trim($_POST['email']))) {
            $id = (int)$_POST['id'];
            
            $data = [
                'nom'       => isset($_POST['nom']) ? trim($_POST['nom']) : '',
                'prenom'    => isset($_POST['prenom']) ? trim($_POST['prenom']) : '',
                'telephone' => isset($_POST['telephone']) ? trim($_POST['telephone']) : '',
                'email'     => trim($_POST['email']),
                'role'      => isset($_POST['role']) ? $_POST['role'] : 'user'
            ];

            try {
                if (\Models\User::update($id, $data)) {
                    echo "<p>Utilisateur mis à jour avec succès !</p>";
                    echo "<p><a href='/admin/users'>Retour à la liste des utilisateurs</a></p>";
                } else {
                    echo "<p>Erreur lors de la mise à jour.</p>";
                }
            } catch (\PDOException $e) {
                echo "Erreur lors de la mise à jour : " . htmlspecialchars($e->getMessage());
            }
        } else {
            echo "<p>L'identifiant et l'adresse email sont obligatoires pour effectuer la modification.</p>";
        }
    }

    /**
     * Affiche le formulaire de modification d'un utilisateur
     * Displays the form to edit a user
     */
    public function usersEdit($id)
    {
        try {
            $user = \Models\User::findById((int)$id);
            if (!$user) {
                echo "<p>Utilisateur introuvable.</p>";
                return;
            }
            echo "<h2>Modifier l'utilisateur</h2>
                <form method='POST' action='/admin/users/update'>
                    <input type='hidden' name='id' value='" . $user['id'] . "'>
                    <label for='nom'>Nom :</label>
                    <input type='text' id='nom' name='nom' value='" . htmlspecialchars($user['nom']) . "' >
                    <br><br>
                    <label for='prenom'>Prénom :</label>
                    <input type='text' id='prenom' name='prenom' value='" . htmlspecialchars($user['prenom']) . "' >
                    <br><br>
                    <label for='telephone'>Téléphone :</label>
                    <input type='text' id='telephone' name='telephone' value='" . htmlspecialchars($user['telephone']) . "' >
                    <br><br>
                    <label for='email'>Email :</label>
                    <input type='email' id='email' name='email' value='" . htmlspecialchars($user['email']) . "' >
                    <br><br>
                    <label for='role'>Rôle :</label>
                    <select id='role' name='role'>
                        <option value='user'" . ($user['role'] === 'user' ? ' selected' : '') . ">Utilisateur</option>
                        <option value='admin'" . ($user['role'] === 'admin' ? ' selected' : '') . ">Administrateur</option>
                    </select>
                    <br><br>
                    <button type='submit'>Enregistrer les modifications</button>
                </form>";
        } catch (\PDOException $e) {
            echo "Erreur lors de la récupération de l'utilisateur : " . htmlspecialchars($e->getMessage());
            return;
        }
    } 

    /**
     * Supprime un utilisateur et redirige vers la liste
     * Deletes a user and redirects to the list
     */
    public function usersDelete($id)
    {
        try {
            $idUser = (int)$id;
            \Models\User::delete($idUser);

            echo "<p>Utilisateur supprimé avec succès.</p>";
            echo "<p><a href='/admin/users'>Retour à la liste des utilisateurs</a></p>";
        } catch (\PDOException $e) {
            echo "Erreur lors de la suppression de l'utilisateur : " . htmlspecialchars($e->getMessage());
        }
    }
}