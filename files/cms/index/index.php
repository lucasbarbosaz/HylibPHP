<?php
	require_once('../../../geral.php');

	$Auth::Session('connected');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}
	

	$Template->SetParam('page_name', 'Index');
	$Template->SetParam('page_title', '' . HOTELNAME . ' - Crie sua conta, faça amigos e divirta-se gratuitamente.');
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
<!-- 		<script type="text/javascript">
		window.cookieconsent_options = {"message":"No oHabbo, nós usamos cookies para melhorar a sua experiência no nosso site. Para visitar este site, você concorda com a nossa utilização de cookies.","dismiss":"Eu concordo!","learnMore":"Leia mais","link":"/cookiepolicy","theme":"dark-bottom"};
		</script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script> -->
		<?= $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex-column">
			<div class="flex col-c-1">
				<div class="flex-column col-1">
					<form method="POST" role="form" class="lgn-area general-box flex-column margin-top-md">
						<div class="general-header-box flex">
							<div class="flex margin-auto-top-bottom margin-right-min">
								<icon name="pad"></icon>
							</div>
							<label class="white flex-column">
								<h4 class="bold">Área de login</h4>
								<h5>Faça login para jogar conosco!</h5>
							</label>
						</div>
						<div class="width-content flex inputs-login margin-bottom-min">
							<div class="identification-look"></div>
							<input type="text" name="identification" placeholder="Nome de usuário..." class="border-none">
						</div>
						<div class="width-content flex inputs-login flex">
							<div class="flex width-content">
								<icon name="lock-big"></icon>
								<input type="password" name="password" placeholder="Sua senha..." class="border-none">
							</div>
							<button type="submit" class="lgn-button green-button-1 transition-disabled margin-left-min" style="min-width: 120px;height: 45px;">
								<label class="margin-auto white">
									<h5 class="bold fs-14 uppercase">Entrar</h5>
								</label>
							</button>
						</div>
						<a style="text-decoration:none !important;" href="/forgotpass">
							<h5 class="forgotpassword">Esqueceu sua senha?</h5>
						</a>
					</form>
					<div class="margin-top-min">
						<div class="general-box padding-minm width-content">
							<div class="featured-user flex">
								<div class="featured-user-avatarimage flex">
									<icon name="medal"></icon>
									<img class="habbo-imager" src="<?= AVATARIMAGE; ?>figure=hr-115-42.hd-195-19.ch-3030-82.lg-275-1408.fa-1201.ca-1804-64&action=std&direction=2&head_direction=3&gesture=std&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<label class="gray-clear margin-auto-top-bottom padding-right-min">
									<h5 class="bold fs-14">Sem destaque...</h5>
									<h6>Nenhum usuário(a) destaque em eventos se destacou este mês.</h6>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="margin-left-min flex col-2">
					<div class="general-box register-announcement flex padding-md">
						<label class="flex-column white">
							<div class="flex-column padding-minm padding-top-none">
								<h2 class="bold uppercase">Bem-vindos!</h2>
								<h5 class="margin-top-min">O <b><?= HOTELNAME; ?></b> é um incrível mundo de pixels onde você pode criar e construir quartos da maneira que quiser com um catalogo com mobílias variadas, bater papo com outros jogadores em outros quartos, participar e ganhar de promoções dentro do hotel, jogar eventos diariamente também dentro do hotel, postar suas fotos, interagir com outros usuários(as) no fórum, ser famoso e rico(a).</h5>
							</div>
							<div class="flex margin-auto-top">
								<h6 class="margin-auto margin-right-min">Não perca tempo, registre-se agora mesmo e venha viver pessoalmente uma experiência agradável, ou não, aqui no <b><?= HOTELNAME; ?></b></h6>
								<a href="<?= URL; ?>/register" place="<?= HOTELNAME; ?> - Crie sua conta, faça amigos e divirta-se gratuitamente." class="green-button-1 transition-disabled margin-auto-top-bottom no-link" style="min-width: 150px;height: 50px;">
									<label class="margin-auto white">
										<h5 class="bold fs-14 uppercase">Criar conta</h5>
									</label>
								</a>
							</div>
						</label>
					</div>
					<div class="news-index flex-column margin-left-min">
						<?php 
							$index_articles = $db->prepare("SELECT id,title,image,shortstory FROM cms_news WHERE draft != ? ORDER BY timestamp DESC LIMIT 3");
							$index_articles->bindValue(1, 'yes');
							$index_articles->execute();

							while ($index_article = $index_articles->fetch(PDO::FETCH_ASSOC)) {
						?>
							<a href="<?= URL . '/article/' . $index_article['id']; ?>" place="<?= $index_article['title']; ?> - <?= HOTELNAME; ?>" class="article-card flex no-link" style="background-image: url('<?= $index_article['image']; ?>');">
								<label class="white padding-min margin-auto-top text-nowrap pointer-none flex-column">
									<h5 class="bold fs-14 text-nowrap margin-auto-top"><?= $index_article['title']; ?></h5>
									<h6 class="fs-12 text-nowrap"><?= $index_article['shortstory']; ?></h6>
								</label>
							</a>
						<?php } ?>
					</div>
				</div>
			</div>

			<?= $Template->AddTemplate('others', 'footer'); ?>
		</div>
	<script type="text/javascript" src="<?= CDN; ?>/cookie/js/cookie.js?2"></script>
	<script>
	jQuery().cookieInfo();
	</script>
<?= $Template->AddTemplate('others', 'bottom'); ?>
