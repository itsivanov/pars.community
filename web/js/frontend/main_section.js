function main_section() {

  this.init = function() {
      var container = this.get_container();

      //$(container).fadeIn("slow");
    $(container).addClass("slowAppear");
  }


  this.container = false;
  this.get_container = function(){

    if (this.container === false)
      this.container = $("#mostPopular");


    return this.container;
  }
}



var mostPopular = new main_section();
$(document).ready(function() {
  setTimeout(function() {
    mostPopular.init();
  }, 200);
});
