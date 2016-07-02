function index_animation() {
  this.last_bg_top = 0;
  this.imgs = [];

  this.init = function() {
		var self = this;
		this.setSizes();
		this.changeTitleToShort();
		this.initImgHovers();

		$(window).resize(function() {
		    self.setSizes();
		});
  }

	this.changeTitleToShort = function() {

		var length = 48;

		$('.latest__meta-title, .page__posts-link').not("[short]").each(function(){

			this.setAttribute("short", "true");

			var text = $(this).html();

			if (text.length > length) {
				$(this).html(text.substr(0,length-3) + '...')
			}

		})
	}

	this.initImgHovers = function() {
		var self = this;

		$(".popular__item, .latest__item").off('mouseenter.img');
		$(".popular__item, .latest__item").on('mouseenter.img',function() {

			var img    = $(this).find("img[size]");
			if (!img.length) return false;
			var org = $(img).attr("originalSize").split("x");

			$(img).css({
				width: Math.round(org[0]*1.2),
				height: Math.round(org[1]*1.2)
			});

		});

		$(".popular__item, .latest__item").off('mouseleave.img');
		$(".popular__item, .latest__item").on('mouseleave.img',function() {

			var img    = $(this).find("img[size]");
			if (!img.length) return false;

          var originalSize = $(img).attr("originalSize").split("x");

					$(img).css({
						width  : originalSize[0],
						height : originalSize[1]
					});

      });
	}

	this.calcSize = function(o) {
		o.x      = Number(o.x);
		o.y      = Number(o.y);
		o.height = Number(o.size);
		o.width  = Number(o.size);

		if (o.x > o.y) {
			o.width  = o.x * o.height / o.y;
		} else {
			o.height  = o.y * o.width / o.x;
		}

		return {
			"margin-top"    : Math.round((o.size - o.height)/2),
			"margin-left"   : Math.round((o.size - o.width)/2),
			"width"  : Math.round(o.width),
			"height" : Math.round(o.height)
		}

	}

	this.setCalcSizes = function(item, owerflowSize) {
		var size = item.getAttribute("size").split("x");
		var css  = this.calcSize({
			x     : size[0],
			y     : size[1],
			size  : owerflowSize,
		})

		$(item).css(css);
		$(item).attr("originalSize", css.width +"x" + css.height);
	}

  this.setSizes = function() {
		var self = this;
    var size = $(".popular__item").width();

		$(".popular__item img[size]").not('[originalSize]').each(function( index ) {
			self.setCalcSizes(this, size);
    });

		var size = $(".latest__item").width();
    $(".latest__item img[size]").not('[originalSize]').each(function( index ) {
			self.setCalcSizes(this, size);
    });

  }

}


var index_animation = new index_animation();
var loaded1 = 0;
var tm  = false;
var tm2 = false;

$(document).ready(function() {
	index_animation.init();
	index_layout_size();
});

$(window).resize(function() {
		index_layout_size();
});

function index_layout_size() {

		var $list = $(".popular__list");
		if ($list.length < 1) return false;

		var position = $list.offset();
		var height   = $list.height();
		var width    = window.innerWidth/2 - $list.width()/2;

		var window_width = window.innerWidth;
		var top = position.top - ( window_width * 0.01);

		$(".net__top").css({height: top});
		$(".net__bottom").css({top: top+height, height: top*2});

		$(".net__l1_left").css("width", position.left);
		$(".net__l2_left").css("width", position.left-(position.left*0.15));
		$(".net__l3_left").css("width", position.left);
}
