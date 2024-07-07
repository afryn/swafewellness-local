<?= $this->extend('front/layout'); ?>

<?= $this->section('page-title'); ?>
| Register
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

<?= $this->section('scripts'); ?>

<script>
    $(document).on('submit', '#registerForm', function (ev) {

        ev.preventDefault();
        var frm = $('#registerForm');
        var form = $('#registerForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('user.register')) ?>",
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
                    setTimeout(() => {
                        if (data.url != '') {
                            window.location.href = data.url;
                        } else {
                            window.location.href = "<?= base_url(); ?>";
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
                <div class="account-info-area"
                    style="background-image: url(<?= base_url(); ?>front_assets/images/pattern/bg-pattern1.png)">
                    <div class="row h-100 align-items-center">
                        <div class="col-xl-7 col-md-8 col-sm-8">
                            <div class="login-content">
                                <p class="sub-title"> Feel the Swafe Wellness</p>
                                <h1 class="title">The Evolution of <span class="text-secondary"> Wellness</span></h1>
                                <p class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                    tempor incididunt</p>
                            </div>
                        </div>
                        <div class="login-bg col-xl-5 col-md-4 col-sm-4">
                            <lottie-player src="<?= base_url(); ?>front_assets/json/login.json" background="transparent"
                                speed="1" loop="" mood="normal" autoplay=""></lottie-player>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-8 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">Create an account</h3>
                    </div>
                    <h6 class="login-title"><span>Register</span></h6>
                    <div class="form">
                        <form id="registerForm">
                            <div class="form-group m-b10 row">
                                <div class="w-50">
                                    <label class="form-label text-secondary">First Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group input-line">
                                        <input name="firstname" required="" type="text" class="form-control">
                                    </div>
                                    <div class="form-text text-danger ERROR__firstname"></div>
                                </div>
                                <div class="w-50">
                                    <label class="form-label text-secondary">Last Name</label>
                                    <div class="input-group input-line">
                                        <input name="lastname" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-b10">
                                <label class="form-label text-secondary">Email Address <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-line">
                                    <input name="email" required="" type="email" class="form-control">
                                </div>
                                <div class="form-text text-danger ERROR__email"></div>
                            </div>

                            <div class="form-group m-b10">
                                <label class="form-label text-secondary">Mobile Number <span
                                        class="text-danger">*</span></label>
                                <div class="input-group input-line">
                                    <input name="mobile" required="" pattern="\d{7,15}" title="Enter 7 to 15 digits"
                                        maxlength="15" oninput="this.value = this.value.replace(/\D+/g, '')" type="text"
                                        class="form-control">
                                </div>
                                <div class="form-text text-danger ERROR__mobile"></div>
                            </div>
                            <div class="form-group m-b10">
                                <label class="form-label text-secondary">Password <span
                                        class="text-danger">*</span></label>
                                <div class="secure-input input-group input-line">
                                    <input type="password" name="password" class="form-control dz-password">
                                    <div class="show-pass">
                                        <i class="eye-open flaticon-view"></i>
                                    </div>
                                </div>
                                <div class="form-text text-danger ERROR__password"></div>
                            </div>
                            <div class="form-group m-b10">
                                <label class="form-label text-secondary">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <div class="secure-input input-group input-line">
                                    <input type="password" name="cpassword" class="form-control dz-password">
                                    <div class="show-pass">
                                        <i class="eye-open flaticon-view"></i>
                                    </div>
                                </div>
                                <div class="form-text text-danger ERROR__cpassword"></div>
                            </div>
                            <!--<div class=" d-flex flex-wrap mt-5 mt-3">-->
                            <!--    <div class="form-group mt-0 m-b10">-->
                            <!--        <div class="form-check">-->
                            <!--            <input class="form-check-input checkbox-secondary m-r15" type="checkbox" value="" id="flexCheckDefault">-->
                            <!--            <label class="form-check-label" id="basic_checkbox_1"> I accept and agree to the-->
                            <!--                <a class="font-weight-500" href="term-condition.php">Terms & Conditions.</a>-->
                            <!--            </label>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <button type="submit" class="btn btn-primary shadow-primary w-100">Register</button>
                            <p class="text-center m-t30">Already have an account?
                                <a class="font-weight-500" href="<?= base_url(route_to('user.login')); ?>">Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>