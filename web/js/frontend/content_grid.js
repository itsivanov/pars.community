function content_grid() {

	var self = this;

	this.borderV = 10;
	this.borderH = 10;
	this.countInRow = 3;

  // this.images = {};
  // this.image_draw_iter = 0;
  // this.image_draw_line_iter = 0;
  // this.image_draw_all_iter = 0;
  // this.columns_height = [0, 0, 0];

	this.columns_height = [];
  this.remouse = false;




  this.init = function() {
    var self = this;


    $(".grid-item").mouseenter(function() {
      if (self.remouse == true)
        return false;

      var img = $(this).find("img");

      var colors = [
        'rgba(193, 233, 245, 0.9)',
        'rgba(212, 226, 252, 0.9)',
        'rgba(251, 210, 224, 0.9)',
        'rgba(241, 201, 251, 0.9)',
        'rgba(245, 227, 206, 0.9)',
        'rgba(255, 218, 217, 0.9)'
      ];

      var random_color = colors[Math.floor(Math.random() * colors.length)];
      var el = $(this).find(".item-desctription");
  		$(this).find(".item-desctription").animate({"opacity": 1}, 200);

			//  < Main color from image
			var mainColor = $(img).attr("background");
			$(el).css({"background" : mainColor});

			// Old
			//$(el).css({"background" : random_color});
			// >

      self.remouse = true;
    });

    $(".grid-item").mouseleave(function() {
      $(this).find(".item-desctription").animate({"opacity": 0}, 200);
        self.remouse = false;
    });


		this.container = $("#grid");
		$(this.container).show();

		self.resize();

		$(window).resize(function() {
			self.resize();
		});

  }

	this.resize = function() {
		this.container__width =  $(this.container).width();

		if (this.container__width < 650) {
			this.countInRow = 2;
		} else {
			this.countInRow = 3;
		}

		this.box__width_target =  Math.round((this.container__width - this.borderH * (this.countInRow - 1)) / this.countInRow );

		this.images = {};
		this.image_draw_line_iter = 0;
		this.image_draw_iter = 0;
		this.image_draw_line_iter = 0;
		this.image_draw_all_iter = 0;

		for (var i = 0; i < self.countInRow; i++) {
			this.columns_height[i] = 0
		}

		$(this.container).find(".grid-img").each(function(index) {
				var top = 0;

				if (self.image_draw_iter == self.countInRow) {
					self.image_draw_iter = 0;
					self.image_draw_line_iter ++;
				}

				var obj   = $(this);
				var size  = obj.attr("size").split("x");
				var ratio = self.box__width_target / size[0];

				size[0] = self.box__width_target;
				size[1] = size[1] * ratio;

				self.images[index] = { obj  : obj, "n_width" : size[0], "n_height" : size[1]};
	///console.log("index:",{ obj  : obj, "n_width" : size[0], "n_height" : size[1]});

				var left = self.image_draw_iter * self.box__width_target;
				//console.log("LEFT", left);
				// console.log(self.image_draw_line_iter, self.image_draw_iter, index);
				if (  self.image_draw_line_iter > 0)
					top = self.images[(index-self.countInRow)].n_height * self.image_draw_line_iter;


				$(obj).css({"width": size[0]});

				if (self.image_draw_iter > 0) left = left + (self.borderH*self.image_draw_iter);
				if (self.image_draw_line_iter > 0) top = self.columns_height[self.image_draw_iter]

				self.columns_height[self.image_draw_iter] = self.columns_height[self.image_draw_iter] + size[1] + self.borderV;

				$(".grid-item:nth-child("+(index+1)+")").css({"left" : left, "top" : top, "width" : size[0], "height" : size[1]});


				self.image_draw_iter++;
				self.image_draw_all_iter++;

		});

		$(this.container).height(Math.max(...this.columns_height));

	}

}



$(document).ready(function(){
    var cg = new content_grid();
    setTimeout(function() {
        cg.init();
    },1200);
});
