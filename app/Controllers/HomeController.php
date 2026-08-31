<?php

namespace Controllers;

use Models\Trajet;

/** Controller for the home page
 * Contrôleur pour la page d'accueil
 */
class HomeController
{
    public function index()
    {
        $trajets = Trajet::getAllUpcoming();
        require __DIR__ . '/../Views/home/index.php';
    }
}