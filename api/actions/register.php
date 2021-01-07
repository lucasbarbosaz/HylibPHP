<?php 
	require_once('../../geral.php');

	header('Content-Type: application/json');

	if (extract($_POST)) {
		$username = (isset($_POST['username'])) ? $_POST['username'] : '';
		$email = (isset($_POST['email'])) ? $_POST['email'] : '';
		$password = (isset($_POST['password'])) ? $_POST['password'] : '';
		$birth_day = (isset($_POST['day'])) ? $_POST['day'] : '';
		$birth_month = (isset($_POST['month'])) ? $_POST['month'] : '';
		$birth_year = (isset($_POST['year'])) ? $_POST['year'] : '';
		$gender = (isset($_POST['gender'])) ? $_POST['gender'] : '';
		$captcha = (isset($_POST['captcha'])) ? $_POST['captcha'] : '';

		$consult_if_exists_username = $db->prepare("SELECT username FROM players WHERE username = ? LIMIT 1");
		$consult_if_exists_username->bindValue(1, $username);
		$consult_if_exists_username->execute();

		$consult_if_exists_mail = $db->prepare("SELECT email FROM players WHERE email = ? LIMIT 1");
		$consult_if_exists_mail->bindValue(1, $email);
		$consult_if_exists_mail->execute();

		if (strlen($username) == 0) {
			echo json_encode([
				"response" => 'error',
				"message" => 'O <b>nome de usuário(a)</b> não pode ficar vázio!'
			]);
		} else if (strlen($username) < 3 || strlen($username) > 15 || $Function::Validate('username', $username) !== true) {
			echo json_encode([
				"response" => 'error',
				"message" => 'Nome de usuário <b>inválido</b>!'
			]);
		} else if ($consult_if_exists_username->rowCount() > 0) {
			echo json_encode([
				"response" => 'error',
				"message" => 'O nome de usuário(a) <b>' . $username . '</b> já está sendo utilizado!'
			]);
		} else if (strlen($email) == 0) {
			echo json_encode([
				"response" => 'error',
				"message" => 'Você precisa fornecer um <b>endereço de e-mail</b>!'
			]);
		} else if ($Function::Validate('email', $email) !== false) {
			echo json_encode([
				"response" => 'error',
				"message" => 'O <b>endereço de e-mail</b> fornecido é <b>inválido</b>!'
			]);
		} else if ($consult_if_exists_mail->rowCount() > 0) {
			echo json_encode([
				"response" => 'error',
				"message" => 'O <b>endereço de e-mail</b> fornecido já está sendo utilizado!'
			]);
		} else if (strlen($password) == 0) {
			echo json_encode([
				"response" => 'error',
				"message" => 'Você precisa fornecer uma <b>senha</b>, e <b>segura</b> para a sua conta!'
			]);
		} else if (strlen($password) < 6 || strlen($password) > 32) {
			echo json_encode([
				"response" => 'error',
				"message" => 'Sua senha deve conter no <b>mínimo 6 caracteres</b> e no <b>máximo 32 caracteres</b>!'
			]);
		} else if (empty($birth_day) || empty($birth_month) || empty($birth_year)) {
			echo json_encode([
				"response" => 'error',
				"message" => 'Você precisa fornecer a sua <b>data de nascimento</b> por completo!'
			]);
		} else if ($birth_year >= date('Y') - 13) {
			echo json_encode([
				"response" => 'error',
				"message" => 'Você precisa <b>ter mais que 13</b> anos de idade para poder jogar!'
			]);
		} else if (empty($gender) || $gender == null || $gender == '') {
			echo json_encode([
				"response" => 'error',
				"message" => '<b>Escolha o seu sexo</b>, e através dele receba um cafofo incrível!'
			]);
		}/* else if (empty($captcha) || $captcha == null || $captcha == '') {
			echo json_encode([
				"response" => 'error',
				"message" => 'Precisamos verificar se você não é um <b>robô<b>!'
			]);
		}*/ else {
 
				$password_bcrypt = password_hash($password, PASSWORD_BCRYPT);

				#------------------------------------------------------------#

				$date = $birth_day . '/' . $birth_month . '/' . $birth_year;
				$date_birthday = DateTime::createFromFormat('d/m/Y' , $date);
				$birthday_timestamp = $date_birthday->getTimestamp();

				#------------------------------------------------------------#

				$insert_account = $db->prepare("INSERT INTO players (username, password, email, account_created, account_day_of_birth, last_login, last_online, figure, gender, credits, activity_points, vip_points, ip_register, ip_current, browser_register, browser_last, browser_current, discord_token, user_agent) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$insert_account->bindValue(1, $username);
				$insert_account->bindValue(2, $password_bcrypt);
				$insert_account->bindValue(3, $email);
				$insert_account->bindValue(4, TIME);
				$insert_account->bindValue(5, $birthday_timestamp);
				$insert_account->bindValue(6, TIME);
				$insert_account->bindValue(7, TIME);

				if ($gender == 'female') {
					$insert_account->bindValue(8, 'sh-725-62.hd-600-1383.ch-635-95.lg-700-110.ha-1015-62');
				} else {
					$insert_account->bindValue(8, 'sh-290-62.hd-205-1383.ch-215-82.lg-275-110.ha-1015-62');
				}

				if ($gender == 'female') {
					$insert_account->bindValue(9, 'F');
				} else {
					$insert_account->bindValue(9, 'M');
				}

				$insert_account->bindValue(10, $Hotel::Settings('credits'));
				$insert_account->bindValue(11, $Hotel::Settings('duckets'));
				$insert_account->bindValue(12, $Hotel::Settings('diamonds'));
				$insert_account->bindValue(13, IP);
				$insert_account->bindValue(14, IP);
				$insert_account->bindValue(15, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
				$insert_account->bindValue(16, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
				$insert_account->bindValue(17, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
				$insert_account->bindValue(18, sha1(md5($username . GenerateRandom('random', '20') . md5(GenerateRandom('random', '20')))));
				$insert_account->bindValue(19, USER_AGENT);
				$insert_account->execute();

				$consult_account_user = $db->prepare("SELECT id,username FROM players WHERE username = ?");
				$consult_account_user->bindValue(1, $username);
				$consult_account_user->execute();
				$result_account_user = $consult_account_user->fetch(PDO::FETCH_ASSOC);

				#----------------------------------------------------------------------------------------------------------------------#

				$consult_to_insert_ip = $db->prepare("SELECT players_ips WHERE username = ? AND ip = ?");
				$consult_to_insert_ip->bindValue(1, $result_account_user['username']);
				$consult_to_insert_ip->bindValue(2, IP);

				if ($consult_to_insert_ip->rowCount() == 0) {
					$insert_user_ip = $db->prepare("INSERT INTO players_ips (username, ip) VALUES (?,?)");
					$insert_user_ip->bindValue(1, $result_account_user['username']);
					$insert_user_ip->bindValue(2, IP);
					$insert_user_ip->execute();
				}

				#----------------------------------------------------------------------------------------------------------------------#

				session_regenerate_id();

				if (!isset($_SESSION)) {
					session_start();
				}

				$_SESSION['username'] = $result_account_user['username'];
				$_SESSION['password'] = $password_bcrypt;

				echo json_encode([
					'response' => 'ok'
				]);
			}
		}
	 else {
		echo 'Cannot get ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '.';
	}
?>