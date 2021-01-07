<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$order = (isset($_POST['order'])) ? $_POST['order'] : '';

		if ($order == 'version') {
			$version = (isset($_POST['version'])) ? $_POST['version'] : '';

			$consult_client_version = $db->prepare("SELECT * FROM cms_clients WHERE user_id = ?");
			$consult_client_version->bindValue(1, $user['id']);
			$consult_client_version->execute();

			if ($consult_client_version->rowCount() > 0) {
				$update_client_version = $db->prepare("UPDATE cms_clients SET version = ? WHERE user_id = ?");

				if (is_numeric($version) === true) {
					$update_client_version->bindValue(1, $version);
				} else {
					$update_client_version->bindValue(1, '24');
				}

				$update_client_version->bindValue(2, $user['id']);
				$update_client_version->execute();

				echo json_encode([
					"response" => 'success'
				]);
			} else {
				$insert_client_version = $db->prepare("INSERT INTO cms_clients (user_id, version) VALUES (?,?)");
				$insert_client_version->bindValue(1, $user['id']);

				if (is_numeric($version) === true) {
					$insert_client_version->bindValue(2, $version);
				} else {
					$insert_client_version->bindValue(2, '24');
				}

				$insert_client_version->execute();

				echo json_encode([
					"response" => 'success'
				]);
			} 
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>