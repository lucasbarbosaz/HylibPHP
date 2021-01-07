<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST) && isset($user)) {
		$order = (isset($_POST['order'])) ? $_POST['order'] : '';

		if ($order == 'article') {
			$article_id = (isset($_POST['article_id'])) ? $_POST['article_id'] : '';

			if (is_numeric($article_id)) {
				$consult_article_form = $db->prepare("SELECT id,form FROM cms_news WHERE id = ?");
				$consult_article_form->bindValue(1, $article_id);
				$consult_article_form->execute();

				if ($consult_article_form->rowCount() > 0) {
					$result_article_form = $consult_article_form->fetch(PDO::FETCH_ASSOC);

					if ($result_article_form['form'] == 'enabled') {
						$participants = (isset($_POST['participants'])) ? $Function::Filter('xss', $_POST['participants']) : '';
						$link = (isset($_POST['link'])) ? $Function::Filter('xss', $_POST['link']) : '';
						$message = (isset($_POST['message'])) ? $Function::Filter('xss', $_POST['message']) : '';

						$consult_forms_article = $db->prepare("SELECT * FROM cms_post_forms WHERE type = ? AND post_id = ? AND user_id = ?");
						$consult_forms_article->bindValue(1, 'article');
						$consult_forms_article->bindValue(2, $result_article_form['id']);
						$consult_forms_article->bindValue(3, $user['id']);
						$consult_forms_article->execute();

						if (empty($participants)) {
							echo json_encode([
								"response" => 'error',
								"append" => '<div class="general-warn margin-top-min margin-auto-left-right"><label>Você deve ao menos <b>preencher seu nome</b> para enviar seu fórmulario!</label></div>'
							]);
						} else {
							if ($consult_forms_article->rowCount() < 3) {
								$insert_article_form = $db->prepare("INSERT INTO cms_post_forms (type, post_id, user_id, label, timestamp) VALUES (?,?,?,?,?)");
								$insert_article_form->bindValue(1, 'article');
								$insert_article_form->bindValue(2, $result_article_form['id']);
								$insert_article_form->bindValue(3, $user['id']);
								$insert_article_form->bindValue(4, str_replace(';', '', $participants) . ';' . str_replace(';', '', $link) . ';' . str_replace(';', '', $message));
								$insert_article_form->bindValue(5, TIME);
								$insert_article_form->execute();

								echo json_encode([
									"response" => 'success',
									"append" => '<div class="general-success margin-top-min margin-auto-left-right"><label>Seu formulário foi enviado com sucesso!</label></div>'
								]);
							} else {
								echo json_encode([
									"response" => 'error',
									"append" => '<div class="general-warn margin-top-min margin-auto-left-right"><label>Você atingiu o limite de <b>3 formulários</b> por usuário!</label></div>'
								]);
							}
						}
					} else if ($result_article_form['form'] == 'unavailable') {
						echo json_encode([
							"response" => 'error',
							"append" => '<div class="general-warn margin-top-min margin-auto-left-right"><label>Opps! O envios de formulários para está noticia já acabaram!</label></div>'
						]);
					}
				} else {
					echo json_encode([
						"response" => 'not-found'
					]);
				}
			} else {
				echo json_encode([
					"response" => 'error',
					"append" => '<div class="general-warn margin-top-min margin-auto-left-right"><label>Um erro insperado ocorreu ao enviar seu formulário! Tente novamente mais tarde.</label></div>'
				]);
			}
		}
	} else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>