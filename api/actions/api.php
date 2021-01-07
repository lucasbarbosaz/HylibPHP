<?php 
	require_once('../../geral.php');

	header("Content-Type: application/json; charset=UTF-8");

	$type = (isset($_GET['type'])) ? $_GET['type'] : '';

	if ($type !== null) {
		if ($type == 'status') {
			$cadastrados = $db->prepare("SELECT * FROM players");
			$cadastrados->execute();

			$online = $db->prepare("SELECT * FROM players WHERE online='1'");
			$online->execute();

			$quartos = $db->prepare("SELECT * FROM rooms WHERE users > 0");
			$quartos->execute();

			$noticias = $db->prepare("SELECT * FROM cms_news");
			$noticias->execute();

			echo json_encode([
				"cadastrados" => $cadastrados->rowCount(),
				"online" => $online->rowCount(),
				"quartos" => $quartos->rowCount(),
				"noticias" => $noticias->rowCount()
			]);
		} else if($type === 'look') {
			$look = (isset($_GET['look'])) ? $_GET['key'] : '';

			if(isset($_GET['key']) && !empty($look)) {
				$pegar_look = $db->prepare("SELECT look FROM players WHERE username = ?");
				$pegar_look->bindValue(1, $look);
				$pegar_look->execute();
				$result_look = $pegar_look->fetch(PDO::FETCH_ASSOC);

				echo json_encode([
					"ssoTicket" => $result_look['look']
				]);
			} else {
				echo "Nada encontrado";
			}
		} else if ($type === 'ssoticket') {
			$ssoticket = (isset($_GET['key'])) ? $_GET['key'] : '';

			if (isset($_GET['key']) && !empty($ssoticket)) {
				$pegar_sso = $db->prepare("SELECT auth_ticket FROM players WHERE username = ? LIMIT 1");
				$pegar_sso->bindValue(1, $ssoticket);
				$pegar_sso->execute();

				if ($pegar_sso->rowCount() > 0) {
					$result_sso = $pegar_sso->fetch(PDO::FETCH_ASSOC);

					echo json_encode([
						"response" => true,
						"auth_ticket" => $result_sso['auth_ticket']
					]);
				} else {
					echo json_encode([
						"response" => false
					]);
				}
			} else {
				echo "Nenhum usuario especificado!";
			}
		} else if ($type === 'user') {
			$username = (isset($_GET['key'])) ? $_GET['key'] : '';

			if (isset($_GET['key']) && !empty($username)) {
				$puxar_user = $db->prepare("SELECT auth_ticket FROM players WHERE username = ? LIMIT 1");
				$puxar_user->bindValue(1, $username);
				$puxar_user->execute();

					echo json_encode([
						"response" => true,
						"ssoTicket" => $resultado_user['auth_ticket'],
					]);
				} else {
					echo json_encode([
						"response" => false
					]);
				}
			} else {
				echo "Nenhum nome de usuário(a) especificado!";
			}
	} else {
		echo "Nenhum tipo foi especificado!";
	}
?>