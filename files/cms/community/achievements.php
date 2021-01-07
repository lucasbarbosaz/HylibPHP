<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	$Template->SetParam('page_id', 'halloffame/achievements');
	$Template->SetParam('page_name', 'Hall of Fame');
	$Template->SetParam('page_title', 'Comunidade | Hall da Fama: Conquistas - ' . HOTELNAME . '');
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="another-header-menu">
			<div class="webcenter">
				<div class="another-header-menu-icon">
					<icon name="fame"></icon>
				</div>
				<div class="flex">
					<a href="<?= URL . '/community/halloffame/fame'; ?>" place="Comunidade: Hall da Fama - <?= HOTELNAME; ?>" class="another-header-menu-option">
						<label>Riqueza</label>
					</a>
					<separator></separator>
					<a href="<?= URL . '/community/halloffame/achievements'; ?>" place="Comunidade: Hall da Fama - <?= HOTELNAME; ?>" class="another-header-menu-option visited">
						<label>Conquistas</label>
					</a>
				</div>
			</div>
		</div>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="general-box hall-of-fame events padding-none overflow-hidden flex-column margin-right-min">
					<?php 
						$consult_achievements_events = $db->prepare("SELECT username,figure,event_points FROM players WHERE fame_occult = ? AND rank < ? ORDER BY event_points + 0 DESC LIMIT 0,1");
						$consult_achievements_events->bindValue(1, '0');
						$consult_achievements_events->bindValue(2, '5');
						$consult_achievements_events->execute();

						while ($result_achievements_events = $consult_achievements_events->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="first-famous-habbo">
							<div class="first-famous-habbo-banner events">
								<label>Eventos</label>
							</div>
							<div class="flex">
								<div class="first-famous-habbo-imager">
									<img alt="<?= $result_achievements_events['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_events['figure']; ?>&action=wav&direction=2&head_direction=3&gesture=std&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<div class="flex margin-auto-top-bottom width-content">
									<label class="gray flex-column margin-auto-top-bottom">
										<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_events['username']; ?>" place="Perfil: <?= $result_achievements_events['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_events['username']; ?></a></h5>
										<h6>por ganhar <b><?= number_format($result_achievements_events['event_points']); ?></b> eventos</h6>
									</label>
									<div class="trophy flex">
										<icon name="gold-trophy"></icon>
									</div>
								</div>
							</div>
						</div>
					<?php 
						}

						$consult_achievements_events = $db->prepare("SELECT username,figure,event_points FROM players WHERE fame_occult = ? AND rank < ? ORDER BY event_points + 0 DESC LIMIT 1,1");
						$consult_achievements_events->bindValue(1, '0');
						$consult_achievements_events->bindValue(2, '5');
						$consult_achievements_events->execute();

						while ($result_achievements_events = $consult_achievements_events->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_achievements_events['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_events['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_events['username']; ?>" place="Perfil: <?= $result_achievements_events['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_events['username']; ?></a></h5>
									<h6>por ganhar <b><?= number_format($result_achievements_events['event_points']); ?></b> eventos</h6>
								</label>
								<div class="trophy flex">
									<icon name="silver-trophy"></icon>
								</div>
							</div>
						</div>
					<?php 
						}

						$consult_achievements_events = $db->prepare("SELECT username,figure,event_points FROM players WHERE fame_occult = ? AND rank < ? ORDER BY event_points + 0 DESC LIMIT 2,1");
						$consult_achievements_events->bindValue(1, '0');
						$consult_achievements_events->bindValue(2, '5');
						$consult_achievements_events->execute();

						while ($result_achievements_events = $consult_achievements_events->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_achievements_events['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_events['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_events['username']; ?>" place="Perfil: <?= $result_achievements_events['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_events['username']; ?></a></h5>
									<h6>por ganhar <b><?= number_format($result_achievements_events['event_points']); ?></b> eventos</h6>
								</label>
								<div class="trophy flex">
									<icon name="bronze-trophy"></icon>
								</div>
							</div>
						</div>
					<?php }

					$consult_achievements_events = $db->prepare("SELECT username,figure,event_points FROM players WHERE fame_occult = ? AND rank < ? ORDER BY event_points + 0 DESC LIMIT 3,2");
					$consult_achievements_events->bindValue(1, '0');
					$consult_achievements_events->bindValue(2, '5');
					$consult_achievements_events->execute();

					while ($result_achievements_events = $consult_achievements_events->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_achievements_events['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_events['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_events['username']; ?>" place="Perfil: <?= $result_achievements_events['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_events['username']; ?></a></h5>
									<h6>por ganhar <b><?= number_format($result_achievements_events['event_points']); ?></b> eventos</h6>
								</label>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="general-box hall-of-fame promotions padding-none overflow-hidden flex-column margin-right-min">
					<?php 
						$consult_achievements_promotions = $db->prepare("SELECT username,figure,promotions FROM players WHERE fame_occult = ? AND rank < ? ORDER BY promotions + 0 DESC LIMIT 0,1");
						$consult_achievements_promotions->bindValue(1, '0');
						$consult_achievements_promotions->bindValue(2, '5');
						$consult_achievements_promotions->execute();

						while ($result_achievements_promotions = $consult_achievements_promotions->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="first-famous-habbo">
							<div class="first-famous-habbo-banner promotions">
								<label>Promoções</label>
							</div>
							<div class="flex">
								<div class="first-famous-habbo-imager">
									<img alt="<?= $result_achievements_promotions['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_promotions['figure']; ?>&action=wav&direction=2&head_direction=3&gesture=std&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<div class="flex margin-auto-top-bottom width-content">
									<label class="gray flex-column margin-auto-top-bottom">
										<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_promotions['username']; ?>" place="Perfil: <?= $result_achievements_promotions['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_promotions['username']; ?></a></h5>
										<h6>por ganhar <b><?= number_format($result_achievements_promotions['promotions']); ?></b> promoções</h6>
									</label>
									<div class="trophy flex">
										<icon name="gold-trophy"></icon>
									</div>
								</div>
							</div>
						</div>
					<?php }

					$consult_achievements_promotions = $db->prepare("SELECT username,figure,promotions FROM players WHERE fame_occult = ? AND rank < ? ORDER BY promotions + 0 DESC LIMIT 1,1");
					$consult_achievements_promotions->bindValue(1, '0');
					$consult_achievements_promotions->bindValue(2, '5');
					$consult_achievements_promotions->execute();

					while ($result_achievements_promotions = $consult_achievements_promotions->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_achievements_promotions['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_promotions['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_promotions['username']; ?>" place="Perfil: <?= $result_achievements_promotions['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_promotions['username']; ?></a></h5>
									<h6>por ganhar <b><?= number_format($result_achievements_promotions['promotions']); ?></b> promoções</h6>
								</label>
								<div class="trophy flex">
									<icon name="silver-trophy"></icon>
								</div>
							</div>
						</div>
					<?php }

					$consult_achievements_promotions = $db->prepare("SELECT username,figure,promotions FROM players WHERE fame_occult = ? AND rank < ? ORDER BY promotions + 0 DESC LIMIT 2,1");
					$consult_achievements_promotions->bindValue(1, '0');
					$consult_achievements_promotions->bindValue(2, '5');
					$consult_achievements_promotions->execute();

					while ($result_achievements_promotions = $consult_achievements_promotions->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_achievements_promotions['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_promotions['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_promotions['username']; ?>" place="Perfil: <?= $result_achievements_promotions['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_promotions['username']; ?></a></h5>
									<h6>por ganhar <b><?= number_format($result_achievements_promotions['promotions']); ?></b> promoções</h6>
								</label>
								<div class="trophy flex">
									<icon name="bronze-trophy"></icon>
								</div>
							</div>
						</div>
					<?php }

					$consult_achievements_promotions = $db->prepare("SELECT username,figure,promotions FROM players WHERE fame_occult = ? AND rank < ? ORDER BY promotions + 0 DESC LIMIT 3,2");
					$consult_achievements_promotions->bindValue(1, '0');
					$consult_achievements_promotions->bindValue(2, '5');
					$consult_achievements_promotions->execute();

					while ($result_achievements_promotions = $consult_achievements_promotions->fetch(PDO::FETCH_ASSOC)) {
						?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_achievements_promotions['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_achievements_promotions['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a href="<?= URL . '/profile/' . $result_achievements_promotions['username']; ?>" place="Perfil: <?= $result_achievements_promotions['username'] . ' - ' . HOTELNAME; ?>" class="no-link"><?= $result_achievements_promotions['username']; ?></a></h5>
									<h6>por ganhar <b><?= number_format($result_achievements_promotions['promotions']); ?></b> promoções</h6>
								</label>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="general-box padding-max overflow-hidden flex-column margin-right-min height-content">
					<label class="gray">
						<h5>O Hall da Fama de <b>conquistas</b> foi criado com intuito de promover os melhores jogadores de eventos ou os mais empenhados em ganhar promoções onde você tem a chance de ficar entre os 5 usuários que fazem mais pontos em eventos ou que participaram e ganharam promoções!<br><br>Ao final de todo mês este hall da fama é resetado, assim dando uma nova chance para que as outras pessoas possam aparecer por aqui, sem contar que após ser resetado os usuários que ficaram no pódio (5 lugares) ganharam prêmios sendo eles rubis, gemas, emblemas ou até raros. Não perca essa chance e participe dos eventos e ganhe promoções para receber prêmios e ficar famoso!</h5>
					</label>
					<button class="green-button-1 margin-top-md" style="width: 100%;height: 45px;margin-bottom: 2px">
						<label class="margin-auto white">Saber mais</label>
					</button>
				</div>
			</div>
			<?= $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?= $Template->AddTemplate('others', 'bottom'); ?>