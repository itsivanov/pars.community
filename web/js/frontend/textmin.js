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
     $(document).ready(function () {
         alert('asdas');
        textmin($('.page__title'));
//         
//            var cl=false;
//   $('.nav-min').click(function(){
//       alert('asds');
//       if(cl==false){
//   $('.mini-menu-h').slideDown();
//           cl=true;
//           return;
//       }
//        if(cl==true){
//   $('.mini-menu-h').slideUp();
//            cl=false;
//       }
//    });
     });
    $(window).resize(function () {
        textmin($('.page__title'));
    });


