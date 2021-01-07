<?php
	class MyPDO extends PDO {
		private $hostname = "localhost";
		private $database = "crazzy_ohabbo";
		private $username = "root";
		private $password = "";

		public static $pdo;

		public function __construct() {
			try {
				self::$pdo = new \PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->database, $this->username, $this->password, [
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
					\PDO::ATTR_PERSISTENT => true,
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
				]);

				return self::$pdo;
			} catch (PDOException $e) {
				echo "ERROR: " . $e->getMessage();

				die();
			}
		}

		public function connection() {
			return self::$pdo;
		}
	}
?>