<?php
class Email {
	static function verifyEmail() {
		global $db;
		if(isset($_POST['env']) && $_POST['env'] == "form") {
			$email = addslashes($_POST['email']);
			$sql = $db->prepare("SELECT * FROM players WHERE mail = ?");
			$sql->bindValue(1, $email);
			$sql->execute();
			$get = $sql->fetch(PDO::FETCH_ASSOC);
			$total = $get->rowCount();

			if($total > 0) {
				sendEmail($get['mail']);
			} else {
				echo "nao tem";
			}
		}
	}

	static function sendEmail($email) {
		global $db;
		echo $email;
	}
}
?>