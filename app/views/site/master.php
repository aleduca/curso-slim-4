<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"/>
		<link rel="stylesheet" href="./assets/site/styles.css">
		<title><?=$this->e($title ?? 'My title')?></title>
	</head>
	<body>
		<div class="container">

			<?php $this->insert('site/partials/header') ?>
			<?=$this->section('content');?>
			<?php $this->insert('site/partials/footer') ?>
		</div>
	</body>
</html>