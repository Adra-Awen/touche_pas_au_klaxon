<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1> Bienvenue sur votre espace personnel, 
    <?= htmlspecialchars($_SESSION['user_prenom']) ?>
    <?= htmlspecialchars($_SESSION['user_nom']) ?>
</h1>
<p>Vous pouvez consulter vos trajets proposés.</p>

<h2>Mes trajets partagés</h2>

<?php if (empty($mesTrajets)) : ?>
    <p>Aucun trajet partagé pour le moment.</p>
<?php else : ?>
    <?php foreach ($mesTrajets as $trajet) : ?>
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
            <a href="/trajets/edit/<?= htmlspecialchars($trajet['id']) ?>">Modifier</a>
            <a href="/trajets/delete/<?= htmlspecialchars($trajet['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">Supprimer</a>
        </article>
    <?php endforeach; ?>
<?php endif; ?>

<p><a href="/trajets/add">Ajouter un nouveau trajet</a></p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>