$(document).ready(function(){
	function resize() {
		var size = $(".page__posts-item").width();

		$(".page__posts-item img").each(function( index ) {
			var s = $(this).attr('size').split("x");
      
      if (parseInt(s[0]) > parseInt(s[1])) {
          var height =  Math.round(size);
          var width  =  Math.round(s[0] * height/s[1]);
      }
      else {
        var width   =  Math.round(size);
        var height  =  Math.round(s[1] * width/s[0]);
      }

      var top = 0;// Math.round((size - height)/2);
      var left =  Math.round((size - width)/2);



			$(this).css({"width" : width, "height" : height, "margin-top" : top, "margin-left" : left});
			$(this).attr("originalSize", width +"x" + height);

		});
	}
	resize();

});
