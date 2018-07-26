(function(e){
	e(document).on("focus","input, textarea",function(){
		var t=e(this);
		placeholder=t.attr("placeholder"),t.attr("placeholder","")
	}),e(document).on("focusout","input, textarea",function(){
		e(this).attr("placeholder",placeholder)
	})
})(jQuery);
