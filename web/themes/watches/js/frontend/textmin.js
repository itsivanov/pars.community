   var boolv=false,def;
    function textmin(obj) {
        var obj,strn;
        strn = obj.html();
        if (boolv==false){
         def = obj.html();
            boolv=true;
        }
        var strn = obj.html();
        if ($(window).width() <= 450) {
            obj.text(copy(120, strn));
        } else if ($(window).width() > 450) {
            obj.text(def);
        }
    }

    function copy(len, str) {
        var len, strnew = '',
            i, str;
        for (i = 0; i < len; i++) {
            strnew += str.charAt(i);
        }
        strnew += ' ...';
        return strnew;
    }
var cl=false;
     $(document).ready(function () {
         if (window.location==(window.location.protocol+'//'+window.location.hostname+'/')){
               $('.img-conteiner>img').attr('src','../../../web/img/logo-black-header.svg');
            $('.header-top').css('background','black');
            $('.img-conteiner').css('background','black');
            $('.img-conteiner').css('border-color','black');
            $('.header-top').css('border-color','black');
         }
        textmin($('.page__title'));
   $('.nav-min').click(function(){
       if(cl==false){
   $('.mini-menu-h').slideDown();
           cl=true;
           return;
       }
        if(cl==true){
   $('.mini-menu-h').slideUp();
            cl=false;
       }
    });
     });
    $(window).resize(function () {
        textmin($('.page__title'));
    });
