<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$order = (isset($_POST['order'])) ? $_POST['order'] : '';
		$package = (isset($_POST['package'])) ? $_POST['package'] : '';

		if ($order == 'vip') {
			if ($user['online']) {
				echo json_encode([
					"response" => 'error',
					"label" => '<div class="general-warn-2"><label>Você precisa <b>estar offline</b> para realizar a compra deste plano!</label></div>'
				]);
			} else {
				$consult_vip_package = $db->prepare("SELECT * FROM cms_store WHERE product_id = ?");
				$consult_vip_package->bindValue(1, $package);
				$consult_vip_package->execute();

				if ($consult_vip_package->rowCount() > 0) {
					$result_vip_package = $consult_vip_package->fetch(PDO::FETCH_ASSOC);

					$json_package = json_decode($result_vip_package['label'], true);
					$package_info = $json_package['product_label'][0];

					@$date_now = mktime(date('d/m/Y H:i:s'));
					$vip_timestamp = $user['vip_expire'];
					$vip_date = date('d/m/Y H:i:s', $vip_timestamp);

					/*if ($user['vip_expire'] == 'NULL' || $user['vip_expire'] == '') {

					}*/

					echo json_encode([
						"response" => 'success',
						"label" => '<div class="general-success-2"><label>Você comprou com sucesso o plano de <b class="underline">' . $package_info['name'] . '</b></label></div>'
					]);
				} else {
					echo json_encode([
						"response" => 'error',
						"label" => '<div class="general-warn-2"><label>Houve um error ao processar sua comprar, por favor tente novamente mais tarde!</label></div>'
					]);
				}
			}
		} else {
			echo json_encode([
				"response" => 'error',
				"label" => '<div class="general-warn-2"><label>Houve um error ao processar sua comprar, por favor tente novamente mais tarde!</label></div>'
			]);
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>