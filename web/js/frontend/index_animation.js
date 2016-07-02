function index_animation() {
  this.last_bg_top = 0;
  this.imgs = [];

  this.init = function() {
      $("#popular_grid").css("visibility","visible");


      /* --- RANDOM COLORS --- */
      var self = this;
      $(".popular_grid__li").mouseenter(function() {//console.log("mouseou1t");
        if (self.remouse == true)
          return false;

        var img = $(this).find("img");

        var colors = ['#c1e9f5', '#d4e2fc', '#fbd2e0', '#f1c9fb', '#f5e3ce', '#ffdad9'];
        var random_color = colors[Math.floor(Math.random() * colors.length)];
        var el = $(this).find(".photo_bg");

        var meta = $(this).find(".popular_grid__meta");
        var arrow = $(this).find(".popular_grid__svg");


        var meta_h = $(meta).height();
        var meta_t = ($(".popular_grid__li").height() - meta_h)/2;

        //  < Main color from image
        var mainColor = $(img).attr("background");
        $(el).css({"background" : mainColor});

        // Old
        //$(el).css({"background" : random_color});
        // >

       $(el).velocity({ top: 0 }, "easeInSine", 330);
       $(meta).velocity({ top: meta_t }, "easeInSine", 330);
       $(arrow).velocity({ bottom: "2%" }, "easeInSine", 330);

        var org = $(img).attr("originalSize").split("x");
        $(img).velocity({ width: Math.round(org[0]*1.2), height: Math.round(org[1]*1.2)}, {"delay": 20, "duration": 290});

        self.remouse = true;
      });

      $(".popular_grid__li").mouseleave(function() {
          var el = $(this).find(".photo_bg");
          var meta = $(this).find(".popular_grid__meta");

          var meta_h = $(meta).height();
          var meta_t = ($(".popular_grid__li").height() - meta_h)/2
          var arrow = $(this).find(".popular_grid__svg");
          var img = $(this).find("img");

          $(el).velocity({ top: "100%" }, "easeInSine", 330);
          $(meta).velocity({ top: "100%"  }, "easeInSine", 330);
          $(arrow).velocity({ bottom: "-100%" }, "easeInSine", 330);
          var originalSize = $(img).attr("originalSize").split("x");

          //$(img).velocity({ width :originalSize[0], height : originalSize[1] }, "easeInSine", 330);
          $(img).velocity({ width :originalSize[0], height : originalSize[1] }, "easeInSine", 330);
          self.remouse = false;

      });


      $(".popular_grid__li").velocity({ opacity: 1 }, "easeInSine", 830);

      var self = this;
      this.recalcImg();

      setTimeout(function() {
        $("#h1__pp").velocity({ opacity: 1 }, "easeInSine", 430);
      }, 500);
  }

	this.recalcImg = function() {
		var self = this;
		$(".popular_grid__li img").each(function( index ) {
			if (index > 3) var sindex = index - 3;
			var s = 50*sindex;

			var img = self.imgs[index];
				$(this).velocity({ width: img.scale.width, height: img.scale.height }, "easeInSine", (430+s));
		});
	}

  this.setSizes = function(resize) {
    var size = $(".popular_grid__li").width();
		//console.log("GRID SIZE", size);

    var self = this;
    $(".popular_grid__li img").each(function( index ) {
      var s = $(this).attr('size').split("x");

      if (s[0] > s[1]) {
          var height = size;
          var width  = s[0] * height/s[1];
      }
      else {
        var width   = size;
        var height  = s[1] * width/s[0];
      }




      var top = (size - height)/2;
      var left = (size - width)/2;

      var width = Math.round(width);
      var height = Math.round(height);
      var top = Math.round(top);
      var left = Math.round(left);

      self.imgs[index]  = {css : {}, scale : {}};
      self.imgs[index].css = {"width":Math.round(width*0.5), "height" : (Math.round(height*0.5)), "margin-top" : top, "margin-left" : left};
      //self.imgs[index].css = {"width":width, "height" :height, "margin-top" : top, "margin-left" : left};
      self.imgs[index].scale = {"width":width, "height" : height, "ratio" : 2};


			if (resize) {
				self.imgs[index].css = {"width" : width, "height" : height, "margin-top" : top, "margin-left" : left};
			} else {
				self.imgs[index].css = {"width":Math.round(width*0.5), "height" : (Math.round(width*0.5)), "margin-top" : top, "margin-left" : left};
			}

      $(this).css(self.imgs[index].css);

      // $(this).css({width:width,height:height});
      $(this).attr("originalSize", width +"x" + height);
      $(".photo_bg").css({"width":width+1, "height" : height+1, "top" : height+1});
    });

  }


}


var index_animation = new index_animation();
var loaded1 = 0;
var tm  = false;
var tm2 = false;

$(document).ready(function() {
  //console.log("L");

  index_animation.setSizes();

  tm2 = setTimeout(function() { if (tm) {clearTimeout(tm); } index_animation.init(); }, 590);

 $(".popular_grid__li img").load(function() {
   loaded1++;
   //console.log("loaded1", loaded1);
   if (loaded1 == 6)
     tm = setTimeout(function() { if (tm2) {clearTimeout(tm2);} index_animation.init(); }, 90);
 });


});

$(window).resize(function() {
		index_animation.setSizes(true);
		//setTimeout(function() { index_animation.recalcImg(); }, 200);
});


