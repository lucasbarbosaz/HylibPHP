<?php
	require_once('../../../geral.php');
	
	$Auth::Session('connected');

	if ($Hotel::Manutention('state') == 'disabled') {
		Redirect(URL);
	}

	$Template->SetParam('page_name', 'maintenance');
	$Template->SetParam('page_name', 'Maintenance');
	$Template->SetParam('page_title', 'Manutenção - ' . HOTELNAME);
	$Template->SetParam('page_description', 'Opps, parece que está havendo algumas alterações no hotel, e pra isso precisamos de apenas o pessoa da equipe dentro do hotel.');
	$Template->SetParam('page_image', URL . '/image.png');
?>
<html style="background: linear-gradient(rgb(81 52 152),rgb(92 80 125));">
	<head>
		<meta charset="utf-8">
		<title>Manutenção - <?= HOTELNAME; ?></title>
		<meta name="description" content="">
		<link rel="shortcut icon" href="<?= URL; ?>/favicon.ico?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/maintenance.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/types.css?<?= TIME; ?>">
		<link rel="stylesheet" type="text/css" href="<?= CDN; ?>/assets/css/buttons.css?<?= TIME; ?>">
		<script src="<?= CDN; ?>/assets/player/js/jquery-1.12.4.js"></script>
		<script src="<?= CDN; ?>/assets/player/js/jquery-ui.js"></script>
		<script src="<?= CDN; ?>/assets/radio/js/tipped.js"></script>
		<script src="<?= CDN; ?>/assets/radio/js/player1.js"></script>
		<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:regular,bold|Ubuntu+Condensed:regular">
	</head>
	<style>
#radio-container, #discord-container {
    position: relative;
    background: rgb(160 160 160);
    width: 480px;
    height: 66px;
    color: white !important;
    border-radius: 5px;
    padding: 10px;
}
#logo {
    position: relative;
    background: url(https://cdn.discordapp.com/attachments/737706808441045004/738903950698479666/logo2.png) no-repeat;
    background-size: 104%;
    background-position-y: -19px;
    background-position-x: -4px;
    top: -15px;
    width: 237px;
    height: 64px;
}
	</style>
	
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
<script src="<?= CDN; ?>/assets/player/js/jquery-1.12.4.js"></script>
<script src="<?= CDN; ?>/assets/player/js/jquery-ui.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/tipped.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/player1.js"></script>
	<body class="flex grid-template-rows" style="background: linear-gradient(rgb(81 52 152),rgb(92 80 125));" onload="auto()">
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
		player2.src='https://streamssl.hospedandosites.com.br/sc_uvade.php/;';
		player2.load();
		player2.play();
	}
</script>
<script src="<?= CDN; ?>/assets/player/js/jquery-1.12.4.js"></script>
<script src="<?= CDN; ?>/assets/player/js/jquery-ui.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/tipped.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/player1.js"></script>
<audio controls autoplay id="player2" src="https://streamssl.hospedandosites.com.br/sc_uvade.php/;"></audio>
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
	
		<div class="flex-column overflow-hidden" id="content">
			<div class="row-1 flex">
				<div class="margin-auto-left margin-auto-top-bottom flex-column">
					<div class="flex margin-bottom-max">
						<div class="margin-auto-left-right z-index" id="logo"></div>
						<div id="spin-ray" style="left: 19px;"></div>
					</div>

					<label class="margin-auto-left-right flex-column">
						<h2 class="white bold">Estamos em manutenção<br> Saiba mais em nosso discord!</h2>
						<h5 class="white margin-top-md margin-auto-left-right data" data="login-staff">Login administrativo</h5>
					</label>
				</div>
			</div>
			<div id="features-manutention">
				<div class="flex" id="features-manutention-header">
					<div class="flex" id="features-manutention-header-icon">
						<icon name="hotel-big" class="margin-auto"></icon>
					</div>
					<label class="white margin-top-minm">
						<h2 class="bold">Novidades em geral:</h2>
						<h5>Confira abaixo algumas novidade que estão rolando no novo <?= HOTELNAME; ?>!</h5>
					</label>
				</div>
				<div class="margin-top-min flex" id="features-manutention-list">
					<div id="features-manutention-list-box">
						<div class="margin-right-min" id="features-manutention-list-box-header">
							<div id="features-manutention-list-box-header-icon">
								<icon icon=""></icon>
							</div>
						</div>
						<label class="gray margin-auto-top-bottom">
							<h3 class="bold">Uma nova cara!</h3>
							<h5>Nossa CMS vai estar de cara nova</h5>
						</label>
	                </div>
	                <label class="gray-clear margin-auto">
						<h5 class="bold">Nenhuma nota de atualização foi postada ainda!</h5>
					</label>
				</div>
			</div>
			<div class="row-3 margin-top-min flex-wrap">
			
			
			
<script src="<?= CDN; ?>/assets/player/js/jquery-1.12.4.js"></script>
<script src="<?= CDN; ?>/assets/player/js/jquery-ui.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/tipped.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/player1.js"></script>
			
				<div class="flex" id="radio-container">
					<div id="radio-container-locutor">
						<img src="<?= AVATARIMAGE; ?>figure=hr-828-39.hd-180-2.lg-281-64.sh-295-62.ch-235-62&headonly=0&size=n&gesture=sml&direction=2&head_direction=2&action=std">
					</div>
					<div class="flex" id="radio-container-locutor-info">
						<label class="text-nowrap margin-auto-top-bottom">
							<h5 class="text-nowrap bold"><a onclick="atualiza_dados('locutorver','locutor')"><font color="#FFFFFF"><span id="locutorver"></span></font></a></h5>
							<h5 class="text-nowrap"><a onclick="atualiza_dados('programaver','programa')"><font color="#FFFFFF"><span id="programaver"></span></font></a></h5>
						</label>
					</div>
					<div class="flex-wrap margin-auto-top-bottom margin-auto-left" id="radio-container-interactions">
						<a onclick="UpdateAudio()"><button class="reset-button" title="Parar/Ouvir" id="pause"></button></a>
						<a onclick="SetVolumeHigher()"><button class="reset-button" title="Aumentar" id="aumentar"></button>
						<a onclick="SetVolumeLower()"><button class="reset-button" title="Diminuir" id="diminuir"></button>
						<a href="/pedidos" onclick="window.open(this.href,'targetWindow','toolbar=no, location=no, status=no, menubar=no, scrollbars=yes, resizable=no, width=780, height=250'); return false;"><button style="cursor:pointer" class="reset-button" title="Pedir Música" id="pedido"></button></a>
					</div>
				</div>
				
<script src="<?= CDN; ?>/assets/player/js/jquery-1.12.4.js"></script>
<script src="<?= CDN; ?>/assets/player/js/jquery-ui.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/tipped.js"></script>
<script src="<?= CDN; ?>/assets/radio/js/player1.js"></script>
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
				
				
				
				<div class="margin-left-min flex" id="discord-container">
					<label class="text-nowrap margin-right-min margin-auto-top-bottom margin-left-minm">
						<h3 class="bold text-nowrap">Junte-se a nós hoje!</h3>
						<h5 class="text-nowrap">Participe de promoções e fique por dentro de tudo que rola no hotel!</h5>
					</label>
					<a href="<?= $Hotel::Settings('discord'); ?>" target="_blank" alt="Convite para servidor do Discord.">
						<div class="flex" id="discord-container-box">
							<div class="margin-auto-left margin-auto-top-bottom margin-left-min" id="discord-container-box-logo"></div>
							<div class="margin-auto-left margin-auto-top-bottom margin-right-min" id="discord-container-box-server-logo" style="background-image: url(https://cdn.discordapp.com/icons/737379955545210925/994e8a7e0efb09012a5bad03425f0f68.png?size=2048);"></div>
						</div>
					</a>
				</div>
			</div>
			<label class="margin-auto-left-right margin-top-md flex-column white">
				<h5>© <?= HOTELNAME; ?> - Todos os direitos reservados aos seus respectivos donos!</h5>
				<h6 class="margin-auto-left-right margin-top-minm">Não autorizamos cópia parcial deste site!</h6>
			</label>
		</div>
		<div class="modal-area" style="display: none;">
			<div class="modal-area-close"></div>
			<div class="modal login-staff">
				<form method="POST" role="form" class="flex-column padding-max" id="login-admin-form">
					<label class="gray margin-bottom-md">
						<h4 class="bold margin-bottom-min uppercase">Você faz parte da nossa equipe?</h4>
						<h5>Se sim, faça já o seu login administrativo pra acompanhar, em primeira mão, o que pode estar por vir nesta manutenção.</h5>
					</label>
					<div class="flex-column">
						<h5 class="margin-bottom-minm">Nome de usuário</h5>
						<input type="text" name="identification" id="admin-username">
					</div>
					<div class="flex-column margin-top-min">
						<h5 class="margin-bottom-minm">Senha</h5>
						<input type="password" name="password" id="admin-password">
					</div>
					<div class="margin-top-md">
						<button class="green-button-2" style="width: 100%;height: 45px;" id="login-admin-submit" type="submit">
							<label class="margin-auto white bold uppercase">Login</label>
						</button>
					</div>
					<div class="general-modal-warn"></div>
				</form>
			</div>
		</div>
		<script src="<?= CDN; ?>/assets/js/jquery.js?<?= TIME; ?>"></script>
		<script src="<?= CDN; ?>/assets/js/jquery.countdown.min.js?<?= TIME; ?>"></script>
		<script type="text/javascript">
			var date = '2020/03/29 19:00';

			var _0xe93a=['L21l','I2NvdW50ZG93biA+IC5ob3VycyA+IHNwYW4=','I2NvdW50ZG93biA+IC5kYXlzID4gc3Bhbg==','dGV4dA==','ZGVidWc=','cmV0dXJuIChmdW5jdGlvbigpIA==','c3RyZnRpbWU=','W2RhdGE9ImxvZ2luLXN0YWZmIl0=','cmVzcG9uc2U=','PC9kaXY+','PC9oNj4=','YWpheA==','Y2xpY2s=','bG9jYXRpb24=','Y291bnRkb3du','c3RhZmY=','e30uY29uc3RydWN0b3IoInJldHVybiB0aGlzIikoICk=','dmFs','d2Fybg==','I2NvdW50ZG93biA+IC5taW51dGVzID4gc3Bhbg==','I2NvdW50ZG93biA+IC5zZWNvbmRzID4gc3Bhbg==','CTxoNj4=','I2NvdW50ZG93bg==','Lm1vZGFsLWFyZWEgPiAubG9naW4tc3RhZmY=','UE9TVA==','aW5wdXRbbmFtZT0icGFzc3dvcmQiXQ==','PGRpdiBjbGFzcz0iZ2VuZXJhbC1lcnJvciBtYXJnaW4tdG9wLW1pbiI+','bG9n','c3VibWl0','dHJhY2U=','dGFibGU=','Lm1vZGFsLWFyZWEgPiAubW9kYWwtYXJlYS1jbG9zZQ==','ZmFkZU91dA==','Y29uc29sZQ==','cGFyZW50','cmVhZHk=','L2FwaS9sb2dpbg==','anNvbg==','aHRtbA==','ZXhjZXB0aW9u','LmdlbmVyYWwtbW9kYWwtd2Fybg==','ZXJyb3I=','aHJlZg==','bWVzc2FnZQ==','Lm1vZGFsLWFyZWE=','I2xvZ2luLWFkbWluLWZvcm0=','ZmluZA==','YXBwbHk='];(function(_0x5c857c,_0xe93a99){var _0x599b65=function(_0x2586c9){while(--_0x2586c9){_0x5c857c['push'](_0x5c857c['shift']());}};_0x599b65(++_0xe93a99);}(_0xe93a,0x1e9));var _0x599b=function(_0x5c857c,_0xe93a99){_0x5c857c=_0x5c857c-0x0;var _0x599b65=_0xe93a[_0x5c857c];if(_0x599b['agFeUa']===undefined){(function(){var _0x5e3d56;try{var _0x23a694=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');');_0x5e3d56=_0x23a694();}catch(_0x17b6f4){_0x5e3d56=window;}var _0x50cd93='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x5e3d56['atob']||(_0x5e3d56['atob']=function(_0x690746){var _0x1292fe=String(_0x690746)['replace'](/=+$/,'');var _0x1c9911='';for(var _0x20f8a4=0x0,_0x53e21f,_0x15961a,_0x10c5dd=0x0;_0x15961a=_0x1292fe['charAt'](_0x10c5dd++);~_0x15961a&&(_0x53e21f=_0x20f8a4%0x4?_0x53e21f*0x40+_0x15961a:_0x15961a,_0x20f8a4++%0x4)?_0x1c9911+=String['fromCharCode'](0xff&_0x53e21f>>(-0x2*_0x20f8a4&0x6)):0x0){_0x15961a=_0x50cd93['indexOf'](_0x15961a);}return _0x1c9911;});}());_0x599b['RScZXh']=function(_0x5840e3){var _0x3314bc=atob(_0x5840e3);var _0x10a9b8=[];for(var _0x85dac4=0x0,_0x144a88=_0x3314bc['length'];_0x85dac4<_0x144a88;_0x85dac4++){_0x10a9b8+='%'+('00'+_0x3314bc['charCodeAt'](_0x85dac4)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0x10a9b8);};_0x599b['Ewgyfl']={};_0x599b['agFeUa']=!![];}var _0x2586c9=_0x599b['Ewgyfl'][_0x5c857c];if(_0x2586c9===undefined){_0x599b65=_0x599b['RScZXh'](_0x599b65);_0x599b['Ewgyfl'][_0x5c857c]=_0x599b65;}else{_0x599b65=_0x2586c9;}return _0x599b65;};var _0x50cd93=function(){var _0x11b63d=!![];return function(_0x42910c,_0x446b85){var _0x456dbd=_0x11b63d?function(){if(_0x446b85){var _0x8fc924=_0x446b85[_0x599b('0x26')](_0x42910c,arguments);_0x446b85=null;return _0x8fc924;}}:function(){};_0x11b63d=![];return _0x456dbd;};}();var _0x5e3d56=_0x50cd93(this,function(){var _0x2f5bcd=function(){};var _0x55923c;try{var _0x469933=Function(_0x599b('0x2c')+_0x599b('0x7')+');');_0x55923c=_0x469933();}catch(_0x99e8e0){_0x55923c=window;}if(!_0x55923c[_0x599b('0x18')]){_0x55923c[_0x599b('0x18')]=function(_0x88fea9){var _0x16297e={};_0x16297e['log']=_0x88fea9;_0x16297e[_0x599b('0x9')]=_0x88fea9;_0x16297e[_0x599b('0x2b')]=_0x88fea9;_0x16297e['info']=_0x88fea9;_0x16297e[_0x599b('0x20')]=_0x88fea9;_0x16297e[_0x599b('0x1e')]=_0x88fea9;_0x16297e[_0x599b('0x15')]=_0x88fea9;_0x16297e[_0x599b('0x14')]=_0x88fea9;return _0x16297e;}(_0x2f5bcd);}else{_0x55923c['console'][_0x599b('0x12')]=_0x2f5bcd;_0x55923c[_0x599b('0x18')][_0x599b('0x9')]=_0x2f5bcd;_0x55923c[_0x599b('0x18')][_0x599b('0x2b')]=_0x2f5bcd;_0x55923c[_0x599b('0x18')]['info']=_0x2f5bcd;_0x55923c[_0x599b('0x18')][_0x599b('0x20')]=_0x2f5bcd;_0x55923c[_0x599b('0x18')][_0x599b('0x1e')]=_0x2f5bcd;_0x55923c[_0x599b('0x18')][_0x599b('0x15')]=_0x2f5bcd;_0x55923c[_0x599b('0x18')][_0x599b('0x14')]=_0x2f5bcd;}});_0x5e3d56();$(document)[_0x599b('0x1a')](function(){$(_0x599b('0xd'))[_0x599b('0x5')](date,function(_0x1d69df){$(_0x599b('0x29'))[_0x599b('0x2a')](_0x1d69df['strftime']('%D'));$(_0x599b('0x28'))[_0x599b('0x2a')](_0x1d69df[_0x599b('0x2d')]('%H'));$(_0x599b('0xa'))[_0x599b('0x2a')](_0x1d69df[_0x599b('0x2d')]('%M'));$(_0x599b('0xb'))[_0x599b('0x2a')](_0x1d69df['strftime']('%S'));});});$(document)['on'](_0x599b('0x13'),_0x599b('0x24'),function(){var _0x4b3fc1=$(this),_0x7cafb={'type':_0x599b('0x6'),'identification':$(this)['find']('input[name=\x22identification\x22]')[_0x599b('0x8')](),'password':$(this)[_0x599b('0x25')](_0x599b('0x10'))[_0x599b('0x8')]()};$[_0x599b('0x2')]({'url':_0x599b('0x1b'),'type':_0x599b('0xf'),'data':_0x7cafb,'dataType':_0x599b('0x1c'),'success':function(_0x3e48ba){if(_0x3e48ba[_0x599b('0x2f')]=='ok'){window[_0x599b('0x4')][_0x599b('0x21')]=_0x599b('0x27');}else{_0x4b3fc1[_0x599b('0x25')](_0x599b('0x1f'))[_0x599b('0x1d')](_0x599b('0x11')+'\x0a'+_0x599b('0xc')+_0x3e48ba[_0x599b('0x22')]+_0x599b('0x1')+_0x599b('0x0'));}}});return![];});$(document)['on'](_0x599b('0x3'),_0x599b('0x2e'),function(){if($(_0x599b('0xe'))){$(_0x599b('0x23'))['fadeIn'](0xfa);}});$(document)['on'](_0x599b('0x3'),_0x599b('0x16'),function(){$(this)[_0x599b('0x19')]()[_0x599b('0x17')](0xfa);});
		</script>
	</body>
</html>