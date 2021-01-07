<?php 
	require_once('../../../geral.php');

	$keywords = "habbo, habbo pirata, habbo atlanta, atlanta, habbon, habblet, habbinc, habbig, habbink, habbolove, habblove, hybbe, Haibbo Hotel, habbolella, lella hotel, lella, iron, iron hotel, habbig hotel, crazzy, crazzy habbo, habbok, habbook hotel, habbinfo, habblive, live, hotel, habbonados, raduckets, catálogo atualizado, habbo futebol, mobis, mobilias, snow war, futebol, bola rebug, bola habbo, bola 100%, bola 8q, bola 6q, bola 4q, wireds, mascotes, habbocity, habbo.com, habbo.,habbo online, habbo lotado, habbo bom, habbo atualizado, habbo antigo, habbo r63, habbo dino, habbo dinossauro, habbo original, habbo oficial, retro server, habb, rabbo, hotel, Age, Like Hotel, Habbo Privado, Pirata, Privado, Habbo.com.br, habble, habblo, fresh-hotel, crazzy, habbo hotel, virtual, mundo, comunidade virtual, grátis, comunidade, avatar, bate papo, online, jovem, rpg, entre, social, grupos, fóruns, seguro, jogue, jogos, online, amigos, jovens, raros, mobis raros, colecionar, expressão, emblemas, diversão, música, celebridade, visita de famosos, celebridades, mmo, mmorpg, rpg online";
	global $db;
?>
<!DOCTYPE html>
<html style="overflow: hidden;">
	<head>
		<base href="<?= URL; ?>">
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<meta http-equiv="content-language" content="pt-br">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="robots" content="index,follow,all">
		<meta name="googlebot" content="index,follow,all">
		<title><?= $page_title; ?></title>
		<meta name="author" content="<?= HOTELNAME; ?>">
		<meta name="description" content="<?= $page_description; ?>">
		<meta name="keywords" content="<?= $keywords; ?>">
		<meta name="category" content="Wesbite">
		<meta name="classification" content="Online Games">
		<meta name="country" content="Brazil">
		<meta name="language" content="Portuguese">
		<meta name="reply-to" content="haibbobrpt@gmail.com">
		<meta property="og:title" content="<?= $page_title; ?>">
		<meta property="og:description" content="<?= $page_description; ?>">
		<meta property="og:site_name" content="<?= HOTELNAME; ?>">
		<meta property="og:image" content="<?= $page_image; ?>">
		<meta property="og:locale" content="pt_BR">
		<meta property="og:url" content="<?= URL_ATUAL; ?>">
		<meta property="og:type" content="wesbite">
		<meta name="twitter:title" content="<?= $page_title; ?>">
		<meta name="twitter:description" content="<?= $page_description; ?>">
		<meta name="twitter:site" content="@HaibboBRPT">
		<meta name="twitter:card" content="summary">
		<meta name="twitter:image:src" content="<?= URL; ?>/image.png">
		<meta name="twitter:domain" content="<?= URL_ATUAL; ?>">
		
		<link rel="shortcut icon" href="<?= URL; ?>/favicon.ico?<?= time(); ?>">
		<link rel="manifest" href="<?= URL; ?>/manifest.json?<?= time(); ?>">
		<link rel="stylesheet" href="<?= CDN; ?>/assets/css/style.css?<?= time(); ?>" type="text/css">
		<link rel="stylesheet" href="<?= CDN; ?>/assets/css/types.css?<?= time(); ?>" type="text/css">
		<link rel="stylesheet" href="<?= CDN; ?>/assets/css/buttons.css?<?= time(); ?>" type="text/css">
		<link rel="stylesheet" href="<?= CDN; ?>/assets/css/animations.css?<?= time(); ?>" type="text/css">
		<link rel="stylesheet" href="<?= CDN; ?>/assets/css/tooltip.css?<?= time(); ?>" type="text/css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap">
		<link rel="stylesheet" href="<?= CDN; ?>/cookie/css/cookie.css?2">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css?" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

		<script data-ad-client="ca-pub-7525151609698432" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	</head>


	</head>
	<body class="root">
		<div class="errors-top"></div>
		
		<div class="loader">
			<div class="flex-column margin-auto">
				<icon name="logo-hybbe-mini" class="margin-bottom-max"></icon>
				<div class="loader-spin margin-auto-left-right"></div>
			</div>
		</div>

		<div class="container">
			<div class="content flex-column">
<?php if (isset($_SESSION['username'])) { ?>
		<div class="header__1 flex">
			<div class="webcenter">
				<a href="<?= URL; ?>/me" place="Principal: <?= USERNAME . ' - ' . HOTELNAME; ?>" class="margin-auto-top-bottom flex">
					<icon name="logo-hybbe-big" class="float-logo overflow-hidden"></icon>
				</a>
				<div class="flex margin-auto-top-bottom margin-auto-left">
					<div class="header__users-online">
						<label class="white margin-auto">
							<h5><?= Functions::Onlines(); ?></h5>
						</label>
					</div>
					<a href="<?= URL; ?>/client" class="green-button-2 no-link" style="width: 170px;height: 42px;">
						<label class="margin-auto white">
							<h5>Entrar no Hotel</h5>
						</label>
					</a>
				</div>
			</div>
			<div class="scenery__farm_default pointer-none">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
<?php } else { ?>
		<div class="header__1 flex">
			<a href="<?= URL; ?>" place="<?= HOTELNAME; ?> - Crie sua conta, faça amigos e divirta-se gratuitamente." class="margin-auto flex">
				<icon name="logo-hybbe-big" class="float-logo overflow-hidden"></icon>
			</a>
			<div class="scenery__farm_default pointer-none">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
<?php } ?>