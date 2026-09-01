<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1>Gestion des trajets</h1>

<?php if (empty($trajets)) : ?>
    <p>Aucun trajet trouvé.</p>

    <?php else : ?>
    <table>
        <thead>
            <tr>
                <th>Ville de départ</th>
                <th>Ville d'arrivée</th>
                <th>Date et heure de départ</th>
                <th>Date et heure d'arrivée</th>
                <th>Places</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trajets as $trajet) : ?>
                <tr>
                    <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                    <td><?= htmlspecialchars($trajet['gdh_depart']) ?></td>
                    <td><?= htmlspecialchars($trajet['gdh_arrivee']) ?></td>
                    <td><?=htmlspecialchars($trajet['conducteur_nom'])?>
                        <<?= htmlspecialchars($trajet['conducteur_prenom']) ?></td>
                    <td><?= htmlspecialchars($trajet['places_disponibles']) ?> / <?= htmlspecialchars($trajet['places_totales']) ?></td>
                    <td>
                        <a href="/admin/trajets/delete/<?= (int) $trajet['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p>
    <a href="/admin">Retour au tableau de bord</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>