<section class="testimonial-wrapper1 overflow-hidden content-inner-1">
		<div class="container">
			<div class="section-head text-center">
				<h3 class="title">Testimonials </h3>
			</div>
			<div class="swiper-container testimonial-swiper-1">
				<div class="swiper-wrapper">
					<?php foreach ($testimonials as $test) :?>
						<div class="swiper-slide">
						<div class="testimonial-1">
							<div class="testimonial-text">
								<p>“<?= stripcslashes($test->comment) ;?>”</p>
							</div>
							<div class="testimonial-details">
								<div class="testimonial-info">
									<div class="testimonial-pic">
										<img src="<?=base_url();?>uploads/testimonials/<?= $test->image;?>" alt="">
									</div>
									<div class="clearfix">
										<h5 class="testimonial-name"><?= $test->name;?></h5>
									</div>
								</div>
								<div class="testimonial-rating">
									<ul>
										<li><i class="la la-star <?= ($test->rating > 0) ? 'text-white' : '';?>"></i></li>
										<li><i class="la la-star <?= ($test->rating > 1) ? 'text-white' : '';?>"></i></li>
										<li><i class="la la-star <?= ($test->rating > 2) ? 'text-white' : '';?>"></i></li>
										<li><i class="la la-star <?= ($test->rating > 3) ? 'text-white' : '';?>"></i></li>
										<li><i class="la la-star <?= ($test->rating > 4) ? 'text-white' : '';?>"></i></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					
					<?php endforeach;?>
					
				</div>
				<div class="num-pagination justify-content-center">
					<div class="testimonial1-button-prev btn-prev"><i class="fa-solid fa-arrow-left"></i></div>
					<div class="testimonial1-button-next btn-next"><i class="fa-solid fa-arrow-right"></i></div>
				</div>
			</div>
		</div>
	</section>