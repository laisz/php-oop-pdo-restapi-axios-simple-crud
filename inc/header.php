<?php if(!isset($_SESSION)) { session_start(); } ?>
<?php include('config/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title id ="title">CRUD - Home Page</title>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/font-awesome.min.css">
			<!-- BootStrap Material Design 4 -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/boot_material_design_4/bootstrap-material-design.min.css">
			<!-- CSS For DataTables With BootStrap-4 -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/bootstrap4_datatables.min.css">
			<!-- Custom CSS -->
		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/crud.css">

		<style>
			li.nav-item > a.nav-link:first-child {
				text-transform: capitalize;
			}

			div.name_validity,
			div.roll_validity,
			div.address_validity {
				color: deeppink;
			}
			
		</style>
	</head>
	<body>
		<header class="header">
			<div class="container-fluid">
				<nav class="navbar navbar-expand-lg navbar-info bg-info">
					<a href="<?php echo BASE_URL; ?>" class="navbar-brand text-white">PHP RestAPI CRUD</a>
					<button type="button" class="navbar-toggler text-white" data-toggle="collapse" data-target="#collapseMe">
						<span class="navbar-toggler-icon">
							<i class="fa fa-navicon"></i>
						</span>
					</button>
					<div class="collapse navbar-collapse" id="collapseMe">
						<ul class="navbar-nav ml-auto">
							<li class="nav-item"><a class="nav-link text-white" href="<?php echo BASE_URL; ?>">Home</a></li>
						</ul>
					</div>
				</nav>
			</div> <!-- /.container -->
		</header> <!-- /.header -->
		<?php include("lib/DB.php"); ?>
		<?php $db = new DB();  ?>
		<?php $table = " tbl_pdo_crud_ajax";  ?>
		<?php $table_blank = "tbl_blank";  ?>
		