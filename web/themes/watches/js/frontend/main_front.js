!function($){

	var page = PAGE;

	// Get one category

	var endInDb    = false;
	var inProgress = false;

	function lazyLoadPreloaderOff() {
		$(".lazyload_preloader__block").hide();
	}

	function lazyLoadPreloaderOn() {
		$(".lazyload_preloader__block").show();
	}

	function lazyLoad() {

		if (endInDb || inProgress) return false;

		inProgress = true;
		lazyLoadPreloaderOn();

		setTimeout(function () {

					var data = {ajax:true};
					var currentPage = +page + 1;

					if (SEARCH) data.search = SEARCH;
					if (CATEGORY) data.category = CATEGORY;

					$.ajax({
						url     : "/page/"+currentPage,
						type    : "GET",
						data    : data,
						cache   : false,
					}).done(function(response) {

						if (!response || response.length < 10 || response == '0' || response == '') {
							endInDb = true;

						} else {

							$("#grid").append(response);

							index_animation.setSizes();
							index_animation.initImgHovers();
							index_animation.changeTitleToShort();


							page++;
							$(".latest__more").attr('href','/page/' + (page + 1));

						}

						inProgress = false;

					}).always(function(){
						lazyLoadPreloaderOff();
					});


			}, 500);

	}

	function checkScrollTopToEnd() {

		return ($(window).scrollTop() + $(window).height() >= $(document).height() - 100);
	}

	$(document).ready(function(){

		setUpSearch();
		lazyLoadPreloaderOff();

		setTimeout(function () {
			if ( checkScrollTopToEnd() ) {
				lazyLoad();
			}
		}, 1000);

		$(window).scroll(function() {

				if ( checkScrollTopToEnd() ) {

					lazyLoad();
				}

		});

	});


var searchFocus = false;
function setUpSearch()
{
		$('#search-form').submit(function(){

			var search = $('.search-input').val().trim();

			search = encodeURIComponent(search);

			if(search != ''){
				window.location.href = HOST + 'search/' + search;
			};

			return false;
		});
}


}(window.jQuery);


// < Efect hover for menu li a
// var itemsMenu = $('.click__brands');
// itemsMenu.hover(
// 	function() {
// 			var id = $(this).attr('id');
// 			$('.click__brands a.main_item').addClass("menu__button");
// 	}, function() {
//
// 	}
// );
// >
