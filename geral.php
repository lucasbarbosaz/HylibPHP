<?php
	error_reporting(0);
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	ini_set('display_startup_errors', 1);
	error_reporting(-1);

	if (!isset($_SESSION)) {
		session_start();
	}


	define('SEPARATOR', DIRECTORY_SEPARATOR);
	define('DIR', __DIR__);

	require_once('configuration/class/class.core.php');
	require_once('configuration/functions.php');

	define('PROTOCOL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http"));
	define('URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST']);
	define('URL_ATUAL', URL . $_SERVER['REQUEST_URI']);
	define('UPDATE', mt_rand(500, 999));
	define('GENERATE_KEY', md5(microtime() . rand()));
	define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);

    define('API', URL . '/api');
    define('CDN', URL . '/cdn');
    define('SWF', URL . '/swf');
    define('AVATARIMAGE', $Hotel::Settings('avatarimage'));
    define('TIME', time());
    define('USERS', $Function::Onlines());
    define('HOTELNAME', $Hotel::Settings('hotelname'));
    define('IP', $Function::IP());

    define('RANK_MIN', '5');
	
	header("Content-Type: text/html; charset=utf-8", true);
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.iso-8859-15', 'portuguese');
	date_default_timezone_set('America/Sao_paulo');

	# Puxando informaçõs do usuários se o mesmo estiver conectado, dando acesso para utilizar a variavél $user
	if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
		$username = $_SESSION['username'];
		$password = password_hash($_SESSION['password'], PASSWORD_BCRYPT);

		if (password_verify($_SESSION['password'], $password)) {
			$consult_user = $db->prepare("SELECT * FROM players WHERE username = ? LIMIT 1");
			$consult_user->bindValue(1, $username);
			$consult_user->execute();

			if ($consult_user->rowCount() > 0) {
				$user = $consult_user->fetch(PDO::FETCH_ASSOC);

				define('USERNAME', $user['username']);
				$Function::Check('ban', $user['id']);

				#------------------------------------------------------------------------------------------------------------#

				if ($user['discord_token'] == NULL || $user['discord_token'] == '') {
					$insert_discord_token = $db->prepare("UPDATE players SET discord_token = ? WHERE id = ?");
					$insert_discord_token->bindValue(1, sha1(md5($user['username'] . $Function::Random('random', '20') . md5($Function::Random('random', '20')))));
					$insert_discord_token->bindValue(2, $user['id']);
					$insert_discord_token->execute();
				}

				#------------------------------------------------------------------------------------------------------------#

				if (empty($user['browser_register']) && empty($user['browser_last']) && empty($user['browser_current'])) {
					$set_browsers = $db->prepare("UPDATE players SET browser_register = ?, browser_last = ?, browser_current = ? WHERE id = ?");
					$set_browsers->bindValue(1, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
					$set_browsers->bindValue(2, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
					$set_browsers->bindValue(3, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
					$set_browsers->bindValue(4, $user['id']);
					$set_browsers->execute();
				}

				if ($user['browser_current'] != $Function::GetBrowser($_SERVER['HTTP_USER_AGENT'])) {
					$update_browsers = $db->prepare("UPDATE players SET browser_last = ?, browser_current = ?, mobile = ? WHERE id = ?");
					$update_browsers->bindValue(1, $user['browser_current']);
					$update_browsers->bindValue(2, $Function::GetBrowser($_SERVER['HTTP_USER_AGENT']));
					$update_browsers->bindValue(3, $user['id']);
					$update_browsers->bindValue(4, '0');
					$update_browsers->execute();
				}

				if(empty($user['user_agent']) || $user['user_agent'] != USER_AGENT) {
					$update_useragent = $db->prepare("UPDATE players SET user_agent = ? WHERE id = ?");
					$update_useragent->bindValue(1, USER_AGENT);
					$update_useragent->bindValue(2, $user['id']);
					$update_useragent->execute();
				}

				if ($user['mobile'] == '0' && $user['user_agent'] != $Function::GetMobile($_SERVER['HTTP_USER_AGENT'])) {
					$set_mobile = $db->prepare("UPDATE players SET browser_last = ?, browser_current = ?, mobile = ? WHERE id = ?");
					$set_mobile->bindValue(1, $Function::GetMobile($_SERVER['HTTP_USER_AGENT']));
					$set_mobile->bindValue(2, $Function::GetMobile($_SERVER['HTTP_USER_AGENT']));
					$set_mobile->bindValue(3, '1');
					$set_mobile->bindValue(4, $user['id']);
					$set_mobile->execute();
				}

				#------------------------------------------------------------------------------------------------------------#

				if ($user['ip_current'] != IP) {
					$update_ip = $db->prepare("UPDATE players SET ip_current = ? WHERE id = ?");
					$update_ip->bindValue(1, $user['ip_current']);
					$update_ip->bindValue(2, $user['id']);
					$update_ip->execute();
				}

				#------------------------------------------------------------------------------------------------------------#

				$consult_to_insert_ip = $db->prepare("SELECT * FROM players_ips WHERE username = ? AND ip = ?");
				$consult_to_insert_ip->bindValue(1, $user['username']);
				$consult_to_insert_ip->bindValue(2, IP);

				if ($consult_to_insert_ip->rowCount() == 0) {
					$insert_user_ip = $db->prepare("INSERT INTO players_ips (username, ip) VALUES (?,?)");
					$insert_user_ip->bindValue(1, $user['username']);
					$insert_user_ip->bindValue(2, IP);
					$insert_user_ip->execute();
				}

				#------------------------------------------------------------------------------------------------------------#

			} else {
				session_destroy();
				Redirect(URL);
			}
		}
	}
?>