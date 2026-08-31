<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1>Détails du trajet</h1>

<h2>
    <?= htmlspecialchars($trajet['agence_depart']) ?> -> <?= htmlspecialchars($trajet['agence_arrivee']) ?>
</h2>

<p>
    <strong>Date et heure de départ :</strong> 
    <?= htmlspecialchars($trajet['gdh_depart']) ?> à <?= htmlspecialchars($trajet['gdh_depart']) ?>
</p>
<p>
    <strong>Date et heure d'arrivée :</strong> 
    <?= htmlspecialchars($trajet['gdh_arrivee']) ?> à <?= htmlspecialchars($trajet['gdh_arrivee']) ?>
</p>
<p>
    <strong>Nombre de places disponibles :</strong> <?= htmlspecialchars($trajet['places_disponibles']) ?>
    / 
    <?= htmlspecialchars($trajet['places_totales']) ?>
</p>

<p>
    <a href="/">Retour à l'accueil</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>