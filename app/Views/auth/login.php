<?php require __DIR__ . '/../layouts/header.php'; ?>

<h1> Connexion </h1>

<form method="POST" action="/login">
    <div>
        <label for="email">Email : </label>
        <input
            type="email"
            id="email"
            name="email"
            required
        >
    <div>
        <label for="mdp">Mot de passe : </label>
        <input
            type="password"
            id="mdp"
            name="mdp"
            required
        >
    </div>
    <button type="submit">Se connecter</button>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>