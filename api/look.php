<?php 
	require_once('../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$identification = (isset($_POST['identification'])) ? $_POST['identification'] : '';

		$consult_look = $db->prepare("SELECT figure FROM players WHERE username = ?");
		$consult_look->bindValue(1, $identification);
		$consult_look->execute();

		$look = $consult_look->fetch(PDO::FETCH_ASSOC);

		if ($consult_look->rowCount() > 0) {
			echo json_encode([
				"look" => AVATARIMAGE . 'figure=' . $look['figure'] . '&head_direction=3&size=n&gesture=sml'
			]);
		} else {
			echo json_encode([
				"look" => CDN . '/assets/img/ghost.png'
			]);
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>