<?php

# Autoload
require_once './src/autoload.php';

# Manager Advert
$advertManager = new AdvertManager();

// Récupération de toutes les annonces
$lastAdvert = $advertManager->getLastAdverts();

// Ttile
$title = "Accueil";	
// Navbar
$navbar = "navbar";
// Header
require_once './templates/header.php';
?>
<h1>Nos 15 dernières annonces</h1>

<table class="table table-striped mt-5">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Code postal</th>
            <th>ville</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Date de création</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($lastAdvert as $advert) : ?>
            <tr>
                <td><?= mb_strtoupper($advert['title']); ?></td>
                <td><?= ucfirst(substr($advert['description'], 0, 10) . "..."); ?></td>
                <td><?= $advert['postcode']; ?></td>
                <td><?= $advert['city']; ?></td>
                <td><?= $advert['category']; ?></td>
                <td><?= $advert['price']; ?> €</td>
                <td><?= $advert['created_at']; ?></td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>
</div>

<?php require_once './templates/footer.php' ?>