<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	$Template->SetParam('page_id', 'halloffame/fame');
	$Template->SetParam('page_name', 'Hall of Fame');
	$Template->SetParam('page_title', 'Comunidade | Hall da Fama: Fama - ' . HOTELNAME . '');
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
					<a href="<?= URL . '/community/halloffame/fame'; ?>" place="Comunidade: Hall da Fama - <?= HOTELNAME; ?>" class="another-header-menu-option visited">
						<label>Riqueza</label>
					</a>
					<separator></separator>
					<a href="<?= URL . '/community/halloffame/achievements'; ?>" place="Comunidade: Hall da Fama - <?= HOTELNAME; ?>" class="another-header-menu-option">
						<label>Conquistas</label>
					</a>
				</div>
			</div>
		</div>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="general-box hall-of-fame credits padding-none overflow-hidden flex-column margin-right-min">
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,credits FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY credits + 0 DESC LIMIT 0,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="first-famous-habbo">
							<div class="first-famous-habbo-banner credits">
								<label>Créditos</label>
							</div>
							<div class="flex">
								<div class="first-famous-habbo-imager">
									<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=wav&direction=2&head_direction=3&gesture=std&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<div class="flex margin-auto-top-bottom width-content">
									<label class="gray flex-column margin-auto-top-bottom">
										<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
										<h6>por ter <b><?= number_format($result_hall_currency['credits']); ?></b> créditos</h6>
									</label>
									<div class="trophy flex">
										<icon name="gold-trophy"></icon>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,credits FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY credits + 0 DESC LIMIT 1,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['credits']); ?></b> créditos</h6>
								</label>
								<div class="trophy flex">
									<icon name="silver-trophy"></icon>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,credits FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY credits + 0 DESC LIMIT 2,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['credits']); ?></b> créditos</h6>
								</label>
								<div class="trophy flex">
									<icon name="bronze-trophy"></icon>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,credits FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY credits + 0 DESC LIMIT 3,7");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['credits']); ?></b> créditos</h6>
								</label>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="general-box hall-of-fame diamonds padding-none overflow-hidden flex-column margin-right-min">
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,vip_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY vip_points + 0 DESC LIMIT 0,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="first-famous-habbo">
							<div class="first-famous-habbo-banner diamonds">
								<label>Diamantes</label>
							</div>
							<div class="flex">
								<div class="first-famous-habbo-imager">
									<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=wav&direction=2&head_direction=3&gesture=std&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<div class="flex margin-auto-top-bottom width-content">
									<label class="gray flex-column margin-auto-top-bottom">
										<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
										<h6>por ter <b><?= number_format($result_hall_currency['vip_points']); ?></b> diamantes</h6>
									</label>
									<div class="trophy flex">
										<icon name="gold-trophy"></icon>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,vip_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY vip_points + 0 DESC LIMIT 1,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['vip_points']); ?></b> diamantes</h6>
								</label>
								<div class="trophy flex">
									<icon name="silver-trophy"></icon>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,vip_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY vip_points + 0 DESC LIMIT 2,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['vip_points']); ?></b> diamantes</h6>
								</label>
								<div class="trophy flex">
									<icon name="bronze-trophy"></icon>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,vip_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY vip_points + 0 DESC LIMIT 3,7");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['vip_points']); ?></b> diamantes</h6>
								</label>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="general-box hall-of-fame duckets padding-none overflow-hidden flex-column">
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,activity_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY activity_points + 0 DESC LIMIT 0,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="first-famous-habbo">
							<div class="first-famous-habbo-banner duckets">
								<label>Duckets</label>
							</div>
							<div class="flex">
								<div class="first-famous-habbo-imager">
									<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=wav&direction=2&head_direction=3&gesture=std&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<div class="flex margin-auto-top-bottom width-content">
									<label class="gray flex-column margin-auto-top-bottom">
										<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
										<h6>por ter <b><?= number_format($result_hall_currency['activity_points']); ?></b> duckets</h6>
									</label>
									<div class="trophy flex">
										<icon name="gold-trophy"></icon>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,activity_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY activity_points + 0 DESC LIMIT 1,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['activity_points']); ?></b> duckets</h6>
								</label>
								<div class="trophy flex">
									<icon name="silver-trophy"></icon>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,activity_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY activity_points + 0 DESC LIMIT 2,1");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['activity_points']); ?></b> duckets</h6>
								</label>
								<div class="trophy flex">
									<icon name="bronze-trophy"></icon>
								</div>
							</div>
						</div>
					<?php } ?>
					<?php 
						$consult_hall_currency = $db->prepare("SELECT username,figure,activity_points FROM players WHERE rank < 6 AND fame_occult = ? ORDER BY activity_points + 0 DESC LIMIT 3,7");
						$consult_hall_currency->bindValue(1, '0');
						$consult_hall_currency->execute();

						while ($result_hall_currency = $consult_hall_currency->fetch(PDO::FETCH_ASSOC)) {
					?>
						<div class="others-famous-habbo flex">
							<div class="others-famous-habbo-imager">
								<img alt="<?= $result_hall_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_hall_currency['figure']; ?>&action=std&direction=2&head_direction=2&gesture=std&size=n&img_format=png&frame=0&headonly=1">
							</div>
							<div class="flex margin-auto-top-bottom width-content">
								<label class="gray flex-column margin-auto-top-bottom">
									<h5 class="bold"><a class="no-link" href="<?= URL; ?>/profile/<?= $result_hall_currency['username']; ?>"><?= $result_hall_currency['username']; ?></a></h5>
									<h6>por ter <b><?= number_format($result_hall_currency['activity_points']); ?></b> duckets</h6>
								</label>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?= $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?= $Template->AddTemplate('others', 'bottom'); ?>