<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$userPath = (isset($_POST['userPath'])) ? str_replace('/profile/', '', $_POST['userPath']) : '';
		$username = (isset($_POST['username'])) ? $_POST['username'] : '';
		$value = (isset($_POST['value'])) ? htmlspecialchars_decode($_POST['value']) : '';

		$consult_to_send_errand = $db->prepare("SELECT id,username FROM players WHERE username = ?");
		$consult_to_send_errand->bindValue(1, $username);
		$consult_to_send_errand->execute();

		if ($consult_to_send_errand->rowCount() > 0 && $username == $userPath) {
			$result_to_send_errand = $consult_to_send_errand->fetch(PDO::FETCH_ASSOC);

			$consult_last_errands = $db->prepare("SELECT data FROM cms_errands WHERE user_from_id = ? AND user_to_id = ? ORDER BY data DESC LIMIT 1");
			$consult_last_errands->bindValue(1, $user['id']);
			$consult_last_errands->bindValue(2, $result_to_send_errand['id']);
			$consult_last_errands->execute();

			$result_last_errands = $consult_last_errands->fetch(PDO::FETCH_ASSOC);

			if ($consult_last_errands->rowCount() > 0 && $result_last_errands['data'] >= time() - 300) {
				echo json_encode([
					"response" => 'error',
					"append" => '<div class="general-warn-time-2"><label>Você precisa precisa esperar <b>5 minutos</b> para enviar um recado para ' . $result_to_send_errand['username'] . ' novamente.</label></div>'
				]);
			} else {
				if (strlen($value) <= 0 || strlen($value) >= 300) {
					echo json_encode([
						"response" => 'error',
						"append" => '<div class="general-warn-2"><label>Seu recado <b>deve ter</b> no máximo <b>300</b> caracteres.</label></div>'
					]);
				} else if (Functions::AntiPub($value) !== false) {
					echo json_encode([
						"response" => 'error',
						"append" => '<div class="general-warn-2"><label>Seu recado contém palavras proibidas de acordo com o nosso filtro! Clique <a>aqui</a> para saber mais.</label></div>'
					]);
				} else {
					$insert_errand = $db->prepare("INSERT INTO cms_errands (user_from_id, user_to_id, data, value) VALUES (?,?,?,?)");
					$insert_errand->bindValue(1, $user['id']);
					$insert_errand->bindValue(2, $result_to_send_errand['id']);
					$insert_errand->bindValue(3, TIME);
					$insert_errand->bindValue(4, $Function::Filter('xss', $value));
					$insert_errand->execute();

					$consult_last_sended_errand = $db->prepare("SELECT id FROM cms_errands WHERE user_from_id = ? AND user_to_id = ? ORDER BY id DESC LIMIT 1");
					$consult_last_sended_errand->bindValue(1, $user['id']);
					$consult_last_sended_errand->bindValue(2, $result_to_send_errand['id']);
					$consult_last_sended_errand->execute();

					$result_last_sended_errand = $consult_last_sended_errand->fetch(PDO::FETCH_ASSOC);

					echo json_encode([
						"response" => 'success',
						"label" => [
							"errand-id" => $result_last_sended_errand['id'],
							"author" => [
								"alt" => $user['username'] . ' - ' . HOTELNAME,
								"username" => $user['username'],
								"figure" => AVATARIMAGE. 'figure=' . $user['figure'] . '&direction=2&head_direction=3&gesture=spk&size=s',
								"profile" => [
									"link" => URL . '/perfil/' . $user['username'],
									"place" => 'Perfil: ' . $user['username'] . ' - ' . HOTELNAME
								]
							],
							"time" => [
								"date" => utf8_encode(strftime('%d de %B de %Y', TIME)),
								"hour" => utf8_encode(strftime('%H:%M', TIME))
							],
							"value" => $Function::Filter('xss', $Function::Filter('emoji', $value))
						]
					]);
				}
			}
		} else {
			echo json_encode([
				"response" => 'error',
				"append" => '<div class="general-warn-2"><label>Parece que houve um erro ao enviar seu recado para <b>' . str_replace('/profile/', '', $userPath) . '</b>, tente novamente mais tarde!</label></div>'
			]);
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>