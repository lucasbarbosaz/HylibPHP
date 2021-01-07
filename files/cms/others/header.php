<?php 
	require_once('../../../geral.php');

	global $db;

	if (isset($_SESSION['username'])) {
?>
<div class="header-nav-menu margin-bottom-min">
					<div class="webcenter">
						<div class="header-menu-options flex-wrap">
							<li class="header-menu dropdown">
								<label class="dropbtn <?php if ($page_id == 'me') { ?>visited<?php } ?>">
									<h5 class="no-select"><?= USERNAME; ?></h5>
								</label>
								<ul class="dropdown-content">
									<a href="<?= URL; ?>/me" place="Principal: <?= USERNAME; ?> - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Me') { ?>visited<?php } ?>">
										<h5 class="no-select">Minha página</h5>
									</a>
									<a href="<?= URL . '/profile/' . USERNAME; ?>" place="Perfil: <?= USERNAME; ?> - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Profile') { ?>visited<?php } ?>">
										<h5 class="no-select">Meu perfil</h5>
									</a>
									<!-- <div class="list-content">
										<h5 class="no-select">Configurações</h5>
									</div> -->
									<a href="logout" class="list-content">
										<h5 class="no-select">Sair</h5>
									</a>
								</ul>
							</li>
							<li class="header-menu dropdown">
								<label class="dropbtn">
									<h5 class="no-select">Jornalismo</h5>
								</label>
								<div class="dropdown-content">
								<?php
								$consult_last_article = $db->prepare("SELECT id,title FROM cms_news ORDER BY timestamp DESC LIMIT 1");
								$consult_last_article->execute();

								while ($result_last_article = $consult_last_article->fetch(PDO::FETCH_ASSOC)) {
								?>
								<a href="<?= URL . "/article/" . $result_last_article['id']; ?>" place="<?= "Noticia: " . $result_last_article['title'] . " - " . HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Article') { ?>visited<?php } ?>">
									<h5 class="no-select">Ultima Notícia</h5>
								</a>
								<?php } ?>
								<a href="<?= URL . '/article/2'; ?>" place="Noticia: Promoções Ativas  - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Article') { ?>visited<?php } ?>">
										<h5 class="no-select">Promoções Ativas</h5>
								</a>
								<a href="<?= URL . '/article/4'; ?>" place="Noticia: Padrão de Qualidade  - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Article') { ?>visited<?php } ?>">
									<h5 class="no-select">Padrão de Qualidade</h5>
								</a>
								<a href="<?= URL . '/article/1'; ?>" place="Noticia: Premiação em Eventos  - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Article') { ?>visited<?php } ?>">
									<h5 class="no-select">Premiação em Eventos</h5>
								</a>
								</div>
							</li>
							<li class="header-menu dropdown">
								<label class="dropbtn <?php if ($page_id == 'community') { ?> visited<?php } ?>">
									<h5 class="no-select">Comunidade</h5>
								</label>
								<div class="dropdown-content">
									<a href="<?= URL . '/community/halloffame'; ?>" place="Comunidade: Hall da Fama  - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Hall of Fame') { ?>visited<?php } ?>">
										<h5 class="no-select">Hall da Fama</h5>
									</a>
									<a href="<?= URL . '/community/staff'; ?>" place="Comunidade: Equipe  - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'Staff') { ?>visited<?php } ?>">
										<h5 class="no-select">Equipe</h5>
									</a>
									<a href="<?= URL . '/community/vip'; ?>" place="Comunidade: VIP  - <?= HOTELNAME; ?>" class="list-content <?php if ($page_name == 'vip') { ?>visited<?php } ?>">
										<h5 class="no-select">VIP's</h5>
									</a>
									<!-- <div class="list-content">
										<h5 class="no-select">Rádio</h5>
									</div>
									<div class="list-content">
										<h5 class="no-select">Fórum</h5>
									</div> -->
								</div>
							</li>
							<li class="header-menu">
								<a target="_blank" href="/store/vip" class="dropbtn <?php if ($page_name == 'Store') { ?> visited<?php } ?>">
									<h5 class="no-select">Loja</h5>
								</a>
								<!-- <div class="dropdown-content">
									<div class="list-content">
										<h5 class="no-select">Pacotes</h5>
									</div>
									<div class="list-content">
										<h5 class="no-select">VIP</h5>
									</div>
									<div class="list-content">
										<h5 class="no-select">Esmeraldas</h5>
									</div>
									<div class="list-content">
										<h5 class="no-select">Confirmar Pag.</h5>
									</div>
								</div> -->
							</li>
						</div>
					</div>
				</div>
<?php } else { ?>
<div class="webcenter flex">
					<div class="margin-bottom-min margin-top-min width-content">
						<div class="general-box hotel-big-msg flex width-content">
							<icon name="hotel-big" class="margin-right-min"></icon>
							<h5 class="gray-clear margin-auto-top-bottom">Olá, muito bom ver você por aqui, atualmente temos <b class="lowercase"><?= Functions::Onlines(); ?></b>, que tal se juntar a todos e desfrutar do que preparamos para você?</h5>
						</div>
					</div>
				</div>
<?php } ?>
