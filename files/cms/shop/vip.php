<?php
	require_once('../../../geral.php');

	$Auth::Session('disconnected');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	$Template->SetParam('page_name', 'Shop/VIP');
	$Template->SetParam('page_title', 'Loja: VIP - ' . HOTELNAME);
	$Template->SetParam('page_description', 'No hybbe hotel, você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<div class="container flex-column margin-bottom-min">
			<div class="content">
				<?php echo $Template->AddTemplate('others', 'header'); ?>
				<div class="another-header-menu">
					<div class="webcenter">
						<div class="another-header-menu-icon">
							<icon name="fame"></icon>
						</div>
						<div class="flex">
							<a href="<?= URL; ?>/shop/packets" place="Loja: Pacotes - <?= HOTELNAME; ?>" class="another-header-menu-option">
								<label>Pacotes</label>
							</a>
								<separator></separator>
							<a href="<?= URL; ?>/shop/vip" place="Loja: VIP - <?= HOTELNAME; ?>" class="another-header-menu-option visited">
								<label>VIP</label>
							</a>
							<div class="cash-amount flex">
								<div class="cash-icon"></div>
								<label class="flex">
									<h5><span class="bold">0</span> cash</h5>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="webcenter flex-column">
					<div class="flex">
						<div class="card-packets">
						<?php 
							$consult_vip_packages = $db->prepare("SELECT * FROM cms_shop WHERE page = ?");
							$consult_vip_packages->bindValue(1, 'vip');
							$consult_vip_packages->execute();

							while ($result_vip_packages = $consult_vip_packages->fetch(PDO::FETCH_ASSOC)) {
								$json = json_decode($result_vip_packages['label'], true);
						?>
							<div class="general-box vip card padding-none">
								<div class="general-box-container flex-column padding-min">
									<div class="general-box-header flex-column">
										<div class="general-box-header-content flex">
											<icon name="vip-badge-mini" class="margin-auto-top-bottom margin-right-min"></icon>
											<label class="white flex width-content">
												<h5 class="margin-auto-top-bottom"><?= $json['product_label'][0]['name']; ?></h5>
												<div class="price">
													<h6><b><?= number_format($json['product_label'][0]['cost_cash']); ?></b> Cash</h6>
												</div>
											</label>
										</div>
										<div class="vip-benefits">
											<div class="vip-benefits-cover"></div>
											<ol class="vip-benefits-list flex-column">
											<?php 
												$benefits = count($json['product_label'][0]['benefits'][0]);

												if ($benefits > 0) {
													for ($i = 0; $i < $benefits; $i++) { 
											?>
												<li><?= $json['product_label'][0]['benefits'][0][$i]; ?></li>
											<?php 
													} 
												} else {
											?>
												<label class="white text-center">
													<h6>Nenhum benefício incluso neste plano.</h6>
												</label>
											<?php } ?>
											</ol>
										</div>
									</div>
									<div class="general-box-content flex-column">
										<div class="flex">
											<button class="green-button-1 margin-right-min buy-package" data-package="<?= $result_vip_packages['product_id']; ?>" style="min-width: 113px; height: 43px;">
												<label class="margin-auto white">
													<h5>Comprar</h5>
												</label>
											</button>
											<button class="blue-button-1 benefits" style="min-width: 160px; height: 43px;">
												<label class="margin-auto white">
													<h5><span>Ver</span> benefícios</h5>
												</label>
											</button>
										</div>
									</div>
								</div>
								<div class="general-box-warn"></div>
							</div>
						<?php } ?>
						</div>
						<div class="flex-column col-15">
							<div class="general-box padding-none height-fit overflow-hidden">
								<div class="general-box-content flex-column">
									<label class="gray padding-md">
										<h5 class="bold">Usuários(as) VIP's</h5>
										<h6 class="margin-top-minm">Aqui ficam os usuários(a) que adquiriram alguns dos nossos planos VIP's assim ajudando também a manter o hotel online.</h6>
									</label>
										<hr>
									<div class="vip-club-users bg-2">
										<div class="vip-club-users"></div>
										<div class="padding-max">
											<label class="gray">
												<h6>Opps! Parece que não há usuários que adquiriram algum dos planos ao lado, e se tem, não deseja estar nesta lista.</h6>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php echo $Template->AddTemplate('others', 'footer'); ?>
				</div>
			</div>
		</div>
<?php echo $Template->AddTemplate('others', 'bottom'); ?>