<?= $this->extend('front/layout'); ?>

<?= $this->section('page-title'); ?>
| Contact Us
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<style>
	.header-nav .nav>li>a {
		color: #050505;
	}

	.form-check-input {
		appearance: none;
		width: 17px;
		height: 17px;
	}

	label.form-check-label {
		position: inherit !important;
		transform: inherit !important;
	}
	.dz-form-card {
    background: #e1a759;
}
.widget_getintuch ul li i {
    color: #e1a759;
}
a.btn-social.btn-secondary {
    background: #e1a759;
}
</style>
<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>
<script>


	$(document).on('submit', '#addqueryForm', function (ev) {

		ev.preventDefault();

		var frm = $('#addqueryForm');
		var form = $('#addqueryForm')[0];
		var data = new FormData(form);

		$.ajax({
			type: 'POST',
			url: "<?= base_url(route_to('add.query')) ?>",
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			async: false,
			cache: false,
			data: data,
			beforeSend: function () {

				$('div[class*="ERROR__"]').html('');
				$('body').css('pointer-events', 'none');

			},
			success: function (data) {

				if (data.success == true) {
					sweetAlret(data.msg, 'success')
					window.scrollTo({ top: 0, behavior: 'smooth' });
					$('#addqueryForm').trigger('reset')
					// window.location.href = "";
				}
				if (data.success == false) {
					sweetAlret(data.msg, 'error')
					window.scrollTo({ top: 0, behavior: 'smooth' });
				}

				if (data.success == false) {
					$.each(data.errors, function (field, message) {
						$('.ERROR__' + field).html('<div class="text-danger">' + message + '</div>');
					});
				}
			},

			complete: function (data) {
				$('body').css('pointer-events', 'auto');
			}
		});
	});
</script>
<?= $this->endSection(); ?>


<?= $this->section('page-content'); ?>
<div class="page-content bg-white">

	<!-- Banner  -->
	<div class="dz-bnr-inr style-1 text-center">
		<div class="container">
			<div class="dz-bnr-inr-entry">
				<h1>Contact US</h1>
				<!-- Breadcrumb Row -->
				<nav aria-label="breadcrumb" class="breadcrumb-row">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">contact Us</li>
					</ul>
				</nav>
				<!-- Breadcrumb Row End -->
			</div>
		</div>
		<svg class="bg-image" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 1919 379" fill="none">
			<path
				d="M73.3165 123.52C157.912 108.819 150.516 156.618 189.162 158.467C227.762 160.317 227.762 145.616 271.909 162.166C316.056 178.715 325.208 213.663 367.506 208.115C409.804 202.614 409.804 178.715 441.054 209.965C472.303 241.214 485.201 266.963 536.651 298.212C588.149 329.462 619.398 305.562 645.147 292.711C670.895 279.86 657.998 272.464 698.447 285.361C738.895 298.212 849.193 270.661 893.34 265.114C937.487 259.613 981.588 217.315 1010.99 202.614C1040.39 187.914 1101.09 230.212 1126.83 244.912C1152.58 259.613 1178.33 239.411 1209.58 230.212C1240.83 221.013 1273.93 222.862 1329.08 198.963C1384.23 175.063 1429.11 187.637 1472.57 176.958C1535.07 161.565 1551.15 180.425 1636.12 211.814C1679.34 227.808 1679.02 227.115 1698.62 206.313C1708.14 196.189 1719.7 210.612 1733.15 213.524C1751.64 217.5 1767.64 208.901 1806.23 192.352C1837.62 178.9 1894.94 148.251 1920 156.757V373.436H0.0465088V134.614C17.844 132.442 41.9283 129.021 73.3165 123.52Z"
				fill="var(--primary)"></path>
			<path
				d="M747.309 336.865C747.309 336.865 760.53 330.532 761.084 321.009C755.815 321.518 746.292 331.04 746.292 331.04C746.292 331.04 751.053 318.328 742.039 310.932C740.975 318.883 744.443 330.624 744.443 330.624C744.443 330.624 742.177 327.111 736.769 325.493C737.971 329.422 740.513 333.537 747.309 336.865Z"
				fill="var(--theme-text-color)"></path>
			<path
				d="M1708.14 273.534C1708.14 273.534 1732.04 262.07 1732.96 244.873C1723.4 245.844 1706.2 263.04 1706.2 263.04C1706.2 263.04 1714.8 240.112 1698.57 226.752C1696.68 241.082 1702.92 262.301 1702.92 262.301C1702.92 262.301 1698.8 255.968 1689.05 253.055C1691.27 260.082 1695.84 267.524 1708.14 273.534Z"
				fill="var(--theme-text-color)"></path>
			<path
				d="M343.56 303.582C343.56 303.582 353.314 302.935 354.886 294.475C353.314 290.407 347.952 299.191 347.952 299.191C347.952 299.191 346.057 284.121 337.597 278.435C342.312 291.332 345.456 299.191 345.456 299.191C345.456 299.191 338.522 289.113 330.386 288.512C332.882 296.648 343.56 303.582 343.56 303.582Z"
				fill="var(--theme-text-color)"></path>
			<path
				d="M1438.27 246.676C1438.27 246.676 1448.02 246.029 1449.59 237.57C1448.02 233.502 1442.66 242.285 1442.66 242.285C1442.66 242.285 1440.76 227.215 1432.3 221.529C1437.02 234.426 1440.16 242.285 1440.16 242.285C1440.16 242.285 1433.23 232.207 1425.09 231.606C1427.59 239.742 1438.27 246.676 1438.27 246.676Z"
				fill="var(--theme-text-color)"></path>
			<path
				d="M102.624 254.257L116.539 238.263C111.407 237.246 101.607 249.08 101.607 249.08C101.607 249.08 105.722 237.754 94.9044 223.84C91.2525 237.246 102.624 254.257 102.624 254.257Z"
				fill="var(--theme-text-color)"></path>
			<path d="M234.557 199.849V286.201" stroke="var(--theme-text-color)" stroke-width="3.1879"
				stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M259.982 204.471C259.982 217.507 255.128 223.193 235.62 222.315" stroke="var(--theme-text-color)"
				stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M208.716 222.547C208.716 235.583 213.57 241.269 233.078 240.391" stroke="var(--theme-text-color)"
				stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M1025.74 221.899V308.251" stroke="var(--theme-text-color)" stroke-width="3.1879"
				stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M1051.16 226.521C1051.16 239.558 1046.31 245.243 1026.8 244.365" stroke="var(--theme-text-color)"
				stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M999.894 244.597C999.894 257.633 1004.75 263.319 1024.26 262.441" stroke="var(--theme-text-color)"
				stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M1848.26 175.394V261.746" stroke="var(--theme-text-color)" stroke-width="3.1879"
				stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M1873.68 180.017C1873.68 193.053 1868.83 198.739 1849.32 197.86" stroke="var(--theme-text-color)"
				stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
			<path d="M1822.41 198.092C1822.41 211.128 1827.27 216.814 1846.78 215.936" stroke="var(--theme-text-color)"
				stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
			<path
				d="M111.593 249.312C144.09 234.01 144.09 232.115 174.646 258.881C205.203 285.646 235.759 283.705 235.759 283.705C235.759 283.705 298.813 274.136 348.461 302.796C398.109 331.457 407.678 350.549 476.464 354.386C545.25 358.223 741.993 329.562 787.85 329.562C833.707 329.562 803.151 348.654 854.695 327.667C906.284 306.633 885.251 302.843 975.07 299.006C1064.84 295.169 1196.68 277.972 1311.28 264.613C1425.92 251.253 1450.93 227.354 1607.74 253.657C1664.46 263.18 1732.64 268.773 1799.86 255.876C1834.48 249.219 1875.07 252.501 1919.95 263.087V378.344H0V187.229C41.8356 191.666 83.2553 262.671 111.593 249.312Z"
				fill="#fff"></path>
			<path
				d="M1698.14 69.1968C1698.14 69.1968 1690.38 71.626 1688.36 73.3145C1686.38 75.0031 1686.08 77.8173 1680.69 76.899C1680.75 77.8765 1681.37 79.2393 1681.37 79.2393C1681.37 79.2393 1676.69 84.8973 1676.31 86.6155C1675.92 88.3337 1683.83 95.3545 1683.83 95.3545L1681.22 102.109C1681.22 102.109 1688.45 111.529 1690.35 107.767C1693.25 102.02 1697.25 98.1392 1697.25 98.1392C1697.25 98.1392 1705.69 96.8357 1711.77 90.911C1723.97 101.664 1732.15 85.2232 1716.36 82.6756C1716.09 72.6332 1699.77 64.7532 1698.14 69.1968Z"
				fill="var(--dark)"></path>
			<path
				d="M1679.59 19.7851C1681.52 18.215 1682.05 16.7042 1682.26 14.1862C1682.53 10.7499 1685.19 10.0389 1684.6 9.09097C1684.04 8.20226 1681.49 9.86112 1679 12.0829C1678.44 8.0837 1678.11 6.75064 1677.88 2.45521C1677.67 -1.04038 1672.96 -0.803332 1672.4 3.16624C1671.95 6.48409 1671.65 8.11335 1671.42 14.4232C1671.27 18.215 1671.48 20.496 1671.42 24.4952C1671.36 27.0725 1670.62 46.2686 1670.94 50.3567C1671.92 62.8579 1670.53 69.8787 1670.35 73.2262C1670 80.4247 1669.46 97.0435 1669.46 97.0435C1669.46 97.0435 1668.96 102.642 1663.33 110.196C1659.72 115.025 1655.3 118.876 1663 128.563C1665.34 152.677 1666.53 166.037 1666.53 166.037C1666.53 166.037 1626.48 190.032 1623.49 193.024C1620.49 196.016 1619.43 199.689 1618.95 205.407C1618.33 213.257 1617.62 248.124 1617.62 248.124L1591.97 262.492L1624.4 257.544C1624.4 257.544 1625.56 237.637 1633.71 222.411C1638.74 213.02 1637.77 205.555 1637.77 205.555L1675.89 192.521C1675.89 192.521 1682.67 191.869 1685.64 193.913C1699.15 203.215 1720.15 218.974 1726.64 222.115C1745.06 231.061 1759.37 241.637 1770.6 251.827C1762.21 252.775 1759.4 255.589 1759.4 255.589L1787.42 260.092C1787.42 260.092 1787.01 255.886 1781.23 251.768C1772.97 245.873 1758.45 223.981 1734.46 208.547C1726.73 203.57 1724.03 199.838 1717.54 191.81C1706.58 178.242 1700.6 170.362 1697.78 165.208C1696.06 161.297 1690.08 145.804 1690.08 131.289C1690.08 114.107 1696.03 107.234 1691.47 100.184C1684.87 90.0228 1683.09 91.9779 1679.74 78.7954C1679.06 76.1589 1677.28 62.7986 1678.53 50.0604C1679.42 41.0548 1678.35 31.0124 1678.35 26.6873C1678.38 22.3919 1679.59 19.7851 1679.59 19.7851Z"
				fill="var(--dark)"></path>
		</svg>
		<div class="circle1 style-2"></div>
	</div>
	<!-- Banner End -->

	<!-- contact-box  -->
	<section class="content-inner-2">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-12 col-xl-5">
					<div class="contact-box">
						<div class="section-head m-0">
							<h2 class="title m-0">Contact Info</h2>
							<p class="m-t10 m-b30">Fill up the form and our Team will get back to you.</p>
						</div>
						<div class="widget widget_getintuch m-0">
							<ul>
								<li>
									<i class="fa-solid fa-location-dot"></i>
									<p>
									    <a href="https://www.google.com/maps">
										<?= $info->address; ?>
									</a>
									</p>
								</li>
								<li>
									<i class="fa-solid fa-phone"></i>
									<p>
										<a href="tel:<?= $info->mobile; ?>"><?= $info->mobile; ?></a>
										
									</p>
								</li>
								<li>
									<i class="fa-solid fa-envelope"></i>
									<p>
										<a href="mailto:<?= $info->email; ?>"><?= $info->email; ?></a>
										
									</p>
								</li>
							</ul>
						</div>
						<h6 class="m-b15">Our Socials</h6>
						<div class="dz-social-icon icon-gap-5">
							<ul>
								<?php if ($info->facebook != '') { ?>
									<li><a class="btn-social btn-secondary" href="<?= $info->facebook; ?>">
											<i class="fab fa-facebook-f"></i>
										</a></li>
								<?php } ?>

								<?php if ($info->instagram != '') { ?>
									<li><a target="_blank" class="btn-social btn-secondary" href="<?= $info->instagram; ?>">
											<i class="fab fa-instagram"></i>
										</a></li>
								<?php } ?>

								<?php if ($info->twitter != '') { ?>
									<li><a target="_blank" class="btn-social btn-secondary" href="<?= $info->twitter; ?>">
											<i class="fab fa-twitter"></i>
										</a></li>
								<?php } ?>

								<?php if ($info->linkedin != '') { ?>
									<li><a target="_blank" class="btn-social btn-secondary" href="<?= $info->linkedin; ?>">
											<i class="fa-brands fa-linkedin"></i>
										</a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<!-- <div class="widget widget_working bg-primary">
						<ul>
							<li class="m-b20">
								<span class="days">Monday – Friday:</span>
								<span class="time"><a href="javascript:;">07:00 – 21:00</a></span>
							</li>
							<li class="m-b20">
								<span class="days">Sunday Closed:</span>
							</li>
							<li>
								<span class="days">Saturday:</span>
								<span class="time"><a href="javascript:;">07:00 – 16:00</a></span>
							</li>
							<li>
								<a class="btn btn-secondary" href="javascript:;">More Here <i class="fa-solid fa-arrow-right m-l5"></i></a>
							</li>
						</ul>
					</div> -->
				</div>
				<div class="col-lg-6 col-md-12 col-xl-7">
					<div class="dz-form-card">
						<div class="section-head">
							<h2 class="title text-white m-0">Make An Inquiry</h2>
							<p class="text-white m-t10">Fill up the form and our Team will get back to you.</p>
						</div>
						<form id="addqueryForm" >
							<input type="hidden" class="form-control" name="dzToDo" value="Contact">
							<!-- <div class="dzFormMsg"></div> -->
							<div class="row">
								<div class="col-lg-6 col-md-6 ">
									<label class="form-label text-white">Full Name</label>
									<div class="input-group input-line input-white">
										<input name="name" required="" type="text" class="form-control">
									</div>
									<div id="emailHelp" class="form-text text-danger ERROR__name"></div>

								</div>
								<div class="col-xl-6 col-md-6">
									<label class="form-label text-white">Email Address</label>
									<div class="input-group input-line input-white">
										<input name="email" required="" type="email" class="form-control">
									</div>
									<div id="emailHelp" class="form-text text-danger ERROR__email"></div>

								</div>
								<div class="col-xl-6 col-md-6">
									<label class="form-label text-white">Phone Number</label>
									<div class="input-group input-line input-white">
										<input oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="10"
											name="phone" required="" type="text" class="form-control">
									</div>
									<div id="emailHelp" class="form-text text-danger ERROR__phone"></div>

								</div>

								<div class="col-sm-12">
									<label class="form-label text-white">Message...</label>
									<div class="input-group input-line input-white">
										<textarea name="message" rows="5" required="" class="form-control"></textarea>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="d-sm-flex justify-content-between align-items-center">

										<div class="col-xl-5 col-lg-3 col-sm-4">
											<button name="submit" type="submit" value="Submit"
												class="btn w-100 btn-white">Submit</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- contact-box  -->

	<div class="container content-inner-1">
		<div class="map-iframe style-1">

			<iframe
				src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d462560.68282075156!2d54.89782264499286!3d25.076280448206948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f43496ad9c645%3A0xbde66e5084295162!2sDubai%20-%20United%20Arab%20Emirates!5e0!3m2!1sen!2sin!4v1689681386285!5m2!1sen!2sin"
				class="align-self-stretch" style="width:100%; min-height:100%;" allowfullscreen=""></iframe>
		</div>
	</div>
</div>
<?= $this->endSection(); ?>