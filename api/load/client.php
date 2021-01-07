<?php 
	require_once('../../geral.php');

	$Auth::Session('disconnected');

	if (isset($_GET['room']) && is_numeric($_GET['room'])) {
		$room = $_GET['room'];

		if ($room > 0) {
			$consult_room = $db->prepare("SELECT id FROM rooms WHERE id = ? LIMIT 1");
			$consult_room->bindValue(1, $room);
			$consult_room->execute();

			if ($consult_room->rowCount() == 1) {
				$result_room = $consult_room->fetch(PDO::FETCH_ASSOC);

				if ($user['online'] == '1') {
					$have_room_loader = true;
					$have_room = true;
				} else {

				}
			} else {
				$have_room_error = true;
			}
		}
	}

	$consult_if_users_settings = $db->prepare("SELECT expire FROM player_subscriptions WHERE user_id = ?");
	$consult_if_users_settings->bindValue(1, $user['id']);
	$consult_if_users_settings->execute();

	if ($consult_if_users_settings->rowCount() > 0) {
		$result_if_users_settings = $consult_if_users_settings->fetch(PDO::FETCH_ASSOC);

		$timestamp_now = TIME;
		$timestamp_new_hc = '1893549600';
		$timestamp_hc = $result_if_users_settings['expire'];

		if ($timestamp_now > $timestamp_hc || $result_if_users_settings['expire'] == NULL || $result_if_users_settings['club_expire_timestamp'] == '' || $result_if_users_settings['club_expire_timestamp'] == '0') {
			$update_hc_timestamp = $db->prepare("UPDATE player_subscriptions SET expire = ? WHERE user_id = ?");
			$update_hc_timestamp->bindValue(1, $timestamp_new_hc);
			$update_hc_timestamp->bindValue(2, $user['id']);
			$update_hc_timestamp->execute();
		}
	} else {
		$insert_users_settings = $db->prepare("INSERT INTO player_subscriptions (user_id, expire) VALUES (?,?)");
		$insert_users_settings->bindValue(1, $user['id']);
		$insert_users_settings->bindValue(2, '1893549600');
		$insert_users_settings->execute(); 
	}

	$consult_client_version = $db->prepare("SELECT version FROM cms_clients WHERE user_id = ?");
	$consult_client_version->bindValue(1, $user['id']);
	$consult_client_version->execute();

	$result_client_version = $consult_client_version->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html oncontextmenu="false">
	<head>
		<base href="<?= URL; ?>">
		<meta charset="utf-8">
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<meta http-equiv="content-language" content="pt-br">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta name="robots" content="index,follow,all">
		<meta name="googlebot" content="index,follow,all">
		<title>Client - <?= HOTELNAME; ?></title>
		<meta name="author" content="<?= HOTELNAME; ?>">
		<meta name="keywords" content="habbo, habbo pirata, habbo atlanta, atlanta, habbon, habblet, habbinc, habbig, habbink, habbolove, habblove, hybbe, <?= HOTELNAME; ?>, habbolella, lella hotel, lella, iron, iron hotel, habbig hotel, crazzy, crazzy habbo, habbok, habbook hotel, habbinfo, habblive, live, hotel, habbonados, raduckets, catálogo atualizado, habbo futebol, mobis, mobilias, snow war, futebol, bola rebug, bola habbo, bola 100%, bola 8q, bola 6q, bola 4q, wireds, mascotes, habbocity, habbo.com, habbo.,habbo online, habbo lotado, habbo bom, habbo atualizado, habbo antigo, habbo r63, habbo dino, habbo dinossauro, habbo original, habbo oficial, retro server, habb, rabbo, hotel, Age, Like Hotel, Habbo Privado, Pirata, Privado, Habbo.com.br, habble, habblo, fresh-hotel, crazzy, habbo hotel, virtual, mundo, comunidade virtual, grátis, comunidade, avatar, bate papo, online, jovem, rpg, entre, social, grupos, fóruns, seguro, jogue, jogos, online, amigos, jovens, raros, mobis raros, colecionar, expressão, emblemas, diversão, música, celebridade, visita de famosos, celebridades, mmo, mmorpg, rpg online">
		<link rel="shortcut icon" href="<?= URL; ?>/favicon.ico?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/types.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/buttons.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/client.css?<?= TIME; ?>">

		<script src="<?= CDN; ?>/assets/js/jquery.js?<?= TIME; ?>"></script>
		<script src="<?= CDN; ?>/assets/js/jquery-ui.js?<?= TIME; ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.1.2/howler.min.js?<?= TIME; ?>"></script>
		<script src="<?= CDN; ?>/assets/js/swfobject.js?<?= TIME; ?>"></script>
	<?php 
		if ($consult_client_version->rowCount() > 0) { 
			if ($result_client_version['version'] != '0') {
	?>
		<script type="text/javascript">
			var clientvars = {
				"client.allow.cross.domain": "1",
				"client.notify.cross.domain": "0",
				"connection.info.host": "<?= $Hotel::Settings('host'); ?>",
				"connection.info.port": "<?= $Hotel::Settings('port'); ?>",
				"site.url": "<?= URL; ?>",
				"url.prefix": "<?= URL; ?>",
				"client.reload.url": "<?= URL; ?>/me",
				"client.fatal.error.url": "<?= URL; ?>/me",
				"client.connection.failed.url": "<?= URL; ?>/me",
				"external.texts.txt": "<?= $Hotel::Settings('external_flash_texts'); ?>?<?= TIME; ?>",
				"external.variables.txt": "<?= $Hotel::Settings('external_variables'); ?>?<?= TIME; ?>",
				"productdata.load.url": "<?= $Hotel::Settings('productdata'); ?>?<?= TIME; ?>",
				"furnidata.load.url": "<?= $Hotel::Settings('furnidata'); ?>?<?= TIME; ?>",
				"flash.dynamic.avatar.download.configuration": "<?= $Hotel::Settings('figuremap'); ?>?<?= TIME; ?>",
				"external.figurepartlist.txt": "<?= $Hotel::Settings('figuredata'); ?>",
				"external.override.texts.txt": "<?= $Hotel::Settings('external_flash_override_texts'); ?>",
				"flash.client.origin": "popup",
				"processlog.enabled": "1",
				"has.identity": "1",
				"client.starting" : "Aguarde, está carregando...",
				"client.starting.revolving": "Quando você menos esperar... terminaremos de carregar.../Carregando mensagem divertida! Por favor espere./Você quer batatas fritas para acompanhar?/Siga o pato amarelo./O tempo é apenas uma ilusão./Já chegamos?!/Eu gosto da sua camiseta./Olhe para um lado. Olhe para o outro. Pisque duas vezes. Pronto!/Não é você, sou eu./Shhh! Estou tentando pensar aqui./Carregando o universo de pixels.",
				"external.override.variables.txt": "<?= $Hotel::Settings('external_override_variables'); ?>?<?= TIME; ?>",
				"spaweb": "1",
				"use.sso.ticket" : "1",
				"sso.ticket" : "<?= $User->UpdateSSO(USERNAME); ?>",
				"flash.client.url": "<?= $Hotel::Settings('flash_client_url'); ?>/",
<?php if (isset($_GET['room']) && is_numeric($_GET['room'])) { ?>
				"forward.type" : "2",
				"forward.id" : "<?= $room; ?>", 
<?php } else if ($Hotel::Settings('force_room') != false) { ?>
				"forward.type" : "2",
				"forward.id" : "<?= $Hotel::Settings('force_room_id'); ?>", 
<?php } else if ($Hotel::Settings('force_room') != true && $user['home_room'] != '0') { ?>
				"forward.type" : "2",
				"forward.id" : "<?= $user['home_room']; ?>",
<?php } ?>
				"user.hash": "<?= sha1(md5($user['username']) . sha1(Functions::Random('random_number', '50'))); ?>",
				"user.timestamp": "<?= date('Y-m-d H:i:s'); ?>"
			};

			var params = {
				"base": "<?= $Hotel::Settings('flash_client_url'); ?>/",
				"allowScriptAccess": "always",
				"menu": "false",
				"wmode": "opaque"
			};

			var player = {
				ip: 'sonic.dedicado.stream',
				port: '7013',
				volume: 0.5,
				url: 'https://sonic.dedicado.stream:7013/;'
			};

			swfobject.embedSWF('<?= $Hotel::Settings('flash_client_url'); ?>/haibbo_<?= $result_client_version['version']; ?>.swf', 'flash-container', '100%', '100%', '11.1.0', 'expressInstall.swf', clientvars, params, null, null);
		</script>
		<script src="<?= CDN; ?>/assets/js/habboapi.js?<?= TIME; ?>"></script>
		<script src="<?= CDN; ?>/assets/js/radio.js?<?= TIME; ?>"></script>
	<?php 
			} 
		}
	?>
		<script src="<?= CDN; ?>/assets/js/client.js?<?= TIME; ?>"></script>
	</head>
	<body>
	<?php 
		if ($consult_client_version->rowCount() > 0) { 
			if ($result_client_version['version'] != '0') {
	?>
		<div class="client-ui">
			<button class="client-back flex margin-right-minm" tooltip="Voltar a navegação do site.">
				<label class="margin-auto flex white padding-right-min padding-left-minm pointer-none">
					<icon name="hotel-mini-1" class="margin-right-minm"></icon>
					<h5>Voltar</h5>
				</label>
			</button>
			<button class="client-expand flex margin-right-minm" tooltip="Colocar a client em modo tela cheia.">
				<icon name="expand" class="margin-auto"></icon>
			</button>
			<button class="client-unfreeze flex margin-right-minm" tooltip="Descongelar a client.">
				<icon name="flake" class="margin-auto"></icon>
			</button>
			<button class="client-refresh flex" tooltip="Recarregar a client.">
				<icon name="reload" class="margin-auto"></icon>
			</button>
		</div>
		<div class="webview-client">
			<div class="client-disconnected">
				<div class="center-container flex-column">
					<label class="white bold flex margin-bottom-md margin-auto-left-right uppercase">
						<h1>Você foi desconectad<?php if ($user['gender'] === 'F') { ?>a<?php } else { ?>o<?php } ?>!</h1>
					</label>
					<button class="green-button-1 margin-auto-left-right client-refresh margin-auto-left-right" onclick="window.location.reload();" style="width: 150px;height: 45px;">
						<label class="margin-auto white">
							<h5 class="fs-14">Recarregar</h5>
						</label>
					</button>
				</div>
			</div>
			<div class="client-notification flex-column">
				<button class="client-notification-closeall bold fs-14 uppercase">Fechar tudo</button>
				<div class="client-notification-area"></div>
			</div>
			<div class="haibbo-player-area">
				<div class="haibbo-player maximized loadding" style="top: 0px">
					<div class="player-min haibbo-player-large-control"></div>
					<div class="haibbo-player-large flex-column">
						<div class="haibbo-player-large-area flex">
							<div class="haibbo-player-speaker">
								<div class="haibbo-player-speaker-imager" style="background-image: unset;"></div>
							</div>
							<div class="haibbo-player-infos">
								<div class="haibbo-player-infos-speaker">
									<span>...</span>
								</div>
								<div class="haibbo-player-infos-programation">
									<span>...</span>
								</div>
								<div class="haibbo-player-infos-listeners">
									<span>... ouvintes</span>
								</div>
							</div>
							<div class="haibbo-player-large-control"></div>
						</div>
						<div class="player-large-actions flex">
							<div class="player-large-actions-volume">
								<div class="player-large-actions-volume-bar"></div>
							</div>
							<div class="player-large-actions-playpause paused"></div>
							<div class="player-large-actions-reconnect"></div>
							<div class="player-large-actions-dragplayer"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="flash-container">
			<div class="flash-disabled-container flex">
				<div class="flash-disabled-content flex margin-auto">
					<div class="frank margin-right-md"></div>
					<div class="margin-auto-top-bottom flex-column">
						<label class="gray flex-column">
							<h1 class="bold uppercase margin-bottom-minm">Você está quase lá!</h1>
							<h5 class="margin-bottom-min">Agora so falta você permitir que o seu navegador possa executar o flash player para poder jogar.</h5>
							<h5 class="margin-bottom-min">E muito fácil! Basta você clicar no botão <b>Entrar no Hotel</b> e logo em seguida clicar em <b>Permitir</b> para poder executar o flash e você se juntar e desfrutar de toda a diversão que preparamos para você!</h5>
							<div class="bg-2 padding-min general-radius">
								<label class="flex-column">
									<h5 class="margin-bottom-min uppercase">Não consegue ativar o <b>flash</b>?</h5>
									<h6>Está tendo problemas com a ativação do flash? Client branca ou preta? Não se preocupe, para tudo há uma solução!<br><br>E para isto você pode clicar <a class="bold">aqui</a> para, talvez, encontrar um possível solução e saber mais sobre tal problema.</h6>
								</label>
							</div>
						</label>
						<div class="flex margin-top-min margin-auto-left">
							<a href="https://get.adobe.com/flashplayer/" class="green-button-1 no-link" style="width: 180px;height: 48px;">
								<label class="margin-auto white">
									<h5>Entrar no Hotel</h5>
								</label>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } else { ?>
		<div class="client-version-container flex">
			<div class="client-version-content flex margin-auto">
				<form method="POST">
				<div class="frank margin-right-md"></div>
				<div class="margin-auto-top-bottom flex-column">
					<label class="gray flex-column">
						<h1 class="bold uppercase">Escolha sua versão!</h1>
						<h5 class="margin-bottom-min">Agora você pode escolher a versão da client de acordo com o seu gosto!</h5>
						<h5>Você pode escolher a <b>client melhorada</b> caso queira animações mais rápidas e fluídas, ou escolher a <b>client normal</b> onde continua sendo a client padrão de sempre.</h5>
						<h5 class="margin-top-md">Você alterar a versão sempre que quiser nas configurações da sua client!</h5>
						<h5 class="bold margin-top-min uppercase">Escolha abaixo a versão desejada:</h5>
					</label>
					<div class="set-client-version flex margin-top-min">
						<button class="green-button-1 margin-right-min" version="60" style="width: 100%;height: 48px;">
							<label class="margin-auto white">
								<h5>Client melhorada</h5>
							</label>
						</button>
						<button class="green-button-1" version="24" style="width: 100%;height: 48px;">
							<label class="margin-auto white">
								<h5>Client normal</h5>
							</label>
						</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	<?php
			}
		} else { 
	?>
		<div class="client-version-container flex">
			<div class="client-version-content flex margin-auto">
				<form method="POST" action="">
				<div class="frank margin-right-md"></div>
				<div class="margin-auto-top-bottom flex-column">
					<label class="gray flex-column">
						<h1 class="bold uppercase">Escolha sua versão!</h1>
						<h5 class="margin-bottom-min">Agora você pode escolher a versão da client de acordo com o seu gosto!</h5>
						<h5>Você pode escolher a <b>client melhorada</b> caso queira animações mais rápidas e fluídas, ou escolher a <b>client normal</b> onde continua sendo a client padrão de sempre.</h5>
						<h5 class="margin-top-md">Você alterar a versão sempre que quiser nas configurações da sua client!</h5>
						<h5 class="bold margin-top-min uppercase">Escolha abaixo a versão desejada:</h5>
					</label>
					<div class="set-client-version flex margin-top-min">
						<button class="green-button-1 margin-right-min" version="60" style="width: 100%;height: 48px;">
							<label class="margin-auto white">
								<h5>Client melhorada</h5>
							</label>
						</button>
						<button class="green-button-1" version="24" style="width: 100%;height: 48px;">
							<label class="margin-auto white">
								<h5>Client normal</h5>
							</label>
						</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	<?php } ?>
	</body>
</html>