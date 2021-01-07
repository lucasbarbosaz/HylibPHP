<?php 
	require_once('../../../geral.php');

	if (isset($user['username'])) {
		$Hotel::Manutention($user['rank']);
	} else {
		$Hotel::Manutention();
	}
	

	if (isset($_GET['user'])) {
		$profile = (isset($_GET['user'])) ? Functions::Filter('username', $_GET['user']) : '';

		$profile_consult = $db->prepare("SELECT id,username,motto,figure,gender,online,account_created FROM players WHERE username = ?");
		$profile_consult->bindValue(1, $profile);
		$profile_consult->execute();

		if (strlen($profile) <= 0 && isset($user['username']) || empty($profile) && isset($user['username'])) {
			Redirect(URL . '/profile/' . $user['username']);
		} else {
			if ($profile_consult->rowCount() > 0) {
				$profile_result = $profile_consult->fetch(PDO::FETCH_ASSOC);

				$profile_consult_settings = $db->prepare("SELECT profile_picture,profile_cover,home_room FROM player_settings WHERE player_id = ?");
				$profile_consult_settings->bindValue(1, $profile_result['id']);
				$profile_consult_settings->execute();

				$profile_result_settings = $profile_consult_settings->fetch(PDO::FETCH_ASSOC);

				$profile_result_friends = $db->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = ?");
				$profile_result_friends->bindValue(1, $profile_result['id']);
				$profile_result_friends->execute();

				$profile_consult_count_badges = $db->prepare("SELECT * FROM player_badges WHERE player_id = ?");
				$profile_consult_count_badges->bindValue(1, $profile_result['id']);
				$profile_consult_count_badges->execute();
				$profile_count_badges = $profile_consult_count_badges->rowCount();

				$profile_consult_count_rooms = $db->prepare("SELECT * FROM rooms WHERE owner_id = ?");
				$profile_consult_count_rooms->bindValue(1, $profile_result['id']);
				$profile_consult_count_rooms->execute();
				$profile_count_rooms = $profile_consult_count_rooms->rowCount();

				$profile_consult_count_groups = $db->prepare("SELECT * FROM group_memberships WHERE player_id = ?");
				$profile_consult_count_groups->bindValue(1, $profile_result['id']);
				$profile_consult_count_groups->execute();
				$profile_count_groups = $profile_consult_count_groups->rowCount();
			} else if (isset($user['username'])) {
				Redirect(URL . '/profile/' . $user['username']);
			} else {
				Redirect(URL);
			}
		}
	} else if (isset($user['username'])) {
		Redirect(URL . '/profile/' . $user['username']);
	} else {
		Redirect(URL);
	}

	$Template->SetParam('page_id', 'me');
	$Template->SetParam('page_name', 'Profile');
	$Template->SetParam('page_title', 'Perfil: ' . $profile_result['username'] . ' - ' . HOTELNAME);
	$Template->SetParam('page_description', 'No ' . HOTELNAME . ', você pode fazer novos amigos, ganhar eventos, ser o mais rico, jogar e criar os seus próprios jogos, ser famoso, bater-papo, decorar e criar quartos incríveis com uma imensidão de mobílias disponíveis no nosso catálogo. Tudo isso, e muito mais, você encontrar aqui GRATUITAMENTE, o que está esperando para se registar neste incrível universo pixealado e fazer parte do nosso hotel??!!');
	$Template->SetParam('page_image', '' . URL . '/image.png');

	$Template->AddTemplate('others', 'head');
?>
		<?php $Template->AddTemplate('others', 'header'); ?>
		<div class="webcenter flex-column">
			<div class="flex-column">
				<div class="profile-card-main general-box padding-none">
					<div class="profile-card-main-cover">
						<img alt="" src="">
					</div>
					<div class="profile-card-main-about flex">
						<div class="flex-column padding-max width-content">
							<div class="flex margin-bottom-max">
								<div class="profile-card-main-about-habbo">
									<div class="profile-card-main-about-habbo-imager margin-auto-left-right">
										<img alt="<?= $profile_result['username'] . ' - ' . HOTELNAME; ?>" src="<?= AVATARIMAGE . 'figure=' . $profile_result['figure']; ?>?gesture=std&head_direction=3&direction=2&size=s">
									</div>
								</div>
								<div class="profile-card-main-about-friends flex margin-auto-top-bottom margin-auto-left">
									<icon name="friends" class="margin-right-minm"></icon>
									<label class="fs-14 white"><?= number_format($profile_result_friends->rowCount()); ?> frien<?php if ($profile_result_friends->rowCount() != '1') { ?>ds<?php } else { ?>d<?php } ?></label>
								</div>
							</div>
							<div class="flex">
								<div class="flex-column">
									<?php if ($profile_result_settings['profile_picture'] != NULL) { ?>
										<div class="profile-card-main-about-picture">
											<img alt="<?= $profile_result['username']; ': Profile picture - ' . HOTELNAME; ?>" src="<?= $profile_result_settings['profile_picture']; ?>">
										</div>
									<?php } else { ?>
										<div class="profile-card-main-about-picture default">
											<div class="profile-card-main-about-picture-imager">
												<img alt="<?= $profile_result['username']; ' - ' . HOTELNAME; ?>" src="<?= AVATARIMAGE . 'figure=' . $profile_result['figure']; ?>&direction=4&head_direction=3&gesture=sml&action=wav,crr=667">
											</div>
										</div>
									<?php } ?>
									<div class="profile-card-main-about-lastlogin flex margin-top-min">
										<icon name="clock-mini" class="margin-right-minm"></icon>
										<?php if ($profile_result['online'] == '1') { ?>
											<label class="gray-clear">
												<h5>Conectad<?php if ($profile_result['gender'] == 'F') { ?>a<?php } else { ?>o<?php } ?></h5>
											</label>
										<?php } else { ?>
											<label class="gray-clear">
												<h5>Desconectad<?php if ($profile_result['gender'] == 'F') { ?>a<?php } else { ?>o<?php } ?></h5>
											</label>
										<?php } ?>
									</div>
								</div>
								<div class="profile-card-main-about-infos flex-column margin-left-max margin-auto-top">
									<div class="flex-column">
										<div class="profile-card-main-about-display-infos flex white">
											<icon class="margin-right-minm" name="<?php if ($profile_result['gender'] == 'F') { ?>female<?php } else { ?>male<?php } ?>"></icon>
											<label class="flex">
												<h4><b><?= $profile_result['username']; ?></b>&nbsp;|&nbsp;</h4>
												<h6 class="fs-12 margin-auto-top-bottom"><?= User::GetFromUsername('rankname', $profile_result['username']); ?></h6>
											</label>
										</div>
										<label class="margin-top-minm margin-bottom-minm white">
											<h5><?= $Function::Filter('xss', $profile_result['motto']); ?></h5>
										</label>
									</div>
									<div class="profile-card-main-about-another-infos flex-column margin-top-max">
										<div class="flex margin-bottom-minm">
											<icon name="room" class="margin-right-minm"></icon>
											<label class="gray-clear">
												<h5>Brazil</h5>
											</label>
										</div>
										<div class="flex margin-bottom-minm">
											<icon name="link" class="margin-right-minm"></icon>
											<label class="gray-clear">
												<h5><?= URL; ?></h5>
											</label>
										</div>
										<div class="flex">
											<icon name="display-identity" class="margin-right-minm"></icon>
											<label class="gray-clear">
												<h5>Joined in <?= utf8_encode(strftime('%d de %B de %Y', $profile_result['account_created'])); ?></h5>
											</label>
										</div>
									</div>
								</div>
								<div class="flex-column margin-auto-left">
									<div class="profile-card-main-about-badges flex">
										<?php 
										$consult_favorite_group = $db->prepare("SELECT group_id FROM group_memberships WHERE player_id = ? && group_id != '0'");
										$consult_favorite_group->bindValue(1, $profile_result['id']);
										$consult_favorite_group->execute();

										if ($consult_favorite_group->rowCount() > 0) {
											while ($result_favorite_group = $consult_favorite_group->fetch(PDO::FETCH_ASSOC)) {
												$consult_details_favorite_group = $db->prepare("SELECT * FROM groups WHERE id = ?");
												$consult_details_favorite_group->bindValue(1, $result_favorite_group['group_id']);
												$consult_details_favorite_group->execute();

												$result_details_favorite_group = $consult_details_favorite_group->fetch(PDO::FETCH_ASSOC);
												?>
												<div class="profile-card-main-about-badges-display badge" tooltip="<?= Functions::Filter('xss', $result_details_favorite_group['name']); ?>">
													<img alt="<?= Functions::Filter('xss', $result_details_favorite_group['name']); ?>" src=https://swf.ohabbo.org/c_images/Badgeparts/generated/<?= $result_details_favorite_group['badge']; ?>.png">
												</div>
												<?php 
											} 
										} else { 
											?>
											<div class="profile-card-main-about-badges-display not-badge" tooltip="No favorite group"></div>
										<?php } ?>
										<?php
										$consult_showed_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot != 0 LIMIT 0,1");
										$consult_showed_badges->bindValue(1, $profile_result['id']);
										$consult_showed_badges->execute();

										if ($consult_showed_badges->rowCount() > 0) {
											while($result_showed_badges = $consult_showed_badges->fetch(PDO::FETCH_ASSOC)) {
												?>
												<div class="profile-card-main-about-badges-display badge" tooltip="<?= $result_showed_badges['badge_code']; ?>">
													<img alt="<?= $result_showed_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_showed_badges['badge_code']; ?>.gif">
												</div>
												<?php 
											}
										} else { 
											?>
											<div class="profile-card-main-about-badges-display not-badge" tooltip="No emblem slot"></div>
										<?php } ?>
										<?php
										$consult_showed_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot != 0 LIMIT 1,1");
										$consult_showed_badges->bindValue(1, $profile_result['id']);
										$consult_showed_badges->execute();

										if ($consult_showed_badges->rowCount() > 0) {
											while($result_showed_badges = $consult_showed_badges->fetch(PDO::FETCH_ASSOC)) {
												?>
												<div class="profile-card-main-about-badges-display badge" tooltip="<?= $result_showed_badges['badge_code']; ?>">
													<img alt="<?= $result_showed_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_showed_badges['badge_code']; ?>.gif">
												</div>
												<?php 
											}
										} else { 
											?>
											<div class="profile-card-main-about-badges-display not-badge" tooltip="No badge slot"></div>
										<?php } ?>
										<?php
										$consult_showed_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot != 0 LIMIT 2,1");
										$consult_showed_badges->bindValue(1, $profile_result['id']);
										$consult_showed_badges->execute();

										if ($consult_showed_badges->rowCount() > 0) {
											while($result_showed_badges = $consult_showed_badges->fetch(PDO::FETCH_ASSOC)) {
												?>
												<div class="profile-card-main-about-badges-display badge" tooltip="<?= $result_showed_badges['badge_code']; ?>">
													<img alt="<?= $result_showed_badges['badge_code']; ?>" src="<?= SWF; ?>/c_images/album1584/<?= $result_showed_badges['badge_code']; ?>.gif">
												</div>
												<?php 
											}
										} else { 
											?>
											<div class="profile-card-main-about-badges-display not-badge" tooltip="No badge slot"></div>
										<?php } ?>
										<?php
										$consult_showed_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot != 0 LIMIT 3,1");
										$consult_showed_badges->bindValue(1, $profile_result['id']);
										$consult_showed_badges->execute();

										if ($consult_showed_badges->rowCount() > 0) {
											while($result_showed_badges = $consult_showed_badges->fetch(PDO::FETCH_ASSOC)) {
												?>
												<div class="profile-card-main-about-badges-display badge" tooltip="<?= $result_showed_badges['badge_code']; ?>">
													<img alt="<?= $result_showed_badges['badge_code']; ?>" src="<?= SWF; ?>/c_images/album1584/<?= $result_showed_badges['badge_code']; ?>.gif">
												</div>
												<?php 
											}
										} else { 
											?>
											<div class="profile-card-main-about-badges-display not-badge" tooltip="No badge slot"></div>
										<?php } ?>
										<?php
										$consult_showed_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot != 0 LIMIT 4,1");
										$consult_showed_badges->bindValue(1, $profile_result['id']);
										$consult_showed_badges->execute();

										if ($consult_showed_badges->rowCount() > 0) {
											while($result_showed_badges = $consult_showed_badges->fetch(PDO::FETCH_ASSOC)) {
												?>
												<div class="profile-card-main-about-badges-display badge" tooltip="<?= $result_showed_badges['badge_code']; ?>">
													<img alt="<?= $result_showed_badges['badge_code']; ?>" src="<?= SWF; ?>/c_images/album1584/<?= $result_showed_badges['badge_code']; ?>.gif">
												</div>
												<?php 
											}
										} else { 
											?>
											<div class="profile-card-main-about-badges-display not-badge" tooltip="No badge slot"></div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="flex margin-top-min">
					<div class="general-box errands padding-none overflow-hidden margin-right-min height-fit">
						<div class="general-box-header-3 padding-md">
							<?php if (isset($user['username']) && isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
								<label class="gray">
									<h5 class="bold">My messages</h5>
									<h6>The messages your friends leave you stay here!</h6>
								</label>
							<?php } else { ?>
								<label class="gray">
									<h5 class="bold">Messages from <?= $profile_result['username']; ?></h5>
									<h6>The messages that friends from<?= $profile_result['username']; ?> they leave here!</h6>
								</label>
							<?php } ?> 
						</div>
						<div class="general-box-content bg-2 padding-md">
							<div class="errands-area flex-column">
								<?php 
								$consult_errands = $db->prepare("SELECT user_from_id,data,value FROM cms_errands WHERE user_to_id = ? ORDER BY data DESC LIMIT 10");
								$consult_errands->bindValue(1, $profile_result['id']);
								$consult_errands->execute();

								if ($consult_errands->rowCount() > 0) {
									while ($result_errands = $consult_errands->fetch(PDO::FETCH_ASSOC)) {
										$consult_errand_author = $db->prepare("SELECT username,figure FROM players WHERE id = ?");
										$consult_errand_author->bindValue(1, $result_errands['user_from_id']);
										$consult_errand_author->execute();

										$result_errand_author = $consult_errand_author->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="errands-area-box margin-bottom-minm flex">
											<div class="errands-area-box-author-imager">
												<img alt="<?= $result_errand_author['username']; ?>" src="<?= AVATARIMAGE . 'figure=' . $result_errand_author['figure']; ?>&direction=2&head_direction=3&gesture=spk&size=s">
											</div>
											<label class="errands-area-box-label flex-column gray">
												<h6 class="fs-12"><a href="<?= URL . '/profile/' . $result_errand_author['username']; ?>" place="Perfil: <?= $result_errand_author['username'] . ' - ' . HOTELNAME; ?>" class="no-link bold"><?= $result_errand_author['username']; ?></a>&nbsp;|&nbsp;Em <?= utf8_encode(strftime('%d de %B de %Y', $result_errands['data'])); ?> às <?= utf8_encode(strftime('%H:%M', $result_errands['data'])); ?></h6>
												<h5 class="margin-top-minm"><?= Functions::Filter('emoji', $result_errands['value']); ?></h5>
											</label>
											<div class="errands-area-box-actions"></div>
										</div>
										<?php 
									}
								} else { 
									?>
									<div class="errands-area-box-nothing margin-bottom-minm flex padding-min">
										<label class="gray margin-auto-left-right">
											<?php if (isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
												<h5>Looks like you don't have any messages.</h5>
											<?php } else { ?>
												<h5>It seems <b><?= $profile_result['username']; ?></b> has no message.</h5>
											<?php } ?>
										</label>
									</div>
								<?php } ?>
							</div>
							<?php if (isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
								<div class="flex margin-top-min">
									<label class="gray flex-column">
										<h6 class="fs-12 margin-bottom-minm">Easy there??!! You can't leave a message for yourself, but here are the messages that your friends leave for you! If any message contains something offensive or that did not please you, you can delete it, or in more serious cases report the person who left the message to our team.</h6>
										<h6>Take some time to read our <a class="bold">political errands</a> to avoid punishment.</h6>
									</label>
								</div>
							<?php } else { 

								if (isset($user['username'])) {
									$consulte_profile_friended = $db->prepare("SELECT * FROM messenger_friendships WHERE user_one_id = ? AND user_two_id = ?");
									$consulte_profile_friended->bindValue(1, $profile_result['id']);
									$consulte_profile_friended->bindValue(2, $user['id']);
									$consulte_profile_friended->execute();

									if ($consulte_profile_friended->rowCount() > 0) {
										?>
										<div class="send-errand-area flex-column margin-top-md" data-profile-name="<?= $profile_result['username']; ?>">
											<div class="general-contenteditable flex">
												<div contenteditable="true" placeholder="Enter your message here for <?= $profile_result['username']; ?>..."></div>
												<div class="contenteditable-editor flex-column">
													<button class="reset-button bold" onclick="Style('bold');">B</button>
													<button class="reset-button italic" onclick="Style('italic');">I</button>
													<button class="reset-button underline" onclick="Style('underline');">U</button>
												</div>
											</div>
											<button class="green-button-2 send-errand-button" style="width: 100%;height: 40px">
												<label class="white margin-auto">
													<h5>Send message to <b><?= $profile_result['username']; ?></b></h5>
												</label>
											</button>
											<div class="send-errand-area-warn"></div>
										</div>
										<?php 
									} else { 
										?>
										<div class="send-errand-area-nofriends">
											<label class="gray">
												<h5><b>You</b> and <b><?= $profile_result['username']; ?></b> need to be friends to be able to exchange messages!</label></h5>
											</label>
										</div>
										<?php 
									}
								} 
							}
							?>
						</div>
					</div>
					<div class="flex-column">
						<div class="general-box padding-none height-auto overflow-hidden profile-badges">
							<div class="general-box-header-3 padding-md">
								<?php if (isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
									<label class="gray">
										<h5 class="bold">My badges</h5>
										<h6><text>0</text> of <?= number_format($profile_count_badges); ?> badges</h6>
									</label>
								<?php } else { ?>
									<label class="gray">
										<h5 class="bold">Badges from <?= $profile_result['username']; ?></h5>
										<h6><text>0</text> of <?= number_format($profile_count_badges); ?> badges</h6>
									</label>
								<?php } ?> 
							</div>
							<div class="general-box-content flex padding-md bg-2">
								<?php 
								$consult_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot='0' LIMIT 0,1");
								$consult_badges->bindValue(1, $profile_result['id']);
								$consult_badges->execute();

								if ($consult_badges->rowCount() > 0) {
									while ($result_badges = $consult_badges->fetch(PDO::FETCH_ASSOC)) {
										?>
										<div class="profile-badges-display" tooltip="<?= $result_badges['badge_code']; ?>">
											<img alt="<?= $result_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_badges['badge_code']; ?>.gif">
										</div>
										<?php 	
									} 
								} else { 
									?>
									<div class="profile-badges-display not-badged"></div>
								<?php } ?>
								<?php 
								$consult_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot='0' LIMIT 1,1");
								$consult_badges->bindValue(1, $profile_result['id']);
								$consult_badges->execute();

								if ($consult_badges->rowCount() > 0) {
									while ($result_badges = $consult_badges->fetch(PDO::FETCH_ASSOC)) {
										?>
										<div class="profile-badges-display" tooltip="<?= $result_badges['badge_code']; ?>">
											<img alt="<?= $result_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_badges['badge_code']; ?>.gif">
										</div>
										<?php 	
									} 
								} else { 
									?>
									<div class="profile-badges-display not-badged"></div>
								<?php } ?>
								<?php 
								$consult_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot='0' LIMIT 2,1");
								$consult_badges->bindValue(1, $profile_result['id']);
								$consult_badges->execute();

								if ($consult_badges->rowCount() > 0) {
									while ($result_badges = $consult_badges->fetch(PDO::FETCH_ASSOC)) {
										?>
										<div class="profile-badges-display" tooltip="<?= $result_badges['badge_code']; ?>">
											<img alt="<?= $result_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_badges['badge_code']; ?>.gif">
										</div>
										<?php 	
									} 
								} else { 
									?>
									<div class="profile-badges-display not-badged"></div>
								<?php } ?>
								<?php 
								$consult_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot='0' LIMIT 3,1");
								$consult_badges->bindValue(1, $profile_result['id']);
								$consult_badges->execute();

								if ($consult_badges->rowCount() > 0) {
									while ($result_badges = $consult_badges->fetch(PDO::FETCH_ASSOC)) {
										?>
										<div class="profile-badges-display" tooltip="<?= $result_badges['badge_code']; ?>">
											<img alt="<?= $result_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_badges['badge_code']; ?>.gif">
										</div>
										<?php 	
									} 
								} else { 
									?>
									<div class="profile-badges-display not-badged"></div>
								<?php } ?>
								<?php 
								$consult_badges = $db->prepare("SELECT badge_code FROM player_badges WHERE player_id = ? AND slot='0' LIMIT 4,1");
								$consult_badges->bindValue(1, $profile_result['id']);
								$consult_badges->execute();

								if ($consult_badges->rowCount() > 0) {
									while ($result_badges = $consult_badges->fetch(PDO::FETCH_ASSOC)) {
										?>
										<div class="profile-badges-display" tooltip="<?= $result_badges['badge_code']; ?>">
											<img alt="<?= $result_badges['badge_code']; ?>" src="https://swf.ohabbo.org/c_images/album1584/<?= $result_badges['badge_code']; ?>.gif">
										</div>
										<?php 	
									} 
								} else { 
									?>
									<div class="profile-badges-display not-badged"></div>
								<?php } ?>
							</div>
						</div>
						<div class="general-box padding-none height-auto overflow-hidden profile-rooms margin-top-min">
							<div class="general-box-header-3 padding-md">
								<?php if (isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
									<label class="gray">
										<h5 class="bold">My rooms</h5>
										<h6><text>0</text> of <?= number_format($profile_count_rooms); ?> rooms</h6>
									</label>
								<?php } else { ?>
									<label class="gray">
										<h5 class="bold">Rooms from <?= $profile_result['username']; ?></h5>
										<h6><text>0</text> of <?= number_format($profile_count_rooms); ?> rooms</h6>
									</label>
								<?php } ?> 
							</div>
							<div class="general-box-content flex-column bg-2 padding-min">
								<?php 
								$consult_profile_rooms = $db->prepare("SELECT id,name FROM rooms WHERE owner_id = ? AND id != ? LIMIT 5");
								$consult_profile_rooms->bindValue(1, $profile_result['id']);
								$consult_profile_rooms->bindValue(2, $profile_result_settings['home_room']);
								$consult_profile_rooms->execute();

								if ($consult_profile_rooms->rowCount() > 0) {
									while ($result_profile_rooms = $consult_profile_rooms->fetch(PDO::FETCH_ASSOC)) {
										?>
										<div class="profile-rooms-box flex">
											<label class="gray margin-auto-top-bottom">
												<h5><?= Functions::Filter('xss', $result_profile_rooms['name']); ?></h5>
											</label>
											<?php if (isset($user['username'])) { ?>
												<a href="client/<?= $result_profile_rooms['id']; ?>" target="_blank" class="green-button-2 no-link margin-auto-left" style="width: 80px;height: 30px">
													<label class="margin-auto white">
														<h6>Visitar</h6>
													</label>
												</a>
											<?php } ?>
										</div>
										<?php
									}
								} else {
									?>
									<div class="padding-min">
										<label class="text-center">
											<?php if (isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
												<label class="gray">
													<h6>You don't have any rooms!</h6>
												</label>
											<?php } else { ?>
												<label class="gray">
													<h6>It seems that <b><?= $profile_result['username']; ?></b> no have any room.</h6>
												</label>
											<?php } ?>
										</label>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="general-box padding-none height-auto overflow-hidden profile-groups margin-top-min">
							<div class="general-box-header-3 padding-md">
								<?php if (isset($user['username']) && $profile_result['username'] == $user['username']) { ?>
									<label class="gray">
										<h5 class="bold">My groups</h5>
										<h6><text>0</text> from <?= number_format($profile_count_groups); ?> groups</h6>
									</label>
								<?php } else { ?>
									<label class="gray">
										<h5 class="bold">Groups from <?= $profile_result['username']; ?></h5>
										<h6><text>0</text> from <?= number_format($profile_count_groups); ?> groups</h6>
									</label>
								<?php } ?> 
							</div>
							<div class="general-box-content flex padding-md bg-2">
								<?php 
								$consult_profile_groups = $db->prepare("SELECT group_id FROM group_memberships WHERE player_id = ? LIMIT 0,1");
								$consult_profile_groups->bindValue(1, $profile_result['id']);
								$consult_profile_groups->execute();

								if ($consult_profile_groups->rowCount() > 0) {
									while ($result_profile_groups = $consult_profile_groups->fetch(PDO::FETCH_ASSOC)) {
										$consult_group_info = $db->prepare("SELECT name,badge FROM groups WHERE id = ?");
										$consult_group_info->bindValue(1, $result_profile_groups['group_id']);
										$consult_group_info->execute();

										$result_group_info = $consult_group_info->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="profile-group-display flex" tooltip="<?= Functions::Filter('xss', $result_group_info['name']); ?>">
											<img alt="<?= Functions::Filter('xss', $result_group_info['name']); ?>" src="https://swf.ohabbo.org/c_images/Badgeparts/generated/<?= $result_group_info['badge']; ?>.png">
										</div>
										<?php
									}
								} else { 
									?>
									<div class="profile-group-display flex not-group"></div>
								<?php } ?>
								<?php 
								$consult_profile_groups = $db->prepare("SELECT group_id FROM group_memberships WHERE player_id = ? LIMIT 1,1");
								$consult_profile_groups->bindValue(1, $profile_result['id']);
								$consult_profile_groups->execute();

								if ($consult_profile_groups->rowCount() > 0) {
									while ($result_profile_groups = $consult_profile_groups->fetch(PDO::FETCH_ASSOC)) {
										$consult_group_info = $db->prepare("SELECT name,badge FROM groups WHERE id = ?");
										$consult_group_info->bindValue(1, $result_profile_groups['group_id']);
										$consult_group_info->execute();

										$result_group_info = $consult_group_info->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="profile-group-display flex" tooltip="<?= Functions::Filter('xss', $result_group_info['name']); ?>">
											<img alt="<?= Functions::Filter('xss', $result_group_info['name']); ?>" src="https://swf.ohabbo.org/c_images/Badgeparts/generated/<?= $result_group_info['badge']; ?>.png">
										</div>
										<?php
									}
								} else { 
									?>
									<div class="profile-group-display flex not-group"></div>
								<?php } ?>
								<?php 
								$consult_profile_groups = $db->prepare("SELECT group_id FROM group_memberships WHERE player_id = ? LIMIT 2,1");
								$consult_profile_groups->bindValue(1, $profile_result['id']);
								$consult_profile_groups->execute();

								if ($consult_profile_groups->rowCount() > 0) {
									while ($result_profile_groups = $consult_profile_groups->fetch(PDO::FETCH_ASSOC)) {
										$consult_group_info = $db->prepare("SELECT name,badge FROM groups WHERE id = ?");
										$consult_group_info->bindValue(1, $result_profile_groups['group_id']);
										$consult_group_info->execute();

										$result_group_info = $consult_group_info->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="profile-group-display flex" tooltip="<?= Functions::Filter('xss', $result_group_info['name']); ?>">
											<img alt="<?= Functions::Filter('xss', $result_group_info['name']); ?>" src="https://swf.ohabbo.org/c_images/Badgeparts/generated/<?= $result_group_info['badge']; ?>.png">
										</div>
										<?php
									}
								} else { 
									?>
									<div class="profile-group-display flex not-group"></div>
								<?php } ?>
								<?php 
								$consult_profile_groups = $db->prepare("SELECT group_id FROM group_memberships WHERE player_id = ? LIMIT 3,1");
								$consult_profile_groups->bindValue(1, $profile_result['id']);
								$consult_profile_groups->execute();

								if ($consult_profile_groups->rowCount() > 0) {
									while ($result_profile_groups = $consult_profile_groups->fetch(PDO::FETCH_ASSOC)) {
										$consult_group_info = $db->prepare("SELECT name,badge FROM groups WHERE id = ?");
										$consult_group_info->bindValue(1, $result_profile_groups['group_id']);
										$consult_group_info->execute();

										$result_group_info = $consult_group_info->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="profile-group-display flex" tooltip="<?= Functions::Filter('xss', $result_group_info['name']); ?>">
											<img alt="<?= Functions::Filter('xss', $result_group_info['name']); ?>" src="https://swf.ohabbo.org/c_images/Badgeparts/generated/<?= $result_group_info['badge']; ?>.png">
										</div>
										<?php
									}
								} else { 
									?>
									<div class="profile-group-display flex not-group"></div>
								<?php } ?>
								<?php 
								$consult_profile_groups = $db->prepare("SELECT group_id FROM group_memberships WHERE player_id = ? LIMIT 4,1");
								$consult_profile_groups->bindValue(1, $profile_result['id']);
								$consult_profile_groups->execute();

								if ($consult_profile_groups->rowCount() > 0) {
									while ($result_profile_groups = $consult_profile_groups->fetch(PDO::FETCH_ASSOC)) {
										$consult_group_info = $db->prepare("SELECT name,badge FROM groups WHERE id = ?");
										$consult_group_info->bindValue(1, $result_profile_groups['groups_id']);
										$consult_group_info->execute();

										$result_group_info = $consult_group_info->fetch(PDO::FETCH_ASSOC);
										?>
										<div class="profile-group-display flex" tooltip="<?= Functions::Filter('xss', $result_group_info['name']); ?>">
											<img alt="<?= Functions::Filter('xss', $result_group_info['name']); ?>" src="https://swf.ohabbo.org/c_images/Badgeparts/generated/<?= $result_group_info['badge']; ?>.png">
										</div>
										<?php
									}
								} else { 
									?>
									<div class="profile-group-display flex not-group"></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo $Template->AddTemplate('others', 'footer'); ?>
		</div>
<?php echo $Template->AddTemplate('others', 'bottom'); ?>
