jQuery(document).ready(function($){
	"use strict";
		
    $('.andit-type-carousel').each( function() {
        var $carousel = $(this);
        $carousel.owlCarousel({
			dots : $carousel.data("andit-carousel-owl-pagination"),
			margin : $carousel.data("andit-carousel-owl-margin"),
			nav : $carousel.data("andit-carousel-owl-navigation"),
			rtl : $carousel.data("andit-carousel-owl-rtl"),
			loop: $carousel.data("andit-carousel-owl-loop"),
			smartSpeed: $carousel.data("andit-carousel-owl-smart-speed"),
			autoplay : true,
			autoplayTimeout : $carousel.data("andit-carousel-owl-autoplay"),
			navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
			responsive:{
				0:{
					items: $carousel.data("andit-carousel-owl-items-600")
				},
				600:{
					items: $carousel.data("andit-carousel-owl-items-900")
				},
				1000:{
					items: $carousel.data("andit-carousel-owl-items")
				}
			}			
        });
    });		
	
});

var anditCarouselHandler = function($scope, $) {
    $('.andit-type-carousel').each( function() {
        var $carousel = $(this);
        $carousel.owlCarousel({
			dots : $carousel.data("andit-carousel-owl-pagination"),
			margin : $carousel.data("andit-carousel-owl-margin"),
			nav : $carousel.data("andit-carousel-owl-navigation"),
			rtl : $carousel.data("andit-carousel-owl-rtl"),
			loop: $carousel.data("andit-carousel-owl-loop"),
			smartSpeed: $carousel.data("andit-carousel-owl-smart-speed"),
			autoplay : true,
			autoplayTimeout : $carousel.data("andit-carousel-owl-autoplay"),
			navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
			responsive:{
				0:{
					items: $carousel.data("andit-carousel-owl-items-600")
				},
				600:{
					items: $carousel.data("andit-carousel-owl-items-900")
				},
				1000:{
					items: $carousel.data("andit-carousel-owl-items")
				}
			}			
        });
    });			
};	

jQuery(window).on("elementor/frontend/init", function() {
	"use strict";
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/andit-carousel.default",
		 anditCarouselHandler
    );
});	