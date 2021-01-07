<?php 
	require_once('../../../geral.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Desative seu AdBlock - <?= HOTELNAME; ?></title>
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
					<h2 class="bold margin-bottom-minm uppercase">Adblock ativado!</h2>
					<h5 class="margin-bottom-min">Produzir e oferecer um conteúdo de qualidade, são necessários recursos!</h5>
					<h5 class="margin-bottom-minm">E para isso, temos as propagandas que são uma fonte importante para manter o jogo online e gerar renda. Então se você joga, ou gosta do <?= HOTELNAME; ?> <b style="color: red;">desabilite seu bloqueador anuncios</b>.</h5>
				</label>
				<button class="green-button-1 margin-auto-left-right" style="width: 220px;height: 47px;" onclick="window.history.go(-2); return false;">
					<label class="margin-auto white">Já desativei meu AdBlock!</label>
				</button>
			</div>
		</div>
	</body>
</html>