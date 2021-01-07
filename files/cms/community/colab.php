<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	$Template->SetParam('page_id', 'staff');
	$Template->SetParam('page_name', 'Staff');
	$Template->SetParam('page_title', 'Comunidade: Equipe - ' . HOTELNAME);
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
        <div class="another-header-menu">
			<div class="webcenter">
				<div class="another-header-menu-icon" style="padding: 7px;height: 48px;">
					<icon name="help"></icon>
				</div>
				<div class="flex">
					<a href="<?= URL . '/community/staff'; ?>" place="Comunidade: Staff - <?= HOTELNAME; ?>" class="another-header-menu-option">
						<label>Staff</label>
					</a>
					<separator></separator>
					<a href="<?= URL . '/community/collaboration'; ?>" place="Comunidade: Colaboração - <?= HOTELNAME; ?>" class="another-header-menu-option visited">
						<label>Colaboradores</label>
					</a>
				</div>
			</div>
		</div>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="col-13 flex-column margin-right-min">
					<div class="general-box flex-column padding-none margin-bottom-min overflow-hidden">
						<div class="general-box-header-3 flex">
							<div class="general-box-header-3-icon">
								<icon name="duck" class="flex margin-auto"></icon>
							</div>
							<label class="gray flex-column text-nowrap">
								<h4 class="bold text-nowrap">Guardiões</h4>
								<h6 class="text-nowrap">Responsáveis pela moderação dos quartos do hotel e atendimento ao usuário.</h6>
							</label>
						</div>
						<div class="general-box-content staff flex-column bg-2">
						<?php 
							$consult_staff_role = $db->prepare("SELECT username,figure,online,motto FROM players WHERE rank = ? AND staff_occult = ?");
							$consult_staff_role->bindValue(1, '4');
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
										<h6>Faço parte da equipe do <b><?= HOTELNAME; ?></b>!</h6>
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
									<h6 class="fs-12">Parece que ninguém está ocupando esse cargo! Mas fique atento(a) para novas vagas, quem sabe você não ocupe-a.</h6>
								</label>
							</div>
						<?php } ?>
						</div>
					</div>
					<div class="general-box flex-column padding-none overflow-hidden">
						<div class="general-box-header-3 flex">
							<div class="general-box-header-3-icon">
								<icon name="duck" class="flex margin-auto"></icon>
							</div>
							<label class="gray flex-column text-nowrap">
								<h4 class="bold text-nowrap">Ajudantes</h4>
								<h6 class="text-nowrap">Responsáveis por ajudar novos usuários.</h6>
							</label>
						</div>
						<div class="general-box-content staff flex-column bg-2">
						<?php 
							$consult_staff_role = $db->prepare("SELECT username,figure,online,motto FROM players WHERE rank = ? AND staff_occult = ?");
							$consult_staff_role->bindValue(1, '3');
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
										<h6>Faço parte da equipe do <b><?= HOTELNAME; ?></b>!</h6>
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
									<h6 class="fs-12">Parece que ninguém está ocupando esse cargo! Mas fique atento(a) para novas vagas, quem sabe você não ocupe-a.</h6>
								</label>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-14 flex-column height-fit">
					<div class="general-box flex-column padding-none margin-bottom-min overflow-hidden">
						<div class="general-box-header-3 flex">
							<div class="general-box-header-3-icon">
								<icon name="duck" class="flex margin-auto"></icon>
							</div>
							<label class="gray flex-column text-nowrap">
								<h4 class="bold text-nowrap">Embaixadores</h4>
								<h6 class="text-nowrap">Responsáveis pela supervisão dos colaboradores.</h6>
							</label>
						</div>
						<div class="general-box-content staff flex-column bg-2">
						<?php 
							$consult_staff_role = $db->prepare("SELECT username,figure,online,motto FROM players WHERE rank = ? AND staff_occult = ?");
							$consult_staff_role->bindValue(1, '5');
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
										<h6>Faço parte da equipe do <b><?= HOTELNAME; ?></b>!</h6>
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
									<h6 class="fs-12">Parece que ninguém está ocupando esse cargo! Mas fique atento(a) para novas vagas, quem sabe você não ocupe-a.</h6>
								</label>
							</div>
						<?php } ?>
						</div>
					</div>
					<div class="col-14 flex-column height-fit">
						<div class="general-box flex-column padding-none margin-bottom-min overflow-hidden">
							<div class="general-box-header-3 flex bg-2">
								<div class="general-box-header-3-icon" style="border: 2px solid rgb(111 111 111);">
									<icon name="help" class="flex margin-auto"></icon>
								</div>
								<label class="gray flex-column text-nowrap">
									<h4 class="bold text-nowrap">Colaboração <?= str_replace(' Hotel', '', HOTELNAME); ?></h4>
									<h6 class="text-nowrap">Quem nós somos, o que fazemos?</h6>
								</label>
							</div>
							<div class="general-box-content staff flex-column padding-md">
								<label class="flex-column gray">
									<h5 class="margin-bottom-min">A equipe de colaboração do oHabbo, composta por Embaixadores, Guardiões e Ajudantes estão sempre prontos para auxiliar os usuários a qualquer questionamento. </h5>
									<h5 class="margin-bottom-min">Os Colaboradores também são responsáveis pela moderação dos quartos e salas de bate papo.</h5>
									<h5 class="margin-bottom-md">Então caso alguém se passe por um membro da equipe denuncie o mas rápido possível!</h5>
									<h6 class="bold fs-12">CUIDADO!</h6>
									<h6>Nenhum Colaborador, assim como Staff, irá pedir a sua senha. Caso isso aconteça, denuncie a um Staff.</h6>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?php $Template->AddTemplate('others', 'bottom'); ?>