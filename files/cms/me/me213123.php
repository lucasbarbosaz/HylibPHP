<?php 
	require_once('../../../geral.php');

	$Auth::Session('disconnected');

	/*if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}
	*/

	$Template->SetParam('page_id', 'me');
	$Template->SetParam('page_name', 'Me');
	$Template->SetParam('page_title', 'Me: ' . USERNAME . ' - ' . HOTELNAME . '');
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex-column">
			<div class="flex">
				<div class="col-7">
					<div class="display-habbo-me flex-column">
						<div class="display-myhabbo flex">
							<div class="flex width-content">
								<div class="display-myhabbo-imager">
									<img alt="<?= USERNAME . ' - ' .  HOTELNAME; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $user['figure']; ?>">
								</div>
								<label class="white margin-auto-top-bottom margin-left-min">
									<h3 class="bold"><?= USERNAME; ?></h3>
									<h6><?= utf8_decode($Function::Filter('xss', $user['motto'])); ?></h6>
								</label>
								<div class="margin-auto-left margin-right-md">
									<a href="<?= URL; ?>/client" class="green-button-2 no-link margin-top-md" style="width: 180px;height: 42px;">
										<label class="margin-auto white">
											<h5>Entrar no <b>Hotel</b></h5>
										</label>
									</a>
								</div>
							</div>
						</div>
						<div class="display-habbo-currency flex">
							<div class="display-habbo-currency-credits flex">
								<icon name="credits" class="margin-auto-top-bottom margin-right-minm"></icon>
								<h6 class="white fs-12 margin-auto-top-bottom"><?= $Function::NumberUnits(User::GetFromUsername('credits', USERNAME)); ?></h6>
							</div>
							<div class="display-habbo-currency-diamonds flex">
								<icon name="rubys" class="margin-auto-top-bottom margin-right-minm"></icon>
								<h6 class="white fs-12 margin-auto-top-bottom"><?= $Function::NumberUnits(User::GetFromUsername('diamonds', USERNAME)); ?></h6>
							</div>
							<div class="display-habbo-currency-duckets flex">
								<icon name="gems" class="margin-auto-top-bottom margin-right-minm"></icon>
								<h6 class="white fs-12 margin-auto-top-bottom"><?= $Function::NumberUnits(User::GetFromUsername('duckets', USERNAME)); ?></h6>
							</div>
							<div class="display-habbo-vip-status flex">
								<h6 class="white fs-12 margin-auto-top-bottom"><?= $User::GetFromUsername('vip_status', USERNAME); ?></h6>
							</div>
						</div>
					</div>
					<!-- configurar pra só staff ver isso abaixo -->
		
					<!-- configurar pra só staff ver isso acima -->
					<?php if(isset($user)) {?>

					<div class="col-lyor flex margin-top-min margin-right">
					<div class="feed-post-area general-box flex-column margin-top-md">
						<div class="general-header-box flex">
							<div class="flex margin-auto-top-bottom margin-right-min">
								<icon name="pad"></icon>
							</div>
							<label class="white flex-column">
								<h4 class="bold">Feed oHabbo</h4>
								<h5>Aqui você confere as ultimas novidades do oHabbo Hotel!</h5>
							</label>
							<br>
						</div>
					<?php // mostrar comentarios
						$consultLastFeed = $db->prepare("SELECT * FROM cms_feed ORDER BY timestamp DESC LIMIT 1");
						$consultLastFeed->execute();
						$resultLastFeed1 = $consultLastFeed->fetch(PDO::FETCH_ASSOC);

						$selectFeedPosts = $db->prepare("SELECT feed_id, value, author_id, timestamp FROM cms_feed ORDER BY timestamp DESC");
						$selectFeedPosts->execute();

						while($resultLastFeed = $selectFeedPosts->fetch(PDO::FETCH_ASSOC)) {
							$selectLikes = $db->prepare("SELECT likes FROM cms_feed WHERE feed_id = ?");
							$selectLikes->bindValue(1, $resultLastFeed['feed_id']);
							$selectLikes->execute();
							$resultLikesFeed = $selectLikes->fetch(PDO::FETCH_ASSOC);

							$selectAuthorFeed = $db->prepare("SELECT id, figure, username FROM players WHERE id = ?");
							$selectAuthorFeed->bindValue(1, $resultLastFeed['author_id']);
							$selectAuthorFeed->execute();

							$resultAuthorFeed = $selectAuthorFeed->fetch(PDO::FETCH_ASSOC);
						
					?>


<style type="text/css">
.top-feed {
	width: 466px;
}
.date-top-feed {
	float: right;
	color: white;
	background-color: #545454;
	border-radius: 6px;
	padding: 5px;
	font-size: 12px;
	transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.date-top-feed:hover {
	background-color: #3a3a3a;
}
</style>
<form method="POST" action="">
	<div class="article-comment-box flex general-box margin-top-minm" style="background-color: #404040;">		
								<div class="feed-post-author-look margin-right-min" style="background: url(<?= AVATARIMAGE . 'figure=' . $resultAuthorFeed['figure']; ?>&action=wav=667&size=b&head_direction=3&direction=2&gesture=sml&headonly=1) -9px -15px no-repeat #6b6b6b;">
								</div>

								<label style="color:rgb(195 195 195);" class="margin-auto-top-bottom">
									<div class="top-feed">									
										<h4 style="margin: 0 0 3px 0;">
											<a href="https://ohabbo.org/profile/<?= $resultAuthorFeed['username'];?>" class="no-link bold">
												<?= $resultAuthorFeed['username'];?>
											</a>
											<svg style="margin-left: 4px;position: absolute;margin-top: 2px;" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
											  <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
											</svg>
											<a class="date-top-feed" style="float:right;color:white;"><?= utf8_encode(strftime('%d de %B de %Y', $resultLastFeed['timestamp'])); ?> às <?= utf8_encode(strftime('%H:%M', $resultLastFeed['timestamp'])); ?></a>
											<?php
												if($user['rank'] > 8){
											?>
											<a href="javascript:void(0)" title="Apagar esta publicação" onclick="deleteFeed(<?= $resultLastFeed['feed_id'];?>)">
											<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg" style="float: right;margin-top: 4px;color: red;margin-right: 4px;">
											  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
											  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
											</svg>
											</a>
											
												<?php } ?>
										</h4>
									</div>
											</form>
									<h5 style="margin-bottom: 3px;"><?= $resultLastFeed['value'];?></h5>
									<!-- <h6 class="fs-10 margin-top-minm">Por <a href="https://ohabbo.org/profile/<?= $resultAuthorFeed['username'];?>" class="no-link bold">
											<?= $resultAuthorFeed['username'];?></a> em <b><?= utf8_encode(strftime('%d de %B de %Y', $resultLastFeed['timestamp'])); ?></b> às <b><?= utf8_encode(strftime('%H:%M', $resultLastFeed['timestamp'])); ?></b></h6> -->
									<a href="javascript:void(0)" style="text-decoration: none;font-size: 12px;" class="likes" onclick="add_like(<?= $resultLastFeed['feed_id'];?>)" title="Curtir publicação" name="curtir">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-hand-thumbs-up" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										  <path fill-rule="evenodd" d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16v-1c.563 0 .901-.272 1.066-.56a.865.865 0 0 0 .121-.416c0-.12-.035-.165-.04-.17l-.354-.354.353-.354c.202-.201.407-.511.505-.804.104-.312.043-.441-.005-.488l-.353-.354.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581 0-.211-.027-.414-.075-.581-.05-.174-.111-.273-.154-.315L12.793 9l.353-.354c.353-.352.373-.713.267-1.02-.122-.35-.396-.593-.571-.652-.653-.217-1.447-.224-2.11-.164a8.907 8.907 0 0 0-1.094.171l-.014.003-.003.001a.5.5 0 0 1-.595-.643 8.34 8.34 0 0 0 .145-4.726c-.03-.111-.128-.215-.288-.255l-.262-.065c-.306-.077-.642.156-.667.518-.075 1.082-.239 2.15-.482 2.85-.174.502-.603 1.268-1.238 1.977-.637.712-1.519 1.41-2.614 1.708-.394.108-.62.396-.62.65v4.002c0 .26.22.515.553.55 1.293.137 1.936.53 2.491.868l.04.025c.27.164.495.296.776.393.277.095.63.163 1.14.163h3.5v1H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
										</svg> 
										<span id="players-who-liked-<?= $resultLastFeed['feed_id'];?>"><?= $resultLikesFeed['likes'];?></span> curtiram esse post!
            						</a>                    	
								</label>
							</div>
				<?php } ?>
				<?php } ?>					
			</div>
					</div>
								</div>
				<div class="col-10">
					<div class="discord-token-box margin-bottom-min">
						<label class="white flex-column">
							<h2 class="uppercase bold">Discord Token</h2>
							<h5 class="margin-bottom-min">Este token serve para dar acesso ao diversos canais que você pode encontrar em nosso servidor do discord.</h5>
							<h6>Para pegar seu discord token, basta <b>clicar 2x em cima do token</b> e <b>apertar CTRL + C</b> para copiar e em seguida <b>colar no canal de vinculação</b>.</h6>
						</label>
						<div class="discord-token-label flex">
						<?php if ($user['discord_token']) { ?>
							<div class="discord-token-area gray"><?= $user['discord_token']; ?></div>
						<?php } else { ?>
							<div class="discord-token-area gray">Você <b>não tem</b> um discord token!</div>
						<?php } ?>
							<div class="discord-token-badge pointer-none"></div>
						</div>
					</div>
				<?php
					$consult_articles_news = $db->prepare("SELECT id,title,shortstory,category,image,timestamp,author_id FROM cms_news ORDER BY timestamp DESC LIMIT 5");
					$consult_articles_news->execute();

					if ($consult_articles_news->rowCount() > 0) {
				?>
					<div class="last-articles-news width-content">
						<div class="control-last-articles-news flex">
							<span class="prev flex">
								<icon name="prev"></icon>
							</span>
							<span class="next flex margin-left-min">
								<icon name="next"></icon>
							</span>
						</div>
						<div class="last-article-news-background">
							<div class="last-article-news-thumbnail"></div>
						</div>
						<div class="last-articles-news-slides">
						<?php
							while ($result_articles_news = $consult_articles_news->fetch(PDO::FETCH_ASSOC)) {
								if (empty($result_articles_news['author_id'])) {
									$result_articles_news['author_id'] = '1';
								}

								$consult_author_article = $db->prepare("SELECT username FROM players WHERE id = ? LIMIT 1");
								$consult_author_article->bindValue(1, $result_articles_news['author_id']);
								$consult_author_article->execute();

								$result_author_article = $consult_author_article->fetch(PDO::FETCH_ASSOC);
						?>
							<div class="last-article-news">
								<a href="<?= URL . '/article/' . $result_articles_news['id']; ?>" place="<?= $result_articles_news['title'] . ' - ' . HOTELNAME; ?>" class="last-article-news-thumbnail" style="background-image: url('<?= $result_articles_news['image']; ?>');">
									<div class="news-head-author-look" style="background:url(https://habbinc.net/avatar/Lyor./action=wav&size=s&head_direction=3&direction=3&gesture=sml&headonly=1) no-repeat -4px -9px;"></div>
									<div class="news-author-info"><?= $result_author_article['username']; ?></div>
									<div class="news-news-info">
									<h5 class="bold fs-14"><?= $result_articles_news['title']; ?></h5>
									<h6 class="fs-12"><?= $result_articles_news['shortstory']; ?></h6>
									</div>
								</a>
								<label class="flex-column text-nowrap">
									<!-- <h5 class="bold fs-14 text-nowrap"><?= $result_articles_news['title']; ?></h5>
									<h6 class="fs-12 text-nowrap"><?= $result_articles_news['shortstory']; ?></h6> -->
									<div class="last-article-news-info margin-auto-top">Publicada <!--por <a href="<?= URL . '/profile/' . $result_author_article['username']; ?>" class="bold no-link"><?= $result_author_article['username']; ?></a>--> em <b><?= utf8_encode(strftime('%d de %B de %Y', $result_articles_news['timestamp'])); ?></b> às <b><?= utf8_encode(strftime('%H:%M', $result_articles_news['timestamp'])); ?></b></div>
								</label>
							</div>
						<?php } ?>
						</div>
					</div>
				<?php } ?>
					<div class="social-meadia-links flex-column margin-top-min">
						<h3 class="gray bold margin-bottom-min">Mais acessibilidade para você!</h3>
						<a href="<?= $Hotel::Settings('facebook'); ?>" target="blank" class="social-media-facebook flex no-link">
							<div class="margin-auto-top-bottom">Curta a nossa página!</div>
						</a>
						<a href="<?= $Hotel::Settings('application'); ?>" target="blank" class="desktop-haibbo-application flex no-link">
							<div class="margin-auto-top-bottom">Baixe nosso aplicativo!</div>
						</a>
						<a href="https://chrome.google.com/webstore/detail/ohabbo/ehhddomgaelgddjcepijedahlgjolchn" target="blank" class="desktop-haibbo-application flex no-link">
							<div class="margin-auto-top-bottom">Baixe nossa extensão!</div>
						</a>
						<a href="<?= $Hotel::Settings('discord'); ?>" target="blank" class="social-media-discord flex no-link">
							<div class="margin-auto-top-bottom">Junte-se ao servidor do discord!</div>
						</a>
					</div>
				</div>
			</div>
<?php 
	$Template->AddTemplate('others', 'footer');
?>
		</div>
<?php 
	$Template->AddTemplate('others', 'bottom'); 
?>