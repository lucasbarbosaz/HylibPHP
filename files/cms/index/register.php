<?php 
	require_once('../../../geral.php');
	
	$Auth::Session('connected');



	$Template->SetParam('page_name', 'Registro');
	$Template->SetParam('page_title', '' . HOTELNAME . ' - Crie sua conta, faça amigos e divirta-se gratuitamente.');
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="col-3 flex-column">
					<div class="general-box register-area margin-top-md height-auto">
						<div class="general-header-box flex">
							<div class="flex margin-auto-top-bottom margin-right-min">
								<icon name="search"></icon>
							</div>
							<label class="white flex-column">
								<h4 class="bold">Registre-se agora</h4>
								<h5>Junte-se a nós hoje!</h5>
							</label>
						</div>
						<form method="POST" class="padding-minm padding-top-none register-form">
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Escolha seu nome de usuário sabiamente, <b>não toleramos vulgaridades em nomes de usuários!</b><br><br>E o seu nome, também, deve ter entre <b>4 e 15 letras e sem caracteres especiais</b>.</h6>
								</label>
								<div class="register-inputs width-content flex">
									<icon name="head-mini"></icon>
									<input type="text" name="username" placeholder="Nome de usuário(a)" data-input="username" id="username">
									<div class="reg-status username pointer-none"></div>
								</div>										
							</div>
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Certifique-se de utilizar um e-mail <b>válido</b> e <b>verdadeiro</b>, pois caso necessário para recuperação de senhas, entrar em contato e dentre outro, entraremos em contato pelo mesmo.</h6>
								</label>
								<div class="register-inputs width-content flex">
									<icon name="email"></icon>
									<input type="text" name="email" placeholder="Endereço de e-mail" data-input="email" id="email">
									<div class="reg-status email pointer-none"></div>
								</div>
							</div>
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Segurança nunca é demais! Utilize <b>uma senha segura</b> e fácil de você lembrar, outra opção é <b>aceitar sugestões de senhas pelo seu próprio navegador</b>, a senha fica salva nele ao fazer login, facilitando mais e te deixando seguro(a).</h6>
								</label>
								<div class="register-inputs width-content flex">
									<icon name="lock-2"></icon>
									<input type="password" name="password" placeholder="Senha" data-input="password">
									<div class="reg-status password pointer-none"></div>
								</div>
							</div>
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Sua data de nascimento. <b>(Recomeandado para maiores de 13 anos)</b></h6>
								</label>
								<div class="register-inputs">
									<div class="flex reg-birthday">
										<icon name="head" class="margin-right-md margin-auto-top-bottom margin-left-min"></icon>
										<div class="flex width-content">
											<select name="birthday" class="days margin-right-min">
												<option value="DD" selected disabled>Dia</option>
											</select>
											<select name="birthmonth" class="months margin-right-min">
												<option value="MM" selected disabled>Mês</option>
											</select>
											<select name="birthyear" class="years">
												<option value="YYYY" selected disabled>Ano</option>
											</select>
										</div>
									</div>
									<div class="reg-status birthday pointer-none"></div>
								</div>
							</div>
							<label class="gray">
								<h6>Além de ser <b>obrigatório</b>, a <b>escolha de sexo</b> é essêncial para que ao você se registrar você possa receber o seu cafofo bem decorado e um presente bem legal, além de também identificar o seu gênero de acordo com a sua escolha.</h6>
							</label>
							<div class="flex margin-top-min">
								<div class="flex width-content">
									<div class="margin-right-minm flex reg-gender">
										<input type="radio" name="gender" value="female" id="gender-female" class="display-none" checked>
										<label for="gender-female" class="flex cursor-pointer width-content">
											<div class="gender-female-option pointer-none">
												<div class="flex">
													<icon name="female"></icon>
													<h6 class="margin-auto-top-bottom">Sexo feminino</h6>
												</div>
											</div>
										</label>
									</div>
									<div class="margin-left-minm flex reg-gender">
										<input type="radio" name="gender" value="male" id="gender-male" class="display-none">
										<label for="gender-male" class="flex cursor-pointer width-content">
											<div class="gender-male-option pointer-none">
												<div class="flex">
													<icon name="male"></icon>
													<h6 class="margin-auto-top-bottom">Sexo masculino</h6>
												</div>
											</div>
										</label>
									</div>
								</div>
								<div class="flex-column col-6 margin-left-min">
									<div class="result-register-card flex">
										<div class="habbo-result default"></div>
										<label class="white flex-column text-nowrap">
											<h4 class="bold text-nowrap">Seu nome aqui!</h4>
											<h6 class="margin-auto-top margin-bottom-minm text-nowrap">Vamos embarcar?</h6>
										</label>
									</div>
									
									<div class="reg-recaptcha margin-top-min">
										<div class="g-recaptcha" data-sitekey="<?= $Hotel::Settings('recaptcha'); ?>" data-expired-callback="RecaptchaExpired"></div>
									</div>

									<div class="margin-top-min">
										<button type="submit" name="submit-reg" class="green-button-1" style="width: 100%; height: 48px">
											<label class="margin-auto white">
												<h4 class="bold">Vamos nessa!</h4>
											</label>
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="flex-column margin-left-max margin-top-max col-5">
					<label class="gray flex-column">
						<h2 class="bold margin-bottom-min">Venha conhecer o <?= HOTELNAME; ?>!</h2>
						<div class="flex margin-auto-bottom">
							<h5 class="fs-14">O <b><?= HOTELNAME; ?></b> é um comunidade virtua de pixels onde você pode criar seu próprio avatar, fazer muitos amigos, bater-papo com diversos usuários e usuárias do nosso hotel, construir e decorar seus próprios quartos, criar seus próprios jogos ou jogar os de outros usuários e muitos mais...</h5>
							<img class="margin-auto-top-bottom" style="min-width:200px" height="123px" src="https://images.habbo.com/c_images/WhatIsHabbo/ill_17.png">
						</div>
						<div class="flex margin-top-md">
							<img class="margin-auto-top-bottom" style="min-width:200px" height="171px" src="https://images.habbo.com/c_images/WhatIsHabbo/ill_16.png">
							<h5 class="text-right fs-14">Criatividade e originalidade são super bem-vindas no <b><?= HOTELNAME; ?></b>! Toda semana temos várias competições novas para você participar. De competições de quarto, atividades legais onde você pode expressar todos os seus dons artísticos e criativos e, ainda por cima, ganhar conquistas e prêmios! Bateu a inspiração? Dê uma olhada nas nossas <b>notícias</b> para ficar por dentro das últimas atividades e competições da semana!</h5>
						</div>
						<div class="flex margin-auto-top">
							<h5 class="fs-14">Você adora bater papo e encontrar os seus amigos? os <b>Haibbo Grupos, Fórums e comunidades de RPG</b> são ótimas opções para você. Entre no exército e assuma seus deveres, monte a sua própria escola e decida você mesmo o que estudar, e arrase na passarela ou corra para a emergência e comece a salvar vidas pixeladas.</h5>
							<img class="margin-auto-top-bottom" style="min-width:198px" height="157px" src="<?= CDN; ?>/assets/img/custom/comments.png">
						</div>
					</label>
				</div>
			</div>
			<?php $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?php $Template->AddTemplate('others', 'bottom'); ?>