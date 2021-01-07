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
								<h4 class="bold">Register now</h4>
								<h5>Join us today!</h5>
							</label>
						</div>
						<form method="POST" class="padding-minm padding-top-none register-form">
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Choose your username wisely, <b>we do not tolerate vulgarities in usernames!</b><br><br>And your name, too, must be between <b>4 and 15 letters and no special characters</b>.</h6>
								</label>
								<div class="register-inputs width-content flex">
									<icon name="head-mini"></icon>
									<input type="text" name="username" placeholder="You username" data-input="username" id="username">
									<div class="reg-status username pointer-none"></div>
								</div>										
							</div>
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Be sure to use an email <b>valid</b> and <b>true</b> because if necessary for password recovery, contact and among others, we will contact you.</h6>
								</label>
								<div class="register-inputs width-content flex">
									<icon name="email"></icon>
									<input type="text" name="email" placeholder="Your e-mail" data-input="email" id="email">
									<div class="reg-status email pointer-none"></div>
								</div>
							</div>
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Security is never too much! Use <b>a secure password</b> and easy to remember, another option is to <b>accept password suggestions by your own browser</b>, the password is saved on it when logging in, making it easier and making you safe.</h6>
								</label>
								<div class="register-inputs width-content flex">
									<icon name="lock-2"></icon>
									<input type="password" name="password" placeholder="Your Password" data-input="password">
									<div class="reg-status password pointer-none"></div>
								</div>
							</div>
							<div class="flex-column margin-bottom-min">
								<label class="gray margin-bottom-minm">
									<h6>Your date of birth. <b> (Restarted for over 13 years)</b>></h6>
								</label>
								<div class="register-inputs">
									<div class="flex reg-birthday">
										<icon name="head" class="margin-right-md margin-auto-top-bottom margin-left-min"></icon>
										<div class="flex width-content">
											<select name="birthday" class="days margin-right-min">
												<option value="DD" selected disabled>Day</option>
											</select>
											<select name="birthmonth" class="months margin-right-min">
												<option value="MM" selected disabled>Month</option>
											</select>
											<select name="birthyear" class="years">
												<option value="YYYY" selected disabled>Year</option>
											</select>
										</div>
									</div>
									<div class="reg-status birthday pointer-none"></div>
								</div>
							</div>
							<label class="gray">
								<h6>In addition to being <b>mandatory</b>, the <b>gender choice</b> is essential so that when you register you can receive your well decorated cafofo and a nice gift, in addition to also identifying your gender according to your choice.</h6>
							</label>
							<div class="flex margin-top-min">
								<div class="flex width-content">
									<div class="margin-right-minm flex reg-gender">
										<input type="radio" name="gender" value="female" id="gender-female" class="display-none" checked>
										<label for="gender-female" class="flex cursor-pointer width-content">
											<div class="gender-female-option pointer-none">
												<div class="flex">
													<icon name="female"></icon>
													<h6 class="margin-auto-top-bottom">Gender Woman</h6>
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
													<h6 class="margin-auto-top-bottom">Gender Male</h6>
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
							<h5 class="fs-14">O <b><?= HOTELNAME; ?></b> is a virtua community of pixels where you can create your own avatar, make many friends, chat with various users and users of our hotel, build and decorate your own rooms, create your own games or play those of other users and many more...</h5>
							<img class="margin-auto-top-bottom" style="min-width:200px" height="123px" src="https://images.habbo.com/c_images/WhatIsHabbo/ill_17.png">
						</div>
						<div class="flex margin-top-md">
							<img class="margin-auto-top-bottom" style="min-width:200px" height="171px" src="https://images.habbo.com/c_images/WhatIsHabbo/ill_16.png">
							<h5 class="text-right fs-14">Creativity and originality are super welcome in <b><?= HOTELNAME; ?></b>! Every week we have several new competitions for you to participate in. From bedroom competitions, cool activities where you can express all your artistic and creative gifts and, on top of that, win achievements and prizes! Did you hit the inspiration? Take a look at our <b> news</b> to stay on top of the latest activities and competitions of the week!</h5>
						</div>
						<div class="flex margin-auto-top">
							<h5 class="fs-14">Do you love chatting and meeting your friends? The <b>Haibbo Groups, Forums and RPG communities</b> are great options for you. Enter the army and take on your duties, set up your own school and decide for yourself what to study, and rock the catwalk or run to the emergency room and start saving pixelated lives.</h5>
							<img class="margin-auto-top-bottom" style="min-width:198px" height="157px" src="<?= CDN; ?>/assets/img/custom/comments.png">
						</div>
					</label>
				</div>
			</div>
			<?php $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?php $Template->AddTemplate('others', 'bottom'); ?>
