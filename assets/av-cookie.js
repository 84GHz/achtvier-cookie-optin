document.addEventListener("DOMContentLoaded", function() {
     var avCookieselect = document.getElementById('av-cookie-trak');
     var avCookieSave = document.getElementById('av-cookie-save'); 
     var avCookieAkzpt = document.getElementById('av-all-cookie-acpt');
     var avCookieWrapper = document.getElementById('av-cbnwr');
     var d = new Date;
     //drei Monate dauer
     d.setTime(d.getTime() + 24*60*60*1000*90);

     
     avCookieAkzpt.onclick = function(e){
        e.preventDefault();
     
        document.cookie = "av_cookie_optin=2;samesite;expires=" + d;
        avCookieWrapper.classList.add("av-verschwind");
        setTimeout(function(){
            avCookieWrapper.parentNode.removeChild(avCookieWrapper);
        },2000)
     }
     avCookieSave.onclick = function(e){
        e.preventDefault();
        var avCookieselect = document.getElementById('av-cookie-trak');
        if (avCookieselect.checked) {
            document.cookie = "av_cookie_optin=2;samesite;expires=" + d;
        }
        else {
            document.cookie = "av_cookie_optin=1;samesite;expires=" + d;
        }
        avCookieWrapper.classList.add("av-verschwind");
        setTimeout(function(){
            avCookieWrapper.parentNode.removeChild(avCookieWrapper);
        },2000)
     }

     
  });