<?php 
	require_once('../../../geral.php');

	$Template->SetParam('page_name', 'Erro');
	$Template->SetParam('page_title', 'Erro - ' . HOTELNAME . '');
	$Template->SetParam('page_description', 'Não foi possível encontrar nada com este link, parece ser inválido!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<div class="container flex-column margin-bottom-min">
			<div class="content">
				<?php $Template->AddTemplate('others', 'header'); ?>
				<div class="webcenter flex-column">
					<div class="error-container flex">
						<div class="margin-auto flex-column">
							<div class="error-container-image"></div>
							<label class="gray margin-bottom-min text-center">
								<h2 class="bold margin-bottom-minm">Nada encontrado!</h2>
								<h5>Parece que a página que você estava procurando não foi encontrada!<br>Verifique o endereço para ver se tudo está correto ou na duvida contade a um membro da equipe!</h5>
							</label>
							<button class="green-button-1 margin-auto-left-right" style="width: 179px;height: 45px;" onclick="window.history.go(-2); return false;">
								<label class="margin-auto white">Voltar</label>
							</button>
						</div>
					</div>
				</div>
				<img src="banner.gif?" width="1" height="1" id="kop">
			</div>
		</div>
<?php echo $Template->AddTemplate('others', 'bottom'); ?>