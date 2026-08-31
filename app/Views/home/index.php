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

            <button 
                type="button" 
                onclick="ouvrirModal('<?= $trajet['id'] ?>')">
                    Voir les détails
            </button>

            <?php if (
                isset($_SESSION['user_id']) 
                && $_SESSION['user_id'] === $trajet['id_conducteur']) : ?>
                <a href="/trajets/edit/<?= $trajet['id'] ?>">Modifier le trajet</a>
                <a href="/trajets/delete/<?= $trajet['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">Supprimer le trajet</a>
            <?php endif; ?>
            
        </article>

        <div id="modal-<?= $trajet['id'] ?>" class="modal">
            <div class="modal-content">

                <button
                        type="button"
                        class="modal-fermer"
                        onclick="fermerModal(<?= (int) $trajet['id'] ?>)"
                    >
                        ×
                </button>

                <h2>Détails du trajet</h2>

                <h3><?= htmlspecialchars($trajet['agence_depart']) ?> 
                    > 
                    <?= htmlspecialchars($trajet['agence_arrivee']) ?>
                </h3>

                <p>
                    <strong>Conducteur :</strong>
                    <?= htmlspecialchars($trajet['conducteur_nom']) ?> 
                    <?= htmlspecialchars($trajet['conducteur_prenom']) ?>
                </p>
                <p>
                    <strong>Téléphone :</strong> 
                    <?= htmlspecialchars($trajet['conducteur_telephone']) ?>
                </p>
                <p>
                    <strong>Email :</strong> 
                    <?= htmlspecialchars($trajet['conducteur_email']) ?>
                </p>
                <p>
                    <strong>Date et heure de départ :</strong> <?= htmlspecialchars($trajet['gdh_depart']) ?>
                </p>
                <p>
                    <strong>Date et heure d'arrivée :</strong> <?= htmlspecialchars($trajet['gdh_arrivee']) ?>
                </p>
                <p>
                    <strong>Places totales :</strong> <?= htmlspecialchars($trajet['places_totales']) ?>
                </p>
                <p>
                    <strong>Places disponibles :</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?> 
                </p>
                <button 
                    type="button" 
                    onclick="fermerModal(<?= (int) $trajet['id'] ?>)">
                        Fermer
                </button>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>

<!-- Script pour gérer l'ouverture et la fermeture des modales -->
<script>
    function ouvrirModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    function fermerModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        const modals = document.getElementsByClassName('modal');
        for (let i = 0; i < modals.length; i++) {
            if (event.target === modals[i]) {
                modals[i].style.display = 'none';
            }
        }
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>