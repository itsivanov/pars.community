function index_first_grid() {

  this.start_size = 0.2415;
  this.init = function() {

    this.cache_selectors();

    this.set_sizes();

    setTimeout(function() {
    $("#section1_opacity").addClass("slowOpacity");
    $(".popular_grid__img").addClass("showBlocks");
  }, 300);



  }

  this.$images = [];
  this.$li = [];
  this.cache_selectors = function() {

      var li  = $(".popular_grid__li");
      var imgs = $(".popular_grid__img");

      for (var i = 0; i < imgs.length; i++) {

        var size = $(imgs[i]).attr("size").split("x");
        this.$images[i] = {obj : $(imgs[i]), size : size};
        this.$li[i] = {obj : $(li[i])};
      }

      console.log("cache_selectors", [li, imgs, this.$images]);
  }



  this.set_sizes = function() {
      var start_size = this.get_start_size();
      var rw    = this.get_rw();
      var vh    = this.get_vh();
      var li    = this.$li;
      var imgs  = this.$images;
      var scale = 1.1;
      var marginR = 0.01;

      var box_size = Math.round(rw * start_size);


      $("#popular_grid").height((box_size*3));

      for (var i in li) {
        var el = li[i];

        mr = Math.round(rw * marginR);

        if (i == 0) {
          left = Math.round((box_size + mr ) * 2);
          top = 0;
        }
        else if (i > 0 && i < 5) {
          left = Math.round((box_size + mr  ))* (i -1);
          top = box_size + mr;
        }
        else if (i == 5) {
          left = Math.round((box_size + mr  ));
          top = (box_size + mr) * 2;
        }
        else {
            top = box_size + mr;
            left = 0;
        }



        // Set blocks
        $(el.obj).css({
            "width" : box_size,
            "height" : box_size,
            "left" : left,
            "top" : top
          });


        var box_size_scaled = box_size * scale;
        // Set images
        var img_el = imgs[i];

        if (img_el.size[0] > img_el.size[1])
          var width  =  img_el.size[0] * (box_size_scaled / img_el.size[1]);
        else
          var height  =  img_el.size[1] * (box_size_scaled / img_el.size[0]);


        var left  = Math.round((box_size - width)  / 2);
        var top   = Math.round((box_size - height) / 2);



          $(img_el.obj).css({
            "width" : Math.round(width),
            "height" : Math.round(height),
            left : left,
            top: top,


          });

      }

      // Let's set titles

      var first_block = $(li[1].obj).offset() ;
//      $("#h1__pp").css({"left" : first_block.left, "top" : first_block.top - box_size - mr, "height" : box_size, "width" : (box_size)*2+mr});


      console.log("Set sizes", [start_size, rw, vh, box_size, first_block]);
  }




  this.get_start_size = function() {
    return this.start_size;
  }


  this.get_vw = function() {
    return window.innerWidth;
  }

  this.get_rw = function() {
    return $("#popular_grid").width();
  }


  this.get_vh = function() {
    return window.innerHeight;
  }

}


var index_first_grid = new index_first_grid();
$(document).ready(function() {
  setTimeout(function() {index_first_grid.init(); }, 500);
})
