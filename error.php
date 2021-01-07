<!DOCTYPE html!>
<html lang="pt-Br">
	<head>
		<meta charset="utf-8">
		<title>Nada encontrado - Hybbe Hotel</title>
		<link rel="shortcut icon" href="https://haibbo.in/favicon.ico?<?php echo time(); ?>">
		<link rel="stylesheet" href="https://haibbo.in/general/assets/css/error.css?<?php echo time(); ?>" type="text/css" media="all"/>
		<link rel="stylesheet" href="https://haibbo.in/general/assets/css/types.css?<?php echo time(); ?>" type="text/css"/>
		<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
	</head>
	<body>
		<div id="error-container">
			<div id="error-image" class="drop-shadow"></div>
			<div id="error-label">
				<div id="error-label-title">Nada encontrado!</div>
				<div id="error-label-description">Parece que a página que você estava procurando não foi encontrada!<br>Verifique o endereço para ver se tudo está correto ou na duvida contade a um membro da equipe!</div>
				<button class="reset-button" id="error-button-back" onclick="voltar()">Voltar</button>
			</div>
		</div>
	</body>
	
	<script type="text/javascript">
		function voltar() {
			window.history.go(-1);
		}
	</script>
</html>