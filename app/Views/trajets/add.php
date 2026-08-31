<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1>Ajouter un trajet</h2>

<form method="POST" action="/trajets/create">

    <div>
        <label for="id_agence_depart">Agence de départ : </label>
        <select 
            id="id_agence_depart"
            name="id_agence_depart"
            required
        >

            <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>">
                    <?= htmlspecialchars($agence['ville']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="id_agence_depart">Agence d'arrivée : </label>
        <select 
            id="id_agence_arrivee"
            name="id_agence_arrivee"
            required
        >

            <?php foreach ($agences as $agence): ?>
                <option value="<?= htmlspecialchars($agence['id']) ?>">
                    <?= htmlspecialchars($agence['ville']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label for="gdh_depart">Date et heure de départ : </label>
        <input 
            type="datetime-local"
            id="gdh_depart"
            name="gdh_depart"
            required
        >
    </div>

    <div>
        <label for="gdh_arrivee">Date et heure d'arrivée : </label>
        <input 
            type="datetime-local"
            id="gdh_arrivee"
            name="gdh_arrivee"
            required
        >
    </div>

    <div>
        <label for="places_totales">Nombre total de places : </label>
        <input 
            type="number"
            id="places_totales"
            name="places_totales"
            min="1"
            max="5"
            required
        >
    </div>

    <button type="submit">Ajouter le trajet</button>
</form>


<?php require __DIR__ . '/../layouts/footer.php'; ?>