function Menus() {
	var ismove = false;
	var self   = this;

	this.btns  = {
		'menuOpen'    : '.btn-menu-open',
		'menuClose'   : '.index_main, header, .menu .icon-close, .contact, .copyright',

		'searchOpen'  : '.btn-search-open',
		'searchClose' : '.search-close',

		'contactOpen'  : '.contact, .menu__contact',
		'contactClose' : '.contact-wrapper, .contact-close',
	};

	this.move = function(action, callback) {


		if (ismove === true) return false;
		ismove = true;

		switch (action) {
			case 'menuOpen':
			case 'menuClose':
			case 'searchOpen':
			case 'searchClose':
			case 'contactOpen':
			case 'contactClose':
				this[action](function(){ismove = false;if (typeof callback === 'function') callback();})
				break;

		}
	}

	this.contactClose = function(callback) {


		$(self.btns['contactClose']).off('click.contactClose');

		$('.contact-wrapper').velocity({ opacity: 0}, 500);

		setTimeout(function () {
			$('.contact-wrapper').css({
				display    : 'none',
				visibility : 'hidden',
				opacity    : '0',
			});
			callback();
		},501);
	}

	this.contactOpen = function(callback) {
		$('.contact-wrapper').css({
			display    : 'block',
			visibility : 'visible',
			opacity    : '0',
		});

		setTimeout(function () {
			$('.contact-wrapper').velocity({ opacity: 1}, 500);
		},10);

		setTimeout(function () {
			callback();
		},501);

		setTimeout(function () {

			$(".example").click(function(){
			  $(this).fadeOut("fast");
			}).children().click(function(e) {
			  return false;
			});

			$(self.btns['contactClose']).on('click.contactClose', function() {
				self.move('contactClose');
			}).children(':not(.contact-close)').on('click.contactClose',function(e) {
				event.stopPropagation();
			});

		}, 100);
	}

	this.searchOpen = function(callback) {
		$('.search-block').css({
			display    : 'block',
			visibility : 'visible',
			top        : - $('.search-block').outerHeight(),
		});

		setTimeout(function () {
			$('.search-block').velocity({ top: 0}, 500);
		},10);

		setTimeout(function () {
			callback();
		},501);

		setTimeout(function () {
			$(self.btns['searchClose']).on('click.searchClose', function() {
				self.move('searchClose');
			});
		}, 100);
	}

	this.searchClose = function(callback) {

		setTimeout(function () {
			$('.search-block').velocity({ top: -$('.search-block').outerHeight()}, 500);
		},10);

		$(self.btns['searchClose']).off('click.searchClose');

		setTimeout(function () {
			$('.search-block').css({
				display    : 'none',
				visibility : 'hidden',
			});

			callback();
		},501);
	}

	this.menuClose = function(callback) {
		var width = $('.menu').outerWidth();

		setTimeout(function () {
			$('.copyright, .contact, .btn-menu-open').removeClass('hide');
		},600);

		$('header, .index_main, .copyright').velocity({ left: '0'}, 500);
		$('.menu').velocity({ left: width/2}, 500);

		$(self.btns['menuClose']).off('click.menuClose');

		setTimeout(function () {
			$('body').removeClass('body-menu-open');
			callback();
		},501);
	}

	this.menuOpen = function(callback) {

		var width = $('.menu').outerWidth();

		$('.copyright, .contact, .btn-menu-open').addClass('hide');

		$('body').addClass('body-menu-open');

		$('header, .index_main').velocity({ left: width}, 500);
		console.log('asdsfd');
		$('.menu').velocity({ left: '0'}, 500);

		setTimeout(function () {
			callback();
		},501);

		setTimeout(function () {

			$(self.btns['menuClose']).on('click.menuClose', function() {
				self.move('menuClose');
			});
		}, 100);

	}

	this.init = function() {
		$(self.btns['menuOpen']).on('click.menuOpen',function() {
			self.move('menuOpen');
		});

		$(self.btns['searchOpen']).on('click.searchOpen',function() {
			self.move('searchOpen');
		});

		$(self.btns['contactOpen']).on('click.contactOpen',function() {
			self.move('contactOpen');
		});


	}
}


$(document).ready(function() {
	(new Menus()).init();
});


