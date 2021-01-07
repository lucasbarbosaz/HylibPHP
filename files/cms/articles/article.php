<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}

	if (isset($_GET['article_id']) && is_numeric($_GET['article_id'])) {
		$consult_article = $db->prepare("SELECT id,title,image,shortstory,longstory,category,timestamp,timestamp_expire,author_id,form,form_link,comments,draft FROM cms_news WHERE id = ? LIMIT 1");
		$consult_article->bindValue(1, $_GET['article_id']);
		$consult_article->execute();

		$consult_has_articles = $db->prepare("SELECT * FROM cms_news");
		$consult_has_articles->execute();

		if ($consult_has_articles->rowCount() > 0) {
			if ($consult_article->rowCount() > 0) {
				$result_article = $consult_article->fetch(PDO::FETCH_ASSOC);

				if ($result_article['draft'] == '1' && $user['rank'] < 8) {
					$consult_last_article_no_draft = $db->prepare("SELECT id FROM cms_news WHERE draft != 1 ORDER BY timestamp DESC LIMIT 1");
					$consult_last_article_no_draft->execute();

					$result_last_article_no_draft = $consult_last_article_no_draft->fetch(PDO::FETCH_ASSOC);
					Redirect(URL . '/article/' . $result_last_article_no_draft['id']);
				}

				if ($result_article['author_id'] == NULL || $result_article['author_id'] == '0' || $result_article['author_id'] == '') {
					$result_article['author_id'] = '1';
				}

				$consult_author = $db->prepare("SELECT username,figure FROM players WHERE id = ?");
				$consult_author->bindValue(1, $result_article['author_id']);
				$consult_author->execute();
				$result_author = $consult_author->fetch(PDO::FETCH_ASSOC);

				$consult_article_likes = $db->prepare("SELECT * FROM cms_post_reaction WHERE post_id = ? AND type = ? AND state != ?");
				$consult_article_likes->bindValue(1, $result_article['id']);
				$consult_article_likes->bindValue(2, 'article');
				$consult_article_likes->bindValue(3, 'undefined');
				$consult_article_likes->execute();

				if (isset($user)) {
					$consult_article_liked = $db->prepare("SELECT * FROM cms_post_reaction WHERE post_id = ? AND type = ? AND user_id = ? AND state != ?");
					$consult_article_liked->bindValue(1, $result_article['id']);
					$consult_article_liked->bindValue(2, 'article');
					$consult_article_liked->bindValue(3, $user['id']);
					$consult_article_liked->bindValue(4, 'undefined');
					$consult_article_liked->execute();
				}
			} else {
				$consult_last_article = $db->prepare("SELECT id FROM cms_news ORDER BY timestamp DESC LIMIT 1");
				$consult_last_article->execute();

				$result_last_article = $consult_last_article->fetch(PDO::FETCH_ASSOC);
				Redirect(URL . '/article/' . $result_last_article['id']);
			}
		} else {
			Redirect(URL . '/me');
		}
	} else {
		$consult_last_article = $db->prepare("SELECT id FROM cms_news ORDER BY timestamp DESC LIMIT 1");
		$consult_last_article->execute();

		$result_last_article = $consult_last_article->fetch(PDO::FETCH_ASSOC);
		Redirect(URL . '/article/' . $result_last_article['id']);
	}

	$Template->SetParam('page_id', 'article');
	$Template->SetParam('page_name', 'Article');
	$Template->SetParam('page_title', $result_article['title'] . ' - ' . HOTELNAME);
	$Template->SetParam('page_description', $result_article['shortstory']);
	$Template->SetParam('page_image', $result_article['image']);

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex">
			<div class="col-11 flex-column">
				<div class="news-article general-box padding-none overflow-hidden">
					<div class="news-article-head flex">
						<div class="news-article-thumbnail" style="background-image: url('<?= $result_article['image']; ?>');">
							<div class="news-article-author">
								<img alt="<?= $result_author['username']; ?>" src="<?= AVATARIMAGE . 'figure=' . $result_author['figure']; ?>&action=wav&direction=2&head_direction=3&gesture=sml&size=n&img_format=png&frame=0&headonly=0">
							</div>
						</div>
						<label class="gray flex- margin-auto-top-bottom">
							<h4 class="bold"><?= $result_article['title']; ?></h4>
							<h5><?= $result_article['shortstory']; ?></h5>
							<h6 class="margin-top-minm">Published by <a href="<?= URL . '/profile/' . $result_author['username']; ?>" place="<?= 'Perfil: ' . $result_author['username'] . ' - ' . HOTELNAME; ?>" class="no-link bold"><?= $result_author['username']; ?></a> em <b><?= utf8_encode(strftime('%d de %B de %Y', $result_article['timestamp'])); ?></b> às <b><?= utf8_encode(strftime('%H:%M', $result_article['timestamp'])); ?></b> na categoria <b><?= $result_article['category']; ?></b></h6>
						</label>
					</div>
					<div class="news-article-body"><?= $result_article['longstory']; ?></div>
					<div class="news-article-footer flex padding-min">
					<?php if ($result_article['form'] == 'enabled') { ?>
						<a <?php if ($result_article['form_link'] != NULL) { ?>href="<?= $result_article['form_link']; ?>" target="_blank"<?php } ?> class="news-article-form no-link">
							<label class="flex white pointer-none">
								<icon name="duck" class="margin-auto-top-bottom"></icon>
								<h5 class="margin-auto-top-bottom margin-left-min">Form</h5>
							</label>
						</a>
					<?php } else if ($result_article['form'] == 'unavailable') { ?>
						<div class="news-article-form-disabled" disabled>
							<label class="flex white pointer-none">
								<icon name="duck" class="margin-auto-top-bottom"></icon>
								<h5 class="margin-auto-top-bottom margin-left-min">Form unavailable</h5>
							</label>
						</div>
					<?php } ?>
						<div class="news-article-like flex-column margin-auto-left margin-right-minm">
						<?php if (isset($user)) { ?>
							<button class="reset-button flex margin-auto" data-article-id="<?= $result_article['id']; ?>">
							<?php if ($consult_article_liked->rowCount() > 0) { ?>
								<icon name="heart-big"></icon>
							<?php } else { ?>
								<icon name="heart-big-noborder"></icon>
							<?php } ?>
							</button>
							<h5 class="margin-auto-top marign-auto-left-right text-center"><?= $consult_article_likes->rowCount(); ?> like<?php if ($consult_article_likes->rowCount() == 0 || $consult_article_likes->rowCount() > 1) { ?>s<?php } ?></h5>
						<?php } else { ?>
							<div class="flex margin-auto">
								<icon name="heart-big-noborder"></icon>
							</div>
							<h5 class="margin-auto-top marign-auto-left-right text-center"><?= $consult_article_likes->rowCount(); ?> like<?php if ($consult_article_likes->rowCount() == 0 || $consult_article_likes->rowCount() > 1) { ?>s<?php } ?></h5>
						<?php } ?>
						</div>
					</div>
				</div>
			<?php if ($result_article['comments'] == 'enabled') { ?>
				<div class="article-comments flex-column margin-top-min">
					<?php if (isset($user)) { ?>
						<div class="article-send-comment general-box flex-column padding-none overflow-hidden">
							<div class="flex padding-min">
								<div class="article-send-comment-habbo">
									<img alt="<?= $user['username']; ?>" src="<?= AVATARIMAGE . 'figure=' . $user['figure']; ?>&action=wlk,crr=667direction=2&head_direction=3&gesture=sml&size=n&img_format=png&frame=0&headonly=0">
								</div>
								<div class="general-contenteditable flex">
									<div contenteditable="true" placeholder="Enter your comment here..."></div>
									<div class="contenteditable-editor flex-column">
										<button class="reset-button bold" onclick="Style('bold');">B</button>
										<button class="reset-button italic" onclick="Style('italic');">I</button>
										<button class="reset-button underline" onclick="Style('underline');">U</button>
									</div>
								</div>
								<div class="article-send-comment-button">
									<button data-article-id="<?= $result_article['id']; ?>">Send comment...</button>
								</div>
							</div>
							<div class="send-comment-warn"></div>
						</div>
					<?php } ?>
					<div class="article-comments-area flex-column">
						<?php 
						$select_comments_from_article = $db->prepare("SELECT id,value,author_id,timestamp FROM cms_post_comments WHERE post_id = ? AND type = ? ORDER BY timestamp DESC");
						$select_comments_from_article->bindValue(1, $result_article['id']);
						$select_comments_from_article->bindValue(2, 'article');
						$select_comments_from_article->execute();

						while ($result_comments_from_article = $select_comments_from_article->fetch(PDO::FETCH_ASSOC)) {
							$select_author_comment = $db->prepare("SELECT id,username,figure FROM players WHERE id = ?");
							$select_author_comment->bindValue(1, $result_comments_from_article['author_id']);
							$select_author_comment->execute();

							$result_author_comment = $select_author_comment->fetch(PDO::FETCH_ASSOC);
							?>
							<div class="article-comment-box flex general-box margin-top-minm" data-comment-id="<?= $result_comments_from_article['id']; ?>">
								<div class="article-comment-author-habbo margin-right-min">
									<img alt="<?= $result_author_comment['username']; ?>" width="32px" height="55px" src="<?= AVATARIMAGE . 'figure=' . $result_author_comment['figure']; ?>&action=std&direction=2&head_direction=3&gesture=std&size=s&img_format=png&frame=0&headonly=0" class="margin-auto-left-right">
								</div>
								<label class="gray margin-auto-top-bottom">
									<h5><?= $Function::Filter('xss', $result_comments_from_article['value']); ?></h5>
									<h6 class="fs-10 margin-top-minm">By <a href="<?= URL . '/profile/' . $result_author_comment['username']; ?>" place="Perfil: <?= $result_author_comment['username'] . ' - ' . HOTELNAME; ?>" class="no-link bold"><?= $result_author_comment['username']; ?></a> em <b><?= utf8_encode(strftime('%d de %B de %Y', $result_comments_from_article['timestamp'])); ?></b> às <b><?= utf8_encode(strftime('%H:%M', $result_comments_from_article['timestamp'])); ?></b></h6>
								</label>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } else { ?>
				<div class="general-box article-comments-disabled flex height-auto margin-top-min">
					<label class="white">
						<h3 class="bold">Better comment on the lives of others</h3>
						<h5>For the comments for this news, were disabled by the author.</h5>
					</label>
				</div>
			<?php } ?>
<?php 
	$Template->AddTemplate('others', 'footer'); 
?>
		</div>
		<div class="col-12">
			<div class="general-box height-auto overflow-hidden padding-none">
				<div class="general-box-header-3 flex">
					<div class="general-box-header-3-icon">
						<icon name="plus-magic" class="flex margin-auto"></icon>
					</div>
					<label class="gray flex-column text-nowrap">
						<h4 class="bold text-nowrap">Other news</h4>
						<h6 class="text-nowrap">See here for more news</h6>
					</label>
				</div>
				<div class="general-box-content flex-column">
					<?php
					for ($i = 0; $i < 6; $i++) {
						$section_name = "";
						$section_time_max = 0;
						$section_time_min = 0;

						switch ($i) {
							case 0:
							$section_name = 'Today';
							$section_time_max = time();
							$section_time_min = time() - 86400;
							break;
							case 1:
							$section_name = 'Yesterday';
							$section_time_max = time() - 86400;
							$section_time_min = time() - 172800;
							break;
							case 2:
							$section_name = 'This week';
							$section_time_max = time() - 172800;
							$section_time_min = time() - 604800;
							break;
							case 3:
							$section_name = 'Previous week';
							$section_time_max = time() - 604800;
							$section_time_min = time() - 1209600;
							break;
							case 4:
							$section_name = 'This month';
							$section_time_max = time() - 1209600;
							$section_time_min = time() - 2592000;
							break;
							case 5:
							$section_name = 'Last month';
							$section_time_max = time() - 2592000;
							$section_time_min = time() - 5184000;
							break;
							case 6:
							$section_name = 'Last month';
							$section_time_max = time() - 5184000;
							$section_time_min = time() - 269298000;
							break;
						}

						$consult_others_articles = $db->prepare("SELECT * FROM cms_news WHERE timestamp >= ? AND timestamp <= ? ORDER BY timestamp DESC LIMIT 5");
						$consult_others_articles->bindValue(1, $section_time_min);
						$consult_others_articles->bindValue(2, $section_time_max);
						$consult_others_articles->execute();

						if ($consult_others_articles->rowCount() > 0) {
							echo '								<div class="others-articles-separator">' . $section_name . '</div>
							<div class="others-articles-boxes">' . "\n";

							while ($result_others_articles = $consult_others_articles->fetch(PDO::FETCH_ASSOC)) {
								if($result_others_articles['id'] == $result_article['id']) {
									echo '									<a href="' . URL . '/article/' . $result_others_articles['id'] . '" place="' . $result_others_articles['title'] . ' - ' . HOTELNAME . '" class="other-aticle-box no-link" style="background-image: url(' . $result_others_articles['image'] . ');">
									<div class="other-article-indicator visited pointer-none"></div>
									<label class="width-content text-nowrap white pointer-none">
									<h5 class="bold text-nowrap">' . $result_others_articles['title'] . '</h5>
									<h6 class="text-nowrap fs-11">' . $result_others_articles['shortstory'] . '</h6>
									</label>
									</a>';
								} else {
									echo '									<a href="' . URL . '/article/' . $result_others_articles['id'] . '" place="' . $result_others_articles['title'] . ' - ' . HOTELNAME . '" class="other-aticle-box no-link" style="background-image: url(' . $result_others_articles['image'] . ');">
									<div class="other-article-indicator pointer-none"></div>
									<label class="width-content text-nowrap white pointer-none">
									<h5 class="bold text-nowrap">' . $result_others_articles['title'] . '</h5>
									<h6 class="text-nowrap fs-11">' . $result_others_articles['shortstory'] . '</h6>
									</label>
									</a>' . "\n";
								}
							}
							echo '								</div>' . "\n";
						}
					}
					?>
				</div>
			</div>
		</div>
<?php
	$Template->AddTemplate('others', 'bottom'); 
?>
