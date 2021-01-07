<?php
	class Auth {
		static function Login($identification, $password, $type = null) {
			global $db;

			$password_bcrypt = password_hash($password, PASSWORD_BCRYPT);

			if (empty($identification) || empty($password)) {
				echo json_encode([
					"response" => 'error',
					"message" => 'You need to provide your username and password to sign in.'
				]);
			} else {
				$consult_user = $db->prepare("SELECT id,username,password,account_disabled,machine_id,ip_register,ip_current FROM players WHERE username = ?");
				$consult_user->bindValue(1, $identification);
				$consult_user->execute();

				if ($consult_user->rowCount() > 0) {
					$result_user = $consult_user->fetch(PDO::FETCH_ASSOC);

					if (password_verify($password, $result_user['password'])) {
						$consult_user_ban = $db->prepare("SELECT expire, reason FROM bans WHERE (data = ? OR ip = ? OR ip = ? OR machine = ?)");
						$consult_user_ban->bindValue(1, $result_user['id']);
						$consult_user_ban->bindValue(2, $result_user['ip_register']);
						$consult_user_ban->bindValue(3, $result_user['ip_current']);
						$consult_user_ban->bindValue(4, $result_user['machine_id']);
						$consult_user_ban->execute();

						if ($result_user['account_disabled'] == '1') {
							echo json_encode([
								"response" => 'error',
								"message" => 'Sua conta foi <b>desativada</b>.'
							]);
						} else if ($consult_user_ban->rowCount() > 0) {
							$result_user_ban = $consult_user_ban->fetch(PDO::FETCH_ASSOC);

							$timestamp_now = TIME;
							$timestamp_ban = $result_user_ban['expire'];

							if ($timestamp_ban == '0') {
								echo json_encode([
									"response" => 'error',
									"message" => 'Your account has been permanently banned from the hotel for the following reasons: ' . $result_user_ban['reason']
								]);
							} else if ($timestamp_now < $timestamp_ban) {
								echo json_encode([
									"response" => 'error',
									"message" => 'Your account has been banned until: <b>' . utf8_encode(strftime('%d de %B de %Y', $result_user_ban['expire'])) . '</b> for the following reason: ' . $result_user_ban['reason']
								]);
							} else if ($timestamp_now > $timestamp_ban) {
								$delete_user_ban = $db->prepare("DELETE FROM bans WHERE data = ?");
								$delete_user_ban->bindValue(1, $result_user['id']);
								$delete_user_ban->execute();

								if ($type == 'staff' && $result_user['rank'] < 5) {
									echo json_encode([
										"response" => 'error',
										"message" => 'Currently, only staff members can log in.'
									]);
								} else if ($type == 'permissions' && $result_user['staff_access'] == '0') {
									echo json_encode([
										"response" => 'error',
										"message" => 'Currently only users with permission can log in.'
									]);
								} else {
									session_regenerate_id();

									if (!isset($_SESSION)) {
										session_start();
									}

									if ($result_user['ip_current'] != IP) {
										$update_ip = $db->prepare("UPDATE players SET ip_current = ? WHERE id = ?");
										$update_ip->bindValue(1, $result_user['ip_current']);
										$update_ip->bindValue(2, $result_user['id']);
										$update_ip->execute();
									}


									$consult_to_insert_ip = $db->prepare("SELECT players_ips WHERE username = ? AND ip = ?");
									$consult_to_insert_ip->bindValue(1, $result_user['username']);
									$consult_to_insert_ip->bindValue(2, IP);
									$consult_to_insert_ip->execute();

									$consult_to_useragent = $db->prepare("SELECT players WHERE user_agent = ? AND id = ?");
									$consult_to_useragent->bindValue(1, $result_user['user_agent']);
									$consult_to_useragent->bindValue(2, $result_user['id']);
									

									if ($consult_to_insert_ip->rowCount() == 0) {
										$insert_user_ip = $db->prepare("INSERT INTO players_ips (username, ip) VALUES (?,?)");
										$insert_user_ip->bindValue(1, $result_user['username']);
										$insert_user_ip->bindValue(2, IP);
										$insert_user_ip->execute();
									}

									if($Function::detecMobile()) {
										$updateUserAgent = $db->prepare("UPDATE players SET mobile = '1' WHERE id = ?");
										$updateUserAgent->bindValue(1, $result_user['id']);
										$updateUserAgent->execute();
									}

									$_SESSION['username'] = $result_user['username'];
									$_SESSION['password'] = $password_bcrypt;

									echo json_encode([
										"response" => 'ok'
									]);
								}
							}
						} else {
							$consultRank = $db->prepare("SELECT * FROM players WHERE username = ?");
							$consultRank->bindValue(1, $identification);
							$consultRank->execute();
							$result_rank = $consultRank->fetch(PDO::FETCH_ASSOC);
							if ($type == 'staff' && $result_rank['rank'] < 5) {
								echo json_encode([
									"response" => 'error',
									"message" => 'At this time, only staff members can sign in.'
								]);
							} else if ($type == 'permissions' && $result_user['staff_access'] == '0') {
								echo json_encode([
									"response" => 'error',
									"message" => 'Currently only users with permission can log in.'
								]);
							} else {
								session_regenerate_id();

								if (!isset($_SESSION)) {
									session_start();
								}

								if ($result_user['ip_current'] != IP) {
									$update_ip = $db->prepare("UPDATE players SET ip_current = ? WHERE id = ?");
									$update_ip->bindValue(1, $result_user['ip_current']);
									$update_ip->bindValue(2, $result_user['id']);
									$update_ip->execute();
								}

								$consult_to_insert_ip = $db->prepare("SELECT * FROM players_ips WHERE username = ? AND ip = ?");
								$consult_to_insert_ip->bindValue(1, $result_user['username']);
								$consult_to_insert_ip->bindValue(2, IP);

								if ($consult_to_insert_ip->rowCount() == 0) {
									$insert_user_ip = $db->prepare("INSERT INTO players_ips (username, ip) VALUES (?,?)");
									$insert_user_ip->bindValue(1, $result_user['username']);
									$insert_user_ip->bindValue(2, IP);
									$insert_user_ip->execute();
								}

								$_SESSION['username'] = $result_user['username'];
								$_SESSION['password'] = $password_bcrypt;

								echo json_encode([
									"response" => 'ok'
								]);
							}
						}
					} else {
						echo json_encode([
							"response" => 'error',
							"message" => 'The username or password is <b>incorrect</b>.'
						]);
					}
				} else {
					echo json_encode([
						"response" => 'error',
						"message" => 'It was not possible to find any account with the data provided.'
					]);
				}
			}
		}

		static function Session($type) {
			if ($type == 'connected') {
				if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
					Redirect(URL . '/me');
				}
			} else if ($type == 'disconnected') {
				if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
					Redirect(URL);
				} else if (isset($_SESSION['username']) && !isset($_SESSION['password'])) {
					session_destroy();
					Redirect(URL);
				} else if (!isset($_SESSION['username']) && isset($_SESSION['password'])) {
					session_destroy();
					Redirect(URL);
				}
			}
		}
	}
?>
