$(document).ready(function() {
	$(document).on('submit', '.lgn-area', function(e) {
		var button = $(this).find(".lgn-button.green-button-1"),
		data = {
			identification : $(this).find('input[name="identification"]').val(),
			password : $(this).find('input[name="password"]').val()
		};

		$.ajax({
			type: $(this).attr('method'),
			url: API + '/login',
			data: data,
			dataType: 'json',
			beforeSend: function() {
				button.attr('disabled', 'disabled');
				button.find('label h5').html(
					'<div class="loader-ellipsis pointer-none">' +
					'   <span></span>' +
					'   <span></span>' +
					'   <span></span>' +
					'</div>'
				);
			},
			success: function(data) {
				if (data['response'] == "error") {
					SetError(data['message']);
				} else if (data['response'] == "ok") {
					EmptyErrors();

					document.location.href = "/me";
				} else {
					SetError('An error occurred while validating your login. Please try again later!');
				}

				button.removeAttr('disabled', 'disabled');
				button.find('label h5').html('Entrar');
			}
		}).fail(function() {
			button.removeAttr('disabled', 'disabled');
			button.find('label h5').html('Entrar');
		});

		return false;
	});
});

$(document).ready(function() {
	$('body').on('submit', '.register-form', function() {
		var button = $(this).find('button[name="submit-reg"]'),
		ecaptcha = grecaptcha.getResponse(),
		data = {
			username: $(this).find('input[name="username"').val(),
			email: $(this).find('input[name="email"]').val(),
			password: $(this).find('input[name="password"]').val(),
			day: $(this).find('select[name="birthday"]').val(),
			month: $(this).find('select[name="birthmonth"]').val(),
			year: $(this).find('select[name="birthyear"]').val(),
			gender: $(this).find('input[name="gender"]:checked').val(),
			captcha: recaptcha
		}

		$.ajax({
			type: $(this).attr('method'),
			url: API + '/register',
			data: data,
			dataType: 'json',
			beforeSend: function() {
				button.attr('disabled', 'disabled');
				button.find('label h4').html(
					'<div class="loader-ellipsis pointer-none">' +
					'   <span></span>' +
					'   <span></span>' +
					'   <span></span>' +
					'</div>'
					);
			},
			success: function(json) {                
				if (json.response == "error") {
					SetError(json.message);

					setTimeout(function() {
						button.removeAttr('disabled', 'disabled');
						button.find('label h4').html('Lets go!');
					}, 500);
				} else if (json.response == "ok") {
					EmptyErrors();

					setTimeout(function() {
						window.location.href = "/me";
					}, 250)
				} else {
					SetError('There was an error registering your account. Please try again later!');

					setTimeout(function() {
						button.removeAttr('disabled', 'disabled');
						button.find('label h4').html('Vamos nessa!');
					}, 500);
				}

				ga('send', 'event', 'Register - Lella Hotel', API + '/register');
			}
		});

		return false;
	});
});

$(document).ready(function() {
	$(document).on('keyup', '.register-inputs input', debounce(function(e) {
		var inputName = $(this).attr('name'),
		inputData = $(this).attr('data-input');

		RegCheck(inputData, inputName);
	}, 500));

	$(document).on('keyup', 'input[name="reg-username"]', function(e) {
		var name = $(this).val(),
		username = $(".result-register-card label h4");

		if (name.length > 0) {
			username.text(name);
		} else {
			username.text('Seu nome aqui!');
		}
	});

	function RegCheck($type, $order) {
		var order = $('input[name="' + $order + '"]').val(),
		input = $('input[name="' + $order + '"]');

		$.post(API + '/check', {
			action: 'register',
			name: $order,
			type: $type,
			value: order
		}, function(json) {
			if (json.status == 'error') {
				input.addClass('error-input');

				$('.reg-status.' + $type + '').html(
					'<div class="error flex">' +
					'   <h6>' + json.message + '</h6>' +
					'   <icon name="error-1"></icon>' +
					'</div>'
					);
			} else if (json.status == 'ok') {
				if (input.hasClass('error-input')) {
					input.removeClass('error-input');
					$('.reg-status.' + $type + '').empty();
				}

				$('.reg-status.' + $type + '').html(
					'<div class="success flex">' +
					'   <icon name="ok-3"></icon>' +
					'</div>'
					);
			}
		});
	}
});

$(document).on('click', '.news-article-like > button', function(e) {
	var button = $(this),
	data = {
		order: 'article',
		article_id: $(this).attr('data-article-id')
	}

	$.ajax({
		type: 'POST',
		url: API + '/reaction',
		data: data,
		dataType: 'json',
		success: function(data) {
			if (data['response'] == 'success') {
				button.find('icon').attr('name', 'heart-big');
				button.parent().find('h5').text(data['likes']);
			} else if (data['response'] == 'update') {
				if (data['state'] == 'remove') {
					button.find('icon').attr('name', 'heart-big-noborder');
					button.parent().find('h5').text(data['likes']);
				} else {
					button.find('icon').attr('name', 'heart-big');
					button.parent().find('h5').text(data['likes']);
				}
			} else if (data['response'] == 'not-found') {
				document.location.reload();
			} else {
				return false;
			}
		}
	});

	return false;
});

$(document).on('submit', '.modal-container-box-form', function(e) {
	var data = {
		order: 'article',
		article_id: $(this).attr('data-article-id'),
		participants: $(this).find('input[name="form-participants"]').val(),
		link: $(this).find('input[name="form-link"]').val(),
		message: $(this).find('textarea[name="form-message"]').val()
	}

	$.ajax({
		type: 'POST',
		url: API + '/form',
		data: data,
		dataType: 'json',
		success: function(data) {
			if (data['response'] == 'success') {
				$('.modal-container-box-form').find('.form-warns').html(data['append']).hide().fadeIn(250);
			} else if (data['response'] == 'error') {
				$('.modal-container-box-form').find('.form-warns').html(data['append']).hide().fadeIn(250);
			} else if (data['response'] == 'not-found') {
				document.location.reload();
			} else {
				return false;
			}
		}
	});

	return false;
});

$(document).on('click', '.article-send-comment .article-send-comment-button > button', function(e) {
	e.preventDefault();

	var button = $(this),
	data = {
		order: 'article',
		article_id: button.attr('data-article-id'),
		value: button.parent().parent().find('.general-contenteditable > [contenteditable]').html().replace(/<div>/gi,'<br>').replace(/<\/div>/gi,'')
	}

	$.ajax({
		type: 'POST',
		url: API + '/comment',
		data: data,
		dataType: 'json',
		success: function(data) {
			if (data['response'] == 'success') {
				$('.general-contenteditable > div:first-child').empty();
				$('<div class="article-comment-box flex general-box margin-top-minm" data-comment-id="' + data['label']['comment-id'] + '"><div class="article-comment-author-habbo margin-right-min"><img alt="' + data['label']['alt'] + '" class="margin-auto" width="32px" height="55px" src="' + data['label']['figure'] + '"></div><label class="gray margin-auto-top-bottom"><h5>' + data['label']['comment'] + '</h5><h6 class="fs-10 margin-top-minm">Por <a href="' + data['label']['profile']['link'] + '" place="' + data['label']['profile']['place'] + '" class="no-link bold">' + data['label']['username'] + '</a> em <b>' + data['label']['time']['date'] + '</b> às <b>' + data['label']['time']['hour'] + '</b></h6></label></div>').prependTo('.article-comments-area').hide().slideDown(250);
				$('.send-comment-warn').slideUp(250, function() {
					$(this).empty();
				});
			} else if (data['response'] == 'error') {
				if ($('.send-comment-warn > div').length > 0) {
					$('.send-comment-warn').slideUp(250, function() {
						$(this).empty(); 
						$(this).html(data['append']).hide().slideDown(250);
					});
				} else {
					$('.article-send-comment').parent().find('.send-comment-warn').html(data['append']).hide().slideDown(250);
				}
			} else if (data['response'] == 'not-found') {
				document.location.reload();
			} else {
				return false;
			}
		}
	});

	return false;
});

$(document).on('keyup', 'input[name="identification"]', debounce(function() {
	$.post(API + '/look', {
		identification: $(this).val()
	}, function(data) {
		if (data['look'].length > 0) {
			$('.identification-look').css('background-image', 'url(' + data['look'] + ')');
		} else {
			$('.identification-look').css('background-image', 'url(' + CDN + '/assets/img/ghost.png)');
		}
	});
}, 500));

$(document).on('click', '.send-errand-area > button.send-errand-button', function() {
	var data = {
		userPath: window.location.pathname,
		username: $(this).parent().attr('data-profile-name'),
		value: $(this).parent().find('.general-contenteditable > div[contenteditable="true"]').html()
	};

	var errands = $(this).parent().parent().find('.errands-area');

	$.ajax({
		url: API + '/errand',
		method: 'POST',
		data: data,
		dataType: 'json',
		beforeSend: function() {
			errands.parent().find('.send-errand-area').addClass('pointer-none');
		},
		success: function(data) {
			errands.parent().find('.send-errand-area').removeClass('pointer-none');

			if (data['response'] == 'success') {
				errands.animate({
					scrollTop: 0
				}, 250);

				if ($('div.errands-area-box-nothing').length >= 1) {
					errands.parent().find('.send-errand-area > .general-contenteditable > div[contenteditable="true"]').empty();
					errands.empty();

					if (errands.find('.errands-area-box').length >= 10) {
						errands.find('.errands-area-box:last-child').fadeOut(250, function() {
							$(this).remove();
						});
					}

					errands.prepend(
						'<div class="errands-area-box margin-bottom-minm flex" data-errand="' + data['label']['errand-id'] + '">' + '\n' +
						'   <div class="errands-area-box-author-imager">' + '\n' +
						'       <img alt="' + data['label']['author']['alt'] + '" src="' + data['label']['author']['figure'] + '">' + '\n' +
						'   </div>' + '\n' +
						'   <label class="errands-area-box-label flex-column gray">' + '\n' +
						'       <h6 class="fs-12"><a href="' + data['label']['author']['profile']['link'] + '" place="' + data['label']['author']['profile']['place'] + '" class="no-link bold">' + data['label']['author']['username'] + '</a> | Em ' + data['label']['time']['date'] + ' às ' + data['label']['time']['hour'] + '</h6>' + '\n' +
						'       <h5 class="margin-top-minm">' + data['label']['value'] + '</h5>' + '\n' +
						'   </label>' + '\n' +
						'</div>'
						).find('.errands-area-box:first-child').hide().fadeIn(500);
				} else {
					errands.parent().find('.send-errand-area > .general-contenteditable > div[contenteditable="true"]').empty();

					if (errands.find('.errands-area-box').length >= 10) {
						errands.find('.errands-area-box:last-child').fadeOut(250, function() {
							$(this).remove();
						});
					}

					errands.prepend(
						'<div class="errands-area-box margin-bottom-minm flex" data-errand="' + data['label']['errand-id'] + '">' + '\n' +
						'   <div class="errands-area-box-author-imager">' + '\n' +
						'       <img alt="' + data['label']['author']['alt'] + '" src="' + data['label']['author']['figure'] + '">' + '\n' +
						'   </div>' + '\n' +
						'   <label class="errands-area-box-label flex-column gray">' + '\n' +
						'       <h6 class="fs-12"><a href="' + data['label']['author']['profile']['link'] + '" place="' + data['label']['author']['profile']['place'] + '" class="no-link bold">' + data['label']['author']['username'] + '</a> | Em ' + data['label']['time']['date'] + ' às ' + data['label']['time']['hour'] + '</h6>' + '\n' +
						'       <h5 class="margin-top-minm">' + data['label']['value'] + '</h5>' + '\n' +
						'   </label>' + '\n' +
						'</div>'
						).find('.errands-area-box:first-child').hide().fadeIn(500);
				}

				if ($('.send-errand-area-warn').length > 0) {
					$('.send-errand-area-warn').slideUp(500, function() {
						$('.send-errand-area-warn').empty();
					});
				}
			} else if (data['response'] == 'error') {
				if ($('.send-errand-area-warn').length > 0) {
					$('.send-errand-area-warn').slideUp(500, function() {
						$('.send-errand-area-warn').empty(); 
						$('.send-errand-area-warn').append(data['append']).hide().slideDown(500);
					});
				} else {
					$('.send-errand-area-warn').append(data['append']).hide().slideDown(500);
				}
			}
		}
	});

	return false;
});

$(document).on('click', '.general-box > .general-box-container > .general-box-content button.buy-package', function() {
	var package = $(this).attr('data-package'),
	button = $(this),
	container = $(this).parent().parent().parent().parent();

	$.ajax({
		url: API + '/shop',
		type: 'POST',
		data: {
			order: 'vip',
			package: package
		},
		dataType: 'json',
		beforeSend: function() {
			button.addClass('pointer-none');
			button.animate({
				'opacity': '0.9'
			});
		},
		success: function(data) {
			if (data['response'] == 'success') {
				if (container.find('.general-box-warn > div').length > 0) {
					container.find('.general-box-warn').slideUp(500, function() {
						container.find('.general-box-warn').empty();
						container.find('.general-box-warn').hide().html(data['label']).slideDown(500);
					});
				} else {
					container.find('.general-box-warn').hide().html(data['label']).slideDown(500);
				}
			} else {
				if (container.find('.general-box-warn > div').length > 0) {
					container.find('.general-box-warn').slideUp(500, function() {
						container.find('.general-box-warn').empty();
						container.find('.general-box-warn').hide().html(data['label']).slideDown(500);
					});
				} else {
					container.find('.general-box-warn').hide().html(data['label']).slideDown(500);
				}
			}

			button.removeClass('pointer-none');
			button.animate({
				'opacity': '1'
			});
		}
	});

	return false;
});

$(document).on('submit', 'form.send-form-article', function() {
	var inputs = {};

	$(this).find('.form-input').each(function(index, element) {
		if ($(element).prop("tagName") == "INPUT" && $(element).attr("type") == "text") {
			inputs[$(element).attr('name')] = $(element).val();
		} else if ($(element).prop("tagName") == "TEXTAREA") {
			inputs[$(element).attr('name')] = $(element).val();
		} else if ($(element).prop("tagName") == "INPUT" && $(element).attr("type") == "radio" && $(element).is(":checked")) {
			inputs[$(element).attr('name')] = $(element).val();
		} else {
			return;
		}
	});

	var form = $(this),
	button = form.find('button[type="submit"]'),
	data = {
		order: 'send',
		article_id: form.attr('data-article-id'),
		inputs: JSON.stringify(inputs)
	};

	$.ajax({
		url: '/api/actions/form.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		beforeSend: function() {
			form.find('.input-error').removeClass('input-error');
			form.find('.input-errors').empty();

			button.attr('disabled', 'disabled');
		},
		success: function(data) {
			if (data['response'] == 'success') {
				form.trigger('reset');

				if (form.find('.form-warns > .form-warn').length > 0) {
					form.find('.form-warns >. form-warn').slideUp(250, function() {
						$(this).parent().empty();

						form.find('.form-warns').hide().append(data['append']).slideDown(250);
					});
				} else {
					form.find('.form-warns').hide().append(data['append']).slideDown(250);
				}
			} else {
				if (data['response'] == 'error' && data['input']) {
					form.find(data['input']).addClass('input-error');
					form.find(data['input']).parent().find('.input-errors').html(data['append']);

					if (form.find('.form-warns > .form-warn').length > 0) {
						form.find('.form-warns > .form-warn').slideUp(250, function() {
							$(this).parent().empty();
						});
					}
				} else {
					if (form.find('.form-warns > .form-warn').length > 0) {
						form.find('.form-warns > .form-warn').slideUp(250, function() {
							$(this).parent().empty();

							if (data['append']) {
								form.find('.form-warns').hide().append(data['append']).slideDown(250);
							}
						});
					} else {
						form.find('.form-warns').hide().append(data['append']).slideDown(250);
					}
				}
			}

			setTimeout(function() {
				button.attr('disabled', null);
			}, 500);
		}
	}).fail(function() {
		button.attr('disabled', null);
	});

	return false;
});
/*
function add_like(id) {
	$('#players-who-liked-'+id+'').html('<img src="https://www.itcosmetics.com/on/demandware.static/Sites-itcosmetics-us-Site/-/default/dw886f70b8/images/loading-small.gif" style="width:15px;height:15px;margin-top:4px;"/>');

	$.post(API + '/actions/add-like.php', {id: id}, function(dados){
		if(dados == 'sucesso') {
			get_like(id);
		} else {
			alert("Você já reagiu a esta publicação!");
			window.location.reload()
		}
	});
	
}

function get_like(id){
	$.post(API + '/actions/likefeed.php', {id: id}, function(valor){
		$('#players-who-liked-'+id+'').text(valor);
	})
}

function deleteFeed(id) {
	$.post(API + '/actions/deleteFeed.php', {id: id}, function(dados) {
		if(dados == 'sucesso') {
			alert("Voce removeu esta publicação!");
			window.location.reload()
		} else {
			alert("Erro ao excluir publicação");
		}
	});
}		

function deleteBan(id) {
	$.post(API + '/actions/deleteban.php', {id: id}, function(dados) {
		if(dados == 'sucesso') {
			alert("Ban removido com sucesso!");
			window.location.reload()
		} else {
			alert("Erro ao retirar banimento");
		}
	});
}
*/

