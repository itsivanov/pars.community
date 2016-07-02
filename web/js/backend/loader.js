function Loader() {
  this.lodaderImage = '/themes/watches/img/loader.svg';

  this.init = function() {
    var html = "<div id='loader' style='display:none; width: 100vw; height: 100vh; position: fixed; top:0px; left:0px; z-index:999999;'>";
        html+= "<div style='width: 100%; height: 100%; background-color: rgba(0,0,0,0.6);'></div>";
        html+= "<div style='width: 150px; height: 150px; position : absolute; left:50%; margin-left: -50px; top: 50%; margin-top: -50px;' ><img src='" + this.lodaderImage + "' class='lazyload_preloader__img'></div>";
        html+= "</div>"
    $('body').append(html)
  }

  this.show = function() {
    $("#loader").show();
  }

  this.hide = function() {
    $("#loader").hide();
  }

}

var loader = false;
$(document).ready(function(){
  loader = new Loader();
  loader.init();
})
