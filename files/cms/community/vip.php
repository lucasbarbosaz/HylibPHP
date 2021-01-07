<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	$Template->SetParam('page_id', 'vip');
	$Template->SetParam('page_name', 'vip');
	$Template->SetParam('page_title', 'Comunidade: VIP - ' . HOTELNAME);
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', voc� pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus pr�prios jogos, ser famoso, bater-papo, decorar e criar quartos incr�veis com uma imensid�o de mob�lias dispon�veis no nosso cat�logo. Tudo isso, e muito mais, voc� encontrar aqui GRATUITAMENTE, o que est� esperando para se registar neste incr�vel universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="col-13 flex-column margin-right-min">
					<div class="general-box flex-column padding-none overflow-hidden">
						<div class="general-box-header-3 flex">
							<div class="general-box-header-3-icon">
								<icon name="duck" class="flex margin-auto"></icon>
							</div>
							<label class="gray flex-column text-nowrap">
								<h4 class="bold text-nowrap">VIP</h4>
								<h6 class="text-nowrap">Usuários VIP do oHabbo Hotel.</h6>
							</label>
						</div>
						<div class="general-box-content staff flex-column bg-2">
						<?php 
							$consult_staff_role = $db->prepare("SELECT username,figure,online,motto FROM players WHERE rank = ? AND staff_occult = ?");
							$consult_staff_role->bindValue(1, '2');
							$consult_staff_role->bindValue(2, '0');
							$consult_staff_role->execute();

							if ($consult_staff_role->rowCount() > 0) {
								while ($result_staff_role = $consult_staff_role->fetch(PDO::FETCH_ASSOC)) {
						?>
							<div class="display-staff-box flex">
								<div class="display-staff-box-imager">
									<img alt="<?= $result_staff_role['username']; ?> - <?= HOTELNAME; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_staff_role['figure']; ?>&headonly=0&size=n&gesture=sml&direction=2&head_direction=3&action=wav">
								</div>
								<label class="flex-column gray margin-auto-top-bottom margin-right-min">
									<h5 class="bold fs-14 flex">
										<a href="<?= URL . '/profile/' . $result_staff_role['username']; ?>" place="Perfil: <?= $result_staff_role['username']; ?> - <?= HOTELNAME; ?>" class="no-link"><?= $result_staff_role['username']; ?></a>&nbsp;
										<span class="online-status" enum="<?= $result_staff_role['online']; ?>"></span>
									</h5>
									<?php if ($result_staff_role['motto'] != NULL || $result_staff_role['motto'] != '') { ?>
										<h6><?= $Function::Filter('xss', utf8_encode(utf8_decode($result_staff_role['motto']))); ?></h6>
									<?php } else { ?>
										<h6>Sou VIP do <b><?= HOTELNAME; ?></b>!</h6>
									<?php } ?>
								</label>
							</div>
						<?php 
								} 
							} else { 
						?>
							<div class="display-staff-box flex padding-max">
								<label class="gray">
									<h5 class="bold fs-14">OH BOBBA?!</h5>
									<h6 class="fs-12">Parece que ninguém está ocupando esse cargo! Compre vip clicando <a target="_blank"  class="no-link" href="/store/vip">aqui</a>.</h6>
								</label>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-14 flex-column height-fit">
					<div class="col-14 flex-column height-fit">
						<div class="general-box flex-column padding-none margin-bottom-min overflow-hidden">
							<div class="general-box-header-3 flex bg-2">
								<div class="general-box-header-3-icon" style="border: 2px solid rgb(111 111 111);">
									<icon name="help" class="flex margin-auto"></icon>
								</div>
								<label class="gray flex-column text-nowrap">
									<h4 class="bold text-nowrap"><?= utf8_encode("VIP");?> <?= str_replace(' Hotel', '', HOTELNAME); ?></h4>
									<h6 class="text-nowrap">Quem são os VIP's?</h6>
								</label>
							</div>
							<div class="general-box-content staff flex-column padding-md">
								<label class="flex-column gray">
									<h5 class="margin-bottom-min">Os usuários VIP são os mais famosos e conhecidos da comunidade. Com seus vastos benefícios, os VIPs sabem muito bem como aproveitar sua estadia no oHabbo. </h5>
									<h6 class="bold fs-12">ATENÇÃO!</h6>
									<h6 class="margin-bottom-min">Os usuários VIP's também devem seguir a nossa etiqueta, assim como todos os usuários.</h6>
									<h6>Para comprar vip, clique <a target="_blank" class="no-link" href="/store/vip">aqui</a>.</h6>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?php $Template->AddTemplate('others', 'bottom'); ?>