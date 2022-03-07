<?php

require_once './src/autoload.php';

$advertManager = new AdvertManager();

// Récupération des information d'une annonce
$advert = $advertManager->getAdvertById($_GET['id']);

// Si l'annonce n'existe pas, redirection vers la liste des magazines
if (!$advert) {
    header('Location: index.php');
    exit();
}

// Title
$title = 'Annonce : ' . $advert['title'] .'';
// navbar
$navbar = "navbar";
// Header
require_once './templates/header.php';
?>

<h1><?= $advert['title'] ?></h1>

<a href="./liste.php" class="btn btn-secondary mt-2 btm-sm">Retour à la liste</a>

<div class="row mt-5">

    <div class="col-10">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Code postal</th>
                    <th>ville</th>
                    <th>Prix</th>
                    <th>Categorie</th>
                    <th>Réservation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $advert['title']; ?></td>
                    <td><?= $advert['description'];  ?></td>
                    <td><?= $advert['postcode']; ?></td>
                    <td><?= $advert['city']; ?></td>
                    <td><?= $advert['price']; ?> €</td>
                    <td><?= $advert['category']; ?></td>
                    <td><?= $advert['reservation_message']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>

<?php require_once './templates/footer.php' ?>