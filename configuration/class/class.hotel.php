<?php
	class Hotel {
		static function Settings($type) {
			global $db;

			$consult_setting = $db->prepare("SELECT " . $type . " FROM cms_settings WHERE id = ?");
			$consult_setting->bindValue(1, '1');
			$consult_setting->execute();

			$result_setting = $consult_setting->fetch(PDO::FETCH_ASSOC);

			return $result_setting[$type];
		}

		static function Manutention($rank = null) {
			$state = self::Settings('maintenance');

			if ($rank == 'state') {
				return $state;
			} else if ($state == 'enabled') {
				if ($rank != null) {
					if ($rank < 5) {
						session_destroy();

						Redirect(URL . '/maintenance');
					}
				} else if (isset($_SESSION['username'])) {
					session_destroy();

					Redirect(URL . '/maintenance');
				} else {
					Redirect(URL . '/maintenance');
				}
			}

			return false;
		}
	}
?>