$(function() {
  
  if(window.location.hash == "") {
  	window.location.hash = "#overview";
  }

  $(window).on("hashchange", function(){
  	hash = window.location.hash;
  	console.log("/admin/" + hash.substring(1));
    $(".main").load("/admin/" + hash.substring(1));
  	$("li").removeClass("active");
    $("a[href='" + hash + "']").parent().addClass("active");
  });
});