<?php 
	require_once('../../../geral.php');

	$Auth::Session('disconnected');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

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
									<a href="<?= URL; ?>/client" target="_blank" class="green-button-1 no-link margin-top-md" style="width: 180px;height: 42px;">
										<label class="margin-auto white">
											<h5>Enter the <b>Hotel</b></h5>
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
					<div class="col-8 flex margin-top-min margin-right">
						<?php 
						$consult_events_default = $db->prepare("SELECT title,description,link,image FROM cms_events WHERE type = ? ORDER BY id DESC LIMIT 1");
						$consult_events_default->bindValue(1, 'evento');
						$consult_events_default->execute();

						while ($result_events_default = $consult_events_default->fetch(PDO::FETCH_ASSOC)) {
							?>
							<div class="event-box-default" style="background-image: url('<?= $result_events_default['image']; ?>');">
								<label class="white margin-auto-top-bottom margin-auto-left text-right text-nowrap">
									<h3 class="bold text-nowrap"><?= $result_events_default['title']; ?></h3>
									<h6 class="text-nowrap"><?= $result_events_default['description']; ?></h6>
								</label>
							</div>
						<?php }
						$consult_events_special = $db->prepare("SELECT title,description,link,image FROM cms_events WHERE type = ? ORDER BY id DESC LIMIT 1");
						$consult_events_special->bindValue(1, 'atividade');
						$consult_events_special->execute();

						while ($result_events_special = $consult_events_special->fetch(PDO::FETCH_ASSOC)) {
							?>
							<div class="event-box-special" style="background-image: url('<?= $result_events_special['image']; ?>');">
								<label class="white margin-auto-top-bottom margin-auto-right text-nowrap">
									<h3 class="bold text-nowrap"><?= $result_events_special['title']; ?></h3>
									<h6 class="text-nowrap"><?= $result_events_special['description']; ?></h6>
								</label>
							</div>
						<?php } ?>
					</div>
					<div class="col-9 flex margin-top-min">
						<div class="general-box featured-users margin-top-min margin-right-min">
							<div class="general-header-box-2 flex hbg-1">
								<div class="flex margin-auto-top-bottom margin-right-min">
									<icon name="gold-trophy" class="margin-auto"></icon>
								</div>
								<label class="white">
									<h5>Rich users</h5>
								</label>
							</div>
							<div class="flex-column users-featured">
								<?php
									$consult_amount_currency = $db->prepare("SELECT username,credits,figure,rank FROM players WHERE rank < 6 ORDER BY credits + 0 DESC LIMIT 1");
									$consult_amount_currency->execute();

									while ($result_amount_currency = $consult_amount_currency->fetch(PDO::FETCH_ASSOC)) {
								?>
									<div class="flex featured-user-credits">
										<div class="featured-user-credits-imager">
											<img alt="<?= $result_amount_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_amount_currency['figure']; ?>">
										</div>
										<label class="white margin-auto-top-bottom margin-auto-right padding-right-min">
											<a href="<?= URL . '/profile/' . $result_amount_currency['username']; ?>" place="Perfil: <?= $result_amount_currency['username']; ?> - <?= HOTELNAME; ?>" class="no-link white">
												<h4 class="bold"><?= $result_amount_currency['username']; ?></h4>
											</a>
											<div class="flex">
												<icon name="credits"></icon>
												<h6 class="margin-left-minm margin-auto-top-bottom"><?= number_format($result_amount_currency['credits']); ?> créditos</h6>
											</div>
										</label>
									</div>
								<?php } ?>
								<?php
									$consult_amount_currency = $db->prepare("SELECT username,vip_points,figure,rank FROM players WHERE rank < 6 ORDER BY vip_points + 0 DESC LIMIT 1");
									$consult_amount_currency->execute();

									while ($result_amount_currency = $consult_amount_currency->fetch(PDO::FETCH_ASSOC)) {
								?>
									<div class="flex featured-user-diamonds">
										<div class="featured-user-diamonds-imager">
											<img alt="<?= $result_amount_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_amount_currency['figure']; ?>">
										</div>
										<label class="white margin-auto-top-bottom margin-auto-right padding-right-min">
											<a href="<?= URL . '/profile/' . $result_amount_currency['username']; ?>" place="Perfil: <?= $result_amount_currency['username']; ?> - <?= HOTELNAME; ?>" class="no-link white">
												<h4 class="bold"><?= $result_amount_currency['username']; ?></h4>
											</a>
											<div class="flex">
												<icon name="rubys"></icon>
												<h6 class="margin-left-minm margin-auto-top-bottom"><?= number_format($result_amount_currency['vip_points']); ?> diamantes</h6>
											</div>
										</label>
									</div>
								<?php } ?>
								<?php
									$consult_amount_currency = $db->prepare("SELECT username,activity_points,figure,rank FROM players WHERE rank < 6 ORDER BY activity_points + 0 DESC LIMIT 1");
									$consult_amount_currency->execute();

									while ($result_amount_currency = $consult_amount_currency->fetch(PDO::FETCH_ASSOC)) {
								?>
									<div class="flex featured-user-duckets">
										<div class="featured-user-duckets-imager">
											<img alt="<?= $result_amount_currency['username']; ?>" src="<?= AVATARIMAGE; ?>figure=<?= $result_amount_currency['figure']; ?>">
										</div>
										<label class="white margin-auto-top-bottom margin-auto-right padding-right-min">
											<a href="<?= URL . '/profile/' . $result_amount_currency['username']; ?>" place="Perfil: <?= $result_amount_currency['username']; ?> - <?= HOTELNAME; ?>" class="no-link white">
												<h4 class="bold"><?= $result_amount_currency['username']; ?></h4>
											</a>
											<div class="flex">
												<icon name="gems"></icon>
												<h6 class="margin-left-minm margin-auto-top-bottom"><?= number_format($result_amount_currency['activity_points']); ?> duckets</h6>
											</div>
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="general-box featured-rooms margin-top-min">
							<div class="general-header-box-2 flex hbg-2">
								<div class="flex margin-auto-top-bottom margin-right-min">
									<icon name="groups" class="margin-auto"></icon>
								</div>
								<label class="white">
									<h5>Most tanned rooms</h5>
								</label>
							</div>
							<div class="rooms-featured">
								<?php 
								$consult_featured_rooms = $db->prepare("SELECT id,owner,name,score FROM rooms ORDER BY score DESC LIMIT 4");
								$consult_featured_rooms->execute();

								while ($result_featured_rooms = $consult_featured_rooms->fetch(PDO::FETCH_ASSOC)) {
									$thumbnail_file = DIR . SEPARATOR . '/camera/thumbnail/' . $result_featured_rooms['id'] . '.png';

									if (!file_exists($thumbnail_file)) {
										$thumbnail = '';
									} else {
										$thumbnail = '';
									}
									?>
									<a href="<?= URL . '/client/' . $result_featured_rooms['id']; ?>" room="<?= $result_featured_rooms['id']; ?>" place="Client = <?= HOTELNAME; ?>" class="featured-room-box flex margin-bottom-minm no-link">
										<div class="featured-room-thumbnail pointer-none" style=""></div>
										<div class="flex margin-auto-top-bottom pointer-none width-content">
											<label class="gray text-nowrap margin-right-min">
												<h5 class="bold text-nowrap"><?= $Function::Filter('xss', $result_featured_rooms['name']); ?></h5>
												<h6 class="text-nowrap"><?= $result_featured_rooms['owner']; ?></h6>
											</label>
											<div class="featured-room-users margin-auto-left"><?= $result_featured_rooms['score']; ?></div>
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-10">
					<div class="discord-token-box margin-bottom-min">
						<label class="white flex-column">
							<h2 class="uppercase bold">Discord Token</h2>
							<h5 class="margin-bottom-min">This token is used to give you access to the various channels you can find on our discord server.</h5>
							<h6>To pick up your discord token, simply <b>click 2x on top of the token</b> and <b>hit CTRL+C</b> to copy and then <b>paste into the linking channel</b>.</h6>
						</label>
						<div class="discord-token-label flex">
						<?php if ($user['discord_token']) { ?>
							<div class="discord-token-area gray"><?= $user['discord_token']; ?></div>
						<?php } else { ?>
							<div class="discord-token-area gray">You <b>don't </b> a discord token!</div>
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
								<a href="<?= URL . '/article/' . $result_articles_news['id']; ?>" place="<?= $result_articles_news['title'] . ' - ' . HOTELNAME; ?>" class="last-article-news-thumbnail" style="background-image: url('<?= $result_articles_news['image']; ?>');"></a>
								<label class="flex-column text-nowrap">
									<h5 class="bold fs-14 text-nowrap"><?= $result_articles_news['title']; ?></h5>
									<h6 class="fs-12 text-nowrap"><?= $result_articles_news['shortstory']; ?></h6>
									<div class="last-article-news-info margin-auto-top">Publicada por <a href="<?= URL . '/profile/' . $result_author_article['username']; ?>" class="bold no-link"><?= $result_author_article['username']; ?></a> em <b><?= utf8_encode(strftime('%d de %B de %Y', $result_articles_news['timestamp'])); ?></b> às <b><?= utf8_encode(strftime('%H:%M', $result_articles_news['timestamp'])); ?></b></div>
								</label>
							</div>
						<?php } ?>
						</div>
					</div>
				<?php } ?>
					<div class="social-meadia-links flex-column margin-top-min">
						<h3 class="gray bold margin-bottom-min">Mais acessibilidade para você!</h3>
						<a href="<?= $Hotel::Settings('facebook'); ?>" target="blank" class="social-media-facebook flex no-link">
							<div class="margin-auto-top-bottom">Like us!</div>
						</a>
						<a href="<?= $Hotel::Settings('application'); ?>" target="blank" class="desktop-haibbo-application flex no-link">
							<div class="margin-auto-top-bottom">Download our app!</div>
						</a>
						<a href="<?= $Hotel::Settings('discord'); ?>" target="blank" class="social-media-discord flex no-link">
							<div class="margin-auto-top-bottom">Join the discord server!</div>
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
