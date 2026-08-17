<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1> Bienvenue sur Touche pas au klaxon !</h1>
<p>Cette application vous permet de partager vos trajets et de trouver des trajets proposés par d'autres utilisateurs.</p>

<h2>Trajets à venir</h2>
<?php if (empty($trajets)) : ?>
    <p>Aucun trajet à venir pour le moment.</p>
<?php else : ?>
    <?php foreach ($trajets as $trajet) : ?>
        <article>
            <h3>
                <?= htmlspecialchars($trajet['agence_depart']) ?> 
                > 
                <?= htmlspecialchars($trajet['agence_arrivee']) ?>
            </h3>
            <p>Départ : <?= htmlspecialchars($trajet['gdh_depart']) ?></p>
            <p>Arrivée : <?= htmlspecialchars($trajet['gdh_arrivee']) ?></p>
            <p>Places disponibles : <?= htmlspecialchars($trajet['places_disponibles']) ?> 
            / 
            <?= htmlspecialchars($trajet['places_totales']) ?></p>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>