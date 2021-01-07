<?php 
	require_once('../../../geral.php');

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

		if ($timestamp_now > $timestamp_hc || $result_if_users_settings['expire'] == NULL || $result_if_users_settings['expire'] == '' || $result_if_users_settings['expire'] == '0') {
			$update_hc_timestamp = $db->prepare("UPDATE players_subscriptions SET expire = ? WHERE user_id = ?");
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
		<meta name="description" content="No <?= HOTELNAME; ?>, você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!">
		<meta name="keywords" content="habbo, habbo pirata, habbo atlanta, atlanta, habbon, habblet, habbinc, habbig, habbink, habbolove, habblove, hybbe, <?= HOTELNAME; ?>, habbolella, lella hotel, lella, iron, iron hotel, habbig hotel, crazzy, crazzy habbo, habbok, habbook hotel, habbinfo, habblive, live, hotel, habbonados, raduckets, catálogo atualizado, habbo futebol, mobis, mobilias, snow war, futebol, bola rebug, bola habbo, bola 100%, bola 8q, bola 6q, bola 4q, wireds, mascotes, habbocity, habbo.com, habbo.,habbo online, habbo lotado, habbo bom, habbo atualizado, habbo antigo, habbo r63, habbo dino, habbo dinossauro, habbo original, habbo oficial, retro server, habb, rabbo, hotel, Age, Like Hotel, Habbo Privado, Pirata, Privado, Habbo.com.br, habble, habblo, fresh-hotel, crazzy, habbo hotel, virtual, mundo, comunidade virtual, grátis, comunidade, avatar, bate papo, online, jovem, rpg, entre, social, grupos, fóruns, seguro, jogue, jogos, online, amigos, jovens, raros, mobis raros, colecionar, expressão, emblemas, diversão, música, celebridade, visita de famosos, celebridades, mmo, mmorpg, rpg online">
		<link rel="shortcut icon" href="<?= URL; ?>/favicon.ico?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/types.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/buttons.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/client.css?<?= TIME; ?>">
		<!-- carregamento -->
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/loading.css?<?= TIME; ?>">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
		<!-- carregamento -->

		<script src="<?= CDN; ?>/assets/js/jquery.js?<?= TIME; ?>"></script>
		<script src="<?= CDN; ?>/assets/js/jquery-ui.js?<?= TIME; ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.1.2/howler.min.js"></script>
		<script src="<?= CDN; ?>/assets/js/swfobject.js?<?= TIME; ?>"></script>
		<script src="<?= CDN; ?>/assets/js/ip.js"></script>
	<?php 
		if ($consult_client_version->rowCount() > 0) { 
			if ($result_client_version['version'] != '0') {
	?>
		<script type="text/javascript">
			var clientvars = {
				"client.allow.cross.domain": "1",
				"client.notify.cross.domain": "0",
				"connection.info.host": "127.0.0.1",
				"connection.info.port": "30000",
				"site.url": "<?= URL; ?>",
				"url.prefix": "<?= URL; ?>",
				"client.reload.url": "<?= URL; ?>/me",
				"client.fatal.error.url": "<?= URL; ?>/me",
				"client.connection.failed.url": "<?= URL; ?>/me",
				"external.texts.txt": "<?= $Hotel::Settings('external_flash_texts'); ?>?v=1",
				"external.variables.txt": "<?= $Hotel::Settings('external_variables'); ?>?v=8",
				"external.override.variables.txt": "<?= $Hotel::Settings('external_override_variables'); ?>?v=1",
				"productdata.load.url": "<?= $Hotel::Settings('productdata'); ?>?v=1",
				"furnidata.load.url": "<?= $Hotel::Settings('furnidata'); ?>?v=1",
				"flash.dynamic.avatar.download.configuration": "<?= $Hotel::Settings('figuremap'); ?>?v=1",
				"external.figurepartlist.txt": "<?= $Hotel::Settings('figuredata'); ?>?v=1",
				"external.override.texts.txt": "<?= $Hotel::Settings('external_flash_override_texts'); ?>?v=1",
				"flash.client.origin": "popup",
				"processlog.enabled": "1",
				"has.identity": "1",
				//"avatareditor.promohabbos":"",
				"client.starting" : "Aguarde, está carregando...",
				"client.starting.revolving": "Quando você menos esperar... terminaremos de carregar.../Carregando mensagem divertida! Por favor espere./Você quer batatas fritas para acompanhar?/Siga o pato amarelo./O tempo é apenas uma ilusão./Já chegamos?!/Eu gosto da sua camiseta./Olhe para um lado. Olhe para o outro. Pisque duas vezes. Pronto!/Não é você, sou eu./Shhh! Estou tentando pensar aqui./Carregando o universo de pixels.",
				"external.override.variables.txt": "<?= $Hotel::Settings('external_override_variables'); ?>",
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
				volume: 0.5,
				url: ''
			};

			swfobject.embedSWF('<?= $Hotel::Settings('flash_client_url'); ?>/Habbo60.swf', 'flash-container', '100%', '100%', '11.1.0', 'expressInstall.swf', clientvars, params, null, null);
		</script>
		<script src="<?= CDN; ?>/assets/js/habboapi.js"></script>
		<!-- <script src="<?= CDN; ?>/assets/js/radio.js?v=1"></script> -->
	<?php 
			} 
		}
	?>
		<script src="<?= CDN; ?>/assets/js/client.js"></script>
		<!--<script src="<?= CDN; ?>/assets/js/socket.js"></script>-->

	</head>
	<body>
		<!-- carregamento -->
<script>
	var _0x227b=["\x46\x6C\x61\x73\x68\x45\x78\x74\x65\x72\x6E\x61\x6C\x6E\x74\x65\x72\x66\x61\x63\x65","\x75\x6E\x64\x65\x66\x69\x6E\x65\x64","\x46\x6C\x61\x73\x68\x45\x78\x74\x65\x72\x6E\x61\x6C\x49\x6E\x74\x65\x72\x66\x61\x63\x65","\x6C\x6F\x67\x4C\x6F\x67\x69\x6E\x53\x74\x65\x70","\x63\x6C\x69\x65\x6E\x74\x2E\x69\x6E\x69\x74\x2E\x63\x6F\x72\x65\x2E\x69\x6E\x69\x74","\x32\x35\x25","\x74\x65\x78\x74","\x23\x6C\x6F\x61\x64\x2D\x63\x6C\x69\x65\x6E\x74","\x77\x69\x64\x74\x68","\x63\x73\x73","\x2E\x70\x72\x6F\x67\x72\x65\x73\x73\x20\x3E\x20\x2E\x70\x72\x6F\x67\x72\x65\x73\x73\x2D\x62\x61\x72","\x43\x61\x72\x72\x65\x67\x61\x64\x6F\x20\x65\x6D\x20\x32\x35\x25","\x6C\x6F\x67","\x63\x6C\x69\x65\x6E\x74\x2E\x69\x6E\x69\x74\x2E\x61\x75\x74\x68\x2E\x6F\x6B","\x35\x30\x25","\x43\x61\x72\x72\x65\x67\x61\x64\x6F\x20\x65\x6D\x20\x35\x30\x25","\x63\x6C\x69\x65\x6E\x74\x2E\x69\x6E\x69\x74\x2E\x6C\x6F\x63\x61\x6C\x69\x7A\x61\x74\x69\x6F\x6E\x2E\x6C\x6F\x61\x64\x65\x64","\x37\x35\x25","\x43\x61\x72\x72\x65\x67\x61\x64\x6F\x20\x65\x6D\x20\x37\x35\x25","\x63\x6C\x69\x65\x6E\x74\x2E\x69\x6E\x69\x74\x2E\x63\x6F\x6E\x66\x69\x67\x2E\x6C\x6F\x61\x64\x65\x64","\x31\x30\x30\x25","\x43\x61\x72\x72\x65\x67\x61\x64\x6F\x20\x65\x6D\x20\x31\x30\x30\x25","\x72\x65\x6D\x6F\x76\x65","\x23\x6C\x6F\x61\x64\x69\x6E\x67"];if( typeof window[_0x227b[0]]=== _0x227b[1]){window[_0x227b[2]]= {}};window[_0x227b[2]][_0x227b[3]]= function(_0xb956x1){if(_0xb956x1== _0x227b[4]){$(_0x227b[7])[_0x227b[6]](_0x227b[5]);$(_0x227b[10])[_0x227b[9]](_0x227b[8],_0x227b[5]);console[_0x227b[12]](_0x227b[11])};if(_0xb956x1== _0x227b[13]){$(_0x227b[7])[_0x227b[6]](_0x227b[14]);$(_0x227b[10])[_0x227b[9]](_0x227b[8],_0x227b[14]);console[_0x227b[12]](_0x227b[15])};if(_0xb956x1== _0x227b[16]){$(_0x227b[7])[_0x227b[6]](_0x227b[17]);$(_0x227b[10])[_0x227b[9]](_0x227b[8],_0x227b[17]);console[_0x227b[12]](_0x227b[18])};if(_0xb956x1=== _0x227b[19]){setTimeout(function(){$(_0x227b[7])[_0x227b[6]](_0x227b[20]);$(_0x227b[10])[_0x227b[9]](_0x227b[8],_0x227b[20]);console[_0x227b[12]](_0x227b[21])},3000);setTimeout(function(){$(_0x227b[23])[_0x227b[22]]()},6000)}}
</script>
<div id="loading" style="top:-52px;height:140vh;display: block;z-index:9999;background: url(https://cdn.ohabbo.org/assets/img/background.png) #252525;">
            <div class="resize">
                <br><img alt="Equipe Crazzy" src="https://i.imgur.com/2rgR8hA.png" style="height:184px;width:374px;animation-iteration-count: infinite;animation-duration: 2s;-webkit-animation-duration: 2s;" class="banner animate__pulse">
                <section class="carregando" style="color:#aaa;margin-top:13px;display: block;">
					<span class="label" style="margin-top:13px;line-height: 0px;">Aguarde, estamos carregando...</span>
                    <div class="progress">
                        <div class="progress-bar"></div>
                    </div>
					<p id="load-client">5%</p>                                       
                </section>
            </div>
        </div>
        <!-- carregamento -->
	<?php 
		if ($consult_client_version->rowCount() > 0) { 
			if ($result_client_version['version'] != '0') {
	?>
		<div class="client-ui flex">
			<button class="client-expand flex margin-right-minm" tooltip="Colocar a client em modo tela cheia.">
				<icon name="expand" class="margin-auto"></icon>
			</button>
			<button class="client-unfreeze flex margin-right-minm" tooltip="Descongelar a client.">
				<icon name="flake" class="margin-auto"></icon>
			</button>
			<button class="client-refresh flex" tooltip="Recarregar a client." onclick="window.location.reload();">
				<icon name="reload" class="margin-auto"></icon>
			</button>
		</div>
		<div class="webview-client">
			<div class="client-disconnected">
				<div class="center-container flex-column">
					<label class="white bold flex margin-bottom-md margin-auto-left-right uppercase">
						<h1>Você foi desconectad<?php if ($user['gender'] === 'F') { ?>a<?php } else { ?>o<?php } ?>!</h1>
					</label>
					<button class="green-button-1 margin-auto-left-right margin-auto-left-right" onclick="window.location.reload();" style="width: 150px;height: 45px;">
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
			

			
			
		</div>
		<div id="flash-container" style="z-index: 99999 !important;">
			<div class="flash-disabled-container flex" style="background: url(../img/background.png) rgb(53, 53, 53);">
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
		<div class="client-version-container flex" style="z-index: 99999 !important;">
			<div class="client-version-content flex margin-auto">
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
			</div>
		</div>
	<?php
			}
		} else { 
	?>
		<div class="client-version-container flex" style="z-index: 99999 !important;">
			<div class="client-version-content flex margin-auto">
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
			</div>
		</div>
	<?php } ?>
	<div id="content" class="client-content">
		<script src="https://www.habblet.in/assets/js/jquery.timer.js" type="text/javascript"></script>
		<script type="text/javascript">
		            $(document).ready(function() {
		                showAd1();
		                showAd2();
		                adTimer.play();
		            });

		            var Interval = 900000; // 20 minutes;
		            var I = 60;
		            var timer = $.timer(function() {
		                I = 60;

		                showAd1();
		                showAd2();
		                adTimer.play();
		            });
		            timer.set({
		                time: Interval,
		                autostart: true
		            });

		            var adClosing = $.timer(function() {
		                closeAd1();
		                closeAd2();
		                adClosing.stop();
		            });

		            adClosing.set({
		                time: 60000,
		                autostart: false
		            });

		            var adTimer = $.timer(function() {
		                I--;
		                $("#adTimer").html("As propagandas fecharão em <b>" + I + "</b> segundos!");
		                if (I <= 0)
		                    adTimer.stop();
		            });

		            adTimer.set({
		                time: 1000,
		                autostart: false
		            });

		            function showAd1() {
		                $("#ad1").fadeIn("slow");
		                adClosing.play();
		                timer.stop();
		            }

		            function closeAd1() {
		                $("#ad1").fadeOut("slow");
		                timer.play();
		            }

		            function showAd2() {
		                $("#ad2").fadeIn("slow");
		                adClosing.play();
		                timer.stop();
		            }

		            function closeAd2() {
		                $("#ad2").fadeOut("slow");
		                timer.play();
		            }
		        </script>
				<style>
				.publicity-client {
					background: url(https://i.imgur.com/G7oBhzb.png) center no-repeat;
   					height: 90px;
   					background-size: 100%;
				}
				</style>
		<div id="ad1" class="roomenterad-habblet-container" style="z-index:9999999999999;display: block; left: 50%; margin-left: -370px; margin-top: -30px; position: fixed; height: 195px; width: 740px; background-image: url(&quot;https://www.habblet.in/assets/images/hotel/banner.png&quot;); background-repeat: no-repeat; z-index: 99999;">
			<div id="adTimer" style="position: absolute; left: 6px; top: 76px; color: rgb(255, 255, 255); font-size: 10px; font-family: Verdana, sans-serif; visibility: visible;float:left;" class="roomenterad-closing1">As propagandas fecharão em <b>14</b> segundos!</div>
			<div style="position: absolute; right: 9px; top: 72px;"><img onclick="closeAd1();" src="https://i.imgur.com/VuLhUw2.png"></div>

			
			<div style="position: absolute;left: 6px;padding-right: 12px;top: 91px;width: 100%;padding-bottom: 10px;" class="roomenterad-habblet-thead">
				<a href="//megafilmeshd50.top/" target="_blank">
					<div class="publicity-client">

					</div>
				</a>
			</div>
		</div>
		
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/radio/css/reset.css?v=000728">
<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/radio/css/style.css?v=000728">
<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/radio/css/tipped.css?v=000728">

<script>
	function atualiza_dados(id, caminho) {
		if (id == null && caminho == null) {
			$("#locutorver").html("...");
			$("#programaver").html("...");
			$("#unicosver").html("...");

			$("#locutorver").fadeOut(500);
			$("#programaver").fadeOut(500);
			$("#unicosver").fadeOut(500);
		} else {
			$("#" + id).html("...");
			$("#" + id).fadeOut(500);
		}

		let data = null;

		//let dataAtual = new Date();
		//console.log('fazendo requisição...', dataAtual.getHours() + ":" + dataAtual.getMinutes() + ":" + dataAtual.getSeconds())

		$.ajax({
			type: 'GET',
			dataType: 'json',
			url: '/radio/new_status.php',
			success: function(response) {
				data = response
			},
			complete: function() {
              	let locutor = data != null && (data.servertitle != '' && data.servertitle != 'AlienWare') ? data.servertitle : 'RadioCrazzY';
                let programa = data != null && data.songtitle != '' ? data.songtitle : 'As melhores';
                let ouvintes = data != null && data.currentlisteners != '' ? data.currentlisteners + ' ouvintes' : 'Vários ouvintes';
              
				if (id == null && caminho == null) {
					$("#locutorver").html(locutor);
					$("#programaver").html(programa);
					$("#unicosver").html(ouvintes);

					$("#locutorver").fadeIn(500);
					$("#programaver").fadeIn(500);
					$("#unicosver").fadeIn(500);
				} else {
					if (caminho === 'locutor') {
						$("#" + id).html(locutor);
					} else if (caminho === 'programa') {
						$("#" + id).html(programa);
					} else if (caminho === 'unicos') {
						$("#" + id).html(ouvintes);
					}

					$("#" + id).fadeIn(500);
				}
			}
		})
	}
</script>
<body onload="auto()">
<div style="display: none">
<script>
	function auto(){
		document.getElementById('player2').volume = 0.3;
	}
    function UpdateInfo() {
        atualiza_dados(null,null);
    }
	function UpdateAudio() {
        UpdateInfo();
		var update = document.getElementById('player2');
		player2.src= 'https://ssl.painelcast.com:6776/sc_uvade.php/;';
		player2.load();
		player2.play();
	}
</script>
<audio id="player2" controls autoplay src="https://ssl.painelcast.com:6776/sc_uvade.php/;"></audio>

<script>
	var stream = document.getElementById("player2");

	function getVolume() {
		alert(stream.volume);
	}
	function SetVolumeLower() {
		stream.volume -= 0.05;
	}
	function SetVolumeHigher() {
		stream.volume += 0.05;
	}

	UpdateAudio();

	setInterval(
		function() {
			if (stream.duration <= 0 || stream.paused) {
				UpdateAudio();
			}
		}, 10000);
	setInterval(
			function() {
				UpdateInfo()
			}, 600000);
</script>
</div>
<div id="area_player">
<div id="player" class="draggable ui-widget-content" style="left: 150px; top: 0px;">
<div class="player_min">
<a href="/profile/Nouk" target="_blank">
<div class="guy tip" title='Desenvolvedor: Emerson'></div>
</a>
<div class="txt">Rádio</div>
<div class="open o-c tip" title="Maximizar"></div>
</div>
<div class="player">
<div class="plus tip" title="Aumentar Volume" style="cursor:pointer" onclick="SetVolumeHigher()"></div>
<div class="min tip" title="Diminuir Volume" style="cursor:pointer" onclick="SetVolumeLower()"></div>
<a id="playerButton" data-enable="1">
<div class="play pause tip" title="Iniciar/Parar Rádio" style="cursor:pointer"></div>
</a>
<a href="/pedidos" onclick="window.open(this.href,'targetWindow',
										'toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=780, height=250');
										return false;">
<div class="orders tip" title="Fazer Pedido" style="cursor:pointer"></div>
</a>
<a onclick="UpdateAudio()">
<div class="update tip" title="Atualizar Rádio" style="cursor:pointer"></div>
</a>
<div class="separa"></div>
<div class="info locutor tip" title="Locutor">
<a href="#" onclick="atualiza_dados('locutorver','locutor')"><span id="locutorver"></span></a>
</div>
<div class="info room tip" title="Programação">
<a href="#" onclick="atualiza_dados('programaver','programa')"><span id="programaver"></span></a>
</div>
<div class="info listeners tip" title="Ouvintes">
<a href="#" onclick="atualiza_dados('unicosver','unicos')"><span id="unicosver"></span></a>
</div>
<div class="close o-c tip" title="Minimizar"></div>
</div>
</div>
</div>
<script src="<?= CDN; ?>/assets/player/js/jquery-1.12.4.js?v=280700"></script>
<script src="<?= CDN; ?>/assets/player/js/jquery-ui.js?v=280700"></script>
<script src="<?= CDN; ?>/assets/radio/js/tipped.js?v=280700"></script>
<script src="<?= CDN; ?>/assets/radio/js/player1.js?v=280700"></script>
<script type="text/javascript">
		$(document).ready(function ()
		{
			$(document).on("click", "#playerButton", function ()
			{
				if ($("#playerButton").attr('data-enable') == 0)
				{
					document.getElementById('player2').muted = false;
					$("#playerButton").attr('data-enable', '1');
				}
				else
				{
					document.getElementById('player2').muted = true;
					$("#playerButton").attr('data-enable', '0');
				}
			});
		});
	</script>
		
				</div>
				
	</body>
</html>