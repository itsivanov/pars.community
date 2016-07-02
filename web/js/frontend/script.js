$(document).ready(function() {
/*scroll in menu*/
	var myScroll = new IScroll('.menu__super_inner',{
		mouseWheel: true,
		scrollbars: true,
		interactiveScrollbars : true,
		scrollbars: 'custom',
	});
/*show submenu*/

	$(".menu__item .menu__button").on('click.openminimenu', function(){


		$('.menu__list').find('ul').removeClass("show");
		$('.menu__super_inner').removeClass("brands-slow");

		var $ul = $(this).parent().find('ul');

		if ($ul.length > 0) {
			$ul.addClass( "show");
			$('.menu__super_inner').addClass("brands-slow");
			myScroll.refresh();
		}

	});

	// $(".click__brands").click(function() {
	// 	$('.menu__brands').toggleClass( "show");
	// 	$('.menu__super_inner').toggleClass( "brands-slow");
	// 	myScroll.refresh();
	// });

/*active menu items*/
	$(".menu__list .menu__item").on('click.addactive', function () {
		$(".menu__list .menu__item").removeClass("active-item");
		$(this).addClass("active-item");

	});
/*active menu brand items */
	$(".menu__brands .menu__brands-item").click(function () {
		$(".menu__brands .menu__brands-item").removeClass("brands-active-item");
		$(this).addClass("brands-active-item");
	});
});
