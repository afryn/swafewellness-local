<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="Swafe Wellness">
	<meta name="robots" content="">
	<meta name="description" content="">	
	<meta property="og:title" content="">
	<meta property="og:description" content="">
	<meta property="og:image" content="">
	<meta name="format-detection" content="telephone=no">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Title -->
	<title>Swafe Wellness
		<?= $this->renderSection('page-title'); ?>
	</title>

	<!-- Favicon icon -->
	<link rel="icon" type="image/png" href="front_assets/images/favicon.png">

	<!-- Stylesheet -->
	<link href="<?= base_url(); ?>front_assets/vendor/animate/animate.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/magnific-popup/magnific-popup.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/magnific-popup/magnific-popup.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/lightgallery/dist/css/lightgallery.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/lightgallery/dist/css/lg-thumbnail.css" rel="stylesheet">
	<link href="<?= base_url(); ?>front_assets/vendor/lightgallery/dist/css/lg-zoom.css" rel="stylesheet">
	 <!-- select 2  -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


	<link rel="stylesheet" href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css">


	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="<?= base_url(); ?>front_assets/css/style.css">
	<link class="skin" rel="stylesheet" href="<?= base_url(); ?>front_assets/css/skin/skin-1.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />

	<?= $this->renderSection('style'); ?>

	<style>
		.btks {
        padding: 5px 18px;
    }
	</style>
</head>

<body id="bg">

	<div id="loading-area" class="loading-page-1">
		<div class="loading-inner">
			<div class="loader one"></div>
			<div class="loader two"></div>
			<div class="loader three"></div>
			<div class="loader four"></div>
			<div class="loader five"></div>
			<div class="loader six"></div>
			<div class="loader seven"></div>
			<div class="loader eight"></div>
		</div>
	</div>
	<div class="page-wraper">

		<!-- Header -->
		<header class="site-header mo-left header header-transparent style-1">
			<!-- Main Header -->
			<div class="sticky-header main-bar-wraper navbar-expand-lg">
				<div class="main-bar clearfix">
					<div class="container clearfix">

						<!-- Website Logo -->
						<div class="logo-header mostion logo-dark">
							<a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>front_assets/images/logo-dark.png"
									alt=""></a>
						</div>

						<!-- Nav Toggle Button -->
						<button class="navbar-toggler collapsed navicon justify-content-end" type="button"
							data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
							aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
							<span></span>
							<span></span>
							<span></span>
						</button>

						<!-- Extra Nav -->
						<?php if(!isLoggedIn()):?>
						<div class="extra-nav">
							<div class="extra-cell">
								<a href="<?= base_url(route_to('user.login'));?>" class="btn btn-primary">Login / Register</a>
							</div>
						</div>
						<?php else:?>
						<div class="extra-nav">
							<div class="extra-cell">
						<div class="dropdown">
						    
                          <a class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Hey, <?= loginUserDet()->firstname . ' ' . loginUserDet()->lastname ;?> 
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url(route_to('user.logout'));?>">Logout</a></li>
                          </ul>
                        </div>
                        </div>
                        </div>
						<!--<div class="extra-nav">-->
						<!--	<div class="extra-cell">-->
								<!--<a href="javascript:void(0)" class="btn btn-outline-primary">Hey, <?= loginUserDet()->firstname . ' ' . loginUserDet()->lastname ;?> </a>-->
							<!--</div>-->
							<!--<a href="<?= base_url(route_to('user.logout'));?>">Logout</a>-->
						<!--</div>-->
						<?php endif;?>
						
						<!-- Extra Nav -->

						<!-- Header Nav -->
						<div class="header-nav navbar-collapse collapse justify-content-end" id="navbarNavDropdown">
							<div class="logo-header logo-dark">
								<a href="<?= base_url(); ?>"><img src="<?= base_url(); ?>front_assets/images/logo.png"
										alt=""></a>
							</div>
							<ul class="nav navbar-nav navbar navbar-left">
								<li><a href="<?= base_url(); ?>">Home</a></li>
								<li><a href="<?= route_to('about.us'); ?>">About Us</a></li>
								<li><a href="<?= base_url(route_to('all.services')); ?>">Programmes</a></li>
								<li><a href="<?= base_url(route_to('gallery')); ?>">Gallery</a></li>
								<!-- <li><a href="<?= base_url(); ?>">Branches</a></li> -->
								<li><a href="<?= base_url(route_to('contact.us')); ?>">Contact Us</a></li>
							
							
							
							
							<!---->
							<?php if(!isLoggedIn()):?>
							
							
						<!--	<div class="extra-nav">
							<div class="extra-cell">
								<a href="<?= base_url(route_to('user.login'));?>" class="btn btn-primary">Login / Register</a>
							</div>
						</div>
						-->
						
							<li><a href="<?= base_url(route_to('user.login')); ?>">Login / Register</a></li>
							
						<?php else:?>
						
							<li><a href="javascript:void(0);">   Hey, <?= loginUserDet()->firstname . ' ' . loginUserDet()->lastname ;?> </a></li>
							
							
						 <li><a class="" href="<?= base_url(route_to('user.logout'));?>">Logout</a></li>
					
					
						<?php endif;?>
							
							
							
							
    							<!---->
    							
    							
								
								<li id="cartIcon">
								    
								    <?php
								    $count = count(basketItems());?>
								
								<a id="countItem" style="padding:6px;" href="<?= ($count 
								>0)? base_url('checkout'): 'javascript:void(0)';?>" class="position-relative">
                                 <i style="color: #f5b661;" class="fa-solid fa-cart-shopping"></i>
                                 <?php ($count > 0)? $class = '': $class = 'd-none';?>
                                  <span class="<?= $class;?> position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cartCount">
                                   <?= $count;?>
                                  </span>
                                </a>
                                
                                </li>
                               
                    
							</ul>
							<div class="dz-social-icon">
								<ul>
									<li><a target="_blank" href="https://www.facebook.com/"><i
												class="fab fa-facebook-f"></i></a></li>
									<li><a target="_blank" href="https://twitter.com/"><i
												class="fab fa-twitter"></i></a></li>
									<li><a target="_blank" href="https://www.linkedin.com/"><i
												class="fab fa-linkedin-in"></i></a></li>
									<li><a target="_blank" href="https://www.instagram.com/"><i
												class="fab fa-instagram"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Main Header End -->
		</header>
		<!-- Header -->



		<?= $this->renderSection('page-content'); ?>


		<!-- Footer -->
		<footer class="site-footer bg-img-fix footer-action"
			style="background-image: url(<?= base_url() ?>front_assets/images/banner1.jpg);" id="footer">
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-xl-4 col-lg-5 order-2 order-lg-0">
							<div class="widget widget_about  text-start">
								<h5 class="footer-title wow fadeInUp" data-wow-delay="0.2s">Join Our Mailing List</h5>
								<form class="dzSubscribe dz-subscribe-wrapper1 wow fadeInUp" data-wow-delay="0.4s"
									method="post">
									<div class="dzSubscribeMsg"></div>
									<div class="form-group">
										<div class="input-group mb-0">
											<input name="dzEmail" required="required" type="email" class="form-control"
												placeholder="Email Address">
											<div class="input-group-addon ">
												<button name="submit" value="Submit" type="submit" class="mail-sent">
													<i class="flaticon-sent"></i>
												</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-xl-4 col-lg-2">
							<div class="footer-logo logo-center">
								<a href="<?= base_url(); ?>"><img src="<?= base_url();?>front_assets/images/logo-dark.png"
										alt="logo"></a>
							</div>
						</div>
						<div class="col-xl-4 col-lg-5 text-end">
							<div class="widget widget_locations">
								<h5 class="footer-title wow fadeInUp" data-wow-delay="0.2s">Stay Connected</h5>
								<div class="dz-social-icon icon-gap-5 wow fadeInUp" data-wow-delay="0.4s">
									<ul>
										<?php $footerInfo = _getWhere('sw_website_info', ['id' => '1']); ?>
										<?php if ($footerInfo->facebook != '') { ?>
											<li><a target="_blank" class="btn-social btn-transparent btn-circle"
													href="<?= $footerInfo->facebook; ?>">
													<i class="fab fa-facebook-f"></i>
												</a></li>
										<?php } ?>
										<?php if ($footerInfo->instagram != '') { ?>
											<li><a target="_blank" class="btn-social btn-transparent btn-circle"
													href="<?= $footerInfo->instagram; ?>">
													<i class="fab fa-instagram"></i>
												</a></li>
										<?php } ?>
										<?php if ($footerInfo->twitter != '') { ?>
											<li><a target="_blank" class="btn-social btn-transparent btn-circle"
													href="<?= $footerInfo->twitter; ?>">
													<i class="fab fa-twitter"></i>
												</a></li>
										<?php } ?>
										<?php if ($footerInfo->linkedin != '') { ?>
											<li><a target="_blank" class="btn-social btn-transparent btn-circle"
													href="<?= $footerInfo->linkedin; ?>">
													<i class="fa-brands fa-linkedin-in"></i>
												</a></li>
										<?php } ?>

									</ul>
								</div>
							</div>
							<div class="text-light text-center">
								Phone : <a href="tel:<?= $footerInfo->mobile; ?>"><?= $footerInfo->mobile; ?></a>
							</div>
							<div class="text-light text-center">
								Email : <a href="mailto:<?= $footerInfo->email; ?>"><?= $footerInfo->email; ?></a>
							</div>
						</div>
						<div class="col-xl-12 wow fadeInUp" data-wow-delay="0.6s">
							<div class="footer-menu">
								<ul class="">
									<li><a href="<?= base_url(); ?>">HOME</a></li>
									<li><a href="<?= base_url(route_to('about.us')); ?>">About Us</a></li>
									<li><a href="<?= base_url(route_to('all.services')); ?>">Programmes</a></li>
									<li><a href="<?= base_url(); ?>">Gallery</a></li>
									<!-- <li><a href="<?= base_url(); ?>">Branches</a></li> -->
									<li><a href="<?= base_url(); ?>">Contact Us</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Footer Bottom Part -->
			<div class="container">
				<div class="footer-bottom">
					<div class="row">
						<div class="col-xl-6 col-lg-6">
							<span class="copyright-text">Copyright © 2023 <a href="javascript:void(0);" target="_blank">Swafe
									Wellness</a>. All rights reserved.</span>
						</div>
						<div class="col-xl-6 col-lg-6">
							<ul class="footer-link">
								<li><a href="<?= base_url(route_to('about.us')); ?>">About Us</a></li>
								<li><a href="<?= base_url(route_to('privacy.policy')); ?>">Privacy Policy</a></li>
								<li><a href="<?= base_url(route_to('terms.conditions')); ?>">Terms & Conditions</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- Footer End -->
		<!-- home page popup  -->
		<!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header hny_head">
						<h5 class="modal-title" id="staticBackdropLabel">BOOK YOUR PROGRAMME</h5><br>
						<!-- <h6>BOOK ONLINE</h6>
					<div class="dlab-divider bg-gray text-gray icon-center"><i class="fas fa-circle bg-white text-gray-dark"></i></div> -->
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="container">
							<div class="row">
								<div class="col-12">

									<!-- trainer select  -->
									<form action="<?= base_url(route_to('check.availability')); ?>" method="get"
										id="modalForm">
										<input type="hidden" id="selectedData" name="selectedData" value="">
										<input type="hidden" name="selectedId" id="selectedId" value="">
										<div class="book_servi" id="trainer_select">
											<label class="form-label text-hny">Looking For</label>
											<div class="input-group input-line input-white">
												<select required class="form-select" id="mySelect" name="lookingfor">
													<option selected disabled value="">-- Select --</option>
												</select>
											</div>
										</div>

										<div class="hny_bbst d-flex">
											<div class="dtae_pinker">
												<label class="form-label text-hny">Arrival</label>
												<div class="input-group input-line input-white">
													<i class="calendar icon"></i>
													<input name="dateSelect" required="" min="<?php echo date('Y-m-d'); ?>" type="date"
														class="form-control hny" 
														placeholder="Pick a Date">
												</div>
											</div>
											<!-- <div class="dtae_pinker">
											<label class="form-label text-hny">Nights</label>
											<div class="input-group input-line input-white hny">
												<select class="form-select default-select hny w-50" name="">
													<option selected="">21</option>
													<option value="1">28</option>
												</select>
											</div>
										</div> -->
									
											<div class="dtae_pinker">
												<label class="form-label text-hny">Adults</label>
												<div class="input-group input-line input-white hny d-flex">
												    <button type="button" class="btn btn-primary btks" onclick="decreaseCount(this)">-</button>
													<input  min="1" value="1" required class="form-control hny" style="text-align: center;border-radius: 0 !important;background: white;color: black;border: 1px solid #cacaca;" type="text" maxlength="2"
														oninput="this.value = this.value.replace(/\D+/g, '');"
														name="adults">
														<button type="button" class="btn btn-primary btks" onclick="increaseCount(this)">+</button>
												</div>
											</div>
										</div>
										<div class="check_avail">
											<button onclick="checkAvailability()" type="submit" class="btn btn-dark w-100">Check Availability</button>
										</div>

									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>


		<button class="scroltop icon-up" type="button"><i class="fas fa-arrow-up"></i></button>
		
		
		<!--confirmation modal -->
		<div class="modal" id="confirmModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <p id="confirmMessage">Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="confirmCancel" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmOk" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>

	</div>
	<!-- JAVASCRIPT FILES ========================================= -->
	<script src="<?= base_url(); ?>front_assets/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
	<script src="<?= base_url(); ?>front_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- BOOTSTRAP.MIN JS -->
	<script src="<?= base_url(); ?>front_assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
	<!-- BOOTSTRAP SELEECT -->
	<script src="<?= base_url(); ?>front_assets/vendor/magnific-popup/magnific-popup.js"></script>
	<!-- MAGNIFIC POPUP JS -->
	<script src="<?= base_url(); ?>front_assets/vendor/counter/waypoints-min.js"></script><!-- WAYPOINTS JS -->
	<script src="<?= base_url(); ?>front_assets/vendor/wow/wow.js"></script><!-- WOW JS -->
	<script src="<?= base_url(); ?>front_assets/vendor/counter/counterup.min.js"></script><!-- COUNTERUP JS -->
	<script src="<?= base_url(); ?>front_assets/vendor/swiper/swiper-bundle.min.js"></script><!-- OWL-CAROUSEL -->
	<script src="<?= base_url(); ?>front_assets/js/dz.carousel.js"></script><!-- OWL-CAROUSEL -->
	<script src="<?= base_url(); ?>front_assets/js/dz.ajax.js"></script><!-- AJAX -->
	<script src="<?= base_url(); ?>front_assets/js/custom.js"></script>
	<script src="<?= base_url(); ?>assets/js/custom_js/main.js"></script>
	<script src="<?= base_url(); ?>front_assets/vendor/rangeslider/rangeslider.js"></script><!-- RANGESLIDER -->
	<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
	<script src="<?= base_url(); ?>front_assets/vendor/masonry/isotope.pkgd.min.js"></script><!-- MASONRY -->
	<script src="<?= base_url(); ?>front_assets/vendor/lightgallery/dist/lightgallery.min.js"></script>
	<script
		src="<?= base_url(); ?>front_assets/vendor/lightgallery/dist/plugins/thumbnail/lg-thumbnail.min.js"></script>
	<script src="<?= base_url(); ?>front_assets/vendor/lightgallery/dist/plugins/zoom/lg-zoom.min.js"></script>
	<script src="<?= base_url(); ?>front_assets/vendor/imagesloaded/imagesloaded.js"></script><!-- IMAGESLOADED -->

	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

	<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
	<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
	
	<!--select2 -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	
	<script>
		$(document).ready(function () {
			$('.popup-with-form').magnificPopup({
				type: 'inline',
				preloader: false,
				focus: '#name',

				// When elemened is focused, some mobile browsers in some cases zoom in
				// It looks not nice, so we disable it:
				callbacks: {
					beforeOpen: function () {
						if ($(window).width() < 700) {
							this.st.focus = false;
						} else {
							this.st.focus = '#name';
						}
					}
				}
			});
		});
	</script>
	<script>
		$(function () {
			$("#datepicker").datepicker();
			$("#anim").on("change", function () {
				$("#datepicker").datepicker("option", "showAnim", $(this).val());
			});
		});
	</script>
	<script>
		var swiper = new Swiper(".mySwiper", {
			slidesPerView: 1,
			spaceBetween: 5,
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
			},
			breakpoints: {
				640: {
					slidesPerView: 2,
					spaceBetween: 20,
				},
				768: {
					slidesPerView: 4,
					spaceBetween: 40,
				},
				1024: {
					slidesPerView: 3,
					spaceBetween: 50,
				},
			},
		});
	</script>

 <script>
      $(".select2_inp_search").select2({
  "text": "label attribute",
   tags: true,
});
 </script>
 
 	<script>
		    function increaseCount(elem){
		        $(elem).prev().val( Number($(elem).prev().val()) + 1)
		    }
		    
		    function decreaseCount(elem){
		        if($(elem).next().val() != 1){
		             $(elem).next().val( Number($(elem).next().val()) - 1)
		        }
		        
		    }
		</script>

	<?= $this->renderSection('scripts'); ?>
</body>

</html>