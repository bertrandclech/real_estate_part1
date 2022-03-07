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
                    <td><?php if ( $advert['reservation_message'] == NULL ) : ?>
                        <form action="" method="post">
                            <input type="hidden" class="form-control" name="id" value="<?php echo $_GET['id']; ?>">
                            <div class="form-group">
                                <label>Message de réservation: </label>
                                <textarea name="reservation_message" rows="10" class="form-control" placeholder="<?php echo $advert['reservation_message'] ?>"></textarea>
                            </div>
                            <a href="index.php" class="btn btn-outline-secondary">Annuler</a>
                            <input type="submit" class="btn btn-primary" name="submit" value="Réserver">
                        </form>
                        <?php else :?>
                            réservé
                        <?php endif ?>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php

// Si le bouton "Valider" est cliqué, on commence l'insertion en BDD
if (isset($_POST['submit'])) {

//    var_dump($_POST);



    // Vérifie que le champ est bien rempli
    if ( isset($_POST['reservation_message']) && !empty($_POST['reservation_message']) ) 	{	
            // On réserve
            $advertManager->book($_GET['id'], htmlspecialchars($_POST['reservation_message']));
    }
    else {
        echo '<div class="alert alert-danger" role="alert">Le champ réservation est vide !</div>';
    }   
}

?>

        
</div>
</div>

<?php require_once './templates/footer.php' ?>