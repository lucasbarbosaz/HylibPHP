<?php

	/* --------------------------------------------------------------------------------------------------*/

	$db_hostname = 'localhost';
	$db_username = 'root';
	$db_password = 'D#pHgpwaSVeM';
	$db_database = 'crazzy_ohabbo';

	try {
		$db = new PDO('mysql:host=' . $db_hostname . ';dbname=' . $db_database, $db_username, $db_password);
	} catch(PDOException $e) {
		die('ERROR:' . $e->getMessage());
	}

	/* --------------------------------------------------------------------------------------------------*/

	$get = array($_GET);

	/* --------------------------------------------------------------------------------------------------*/

	$user = (key($get[0])) ? key($get[0]) : null;

	if (isset($user)) {
		$consult_user_look = $db->prepare("SELECT figure FROM players WHERE username = ? LIMIT 1");
		$consult_user_look->bindValue(1, $user);
		$consult_user_look->execute();

		if ($consult_user_look->rowCount() > 0) {
			$result_user_look = $consult_user_look->fetch(PDO::FETCH_ASSOC);

			$look = $result_user_look['figure'];
		} else {
			$look = null;
		}
	} else {
		$look = null;
	}

	/* --------------------------------------------------------------------------------------------------*/

	if (!empty($_GET['size'])) {
		$size = $_GET['size'];
	} else {
		$size = 'n';
	}

	if (!empty($_GET['direction'])) {
		$direction = $_GET['direction'];
	} else {
		$direction = '2';
	}

	if (!empty($_GET['head_direction'])) {
		$head_direction = $_GET['head_direction'];
	} else {
		$head_direction = '3';
	}

	if (!empty($_GET['gesture'])) {
		$gesture = $_GET['gesture'];
	} else {
		$gesture = 'std';
	}

	if (!empty($_GET['headonly'])) {
		$headonly = $_GET['headonly'];
	} else {
		$headonly = '0';
	}

	$ch = curl_init('https://habbo.com/habbo-imaging/avatarimage?figure=' . $look . '&head_direction=' . $head_direction . '&gesture=' . $gesture . '&headonly=' . $headonly . '&direction=' . $direction . '&size=' . $size);
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING       => "",
		CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.75 Safari/537.36",
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_SSL_VERIFYPEER => false
	));

	$content = curl_exec($ch);
	$type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

	curl_close($ch);

	header("Content-Type: {$type}");
	echo $content;
?>