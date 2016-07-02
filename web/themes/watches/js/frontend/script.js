
/*scroll in menu*/
	var myScroll = new IScroll('.menu__wrapper',{
		mouseWheel: true,
		scrollbars: true,
		click	: true,
		interactiveScrollbars : true,
		scrollbars: 'custom',
	});
/*active menu items*/
	$(".menu__list .menu-item").on('click.addactive', function () {
		$(".menu__list .menu-item").removeClass("active-item");
		$(this).addClass("active-item");

	});


/*----------------------------------------------------------------------------------------------*/
function Menus() {
	var ismove = false;
	var self   = this;

	this.btns  = {
		'contactOpen'  : '.contact, .menu__contact',
		'contactClose' : '.contact-wrapper, .contact-close',
	};

	this.move = function(action, callback) {
		if (ismove === true) return false;
		ismove = true;

		switch (action) {
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




    var boolopen;
	this.menuIsOpen = false;
	this.menuClose = function() {
		$('.menu').velocity({ translateX: ['-100%', '0%'] });
		this.menuIsOpen = false;
	}

	this.menuOpen = function() {
		var self = this;
		if(this.menuIsOpen)
			return false;

		$('.menu').velocity({ translateX: ['0%', '-100%'] });
		this.menuIsOpen = true;
		/*
		setTimeout(function () {
			$('body').on('click.menuClose', function(e) {

				if ($(e.target).hasClass("menu__inner") || $(e.target).parents(".menu__inner").size()) {
					return true;
				}

				e.preventDefault();
				self.menuClose();
				$('body').off('click.menuClose');
			});
		}, 100);
		*/
	}

	this.init = function() {
		var self = this;
        var boolopen = false;
		$(self.btns['contactOpen']).on('click.contactOpen',function() {
			self.move('contactOpen');
		});

		$('.menu__visible').click(function(){
			self.menuOpen();
            boolopen = true;
                 if(cl==true){
   $('.mini-menu-h').slideUp();
            cl=false;
       }
		});

		$('.close-btn').click(function(e) {
			self.menuClose();
            boolopen = false;
		});
        $('.nav-min').click(function(e) {
            if (boolopen == true){
			self.menuClose();
            boolopen = false;
            }
		});


		/*
		$(".click__brands").on('click', function(e){
			$(this).addClass('open');
			myScroll.refresh();
		});
		*/

		$('.parent_cat.active-item').on('click', function(e){
			if($(this).closest('.click__brands').hasClass('open')) {
				$(this).closest('.click__brands').removeClass('open');
			}	else {
				$(this).closest('.click__brands').addClass('open');
			}

			myScroll.refresh();
			e.preventDefault();
		});

		$(".active-item").closest('.click__brands').addClass('open');
		myScroll.refresh();

	}
}
    $(window).scroll(function() {
         if ($(document).scrollTop()>=$('.popular').height()){
        	$('.img-conteiner>a>img').attr('src','../../../web/img/logo-white-header.jpg');
            $('.header-top').css('background','white');
             $('.img-conteiner').css('background','white');
            $('.img-conteiner').css('border-color','#eeeeee');
            $('.header-top').css('border-color','#eeeeee');
		    }
        else if ($(document).scrollTop()<$('.popular').height()){
             $('.img-conteiner>a>img').attr('src','../../../web/img/logo-black-header.jpg');
             $('.header-top').css('background','black');
            $('.img-conteiner').css('background','black');
            $('.img-conteiner').css('border-color','black');
            $('.header-top').css('border-color','black');
        }
});

$(document).ready(function() {
//        $('.img-conteiner>img').attr('src','../../../web/img/logo-white-header.svg');
//            $('.header-top').css('background','white');
//             $('.img-conteiner').css('background','white');
//            $('.img-conteiner').css('border-color','#eeeeee');
//            $('.header-top').css('border-color','#eeeeee');
//    }
//});

		if ($(document).scrollTop() < $('.popular').height()){
		 	 $('.img-conteiner>a>img').attr('src','../../../web/img/logo-black-header.jpg');
			 $('.header-top').css('background','black');
			 $('.img-conteiner').css('background','black');
			 $('.img-conteiner').css('border-color','black');
			 $('.header-top').css('border-color','black');
	 }

		$('#contact-form').on('submit.contactform',function(){

				$('.contact-inner.contacts').fadeOut(300);
				$('.contact-inner.thanks').fadeIn(300);

				setTimeout(function () {
						(new Menus()).move('contactClose',function(){
								$('.contact-inner.contacts').show();
								$('.contact-inner.thanks').hide();
						});
				}, 1000);

				return false;
		});

})

$(document).ready(function() {
	(new Menus()).init();

})
