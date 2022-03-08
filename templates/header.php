<?php if (session_status() !== PHP_SESSION_ACTIVE) {session_start();} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title><?php if (isset($title)) : ?><?= $title ?><?php else : ?>Annonce Immobiliere<?php endif; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./templates/style/css/style.css" />

</head>

<body>
    <header>

        <!-- Nav bar -->
        <?php if (isset($navbar)) {
            if ($navbar === "navbar") {
                # Generale navbar
                require_once 'navbar.php';
            } elseif ($navbar === "navbar_user") {
                # Profil navbar
                require_once 'navbar_user.php';
            }
        } ?>

        <!-- Message -->
        <!-- <div class="container p-5"> -->
            <div class="row text-center">
                <div class="col-6 mx-auto">
                    <?php if (isset($_SESSION['message'])) : ?>
                        <?php foreach ($_SESSION['message'] as $message) : ?>
                            <div id="message" class="alert alert-info" role="alert"><?= $message ?></div>
                        <?php endforeach; ?>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>
                </div>
            </div>
        <!-- </div> -->

    </header>

    <main>
        <!-- Start container -->
        <div class="container">