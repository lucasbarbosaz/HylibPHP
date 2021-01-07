<?php
	require_once('../../../geral.php');

	$Auth::Session('connected');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	if(isset($_POST['email'])) {
		$email = $Function::Validate('email', $_POST['email']);

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error[] = "E-mail inválido";
		}

		$verifyEmail = $db->prepare("SELECT * FROM players WHERE mail = ?");
		$verifyEmail->bindValue(1, $email);
		$verifyEmail->execute();
		$resultEmail = $verifyEmail->fetch(PDO::FETCH_ASSOC);
		$checkEmail = $verifyEmail->rowCount();

		if($checkEmail == '0') {
			$error[] = "E-mail não encontrado";
		}

			if(count($error)) {

				$newPasword = substr(md5(time()), 0, 8);
				$nsCriptogragada = password_hash($newPasword, PASSWORD_BCRYPT);

				if(mail($email, "Sua nova senha", "Você acaba de solicitar uma nova senha para sua conta no oHabbo. Sua nova senha: " . $newPasword)) {

					$updatePassword = $db->prepare("UPDATE players SET password = ? WHERE mail = ?");
					$updatePassword->bindValue(1, $nsCriptogragada);
					$updatePassword->bindValue(2, $email);
					$updatePassword->execute();

				}

			}


		}

	$Template->SetParam('page_name', 'Index');
	$Template->SetParam('page_title', '' . HOTELNAME . ' - Recupere sua senha.');
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?= $Template->AddTemplate('others', 'header'); ?>

		<div class="webcenter flex-column">
        	<div class="flex">
					<div class="col-7">
        				<div class="col-9 flex margin-top-min margin-right">
							<form method="POST" role="form" class="feed-post-area general-box flex-column margin-top-md">
								<div class="general-header-box flex">
									<div class="flex margin-auto-top-bottom margin-right-min">
										<icon name="ipad-lock"></icon>
									</div>
									<style>
									    input::placeholder {
									        color:white;
									        font-size:12px;
									    }
									</style>
									<label class="white flex-column">
										<h4 class="bold">Recupere sua senha!</h4>
										<h5>Preencha o campo abaixo para recuperar a sua senha!</h5>
									</label>
                    		    </div>		
								<div class="width-content flex inputs-login flex">
									<div class="flex width-content">
										<icon name="ballon-mail"></icon>
										<input type="email" name="email" placeholder="Seu email utilizado na conta que você quer recuperar a senha..." 		class="border-none" required>
										<input type="hidden" name="env" value="form">
									</div>
									<button type="submit" class="lgn-button green-button-1 transition-disabled margin-left-min" style="min-width: 120px		;height: 45px;">
										<label class="margin-auto white">
											<h5 class="bold fs-14 uppercase">Enviar</h5>
										</label>
									</button>
								</div>
							</form>
						</div>
    				</div>
    				<div class="col-10">
    					<div class="col-lyor flex margin-top-min margin-right">
    						<div class="feed-post-area general-box flex-column margin-top-md">
								<div class="general-header-box flex">
									<div class="flex margin-auto-top-bottom margin-right-min">
										<icon name="help"></icon>
									</div>
									<label class="white flex-column">
										<h4 class="bold">Lembrou a senha?</h4>
									</label>
                    		    </div>		
								<div class="width-content flex" style="color:rgb(153 153 151);">
									Lembrou da sua senha? Sem problemas, parece que sua memória não está tão ruim assim, volte e faça login.
									<button onclick="window.history.go(-1); return false;" class="lgn-button green-button-1 transition-disabled margin-left-min" style="min-width:120px;height:45px;">
										<label class="margin-auto white">
											<h5 class="bold fs-14 uppercase">Voltar</h5>
										</label>
									</button>
								</div>
							</div>
						</div>
    				</div>
			</div>
			<?= $Template->AddTemplate('others', 'footer-forgot'); ?>
		</div>
<?= $Template->AddTemplate('others', 'bottom'); ?>