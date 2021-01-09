<?php 
	require_once('../../../geral.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Disable your Adblock! - <?= HOTELNAME; ?></title>
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/style.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/types.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/buttons.css?<?= TIME; ?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap">
		<style type="text/css">
			body,
			html {
				background: #fff;
				width: 100%;
				height: 100%;
				display: flex;
			}
		</style>
	</head>
	<body class="flex">
		<div class="margin-auto error-container flex">
			<div class="margin-auto flex-column">
				<div class="adblock-container-image"></div>
				<label class="gray margin-bottom-md text-center">
					<h2 class="bold margin-bottom-minm uppercase">Adblock Enabled!</h2>
					<h5 class="margin-bottom-min">Producing and delivering quality content, resources are needed!</h5>
					<h5 class="margin-bottom-minm">And for that, we have advertisements that are an important source to keep the game online and generate income. So if you play, or like the <?= HOTELNAME; ?> <b style="color: red;">disable your blocker ads</b>.</h5>
				</label>
				<button class="green-button-1 margin-auto-left-right" style="width: 220px;height: 47px;" onclick="window.history.go(-2); return false;">
					<label class="margin-auto white">I've already deactivated my AdBlock!</label>
				</button>
			</div>
		</div>
	</body>
</html>
