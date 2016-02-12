jQuery(document).ready(function($){



$.fn.simpleTabs = function(){ 

	//Default Action

	$(this).find(".tab_content").hide(); //Hide all content

	$(this).find("ul.featured-tabs li:first").addClass("active").show(); //Activate first tab

	$(this).find(".tab_content:first").show(); //Show first tab content

	

	//On Click Event

	$("ul.featured-tabs li").click(function() {

		$(this).parent().parent().find("ul.featured-tabs li").removeClass("active"); //Remove any "active" class

		$(this).addClass("active"); //Add "active" class to selected tab

		$(this).parent().parent().find(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content

		$(activeTab).fadeIn(); //Fade in the active content

		return false;

	});

};//end function



$("div[class^='simpleTabs']").simpleTabs(); //Run function on any div with class name of "Simple Tabs"





});

