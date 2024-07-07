/* JavaScript Document */
jQuery(window).on('load', function() {
    'use strict';
	
	
	function changeItemBoxed() {
		if(jQuery("body").hasClass("boxed")) {
			return 3;
		} else {
			return 4;
		}
	}
	
	// Main Slider
	if(jQuery('.main-slider').length > 0){
		var swiperMain = new Swiper('.main-slider', {
			speed: 3000,
			effect: "fade",
			slidesPerView: 1,
			loop:true,
			// autoplay:{
			
			//   delay: 3000,
			// }, 
			autoplay: false,
			pagination: {
	         	el: ".main-pagination",
	         	clickable: true,
	         	renderBullet: function (index, className) {
					return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
				},
	        },
			navigation: {
	          	nextEl: ".main-btn-next",
				prevEl: ".main-btn-prev",
	        },
		});
	}
	
	// blog slider full
	if(jQuery('.blog-slider-full').length > 0){
		var swiper = new Swiper('.blog-slider-full', {
			speed: 1500,
			parallax: true,
			slidesPerView: changeItemBoxed(),
			centeredSlides: true,
			spaceBetween: 30,
			loop:true,
			autoplay: {
			   delay: 3000,
			}, 
			pagination: {
	         	el: ".swiper-blog-pagination",
	         	clickable: true,
	         	renderBullet: function (index, className) {
					return '<span class="' + className + '">' +"0"+ (index + 1) + "</span>";
				},
	        },
			navigation: {
				nextEl: '.swiper-blog-next',
				prevEl: '.swiper-blog-prev',
			},
			breakpoints: {
				1200: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 2,
					centeredSlides: false,
				},
				320: {
					slidesPerView: 1,
					centeredSlides: false,
				},
			}
		});
	}
	
	// Clients Swiper
	if(jQuery('.clients-swiper').length > 0){
		var swiper5 = new Swiper('.clients-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 5,
			spaceBetween: 30,
			autoplay: {
			   delay: 3000,
			},
			loop:true,
			breakpoints: {
				1191: {
					slidesPerView: 5,
				},
				992: {
					slidesPerView: 4,
				},
				768: {
					slidesPerView: 3,
				},
				575: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 2,
				},
			}
		});
	}
	
	// Team Swiper
	if(jQuery('.team-swiper').length > 0){
		var swiper = new Swiper(".team-swiper", {
			speed: 1500,
			slidesPerView: 3,
			spaceBetween: 30,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			breakpoints: {
				1280: {
					slidesPerView: 3,
				},
				991: {
					slidesPerView: 2,
				},
				768: {
					slidesPerView: 2,
				},
				360: {
					slidesPerView: 1,
				},
			}
			
		  });
	}

	// Team Swiper-2
	if(jQuery('.team-swiper2').length > 0){
		var swiper = new Swiper(".team-swiper2", {
			speed: 1500,
			slidesPerView: 4,
			spaceBetween: 30,
			loop: true,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
			  },
			breakpoints: {
				1280: {
					slidesPerView: 4,
				},
				991: {
					slidesPerView: 3,
				},
				767:{
					slidesPerView: 2,
				},
				360: {
					slidesPerView: 1,
				},
			}
			
		  });
	}

	// testimonial swiper 1
	if(jQuery('.'Programmes List'').length > 0){
		var swiper = new Swiper('.'Programmes List'', {
			speed: 1500,
			parallax: true,
			slidesPerView:"auto",
			spaceBetween: 0,
			centeredSlides: true,
			loop:false,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
	          	nextEl: ".testimonial1-button-next",
	         	 prevEl: ".testimonial1-button-prev",
	        },
		});
	}
	
	// testimonial swiper 3
	if(jQuery('.testimonial-swiper-3').length > 0){
		var swiper = new Swiper('.testimonial-swiper-3', {
			speed: 1500,
			parallax: true,
			slidesPerView:"auto",
			spaceBetween: 30,
			centeredSlides: true,
			loop:true,
			autoplay: {
			   delay: 3500,
			},
		});
	}
	
	// testimonial swiper-6
	if(jQuery('.testimonial-swiper-6').length > 0){
		var swiper = new Swiper('.testimonial-swiper-6', {
			speed: 1500,
			parallax: true,
			slidesPerView:"auto",
			centeredSlides: true,
			loop:true,
			paginationClickable: true,
			navigation: {
				nextEl: ".testimonial6-button-next",
				prevEl: ".testimonial6-button-prev",
			},
			autoplay: {
			   delay: 2500,
			},
		});
	}
	
	// testimonial swiper-7
	if(jQuery('.testimonial-swiper-7').length > 0){
		var swiper = new Swiper('.testimonial-swiper-7', {
			speed: 1500,
			parallax: true,
			slidesPerView:"auto",
			spaceBetween: 0,
			centeredSlides: true,
			loop:true,
			autoplay: {
			   delay: 3500,
			},
			navigation:{
				nextEl: ".testimonial7-button-next",
				prevEl: ".testimonial7-button-prev",
			},
		});
	}
	
	// blog slider
	if(jQuery('.blog-slider').length > 0){
		var swiper = new Swiper('.blog-slider', {
			speed: 1500,
			parallax: true,
			slidesPerView: 3,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			breakpoints: {
				1280: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// portfolio slider
	if(jQuery('.portfolio-slider').length > 0){
		var swiper = new Swiper('.portfolio-slider', {
			speed: 1500,
			slidesPerView: 5,
			spaceBetween: 30,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			breakpoints: {
				1280: {
					slidesPerView: 5,
				},
				1200: {
					slidesPerView: 4,
				},
				991: {
					slidesPerView: 3,
				},
				768: {
					slidesPerView: 2,
				},
				600: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// post swiper
	if(jQuery('.post-swiper').length > 0){
		var swiper = new Swiper('.post-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 1,
			spaceBetween: 0,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.next-post-swiper-btn',
				prevEl: '.prev-post-swiper-btn',
			}
		});
	}
	
	// Split Swiper
	if(jQuery('.spilt-swiper-slider').length > 0){
		var spiltSwiper = new Swiper('.spilt-swiper-slider', {
			direction: "vertical",
			loop: true,
			slidesPerView: 1,
			mousewheel: true,
			paginationClickable: true,
			pagination: ".swiper-pagination",
			grabCursor: true,
			speed: 1000,
			parallax: true,
			//autoplay: {
			//   delay: 3000,
			//},
			effect: "slide",
			mousewheelControl: 1,
		});
	}
	
	if(jQuery('.service-slider').length > 0){
		var spiltSwiper = new Swiper('.service-slider', {
			slidesPerView: 1,
			loop: true,
			autoplay: {
			   delay: 3000,
			},
			paginationClickable: true,
			pagination: {
				el: ".swiper-pagination",
			},
		});
	}
	
});
/* Document .ready END */