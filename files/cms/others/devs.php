<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	$Template->SetParam('page_id', 'staff');
	$Template->SetParam('page_name', 'Developers');
	$Template->SetParam('page_title', 'Hylib: Equipe Desenvolvedora - ' . HOTELNAME);
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="col-13 flex-column margin-right-min">
					<div class="general-box flex-column padding-none margin-bottom-min overflow-hidden">
						<div class="general-box-header-3 flex">
							<div class="general-box-header-3-icon">
								<icon name="badge-ceo" class="flex margin-auto"></icon>
							</div>
							<label class="gray flex-column text-nowrap">
								<h4 class="bold text-nowrap">Desenvolvedores</h4>
								<h6 class="text-nowrap">Responsáveis pelo desenvolvimento da HylibCMS</h6>
							</label>
						</div>
						<div class="general-box-content staff flex-column bg-2">
						<!--  -->
						<div class="display-dev-box-2 flex">
							<div class="display-staff-box-imager">
								<img src="<?= AVATARIMAGE; ?>figure=hr-828-39.hd-180-2.lg-281-64.sh-295-62.ch-235-62&headonly=0&size=n&gesture=sml&direction=2&head_direction=3&action=wav">
							</div>
							<label class="flex-column gray margin-auto-top-bottom margin-right-min">
								<h5 class="bold fs-14 flex">
									<a href="javascript:void(0)" class="no-link">Lyor</a>
								</h5>
								<h6>Novo Front-End</h6>
							</label>
						</div>
						<!--  -->
						<div class="display-dev-box flex">
								<div class="display-staff-box-imager">
									<img src="<?= AVATARIMAGE; ?>figure=hr-828-39.hd-180-2.lg-281-64.sh-295-62.ch-235-62&headonly=0&size=n&gesture=sml&direction=2&head_direction=3&action=wav">
								</div>
								<label class="flex-column gray margin-auto-top-bottom margin-right-min">
									<h5 class="bold fs-14 flex">
										<a href="javascript:void(0)" class="no-link">Laxus</a>
									</h5>
									<h6>Back-End</h6>
								</label>
							</div>
						</div>
						<!--  -->
						<div class="display-dev-box-2 flex">
							<div class="display-staff-box-imager">
								<img src="<?= AVATARIMAGE; ?>figure=hr-828-39.hd-180-2.lg-281-64.sh-295-62.ch-235-62&headonly=0&size=n&gesture=sml&direction=2&head_direction=3&action=wav">
							</div>
							<label class="flex-column gray margin-auto-top-bottom margin-right-min">
								<h5 class="bold fs-14 flex">
									<a href="javascript:void(0)" class="no-link">Dut</a>
								</h5>
								<h6>Front-End</h6>
							</label>
						</div>
						<!--  -->
						<div class="display-dev-box flex">
							<div class="display-staff-box-imager">
								<img src="<?= AVATARIMAGE; ?>figure=hr-828-39.hd-180-2.lg-281-64.sh-295-62.ch-235-62&headonly=0&size=n&gesture=sml&direction=2&head_direction=3&action=wav">
							</div>
							<label class="flex-column gray margin-auto-top-bottom margin-right-min">
								<h5 class="bold fs-14 flex">
									<a href="javascript:void(0)" class="no-link">Wake</a>
								</h5>
								<h6>Design</h6>
							</label>
						</div>
						<!--  -->
					</div>
				</div>
				<div class="col-14 flex-column height-fit">
					<div class="col-14 flex-column height-fit">
						<div class="general-box flex-column padding-none margin-bottom-min overflow-hidden">
							<div class="general-box-header-3 flex bg-2">
								<div class="general-box-header-3-icon">
									<icon name="help" class="flex margin-auto"></icon>
								</div>
								<label class="gray flex-column text-nowrap">
									<h4 class="bold text-nowrap">Equipe <?= str_replace(' Hotel', '', HOTELNAME); ?></h4>
									<h6 class="text-nowrap">Quem nós somos, o que fazemos?</h6>
								</label>
							</div>
							<div class="general-box-content staff flex-column padding-md">
								<label class="flex-column gray">
									<h5 class="margin-bottom-min">A equipe sempre está a sua disposição para anteder todas as necessidades possíveis de todos os usuários e ouvir a comunidade sempre a comunidade do hotel ao máximo.</h5>
									<h5 class="margin-bottom-min">Para a segurança de todos, e principalmente evitar enganos dentro do hotel, todos os staffs possuem um emblema como identificação que pode ser visto claramente ao entrar no hotel.</h5>
									<h5 class="margin-bottom-md">Então caso alguém se passe por um membro da equipe denuncie o mas rápido possível!</h5>
									<h6 class="bold fs-12">CUIDADO!</h6>
									<h6>Os staffs nunca vão pedir a sua senha, caso alguém à peça denuncie a um membro superior da equipe</h6>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?php $Template->AddTemplate('others', 'bottom'); ?>