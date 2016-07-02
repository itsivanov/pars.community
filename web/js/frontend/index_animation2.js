function index_animation() {

  this.remouse = false;
  this.init = function() {
    var self = this;
    $(".popular_grid__li").mouseenter(function() {console.log("mouseou1t");
      if (self.remouse == true)
        return false;

      var colors = ['#c1e9f5', '#d4e2fc', '#fbd2e0', '#f1c9fb', '#f5e3ce', '#ffdad9'];
      var random_color = colors[Math.floor(Math.random() * colors.length)];

      $(".photo_bg").css({"background" : random_color});

      self.remouse = true;
    });

    $(".popular_grid__li").mouseleave(function() {

        self.remouse = false;

    });



    $("#first_screen").addClass("slowOpacity");
    $("#section1__content").addClass("showBlocks");
    $("#h1__pp").addClass("showBlocks_h1");
    $("#popular_grid").css("opacity",1);


    setTimeout(function() {
      /*$("#first_screen").addClass("animation_done").removeClass("slowOpacity").removeClass("beforeAnimationDone");*/

      $("#first_screen").addClass("animation_done").removeClass("beforeAnimationDone");


      $("#section1__content").removeClass("showBlocks");
      $("#h1__pp").removeClass("showBlocks_h1");
    }, 1400);



  }


  this.setSizes = function() {
    var size = $(".popular_grid__li").width();


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

      $(this).css({"width":width, "height" : height, "margin-top" : top, "margin-left" : left});

    });

  }


}


var index_animation = new index_animation();
var loaded1 = 0;
var tm  = false;
var tm2 = false;

$(document).ready(function() {
  index_animation.setSizes();
   tm2 = setTimeout(function() { if (tm) {clearTimeout(tm); } index_animation.init(); }, 590);

  $(".popular_grid__li img").load(function() {
    loaded1++;
    console.log("loaded1", loaded1);
    if (loaded1 == 6)
      tm = setTimeout(function() { if (tm2) {clearTimeout(tm2);} index_animation.init(); }, 90);
  });
});
