<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1>Gestion des agences</h1>

<p>
    <a href="/admin/villes/add">Ajouter une nouvelle agence</a>
</p>

<?php if (empty($agences)) : ?>
    <p>Aucune agence trouvée.</p>

<?php else : ?>
    <table>
        <thead>
            <tr>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agences as $agence) : ?>
                <tr>
                    <td><?= htmlspecialchars($agence['ville']) ?></td>
                    <td>
                        <a href="/admin/villes/edit/<?= (int) $agence['id'] ?>">Modifier</a> |
                        <a href="/admin/villes/delete/<?= (int) $agence['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ?')">Supprimer</a>
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