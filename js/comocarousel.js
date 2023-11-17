// Initiate Carousel
(function($) {
	"use strict"; 
	//var $myCarousel = $('.comocarousel');
	//$myCarousel.carousel();
	
	//Function to animate slider captions
	function doAnimations(elems,slideInterval) {
		//Cache the animationend event in a variable
		var animEndEv = "webkitAnimationEnd animationend";
		elems.each(function() {
			var $this = $(this),
				$animationType = $this.data("animation");
			//$this.addClass($animationType).one(animEndEv, function() {
			$this.addClass($animationType).removeClass('hide').one(animEndEv, function() {
				$this.removeClass($animationType);
				setTimeout(function() { 
					$this.addClass('hide');
				}, slideInterval);
			});
		});
	}
	//Variables on page load
	var $myCarousel = $('.comocarousel'),
		$firstAnimatingElems = $myCarousel.find(".carousel-item:first").find("[data-animation ^= 'animated']");
	//Initialize carousel
	//$myCarousel.Carousel();
	
	//Animate captions in first slide on page load
	var slideInterval = ($myCarousel.data('interval'))*0.99;
	doAnimations($firstAnimatingElems,slideInterval);
	//Other slides to be animated on carousel slide event
	$myCarousel.on("slid.bs.carousel", function(e) {
		var slideInterval = ($myCarousel.data('interval'))*0.99; 
		var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
		doAnimations($animatingElems,slideInterval);
	});
	
	/*$myCarousel.on("slide.bs.carousel", function() {
		$myCarousel.find('.animated').addClass('hide');
	});*/
	
})(jQuery);