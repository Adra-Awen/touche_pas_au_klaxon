<?php

namespace Controllers;

/** Controller for user management
 * Contrôleur pour la gestion des utilisateurs
 */
class UserController
{
    /**
     * Affiche la liste des trajets à venir sur la page d'accueil
     * Displays the list of upcoming trips on the homepage
     * @return void
     */
    public function index()
    {
        try {
            echo "<h2>Liste des utilisateurs</h2>";

            $users = \Models\User::getAll();

            if (empty($users)) {
                echo "<p>Aucun utilisateur trouvé.</p>";
            } else {
                echo "<ul>";
                foreach ($users as $user) {
                    echo "<li>";
                    echo "Nom : " . htmlspecialchars($user['nom']) . "<br>";
                    echo "Prénom : " . htmlspecialchars($user['prenom']) . "<br>";
                    echo "Téléphone : " . htmlspecialchars($user['telephone']) . "<br>";
                    echo "Email : " . htmlspecialchars($user['email']) . "<br>";
                    echo "Rôle : " . htmlspecialchars($user['role']) . "<br>";
                    echo "</li>";
                }
                echo "</ul>";
            }
        } catch (\PDOException $e) {
            echo "<h2>Erreur lors de la récupération des utilisateurs</h2>";
            echo "<p>" . $e->getMessage() . "</p>";
        }
    }
}