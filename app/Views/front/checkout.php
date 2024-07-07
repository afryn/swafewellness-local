<?= $this->extend('front/layout'); ?>

<?= $this->section('page-title'); ?>
| Checkout
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<style>
.req_field{
 top: 0;
    right: 21px;
    position:absolute;ci
}
	.header-nav .nav>li>a {
		color: #050505;
	}
	.form-select{
	     height: 50px;
  border: 1px solid gray !important;
  padding: 10px 20px;
  font-size: 15px;
  font-weight: 400;
  color: #777777;
  transition: all 0.3s ease-in-out;
  background: #fff;
  border-radius: var(--border-radius-base);
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
  .checkout-section-2 .left-sidebar-checkout .checkout-detail-box>ul>li .checkout-box .checkout-detail .custom-accordion .accordion-item .accordion-header .accordion-button::before {
    content: "";
  }

  span.toggle-password {
    position: absolute;
    top: 17px;
    right: 10px;
  }

  span.toggle-passwordtwo {
    position: absolute;
    top: 17px;
    right: 10px;
  }

  .buys-gestt {
    background-color: #f7f7f7;
    border-top: 3px solid #ed3237;
    font-size: 15px;
    padding: 13px 18px;
    position: relative;
    text-transform: capitalize;
    margin-bottom: 15px;
    border-radius: 5px;
  }

  .create-acc {
    background-color: #f7f7f7;
    font-size: 15px;
    padding: 13px 18px;
    position: relative;
    text-transform: capitalize;
    border-radius: 5px;
    margin-bottom: 15px;
    width: 100%;
  }

  .otpVerify {
    width: 50%;
    margin: 20px auto;
    border-radius: 13px;
  }

  .select2-container--default .select2-selection--single {
    height: 49px;
    display: flex;
    align-items: center;
  }
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 25%;
}
  ul.delivery-address-detail h4,
  p,
  h6 {
    margin-bottom: 0.5rem;
  }

  .cart-box-item-title {
    display: flex;
    align-items: center;
    gap: 7px;
  }

  p.hny_p {
    font-size: 13px;
    width: 98px;
  }

  .cart-box-item-price {
    padding-right: 9px;
  }

  .mb-3.border-bottom,
  .odr-summry {
    background-color: #f7f7f7;
    font-size: 15px;
    padding: 13px 18px;
    border-radius: 5px;
  }

  @media (max-width:600px) {
    .otpVerify {
      width: 100%;
    }
  }

  .form-group.input-group.bg-white.rounded.mb-0.p-2.d-flex {
    gap: 10px;
  }
  #placeOrder > div.bg-white.cart-box.shadow-sm.rounded.position-relative.mb-3 > div.py-2.ckout_cart > div > div.cart-box-item-title.ms-3 > p.mb-0.text-capitalize {
    font-size: 12px;
}

.ml-2 {
    margin-left: 1rem;
}

button#coupanCodeButton {
    margin: 0px !important;
}
section.checkout-section-2.section-b-space {
    padding-bottom: 40px;
}
</style>
<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>
<!--scripts here -->
<script>
       function fetchStates(cId){
    var html = '<option value="">---select---</option>';
    
    $('#city_select').html(html) // reset city select 

    $.ajax({
            type: 'GET',
            url: "<?= base_url(route_to('fetch.states')) ?>",
            dataType: "JSON",
            data: {
                cId : cId
            },
            success: function (data) {
                data.states.forEach(element => {
                    html += '<option value="'+ element.id+'">'  + element.name + '</option>';
                });
                $('#state_select').html(html);
            }
        });
   }

   function fetchCities(sId){
    $.ajax({
            type: 'GET',
            url: "<?= base_url(route_to('fetch.cities')) ?>",
            dataType: "JSON",
            data: {
                sId : sId
            },
            success: function (data) {
                var html = '<option value="">---select---</option>';
                data.cities.forEach(element => {
                    html += '<option value="'+ element.id+'">'  + element.name + '</option>';
                });
                $('#city_select').html(html);
            }
        });
   }
</script>
<script>
  $('#paySubmitButton').on('click', function(){
     
      $('#addressDetailsForm').submit();
      
  })
    $(document).on('submit', '#addressDetailsForm', function (ev) {

        ev.preventDefault();
        var frm = $('#addressDetailsForm');
        var form = $('#addressDetailsForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('stripe.pay')) ?>",
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
                    window.location.href = data.url;
                }

                if (data.success == false) {
                    sweetAlret(data.msg, 'error')
                }

                if (data.success == false) {
                    $.each(data.errors, function (field, message) {
                        $('.ERROR__' + field).html('<div class="text-danger">' + message + '</div>');
                    });
                    if($(".ERROR__new_password").text() != ''){
                        $('.passText').hide();
                    }
                }
                $('body').css('pointer-events', 'all');

            }

        });

    });
    
  
</script>
<?= $this->endSection(); ?>


<?= $this->section('page-content'); ?>
<!--page content here -->
<div class="page-content bg-white">
    	<!-- Banner  -->
	<div class="dz-bnr-inr style-1 text-center">
		<div class="container">
			<div class="dz-bnr-inr-entry">
				<h1>Checkout</h1>
				<!-- Breadcrumb Row -->
				<nav aria-label="breadcrumb" class="breadcrumb-row">
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Checkout</li>
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

    
  <section class="checkout-section-2 section-b-space">
    <div class="container my-3 main">
      <!-- login/signup section -->
       
      <div class="row">
        <div class="col-lg-8">
          <div class="left-sidebar-checkout">
            <div class="checkout-detail-box">
              <ul>
                <li>
                  <div class="checkout-box">
                    <div class="checkout-detail">
                      <div class="row g-4">
                          <style>
                              .formOverlay{
                                     top: 0;
                                    left: 0;
                                    z-index: 1111;
                                    width: 100%;
                                    border: 1px solid silver;
                                    height: 100%;
                                    background-color: #ffffffbf;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    flex-direction: column;
                              }
                          </style>
                        <form id="addressDetailsForm" method="post" class="position-relative" action= "<?= base_url(route_to('stripe.pay'));?>">
                            <?php if(!isset($_SESSION['login']) ||$_SESSION['login'] != true):?>
                          <div class="position-absolute formOverlay">Please login to continue <a href="<?= base_url(route_to('user.login'));?>" class="my-2 btn btn-primary">Login</a></div>
                         <?php endif;?>
                          <div class="accordion-item accordion-item-line1 bg-white shadow-sm rounded border-0 position-relative" style="box-shadow: none !important;padding: 10px;border: 1px solid #ddd !important;">
                            <h4 class="accordion-header" id="flush-headingOne">Contact Information
                            </h4>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show">
                              <div class="accordion-body px-4 pb-4 pt-3">
                                <div class="checkout-billing shippingForm">
                               
                                  <div class="ceckout-form">
                                    <!--Billing Fields Start-->
                                    <div class="billing-fields">
                                      <div class="row">
                                        <div class="form-group col-lg-6 mb-3 position-relative">

                                            <span class="text-danger req_field ">*</span>

                                          <input <?= isset($_SESSION['firstname'])? "value='".$_SESSION['firstname'] . "' readonly": '';?> class="form-control" placeholder="First name *" type="text" name="firstname" minlength="3" required id="f_name" >
                                           <div class="form-text text-danger ERROR__firstname"></div>
                                         
                                        </div>
                                        
                                        <div class="form-group col-lg-6 mb-3 position-relative">
                                             <span class="text-danger req_field ">*</span>
                                          <input <?= isset($_SESSION['lastname'])? "value='".$_SESSION['lastname'] . "' readonly": '';?> class="form-control" type="text" required placeholder="Last name *" id="l_name" name="lastname">
                                          <div class="form-text text-danger ERROR__lastname"></div>
                                         
                                        </div>
                                        <div  class="form-group col-lg-6 mb-3 position-relative">
                                             <span class="text-danger req_field ">*</span>
                                          <input id="mobile" <?= isset($_SESSION['mobile'])? "value='".$_SESSION['mobile'] . "' readonly": '';?>  placeholder="Mobile Number *" pattern="\d{7,15}" title="Enter 7 to 15 digits" maxlength="15" oninput="this.value = this.value.replace(/\D+/g, '')"  class="form-control" name="mobile" type="text" >
                                          <div class="form-text text-danger ERROR__mobile"></div>
                                         
                                        </div>
                                        <div id="email" class="form-group col-lg-6 mb-3 position-relative">
                                             <span class="text-danger req_field ">*</span>
                                          <input required class="form-control" name="email" <?= isset($_SESSION['email'])? "value='".$_SESSION['email'] . "' readonly": '';?> placeholder="Email Address *" type="email" >
                                          <div class="form-text text-danger ERROR__email"></div>
                                         
                                        </div>
                                        
                                         <div class="form-group col-lg-12 mb-3 position-relative">
                                              <span class="text-danger req_field ">*</span>
                                          <input required class="form-control" name="house_num" value="<?= (isLoggedIn() && !empty($userAddr))? $userAddr->house_num: '';?>" placeholder="House or Flat Number *" type="text" >
                                          <div class="form-text text-danger ERROR__house_num"></div>
                                        </div>
                                         <div class="form-group col-lg-12 mb-3 position-relative">
                                              <span class="text-danger req_field ">*</span>
                                          <input required class="form-control" name="street" value="<?= (isLoggedIn()&& !empty($userAddr))? $userAddr->street: '';?>" placeholder="Street, Apartment etc. *" type="text" >
                                          <div class="form-text text-danger ERROR__street"></div>
                                        </div>
                                          <div class="form-group col-lg-12 mb-3 position-relative">
                                          <input required class="form-control" name="locality" value="<?= (isLoggedIn()&& !empty($userAddr))? $userAddr->locality: '';?>" placeholder="Locality, Unit etc. (optional)" type="text" >
                                          <div class="form-text text-danger ERROR__locality"></div>
                                        </div>
                                         <div class="form-group col-lg-6 mb-3 position-relative">
                                              <span class="text-danger req_field ">*</span>
                                             <select onchange="fetchStates(this.value)"  id="country_select" name="country"
                                                class="form-select select2_inp_search" id="">
                                                <option value="">---select country---</option>
                                                <?php foreach ($countries as $country): ?>
                                                    <option value="<?= $country->id; ?>" <?= (isLoggedIn()&& !empty($userAddr) && $userAddr->country == $country->id)? 'selected' : '';?>>
                                                        <?= $country->name; ?></option>
                                                <?php endforeach; ?>
                                             </select>
                                                
                                              <div class="form-text text-danger ERROR__country"></div>
                                        </div>
                                         <div class="form-group col-lg-6 mb-3 position-relative">
                                              <span class="text-danger req_field ">*</span>
                                              <!-- State  -->
                                                <select onchange="fetchCities(this.value)" id="state_select" name="state"
                                                    class="form-select select2_inp_search" id="">
                                                    <option value="">---select---</option>
                                                    <?php //in case of edit
                                                   
                                                    if(isset($states)):
                                                    foreach ($states as $state):?>

                                                        <option value="<?= $state->id; ?>"
                                                            <?= (isset($userAddr->state) && $userAddr->state == $state->id) ? 'selected' : ''; ?>>
                                                            <?= $state->name; ?></option>
                                                    <?php endforeach; 
                                                    endif ;?>
                                                </select>
                                               
                                              <div class="form-text text-danger ERROR__state"></div>
                                        </div>
                                        
                                         <div class="form-group col-lg-6 mb-3 position-relative">
                                              <span class="text-danger req_field ">*</span>
                                            <select id="city_select" name="city"
                                                    class="form-select select2_inp_search" id="">
                                                    <option value="">---select---</option>

                                                    <?php //in case of edit
                                                     if (isLoggedIn()) {
                                                    foreach ($cities as $city): ?>
                                                        <option value="<?= $city->id; ?>"
                                                            <?= (isset($userAddr->city) && $userAddr->city == $city->id) ? 'selected' : ''; ?>>
                                                            <?= $city->name; ?></option>
                                                    <?php endforeach;
                                                    }?>
                                                </select>
                                          <div class="form-text text-danger ERROR__city"></div>
                                        </div>
                                        
                                         <div class="form-group col-lg-6 mb-3 position-relative">
                                              <span class="text-danger req_field ">*</span>
                                          <input required class="form-control" value="<?= (isLoggedIn()&& !empty($userAddr))? $userAddr->zip_code : '';?>" name="zip_code" placeholder="Zip Code *" type="number" maxlength= "6" >
                                          <div class="form-text text-danger ERROR__zip_code"></div>
                                        </div>
                                      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 checkoutPage">
          <div class="innerCheckoutPage">
            <div class="fixed-sidebar">
              <form id="placeOrder">
                <div class="bg-white cart-box rounded position-relative mb-3"style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                  <div class="odr-summry border-bottom">
                    <h5 class="mb-0 fw-bold">Your Basket</h5>
                    <p class="small mb-0">Your added programmes from <span class="text-success">Swafe Wellness</span></p>
                  </div>
                  <div class="py-2 pb-0 ckout_cart">
                      <?php if(isset($programmes) && !empty($programmes)){
                        
                          foreach($programmes as $pr):
                          ?>
                          <div class="border-bottom">
                            <?php $progrmDet = _getWhere('sw_packages',['id' => lock($pr['prId'], 'decrypt')]);?>
                            <div class="cart-box-item d-flex align-items-center pt-2 pb-2 px-3 cartitemdiv justify-content-between ">
                              <div class="cart-box-item-title ms-3">
                                <div class="pro-img">
                                  <img src="<?= base_url();?>uploads/packages/<?= $progrmDet->image;?>" class="img-fluid  checkout-image rounded-1" alt="Checkout" width="60px">
                                </div>
                                <div class="success-dot"></div>
                                <p class="mb-0 text-capitalize"><?= $progrmDet->package_name;?></p>
        
                              </div>
                            </div>
                            <?php 
                            if(isset($pr['trainerId'])){
                                $trainerDet = _getWhere('sw_trainers', ['id'=> lock($pr['trainerId'], 'decrypt')]);
                         
                            ?>
                             <div class="cart-box-item d-flex align-items-center pt-2 pb-2 px-3 cartitemdiv justify-content-between">
                              <div class="cart-box-item-title ms-3">
                                <div class="pro-img">
                                  <img src="<?= base_url();?>uploads/trainers/<?= $trainerDet->image ;?>" class="img-fluid  checkout-image rounded-1" alt="Checkout" width="60px">
                                </div>
                                <div class="success-dot"></div>
                                <p class="mb-0 text-capitalize"><?= $trainerDet->trainer_name ;?></p>
        
                              </div>
                            </div>
                                
                            <?php }else if (isset($pr['centerId'])){
                                 $centerDet = _getWhere('sw_centers', ['id'=> lock($pr['centerId'], 'decrypt')]);
                         
                            ?>
                             <div class="cart-box-item d-flex align-items-center pt-2 pb-2 px-3 cartitemdiv justify-content-between">
                              <div class="cart-box-item-title ms-3">
                                <div class="pro-img">
                                  <img src="<?= base_url();?>uploads/centers/<?= $centerDet->center_img ;?>" class="img-fluid  checkout-image rounded-1" alt="Checkout" width="60px">
                                </div>
                                <div class="success-dot"></div>
                                <p class="mb-0 text-capitalize"><?= $centerDet->center_name ;?></p>
        
                              </div>
                            </div>
                                
                            <?php }?>
                           
                            <div class="cart-box-item d-flex align-items-center pt-2 pb-2 px-3 cartitemdiv justify-content-between">
                              
                                <div> <strong>Date</strong></div>
                                <div class="success-dot"></div>
                                <?php 
                                $dateString = $pr['date'];
                                $date = \DateTime::createFromFormat('Y-m-d', $dateString);
                        
                                $formattedDate = $date->format('D, M j, Y');?>
                                <p class="mb-0 text-capitalize"><?= $formattedDate ;?></p>
                            </div>
                        </div>
                          
                    <?php endforeach;  } ?>
                      
                     
                    
                  </div>
                </div>
                
                <div class="bg-white rounded position-relative overflow-hidden mb-3"style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                  <div class="accordion" id="accordionExample">
                    <div class="accordion-item border-0">
                      <div class="odr-summry">
                        <h5 class="accordion-header mb-0" id="headingOne">Order Summary</h5>
                        <p class="mb-1">Here is your Order Summary</p>
                      </div>
                      <div id="collapseOne" class="accordion-collapse collapse text-dark show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body px-3 pb-3 pt-3 cartitemdiv">
                       
                          <div class="d-flex justify-content-between align-items-center pt-1">
                            <div class="fw-bold">Total Amount</div>
                            <div class="fw-bold" id="totalAmount">
                              Rs.<?= number_format($totalAmount);?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
             
              <div id="d-grid">
                 
              <?php if(isLoggedIn()):?>
                    <button id="paySubmitButton" href="<?= base_url(route_to('stripe.pay'));?>"  class="btn btn-primary btn-rounded btn-icon-right mt-3 w-100">Place Order</button>
              <?php else :?>
                <p class="text-center">Please Login To Proceed Further.</p>

                <?php endif;?>

              </div>

            </div>

          </div>
        </div>
      </div>
 
</div> </section>
<?= $this->endSection(); ?>