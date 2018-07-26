(function ($) {
  
  $(document).ready(function (){
    

    /*Scroll to top*/
    $(window).scroll(function(){
	    if ($(this).scrollTop() > 100) {
		    $('.toplink').fadeIn();
	    } else {
		    $('.toplink').fadeOut();
	    }
    });

    //Click event to scroll to top
    $('.toplink').click(function(){
	    $('html, body').animate({scrollTop : 0},800);
	    return false;
    });

    //  $("div.menu-gauche ul.nav" ).accordion();

    $("#incFontSize").click(function(){

	  curSize= parseInt($('.content').css('font-size')) + 2;
	  if(curSize<=24){
		$('.content').css('font-size', curSize);
	  }
    });

    $("#decFontSize").click(function(){
	  curSize= parseInt($('.content').css('font-size')) - 2;
	  if(curSize>=12){
		$('.content').css('font-size', curSize);
	  }
    });

      $("#printBtn").click(function() {
	window.print();
	return false;
      });
    
  
    });
  
  
})(jQuery);
