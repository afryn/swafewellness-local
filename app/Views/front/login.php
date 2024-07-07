<?= $this->extend('front/layout'); ?>

<?= $this->section('page-title'); ?>
| Login
<?= $this->endSection(); ?>

<?= $this->section('style'); ?>
<style>
	.header-nav .nav>li>a {
		color: #050505;
	}

	.page-content.bg-white {
		margin-top: 7rem;
	}

	.form-check {
		position: relative;
	}

	label.form-check-label {
		position: inherit;
		left: 0;
		top: 0;
		transform: inherit;
	}

	.m-r15 {
		margin-right: 7px;
		margin-top: 2px;
	}

	.form-check-input {
		appearance: none;
		width: 20px;
		height: 20px;
	}
</style>
<?= $this->endSection(); ?>
<?= $this->section('scripts');?>

<script>
        $(document).on('submit', '#loginForm', function (ev) {

        ev.preventDefault();
        var frm = $('#loginForm');
        var form = $('#loginForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('user.login')) ?>",
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
                    
                    console.log(data.url)
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                      setTimeout(() => {
                          if(data.url != ''){
                              window.location.href = data.url;
                          }
                          else{
                              window.location.href = "<?= base_url();?>"
                          }
                      }, 800);
                 
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
                $('body').css('pointer-events', 'all');
            }
        });
    }); 
</script>
<?= $this->endSection(); ?>


<?= $this->section('page-content'); ?>
<div class="page-content bg-white">

	<div class="login-account">
		<div class="row h-100">
			<div class="col-lg-7 align-self-start m-b30">
				<div class="account-info-area" style="background-image: url(<?= base_url();?>front_assets/images/pattern/bg-pattern1.png)">
					<div class="row h-100 align-items-center">
						<div class="col-xl-7 col-md-8 col-sm-8">
							<div class="login-content">
								<p class="sub-title">Feel the Swafe Wellness</p>
								<h1 class="title">The Evolution of <span class="text-secondary"> Wellness</span></h1>
								<p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt</p>
							</div>
						</div>
						<div class="login-bg col-xl-5 col-md-4 col-sm-4">
							<lottie-player src="<?= base_url();?>front_assets/json/login.json" background="transparent" speed="1" loop="" mood="normal" autoplay=""></lottie-player>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-7 col-sm-8 mx-auto align-self-center">
				<div class="login-form">
					<div class="login-head">
						<h3 class="title">Welcome Back</h3>
						<p>Lorem ipsum dolor sit amet consectetur adipiscing</p>
					</div>
					<h6 class="login-title"><span>Login</span></h6>
					<form class="form" id="loginForm">
						<div class="form-group m-b30">
							<label class="form-label text-secondary">Email Address</label>
							<div class="input-group input-line">
								<input name="email" required="" type="text" class="form-control">
							</div>
						</div>
						<div class="form-group m-b30">
							<label class="form-label text-secondary">Password</label>
							<div class="secure-input input-line">
								<input type="password" name="password" class="form-control dz-password">
								<div class="show-pass">
									<i class="eye-open flaticon-view"></i>
								</div>
							</div>
						</div>
						<div class=" d-flex flex-wrap mt-4 justify-content-between mt-3">
							<!--<div class="form-group mt-0 m-b20">-->
							<!--	<div class="form-check">-->
							<!--		<input class="form-check-input checkbox-secondary m-r15" type="checkbox" value="" id="flexCheckDefault">-->
							<!--		<label class="form-check-label" for="flexCheckDefault">Remember password</label>-->
							<!--	</div>-->
							<!--</div>-->
							<div class="form-group font-15 mt-0 m-b20">
								<!--<a class="font-weight-500" href="javascript:void(0);"><i class="fa fa-lock"></i> Forgot password?</a>-->
							</div>
						</div>
						<button name="submit" type="submit" value="Submit" class="btn btn-secondary shadow-secondary w-100">Login</button>
						<p class="text-center m-t30">Not registered?
							<a class="font-weight-500" href="<?= base_url(route_to('user.register'));?>">Register</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
<?= $this->endSection(); ?>