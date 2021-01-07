<?php
	class User {
		
		static function GetFromUsername($type, $username = null) {
			global $db;
			$result = '0';

			if ($username != null) {
				if ($type === 'credits') {
					$consult = $db->prepare("SELECT credits FROM players WHERE username = ?");
					$consult->bindValue(1, $username);
					$consult->execute();

					$result = $consult->fetch(PDO::FETCH_ASSOC);
					$result = number_format($result['credits']);
				} else if ($type === 'diamonds') {
					$consult = $db->prepare("SELECT vip_points FROM players WHERE username = ?");
					$consult->bindValue(1, $username);
					$consult->execute();

					$result = $consult->fetch(PDO::FETCH_ASSOC);
					$result = number_format($result['vip_points']);
				} else if ($type === 'duckets') {
					$consult = $db->prepare("SELECT activity_points FROM players WHERE username = ?");
					$consult->bindValue(1, $username);
					$consult->execute();

					$result = $consult->fetch(PDO::FETCH_ASSOC);
					$result = number_format($result['activity_points']);
				}else if ($type == 'vip_status') {
					$consult = $db->prepare("SELECT vip_timestamp FROM players WHERE username = ?");
					$consult->bindValue(1, $username);
					$consult->execute();
					$result = $consult->fetch(PDO::FETCH_ASSOC);

					$vip_timestamp = date('d/m/Y', $result['vip_timestamp']);
					$timestamp_vip = DateTime::createFromFormat('d/m/Y' , $vip_timestamp);
					$timestamp = $timestamp_vip->getTimestamp();

					if ($result['vip_timestamp'] != NULL && time() < $result['vip_timestamp']) {
						$vip_expire = 'Restam <b>' . Functions::CountDays($timestamp) . '</b> dias de <b>VIP</b>!';
					} else {
						$vip_expire = 'Você não é <b>VIP</b>!';
					}

					$result = $vip_expire;
				} else if ($type == 'auth_ticket') {
					$consult = $db->prepare("SELECT auth_ticket FROM players WHERE username = ?");
					$consult->bindValue(1, $username);
					$consult->execute();
					$result_ticket = $consult->fetch(PDO::FETCH_ASSOC);
					
					$result = $result_ticket['auth_ticket'];
				} else if ($type == 'rankname') {
					$consult_rank = $db->prepare("SELECT rank FROM players WHERE username = ?");
					$consult_rank->bindValue(1, $username);
					$consult_rank->execute();

					if ($consult_rank->rowCount() > 0) {
						$result_rank = $consult_rank->fetch(PDO::FETCH_ASSOC);

						$consult_rank = $db->prepare("SELECT name FROM ranks WHERE id = ?");
						$consult_rank->bindValue(1, $result_rank['rank']);
						$consult_rank->execute();

						$result_rank = $consult_rank->fetch(PDO::FETCH_ASSOC);
						$result = $result_rank['name'];
					} else {
						$result = 'undefined';
					}
				}
			}

			return $result;
		}

		public function UpdateSSO($username) {
			global $db;

			$ticket = Functions::Random('sso');

			$update_ticket = $db->prepare("UPDATE players SET auth_ticket = ? WHERE username = ?");
			$update_ticket->bindValue(1, $ticket);
			$update_ticket->bindValue(2, $username);
			$update_ticket->execute();

			return $ticket;
		}
	}
?>