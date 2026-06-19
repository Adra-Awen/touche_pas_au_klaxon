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
        echo "<h1>Liste des villes</h1>
              <p>La liste des villes s'affichera ici</p>";
    }
}