<?php 
	require_once('../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$action = (isset($_POST['action'])) ? $_POST['action'] : '';

		if ($action == 'register') {
			$type = (isset($_POST['type'])) ? $_POST['type'] : '';
			$value = (isset($_POST['value'])) ? $_POST['value'] : '';

			if ($type == 'username') {
				$consulta_username = $db->prepare("SELECT username FROM players WHERE username = ?");
				$consulta_username->bindValue(1, $value);
				$consulta_username->execute();

				$filtro_username = $Function::Validate('username', $value);

				if (strlen($value) == 0) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => "null",
						"message" => 'Nome de usuário inválido!'
					]);
				} else if (strlen($value) < 4 || strlen($value) > 15 || $filtro_username !== true) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => $value,
						"message" => 'Nome de usuário inválido!'
					]);
				} else if ($consulta_username->rowCount() == 1) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => $value,
						"message" => 'Esse nome já está em uso!'
					]);
				} else {
					echo json_encode([
						"status" => 'ok',
						"type" => $type,
						"value" => $value
					]);
				}
			} else if ($type == 'email') {
				$consulta_email = $db->prepare("SELECT mail FROM players WHERE mail = ?");
				$consulta_email->bindValue(1, $value);
				$consulta_email->execute();

				$filtro_email = $Function::Validate('email', $value);

				if (strlen($value) == 0) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => "null",
						"message" => ''
					]);
				} else if ($filtro_email !== false) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => $value,
						"message" => 'E-mail inválido!'
					]);
				} else if ($consulta_email->rowCount() > 0) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => $value,
						"message" => 'Esse e-mail já está em uso!'
					]);
				} else {
					echo json_encode([
						"status" => 'ok',
						"type" => $type,
						"value" => $value
					]);
				} 
			} else if ($type == 'password') {
				if (strlen($value) == 0) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => "null",
						"message" => ''
					]);
				} else if (strlen($value) < 6) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => "encrypted",
						"message" => 'Senha muito curta!'
					]);
				} else if (strlen($value) > 32) {
					echo json_encode([
						"status" => 'error',
						"type" => $type,
						"value" => "encrypted",
						"message" => 'Senha muito grande!'
					]);
				} else {
					echo json_encode([
						"status" => 'ok',
						"type" => $type,
						"value" => "encrypted"	
					]);
				}
			}
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>