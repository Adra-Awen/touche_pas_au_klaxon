<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1> Modifier un trajet</h1>

<form method="POST" 
    action="/trajets/update/<?= htmlspecialchars($trajet['id']) ?>">
    <div>
        <label for="id_agence_depart">Agence de départ : </label>
        <select 
            id="id_agence_depart"
            name="id_agence_depart"
            required
        >

            <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>"
                    <?= $agence['id'] == $trajet['id_agence_depart'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agence['ville']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
            <label for="id_agence_arrivee">Agence d'arrivée : </label>
        <select 
            id="id_agence_arrivee"
            name="id_agence_arrivee"
            required
        >

            <?php foreach ($agences as $agence): ?>
                <option value="<?= (int)$agence['id'] ?>"
                    <?= (int)$agence['id'] === (int)$trajet['id_agence_arrivee'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agence['ville']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    <div>

    <div>
        <label for="gdh_depart">Date et heure de départ : </label>
        <input 
            type="datetime-local"
            id="gdh_depart"
            name="gdh_depart"
            value="<?= htmlspecialchars($trajet['gdh_depart']) ?>"
            required
        >
    </div>

    <div>
        <label for="gdh_arrivee">Date et heure d'arrivée : </label>
        <input 
            type="datetime-local"
            id="gdh_arrivee"
            name="gdh_arrivee"
            value="<?= htmlspecialchars($trajet['gdh_arrivee']) ?>"
            required
        >
    </div>

    <div>
        <label for="places_totales">Nombre total de places : </label>
        <input 
            type="number"
            id="places_totales"
            name="places_totales"
            value="<?= htmlspecialchars($trajet['places_totales']) ?>"
            min="1"
            max="5"
            required
        >
    </div>

    <button type="submit">Modifier le trajet</button>
</form>

    <p>
        <a href="/mon-espace">Retour à mon espace</a>
    </p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>