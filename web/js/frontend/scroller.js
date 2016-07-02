// left: 37, up: 38, right: 39, down: 40,
// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
var keys = {37: 1, 38: 1, 39: 1, 40: 1};

function preventDefault(e) {
  e = e || window.event;
  if (e.preventDefault)
      e.preventDefault();
  e.returnValue = false;
}

function preventDefaultForScrollKeys(e) {
    if (keys[e.keyCode]) {
        preventDefault(e);
        return false;
    }
}

function disableScroll() {
  if (window.addEventListener) // older FF
      window.addEventListener('DOMMouseScroll', preventDefault, false);
  window.onwheel = preventDefault; // modern standard
  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
  //window.ontouchmove  = preventDefault; // mobile
  document.onkeydown  = preventDefaultForScrollKeys;
}

function enableScroll() {
    if (window.removeEventListener)
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
    window.onmousewheel = document.onmousewheel = null;
    window.onwheel = null;
    window.ontouchmove = null;
    document.onkeydown = null;
}
function Scroller() {

	var self    = this;

	this.ismove = false;

	this.init   = function(){

		self.resize();

		$(window).resize(function() {
			self.resize();
		});

		$(window).scroll(function(event) {
			self.checkscroll();
		});

	}

	this.scroll = function(to) {
		this.ismove = true;
		disableScroll()

		$('body').velocity('scroll', {
				duration: 800,
				offset: to,
				easing: 'ease-in-out',
				complete: function(elements) {
					setTimeout(function () {
						self.ismove = false;
						enableScroll()
					}, 300);
				}
		});
	}

	this.checkscroll = function(){

		var scrollTop = $(window).scrollTop();
		var content   = this.contentTop - this.headerHeight;

		if (this.ismove === true) return false;


		if (scrollTop > 0 && scrollTop < (content/2)) {
			this.scroll(content);
		} else if (scrollTop > 0 && scrollTop < (content)) {
			this.scroll(0);
		}
	}

	this.resize = function(){
		this.contentTop   = $("#section_content").offset().top;
		this.headerHeight = $('header').outerHeight();
	}
}

(new Scroller()).init();
