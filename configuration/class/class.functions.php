<?php
	class Functions {
		
		static function Validate($type, $string) {
			if ($type == "username") {
				$match = preg_match('/[^a-zA-Z0-9]+/', $string);

				if ($match == 1) {
					return false;
				} else {
					return true;
				}
			} else if ($type == "email") {
				$pattern = "/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i";
				$match = preg_match($pattern, $string);

				if ($match == 1) {
					return false;
				} else {
					return true;
				}
			}
		}

		static function Onlines() {
			global $db;

			$consulta = $db->prepare("SELECT online FROM players WHERE online='1'");
			$consulta->execute();

			if ($consulta->rowCount() == 1) {
				$onlines = '<b>1</b> usuário online';
			} else {
				$onlines = '<b>' . $consulta->rowCount() . '</b> usuários online';
			}

			return $onlines;
		}

		static function Filter($type, $string) {
			if ($type == 'XSS' || $type == 'xss') {
				$value = htmlspecialchars_decode($string);
				$value = trim($value);

				# 18
				$search = [
					"<script", "/script>", 
					"<div", "/div>",
					"<a", "/a>",
					"<button", "/button>",
					"<?php", "?>",
					"<?=", "?>",
					"<svg", "/svg>",
					"<link", "<?xml"
				];

				$replace = [
					"", "", 
					"", "", 
					"", "",
					"", "",
					"", "", 
					"", "", 
					"", "", 
					"", "", 
					"", ""
				];
				
				$value = str_replace($search, $replace, $value);
			} else if ($type == 'username') {
				$value = htmlspecialchars_decode($string);
				$value = trim($value);

				$search = [
					" ", "/", "\\"
				];

				$replace = [
					"", "", ""
				];
				
				$value = str_replace($search, $replace, $value);
			} else if ($type == 'emoji') {
				$value = htmlspecialchars_decode($string);
				$value = trim($value);

				$search = [
					":D", ":d", ":laughing:", ":rindo:",
					"<3", ":heart:", ":coracao:",
					":O", ":o", ":gaping:", ":supreso:", ":boquiaberto:",
					";P", ":stuck_out_tongue_winking_eye:", ":piscando_com_a_lingua_pra_fora:",
					";(", ":crying:", ":chorando:",
					":(", ":sad:", ":triste:",
					"B)", "b)", ":sunglasses:", ":cool:", ":descolado:",
					":|", ":neutral_face:", ":entendiado:",
					":)", ":happy_face:", ":sorrindo:"	
				];

				$replace = [
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/laughing.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/laughing.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/laughing.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/laughing.png">',
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/heart.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/heart.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/heart.png">',
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/gaping.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/gaping.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/gaping.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/gaping.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/gaping.png">', 
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/blinking.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/blinking.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/blinking.png">',
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/crying.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/crying.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/crying.png">', 
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/sad.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/sad.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/sad.png">',
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/sunglasses.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/sunglasses.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/sunglasses.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/sunglasses.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/sunglasses.png">', 
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/bored.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/bored.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/bored.png">', 
					'<img class="emoji" src="' . CDN . '/assets/img/emoticons/smiling.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/smiling.png">', '<img class="emoji" src="' . CDN . '/assets/img/emoticons/smiling.png">', 
				];
				
				$value = str_replace($search, $replace, $value);
			} else if ($type == 'article') {
				$value = htmlspecialchars_decode($string);

				$search = [
					"<script", "/script>",
					"<?php", "?>", "<?=",
					"<svg", "/svg>",
					"<link", "<?xml"
				];

				$replace = [
					"", "", 
					"", "", "",
					"", "",
					"", "",
				];
				
				$value = str_replace($search, $replace, $value);
			}

			return $value;
		}

		static function AntiPub($string) {
			global $db;

			$search  = ["/", "*", "-", "+", "=", "/", "^", "_", ",", ";", "(", ")", "[", "]", ".", "<", ">"];
			$replace = ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];

			$string_1 = str_replace($search, $replace, $string);
			$string_2 = str_noaccents($string);
			$string_3 = strtolower($string_1);

			$select = $db->prepare("SELECT * FROM cms_wordfilter");
			$select->execute();
			$result = $select->fetchAll();

			for ($i = 0; $i < count($result); $i++) {
				$filtro = $result[$i]['word'];

				if (strpos(trim($string_3), $filtro) !== false) {
					return true;
				}
			}

			return false;
		}

		static function GetBrowser($user_agent) {
			if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) {
				return 'Opera';
			} else if (strpos($user_agent, 'Chrome')) {
				return 'Chrome';
			} else if (strpos($user_agent, 'Safari')) {
				return 'Safari';
			} else if (strpos($user_agent, 'Firefox')) {
				return 'Firefox';
			} else if (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) {
				return 'Explorer';
			}

			return 'Outro';
		}

		static function GetMobile($user_agent) {
			if (strpos($user_agent, 'Android')) {
				return 'Android';
			} else if (strpos($user_agent, 'blackberry')) {
				return 'blackberry';
			} else if (strpos($user_agent, 'bolt')) {
				return 'bolt';
			} else if (strpos($user_agent, 'phone') || strpos($user_agent, 'phone')) {
				return 'phone';
			} else if (strpos($user_agent, 'tablet') || strpos($user_agent, 'tablet')) {
				return 'tablet';
			} else if (strpos($user_agent, 'hiptop') || strpos($user_agent, 'hiptop')) {
				return 'hiptop';
			} else if (strpos($user_agent, 'iPod') || strpos($user_agent, 'iPod')) {
				return 'iPod';
			} else if (strpos($user_agent, 'iPad') || strpos($user_agent, 'iPad')) {
				return 'iPad';
			} else if (strpos($user_agent, 'iPhone') || strpos($user_agent, 'iPhone')) {
				return 'iPhone';
			} else if (strpos($user_agent, 'iOS') || strpos($user_agent, 'iOS')) {
				return 'iOS';
			} else if (strpos($user_agent, 'Linux') || strpos($user_agent, 'Linux')) {
				return 'Linux';
			} 
		
			return 'Outro';
		}

		static function IP() {
			if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
				$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
			} else if (!empty($_SERVER['HTTP_INCAP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_INCAP_CLIENT_IP'];
			} else if (!empty($_SERVER['HTTP_X_SUCURI_CLIENTIP'])) {
				$ip = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
			} else if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED'];
			} else if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_FORWARDED_FOR'];
			} else if (!empty($_SERVER['HTTP_FORWARDED'])) {
				$ip = $_SERVER['HTTP_FORWARDED'];
			} else if (!empty($_SERVER['REMOTE_ADDR'])) {
				$ip = $_SERVER['REMOTE_ADDR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}

			return $ip;
		}

		static function NumberUnits($amount, $precision = 1) {
			$amount = str_replace(',', '', $amount);

			if ($amount < 900000000) {
				$amount_format = number_format($amount, $precision);
				$suffix = '';
			} else if ($amount < 900000000000) {
				$amount_format = number_format($amount / 1000000000, $precision);
				$suffix = ' Bi';
			} else {
				$amount_format = number_format($amount / 1000000000000, $precision);
				$suffix = 'Tri';
			}

			if ($precision > 0) {
				$comma = '.' . str_repeat('0', $precision);
				$amount_format = str_replace($comma, '', $amount_format);
			}

			return $amount_format . $suffix; 
		}

		static function CountDays($string) {
			$date_now = new DateTime(date('Y-m-d', time()));
			$date_string = new DateTime(date('Y-m-d', $string));

			$interval = $date_now->diff($date_string);
			$days = $interval->days;

			return number_format($days);
		}

		static function Random($type, $length = null) {
			switch ($type) {
				case "sso":
					$data = 'haibbo-' . self::Random("random", 16) . '-' . self::Random("random", 8) . '-' . self::Random("random", 18);
					return $data;
				break;
				case "random":
					$data = null;
					$possible  = 'abcdefghijklmnopqrstuvwxyz';
					$possible .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$possible .= '1234567890';

					for ($i = 0; $i < $length; $i++) {
						$data .= substr($possible, rand() % (strlen($possible)), 1);
					}

					return $data;
				break;
				case "random_number":
					$data = "";
					$possible = "1234567890";
					$i  = 0;

					while ($i < $length) {
						$char = substr($possible, mt_rand(0, strlen($possible) - 1), 1);
						$data = $char;
						$i++;
					}

					return $data;
				break;
			}
		}

		static function detecMobile($user_id) {
			$user_agent = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);

			if($user_agent) {
				$updateMobile = $db->prepare("UPDATE players SET mobile = '1' WHERE id = ?");
				$updateMobile->bindValue(1, $user_id);
				$updateMobile->execute();
			}
		}


		static function Check($type, $user_id) {
			global $db;

			if ($type != null && $user_id != null) {
				$consult_user_info = $db->prepare("SELECT * FROM players WHERE id = ?");
				$consult_user_info->bindValue(1, $user_id);
				$consult_user_info->execute();

				if ($consult_user_info->rowCount() > 0) {
					$result_user_info = $consult_user_info->fetch(PDO::FETCH_ASSOC);

					if ($type == 'ban') {
						if ($result_user_info['account_disabled'] == '1') {
							session_destroy();
							Redirect('refresh');
						} else {
							$consult_ban_user = $db->prepare("SELECT * FROM bans WHERE (user_id = ? OR ip = ? OR ip = ? OR machine = ?)");
							$consult_ban_user->bindValue(1, $result_user_info['id']);
							$consult_ban_user->bindValue(2, $result_user_info['ip_register']);							$consult_ban_user->bindValue(4, $result_user_info['ip_current']);
							$consult_ban_user->bindValue(3, $result_user_info['machine_id']);
							$consult_ban_user->execute();

							if ($consult_ban_user->rowCount() > 0) {
								session_destroy();
								Redirect('refresh');
							}
						}
					}
				} else {
					return false;
				}
			} else {
				echo "As variáveis não pode ficar nulas.";
			}
		}

		public static function GetLastFeedLikesTxt($feedId) {
			global $db;

			$username = USERNAME;
			$arr = array();

			$players = $db->prepare("SELECT username FROM players WHERE id IN (SELECT user_id FROM cms_feed_like WHERE feed_id = ?");
			$players->bindValue(1, $feedId);
			$players->execute();

			while($p = $players->fetch()) {
				array_push($arr, $p['username']);
			}
			shuffle($arr);

			$count = count($arr);
			$txt = "";

			if($count > 0) {
				$curtiu = in_array($username, $arr);
				$index = array_search($username, $arr);
				if($curtiu) {
					unset($arr[$index]);
					$arr = array_values($arr);
				}
				if ($count === 1) {
					if($curtiu) {
						$txt = "Você curtiu.";
					} else {
						$txt = 'Você e ' . $arr[0] . ' curtiu.';
					}
				} else if ($count === 2) {
					if($curtiu) {
						$txt = 'Você e ' . $arr[0] . ' curtiram.';
					} else {
						$txt = $arr[0] . ' e ' . $arr[1] . ' curtiram';
					}
				} else if($count === 3) {
					if($curtiu) {
						$txt = 'Você, ' . $arr[0] . ' e ' . $arr[1] . ' curtiram.';
					} else {
						$txt = $arr[0] . ', ' . $arr[1] . ' e ' . $arr[2] . ' curtiram.';
					}
				} else if($count > 3) {
					if ($curtiu) {
						$txt = 'Você, ' . $arr[0] . ', ' . $arr[1] . ', ' . $arr[2] . ($count === 4 ? ' e outra pessoa curtiu.' : ' e outras ' . ($count - 3) . ' pessoas curtiram');
					} else {
						$txt = $arr[0] . ', ' . $arr[1] . ', ' . $arr[2] . ($count === 4 ? ' e outra pessoa curtiu.' : ' e outras ' . ($count -3) . ' pessoas curtiram');
					}
				} else {
					$txt = "Seja o primeiro a curtir!";
				}
			}
		}
	}
?>