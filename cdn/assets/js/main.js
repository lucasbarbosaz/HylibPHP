console.log("%cIMPORTANT WARNING", "font: bold 40px sans-serif;color: rgb(237, 28, 28);text-shadow: 2px 0 0 rgb(0, 0, 0), -2px 0 0 rgb(0, 0, 0), 0 2px 0 rgb(0, 0, 0), 0 -2px 0 rgb(0, 0, 0), 1px 1px rgb(0, 0, 0), -1px -1px 0 rgb(0, 0, 0), 1px -1px 0 rgb(0, 0, 0), -1px 1px 0 rgb(0, 0, 0)");
console.log("%cThe console, is a development tool. In case someone asks you to paste something here saying that you can earn any kind of currency, do not believe, otherwise you will be compromising the access of your account through something you pasted here.\n\nEverything you do through the console, it will be your sole responsibility!\n\Equipe CrazzY - lella.org\n", "bold 20px sans-serif");

var html = $("html"),
head = $("head"),
body  = $("body"),
container = $(".container"),
content = $(".content"),
loader = $(".loader"),
client = $(".client");

var URL = document.location.origin,
API = URL + '/api',
CDN = URL + '/cdn',
HOTELNAME = 'Lella Hotel';

$(document).ready(function(){
	setTimeout('$(".loader").fadeOut(100)', 1500);

});

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;

		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};

		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);

		if (callNow) {
			func.apply(context, args)
		};
	};
}

function Style(type, argument) {
	document.execCommand(type, false, null);
}

function SetError(message) {
	if ($('.errors-top > .error-top').length > 0) {
		$('.errors-top > .error-top').slideUp(250, function() {
			$(this).remove();

			$('<div class="error-top flex">' + '\n' +
				'   <div class="error-top-icon flex">' + '\n' +
				'       <icon name="error-top" class="margin-auto"></icon>' + '\n' +
				'   </div>' + '\n' +
				'   <label class="bold white margin-auto">' + '\n' +
				'       <h5>' + message + '</h5>' + '\n' +
				'   </label>' + '\n' +
				'</div>'
			).appendTo('.errors-top').hide().slideDown(500);
		});
	} else {
		$('<div class="error-top flex">' + '\n' +
			'   <div class="error-top-icon flex">' + '\n' +
			'       <icon name="error-top" class="margin-auto"></icon>' + '\n' +
			'   </div>' + '\n' +
			'   <label class="bold white margin-auto">' + '\n' +
			'       <h5>' + message + '</h5>' + '\n' +
			'   </label>' + '\n' +
			'</div>'
		).appendTo('.errors-top').hide().slideDown(500);
	}
}

function EmptyErrors() {
	$('.errors-top > .error-top').slideUp(250, function() {
		$(this).remove();
	});
}

function setBirthDays() {
	for (i = 1; i < 31; i++){
		if (i < 10) {
			i = "0" + i;
		}

		$(".days").append($('<option />').val(i).html(i));
	}

	for (i = 1; i < 13; i++){
		if (i < 10) {
			i = "0" + i;
		}

		$(".months").append($('<option />').val(i).html(i));
	}

	for (i = new Date().getFullYear(); i > 1944; i--) {
		$(".years").append($('<option />').val(i).html(i));
	}
}

function recaptcha() {
	$.ajax({
		url: 'https://www.google.com/recaptcha/api.js',
		dataType: "script"
	});
}

function recaptchaExpired() {
	setTimeout(function() {
		grecaptcha.reset();
	}, 1000);
}

/* --------------------------------------------------------------- */

function updateTemplate() {
	$(document).ready(function() {
		var eventsMe = $(".col-8 > div");

		if (eventsMe.length == 2) {
			eventsMe.parent().addClass('two-events');
		} else if (eventsMe.length == 0) {
			$(".col-8").html(
				'<div class="dont-events-box">' +
				'    <label class="white margin-auto-top-bottom margin-auto-right text-nowrap">' +
				'         <h3 class="bold text-nowrap">Ops!</h3>' +
				'         <h6 class="text-nowrap">There doesnt seem to be an event yet.</h6>' +
				'    </label>' +
				'</div>'
			);
		}
	});

	$(document).ready(function() {
		var badgesCount = $('.general-box.profile-badges > .general-box-content > .profile-badges-display').not('.not-badged');
		badgesCount.parent().parent().find('.general-box-header-3 > label > h6 > text').text(badgesCount.length);

		var roomsCount = $('.general-box.profile-rooms > .general-box-content').find('.profile-rooms-box');
		roomsCount.parent().parent().find('.general-box-header-3 > label > h6 > text').text(roomsCount.length);

		var groupsCount = $('.general-box.profile-groups > .general-box-content').find('.profile-group-display').not('.not-group');
		groupsCount.parent().parent().find('.general-box-header-3 > label > h6 > text').text(groupsCount.length);
	});

	setBirthDays();
	EmptyErrors();
	recaptcha();
	SetIntervals();
}

var articles = $('.last-article-news'),
initialSlide = 1,
intervalArticles = null;

articles.hide();
articles.first().show();

$(document).on('click', '.control-last-articles-news > span.next', function() {
	var currentSlide = $('.last-article-news:visible'),
	nextSlide = (currentSlide.next().length) ? currentSlide.next() : $('.last-article-news').first(),
	slideController = $(this).parent().find('span');

	slideController.addClass('pointer-none');

	currentSlide.fadeOut('slow');
	nextSlide.fadeIn('slow', function() {
		slideController.removeClass('pointer-none');
	});
});

$(document).on('click', '.control-last-articles-news > span.prev', function() {
	var currentSlide = $('.last-article-news:visible'),
	prevSlide = (currentSlide.prev().length) ? currentSlide.prev() : $('.last-article-news').last(),
	slideController = $(this).parent().find('span');

	slideController.addClass('pointer-none');

	currentSlide.fadeOut('slow');
	prevSlide.fadeIn('slow', function() {
		slideController.removeClass('pointer-none');
	});
});

var intervalArticlesInit = function() {
	var currentSlide = $('.last-article-news:visible'),
	nextSlide = (currentSlide.next().length) ? currentSlide.next() : $('.last-article-news').first();

	currentSlide.fadeOut('slow');
	nextSlide.fadeIn('slow');
};

$(document).on('mouseover', '.last-articles-news', function() {
	clearInterval(intervalArticles);
}).on('mouseout', '.last-articles-news', function() {
	intervalArticles = setInterval(intervalArticlesInit, 5000);
});

/* --------------------------------------------------------------- */

var intervalOnlineCount = null,
intervalOnlineCountInit = function() {
	$.post(API + '/get/online.php', function(data) {
		$('.header__users-online > label > h5').html(data['count']);
	});
}

/* --------------------------------------------------------------- */

$(document).on('mousemove', '[habbo-tooltip]', function(e) {
	var tooltip = $('.tooltip');

	if ($(this).is(':hover')) {
		tooltip.html($(this).attr('habbo-tooltip')).css({
			'left': e.pageX += 20,
			'top': e.pageY += 20,
			'display': 'block'
		});
	}
}).on('mouseout', '[habbo-tooltip]', function() {
	var tooltip = $('.tooltip');

	tooltip.attr('style', null);
	tooltip.empty();
});

/* --------------------------------------------------------------- */

$(document).on('click', '.general-box.vip button.benefits', function() {
	var benefits = $(this).parent().parent().parent().find('.general-box-header > .vip-benefits'),
	button = $(this);

	if (benefits.hasClass('show')) {
		benefits.slideUp(500);
		benefits.removeClass('show');
		button.find('label > h5 > span').text('Ver');
	} else {
		benefits.slideDown(500);
		benefits.addClass('show');
		button.find('label > h5 > span').text('Esconder');
	}
}).on('keyup', 'form.register-form input[name="username"]', function() {
	var value = ($(this).val().length > 0) ? $(this).val() : 'Seu nome aqui!';

	return $('form.register-form').find('.result-register-card > label > h4').text(value);
}).on('change', 'form.register-form input[name="gender"]', function() {
	var genderName = ($(this).val() == 'female') ? 'female' : 'male';

	$('form.register-form').find('.result-register-card > .habbo-result.default').removeClass('default').removeClass('default');

	if (genderName == 'female' && $('form.register-form').find('.result-register-card > .habbo-result').hasClass('male')) {
		$('form.register-form').find('.result-register-card > .habbo-result').removeClass('male').addClass('female');
	} else {
		$('form.register-form').find('.result-register-card > .habbo-result').removeClass('female').addClass('male');
	}
}).on('click', '.open-modal', function() {
	var dataModal = $(this).attr('data-modal');

	if ($('.modal-container[data-modal="' + dataModal + '"]').length > 0) {
		setTimeout(function() {
			$('.modal-container[data-modal="' + dataModal + '"]').toggleClass('show');
		}, 100);
	}
});

function SetIntervals() {
	/* ---------------------------------------------- */
	intervalArticles = setInterval(intervalArticlesInit, 5000);
	intervalOnlineCount = setInterval(intervalOnlineCountInit, 5000);
	/* ---------------------------------------------- */
}

/* --------------------------------------------------------------- */

function detectAdBlock() {
	var adBlockBanner = document.getElementById('kop');

	if (adBlockBanner == null || adBlockBanner['offsetHeight'] <= 0) {
		if (document.location.pathname != '/adbloc') {
			document.location.href = '/adblock';
		}

		console.log('[DETECT ADBLOCK] AdBlock detected.');
	} else {
		console.log('[DETECT ADBLOCK] Not found AdBlock.');
	}
}

$(document).on('keyup', 'input', function(e) {
	var value = $(this).val();

	if ($(this).length > 0 && $(this).attr('type') !== 'password') {
		$(this).attr('value', value);
	}
}).on('click', '.header-menu.dropdown > label', function(e) {
	$(this).parent().find('.dropdown-content').slideUp(200)
	if ($(this).parent().hasClass('active')) {
		$(this).parent().removeClass('active');
	} else {
		$(this).parent().addClass('active');
		$(this).parent().find('.dropdown-content').first().slideDown(300);
		$(this).parent().siblings().find('.dropdown-content').slideUp(200);
		$(this).parent().siblings().removeClass('active');
	}
}).on('click', function(e) {
	if (!e.target.matches('.header-menu.dropdown > .dropbtn')) {
		var dropmenu = $('.header-menu.dropdown'),
		dropdown = dropmenu.find('.dropdown-content');

		if (dropmenu.hasClass('active')) {
			dropmenu.removeClass('active');
			dropdown.slideUp(200);
		}
	}

	if ($('.modal-container.show').length > 0) {
		if (!$('.modal-container.show > .modal-container-box').is(':hover')) {
			$('.modal-container.show').removeClass('show');
		}
	}
});

$(window).on('load', function(e) {
	updateTemplate();
	detectAdBlock();
});