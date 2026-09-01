<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h1>Tableau de bord administrateur</h1>

<p>Bienvenue, <?= htmlspecialchars($_SESSION['user_prenom']) ?> <?= htmlspecialchars($_SESSION['user_nom']) ?> !</p>

<h2>Trajets</h2>

<?php if (empty($trajets)): ?>
    <p>Aucun trajet trouvé.</p>
<?php else: ?>
    <table>
        <tr>
            <th>Ville de départ</th>
            <th>Ville d'arrivée</th>
            <th>Date et heure de départ</th>
            <th>Date et heure d'arrivée</th>
            <th>Places</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($trajets as $trajet): ?>
            <tr>
                <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                <td><?= htmlspecialchars($trajet['gdh_depart']) ?></td>
                <td><?= htmlspecialchars($trajet['gdh_arrivee']) ?></td>
                <td><?= htmlspecialchars($trajet['places_disponibles']) ?> / <?= htmlspecialchars($trajet['places_totales']) ?></td>

                <td>
                    <a href="/admin/trajets/delete/<?= (int) $trajet['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h2>Agences</h2>

<?php if (empty($agences)): ?>
    <p>Aucune agence trouvée.</p>

<?php else: ?>
    <table>
        <tr>
            <th>Ville</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($agences as $agence): ?>
            <tr>
                <td><?= htmlspecialchars($agence['ville']) ?></td>
                <td>
                    <a href="/admin/agences/edit/<?= (int) $agence['id'] ?>">Modifier</a> |
                    <a href="/admin/agences/delete/<?= (int) $agence['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<h2>Utilisateurs</h2>
<?php if (empty($users)): ?>
    <p>Aucun utilisateur trouvé.</p>

<?php else: ?>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['nom']) ?></td>
                <td><?= htmlspecialchars($user['prenom']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p>
    <a href="/">Retour à l'accueil</a>
</p>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
