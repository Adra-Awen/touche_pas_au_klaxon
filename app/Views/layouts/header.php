<?php
$isConnected = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Touche pas au klaxon</title>
</head>
<body>
    <header>
        <nav>
            <a href="/">Touche pas au klaxon</a>
            <?php if ($isConnected): ?>
                <?php if ($isAdmin): ?>
                    <!-- Menu admin -->
                    <a href="/admin">Tableau de bord</a>
                    <a href="/admin/villes">Agences</a>
                    <a href="/admin/trajets">Trajets</a>
                <?php else: ?>
                    <!-- Menu utilisateur -->
                    <a href="/mon-espace">Mon espace</a>
                    <a href="/trajets/add">Proposer un trajet</a>
                <?php endif; ?>
                <span>
                    <?= htmlspecialchars($_SESSION['user_prenom']) ?>
                    <?= htmlspecialchars($_SESSION['user_nom']) ?>
                </span>
                <a href="/logout">Déconnexion</a>
            <?php else: ?>
                <a href="/login">Connexion</a>
            <?php endif; ?>
        </nav>
        </header>
<main>