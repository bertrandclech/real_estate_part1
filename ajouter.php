<?php

require_once './src/autoload.php';			# Autoload

// Manager Advert
$adManager = new AdvertManager();

// Form Builder
$formBuilder = new FormBuilder($_POST, ['title', 'description', 'postcode', 'city', 'category_id', 'price']);

// Form Validator
$formValidator = new FormValidator(
	$formBuilder,
	[
		'title' => FormConstraints::length(@$formBuilder->method['title'], 2, 30),
		'description' => FormConstraints::string(@$formBuilder->method['description']),
		'postcode' => FormConstraints::postalCode(@$formBuilder->method['postcode']),
		'city' => FormConstraints::string(@$formBuilder->method['city']),
		'category_id' => FormConstraints::int(@$formBuilder->method['category']),
		'price' => FormConstraints::int(@$formBuilder->method['price']),
	]
);

if ($formValidator->isSubmit()) {
	if ($formValidator->isValide()) {

		// If Form is valide insert datas in entity
		$advertEntity = new AdvertEntity(
			[
				'title' => htmlspecialchars($formBuilder->method['title']),
				'description' => htmlspecialchars($formBuilder->method['description']),
				'postcode' => htmlspecialchars($formBuilder->method['postcode']),
				'city' => htmlspecialchars($formBuilder->method['city']),
				'category_id' => htmlspecialchars($formBuilder->method['category']),
				'price' => htmlspecialchars($formBuilder->method['price'])
			]
		);
		// Add advert (INSERT INTO DB)
		$adManager->addAdvert($advertEntity);
		$_SESSION['message'] = ["Informations enregistrées."];
	} else {
		# Errors...
		$_SESSION['message'] = $formValidator->errors;
	}
}

// Ttile
$title = "Ajouter une annonce";
// Navbar
$navbar = "navbar";
// Header
require_once './templates/header.php'; ?>

<h1 class="text-center">Nouvelle annonce</h1>

<div class="container">

	<form method="post" class="mt-5" novalidate>

		<div class="form-group">
			<label>Titre</label>
			<input type="text" class="form-control" name="title">
		</div>

		<div class="form-group">
			<label>Description</label>
			<textarea class="form-control"  name="description" id="floatingTextarea"></textarea>
		</div>

		<div class="row g-5">
			<div class="col">
			<label>Code postal</label>
				<input type="text" class="form-control" name="postcode" minlength="5" maxlength="5">
			</div>
			<div class="col">
			<label>Ville</label>
				<input type="text" class="form-control" name="city">
			</div>
		</div>

		<div class="row g-5">
			<div class="col">
				<label>Type</label>
				<select name="category" class="custom-select">
					<?php foreach ($adManager->showCategoryList() as $cat) : ?>
						<option value="<?= $cat['id_category'] ?>"><?= $cat['value'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="col">
				<label>Prix</label>
				<div class="input-group">
					<input type="text" class="form-control" name="price">
					<div class="input-group-append">
						<div class="input-group-text">€</div>
					</div>
				</div>
			</div>
		</div>

		<a href="index.php" class="btn btn-outline-secondary m-3">Annuler</a>
		<input type="submit" class="btn btn-primary" name="submit" value="Valider">
	</form>
</div>

<?php require_once './templates/footer.php' ?>