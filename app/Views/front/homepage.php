<?= $this->extend('front/layout'); ?>

<?= $this->section('style'); ?>
<style>
div.ksfrm:before {
    content: "";
    width: 60%;
    height: 2%;
    background: #f5b661;
    margin: auto;
    border-radius: 0px 0px 15px 15px;
    position: absolute;
    top: 0;
    left: 21%;
}

section.content-inner.section-wrapper3.overflow-hidden .dz-title {
    min-height: auto;
    margin: 10px !important;
}

.ksfrm .modal-header.hny_head:before {
    /* content: "none"; */
    width: 0px;
}

.ksfrm {
    max-width: 500px !important;
    border-radius: 30px;
}

.dz-card.style-1 .dz-info .dz-title {
    margin-bottom: 12px;
    margin-top: 12px;
}

button.btn.dropdown-toggle.btn-light {
    background-color: #f5b661 !important;
    padding: 12px !important;
    border-radius: 3px !important;
}

.dz-team.style-3 .dz-content .dz-name {
    min-height: 43.2px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dz-form-card.bg-secondary.frmsl {
    z-index: 3;
    position: relative;
}

.progrm_pp.mt-1 p {
    color: #777777;
}

.input-line .form-control,
.input-line .wp-block-categories-dropdown select,
.wp-block-categories-dropdown .input-line select,
.input-line .wp-block-archives-dropdown select,
.wp-block-archives-dropdown .input-line select {
    height: 25px;
}

.frmsl .section-head h2.title,
.frmsl .section-head .title.h2 {
    font-size: 30px;
    font-family: var(--font-family-title);
}

.dz-form-card .input-group {
    margin-bottom: 10px;
}

.frmsl .section-head {
    margin-bottom: 10px;
}

.dz-form-card.bg-secondary.frmsl {
    background-color: white !important;
}

.dz-form-card textarea {
    height: 63px !important;
}


.input-line .form-control::placeholder,
.input-line .wp-block-categories-dropdown select::placeholder,
.wp-block-categories-dropdown .input-line select::placeholder,
.input-line .wp-block-archives-dropdown select::placeholder,
.wp-block-archives-dropdown .input-line select::placeholder {
    color: #0000004a;

}

.input-line .form-select {
    color: #fff;
    border-radius: 0;
    background-color: #f5b661;
}

.input-line .default-select button {
    color: #fff !important;
    border-bottom: none !important;
}

.frmsl .form-control {
    color: #0000004a;
    border-bottom: 1px solid rgba(255, 255, 255, 0.8) !important;
    background: #f5f5f5;
    padding: 23px 10px;
}

.dz-form-card {
    padding: 30px 40px;
    margin: 53px;
    border-radius: 20px;
}

.dz-content.text-center {
    min-height: 295px;
}

.dz-tabs.style-5 .nav-tabs {
    width: 80%;
}

.frmsl input {
    border-radius: 4px;
}

.frmsl textarea {
    border-radius: 4px;
}

.frmsl {
    border-top: 5px solid #f5b661;
    border-bottom: 5px solid #f5b661;
}

.white-popup-block {
    background: #FFF;
    padding: 20px 30px;
    text-align: left;
    max-width: 650px;
    margin: 40px auto;
    position: relative;
}

@media (max-width: 1600px) {
    .dz-form-card {
        padding: 15px 32px;
        margin: 0;
        border-radius: 20px;
    }

    .main-bnr-three .banner-content {
        top: 50px;
    }
}

@media (max-width: 1250px) {
    .dz-form-card {
        padding: 15px 32px;
        margin: 0;
        border-radius: 20px;
    }

    .dz-content.text-center {
        min-height: 295px;
    }

    .main-bnr-three .banner-content {
        top: 85px;
    }

    .frmsl p,
    .frmsl label,
    .frmsl input::placeholder {
        font-size: 13px !important;
    }
}

@media (max-width: 991px) {
    .ksd {
        display: none;
    }

    .dz-form-card.bg-secondary.frmsl {
        position: relative !important;
        width: 90%;
        margin: 40px 0px;
    }

    .main-bnr-three .num-pagination {
        display: table;
        position: absolute;
        top: 30%;
    }
}

.progrm_pp.mt-1 {
    margin-bottom: 1rem;
}

select#mySelect {
    border-radius: 10px;
}

input.form-control.hny {
    border-radius: 10px !important;
    padding: 19px;
}

.dtae_pinker {
    width: 45%;
}

.dtae_pinker imput {
    width: 100%;
}

.input-group.input-line.input-white.hny {
    width: 100%;
}

.dz-meta ul {
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    flex-direction: column;
}

.dz-card.style-1 .dz-info .dz-title {
    margin-top: 20px;
    min-height: 38.4px;
}

.text-img-box .text-box {
    background-color: #273253;
    padding: 50px 40px 50px 40px;
    color: #fff;
}

.has-sun-shade-color {
    color: #fbbe4b;
    font-size: 40px;
}

.lead {
    font-size: 1.25rem;
    font-weight: 400;
}

.text-img-box .img-box {
    /* background-image: -webkit-gradient(linear, left top, right top, color-stop(52%, #273253), color-stop(34%, #fff)); */
    background-image: -webkit-linear-gradient(left, #273253 52%, #fff 34%);
    background-image: linear-gradient(90deg, #273253 52%, #fff 34%);
}

.border-drop-left.border-color-soft-creame::after {
    border: solid 1px #f4e9da;
}

@media (min-width: 992px) {
    .text-img-box .img-box .border-drop-left {
        margin-top: 0;
        margin-bottom: 0;
    }

    .border-drop-left::after {
        content: "";
        border: solid 1px #273253;
        width: calc(100% - 20px);
        height: 100%;
        position: absolute;
        display: block;
        left: 0;
        bottom: -20px;
        z-index: 0;
    }

    .border-drop-left>* {
        position: relative;
        z-index: 1;
    }

    .border-drop-left {
        padding-left: 20px;
        position: relative;
    }

    .text-img-box {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }

    .text-img-box .text-box {
        width: 50%;
        padding: 80px 70px 80px 60px;
    }

    .text-img-box .img-box {
        width: 50%;
        padding: 80px 0 100px;
    }
}

/*-------------------------------------------------
    Site Main Section
---------------------------------------------------*/
.ec-slide-item {
    position: $relative;
}

.slide-1,
.slide-2,
.slide-3 {
    height: 60vh;
}

.ec-main-slider {
    .swiper-container {
        border-radius: 50px;
    }

    .slide-1 {
        background-image: url("assets/images/partner-resort/Moana-Exteriors-Daytime-min.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-radius: 30px;
    }

    .slide-2 {
        background-image: url("https://swafewellness.com/front_assets/images/banner2.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .slide-3 {
        background-image: url("https://swafewellness.com/front_assets/images/banner3.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    * {
        direction: $ltr;
    }

    .swiper-buttons {
        display: none;
    }

    .swiper-container-horizontal {
        >.swiper-pagination-bullets {
            bottom: 25px;
        }
    }
}

.ec-slide-content {
    width: 50%;
    padding-left: 85px;
    position: relative;
    z-index: 9;

    .ec-slide-title {
        font-size: 55px;
        color: white;
        margin-bottom: 15px;
        letter-spacing: 0.05rem;
        font-weight: 700;
        position: relative;
        text-transform: uppercase;
        line-height: 1;
        span {
            transform: rotate(180deg);
            font-weight: 400;
            letter-spacing: 3px;
            font-size: 50px;
        }
    }

    .ec-slide-stitle {
        font-size: 30px;
        color: #273253;
        margin-bottom: 15px;
        letter-spacing: 10px;
        position: relative;
        text-transform: capitalize;
    }

    .ec-slide-desc {
        display: block;
    }

    p {
        margin-bottom: 15px;
        margin-right: 78px;
        font-size: 20px;
        line-height: 1;
        letter-spacing: 0;
        color: #292929;
        font-weight: 500;
        b {
            font-size: 30px;
        font-weight: 700;
        }
    }

    .btn {
        font-size: 15px;
        text-transform: $uppercase;
        padding: 0 36px;
        letter-spacing: 0;
        height: 60px;
        line-height: 60px;
        border-radius: 0;
        border-radius: 15px;

        i {
            margin-left: 3px;
            font-size: 18px;
        }
    }
}

.main-slider-dot {
    .swiper-pagination-bullet {
        width: 15px;
        height: 15px;
        display: inline-block;
        border-radius: 6px;
        opacity: 1;
        border: none;
        margin: 0 2.5px !important;
        box-shadow: none;
        transition: all 0.3s ease 0s;
        background-color: #202020;
    }

    .swiper-pagination-bullet.swiper-pagination-bullet-active {
        width: 30px;
    }
}

.main-slider-dot.dot-color-white {

    .swiper-pagination-bullet.swiper-pagination-bullet-active {
        width: 30px;
    }
}
a.btn.btn-lg.btnks1 {
    background: #273253;
    color: white;
}


.ec-slide-item {
    min-height: 450px;
}
</style>
<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>

<script>
$(document).on('submit', '#addqueryForm', function(ev) {
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
        beforeSend: function() {

            $('div[class*="ERROR__"]').html('');
            $('body').css('pointer-events', 'none');

        },
        success: function(data) {

            if (data.success == true) {
                sweetAlret(data.msg, 'success')
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                $('#addqueryForm').trigger('reset')
                // window.location.href = "";
            }
            if (data.success == false) {
                sweetAlret(data.msg, 'error')
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }

            if (data.success == false) {
                $.each(data.errors, function(field, message) {
                    $('.ERROR__' + field).html('<div class="text-danger">' + message +
                        '</div>');
                });
            }
        },

        complete: function(data) {
            $('body').css('pointer-events', 'auto');
        }
    });
});
</script>
<?= $this->endSection(); ?>

<?= $this->section('page-content'); ?>

<div class="page-content bg-white">
    <!-- Banner -->
    <div class="main-bnr-three">
        <div class="swiper-container main-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="banner-inner">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-lg-12"
                                    style="display: flex;justify-content: center;align-content: center;">
                                    <div class="banner-media wow fadeInLeft" data-wow-delay="0.2s">
                                        <img src="<?= base_url(); ?>front_assets/images/banner1.jpg" class="main-img"
                                            alt="" />
                                    </div>
                                    <div class="banner-content">
                                        <div class="row">
                                            <div class="col-lg-6 p-5 ksd">

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="top-content">
                                                    <h1 class="title wow fadeInUp" data-wow-delay="0.2s">
                                                        HIMALAYAN ROCK
                                                    </h1>
                                                    <p class="wow fadeInUp" data-wow-delay="0.4s">
                                                        It is a long established fact that a reader will be
                                                        distracted by the readable content of a page when
                                                        looking at its layout. The point of using...
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-center wow fadeInUp"
                                                        data-wow-delay="0.6s">
                                                        <a href="javascript:;"
                                                            class="btn btn-primary shadow-primary">Try For Free</a>
                                                        <div class="video-bx">
                                                            <a class="video-btn style-1 popup-youtube"
                                                                href="https://www.youtube.com/watch?v=AFwMLBBjk7Y">
                                                                <i class="flaticon-play-button"></i>
                                                                <span class="text">View Video</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-inner">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-lg-12"
                                    style="display: flex;justify-content: center;align-content: center;">
                                    <div class="banner-media wow fadeInLeft" data-wow-delay="0.2s">
                                        <img src="<?= base_url(); ?>front_assets/images/banner2.jpg" class="main-img"
                                            alt="" />
                                    </div>
                                    <div class="banner-content">
                                        <div class="row">
                                            <div class="col-lg-6 p-5 ksd">

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="top-content">
                                                    <h1 class="title wow fadeInUp" data-wow-delay="0.2s">
                                                        Create Stunning Salt Rooms & Caves
                                                    </h1>
                                                    <p class="wow fadeInUp" data-wow-delay="0.4s">
                                                        It is a long established fact that a reader will be
                                                        distracted by the readable content of a page when
                                                        looking at its layout. The point of using...
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-center wow fadeInUp"
                                                        data-wow-delay="0.6s">
                                                        <a href="javascript:;"
                                                            class="btn btn-primary shadow-primary">Try For Free</a>
                                                        <div class="video-bx">
                                                            <a class="video-btn style-1 popup-youtube" href="#">
                                                                <i class="flaticon-play-button"></i>
                                                                <span class="text">View Video</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="banner-inner">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-lg-12"
                                    style="display: flex;justify-content: center;align-content: center;">
                                    <div class="banner-media wow fadeInLeft" data-wow-delay="0.2s">
                                        <img src="<?= base_url(); ?>front_assets/images/banner3.jpg" class="main-img"
                                            alt="" />
                                    </div>
                                    <div class="banner-content">
                                        <div class="row">
                                            <div class="col-lg-6 p-5 ksd">

                                            </div>
                                            <div class="col-lg-6">
                                                <div class="top-content">
                                                    <h1 class="title wow fadeInUp" data-wow-delay="0.2s">
                                                        Your Spiritual Guide Welcome YogaCare
                                                    </h1>
                                                    <p class="wow fadeInUp" data-wow-delay="0.4s">
                                                        It is a long established fact that a reader will be
                                                        distracted by the readable content of a page when
                                                        looking at its layout. The point of using...
                                                    </p>
                                                    <div class="d-flex align-items-center justify-content-center wow fadeInUp"
                                                        data-wow-delay="0.6s">
                                                        <a href="javascript:;"
                                                            class="btn btn-primary shadow-primary">Try For Free</a>
                                                        <div class="video-bx">
                                                            <a class="video-btn style-1 popup-youtube"
                                                                href="https://www.youtube.com/watch?v=AFwMLBBjk7Y">
                                                                <i class="flaticon-play-button"></i>
                                                                <span class="text">View Video</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pagination starts from here -->
            <div class="num-pagination">
                <div class="swiper-pagination main-pagination"></div>
            </div>
        </div>
        <div class="dz-form-card bg-secondary frmsl">
            <div class="section-head">
                <h2 class="title text-dark m-0">
                    Make An Inquiry
                </h2>
            </div>
            <form class="dzForm" id="addqueryForm">
                <input type="hidden" class="form-control" name="dzToDo" value="Contact" />
                <!-- <div class="dzFormMsg"></div> -->
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <label class="form-label text-dark">Full Name <span class="text-danger">*</span></label>
                        <div class="input-group input-line">
                            <input name="name" required="" type="text" class="form-control" placeholder="Full Name" />
                        </div>
                        <div id="emailHelp" class="form-text text-danger ERROR__name"></div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <label class="form-label text-dark">Email Address<span class="text-danger">*</span></label>
                        <div class="input-group input-line">
                            <input name="email" required="" type="email" class="form-control"
                                placeholder="Email Address" />
                        </div>
                        <div id="emailHelp" class="form-text text-danger ERROR__email"></div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <label class="form-label text-dark">Phone Number<span class="text-danger">*</span></label>
                        <div class="input-group input-line">
                            <input name="phone" required="" title="Enter 7 to 15 digits" minlength="7" maxlength="15"
                                oninput="this.value = this.value.replace(/[^+\d]+/g, '')" type="text"
                                class="form-control" placeholder="Phone Number" />
                        </div>
                        <div id="emailHelp" class="form-text text-danger ERROR__phone"></div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <label class="form-label text-dark">Programme<span class="text-danger">*</span></label>
                        <div class="input-group input-line">
                            <select class="form-select form-select-lg mb-3" name="service"
                                aria-label="Large select example">
                                <option selected disabled value="">---select---</option>
                                <?php foreach ($packages as $programme): ?>
                                <option value="<?= $programme->id; ?>"><?= $programme->package_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="emailHelp" class="form-text text-danger ERROR__service"></div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label text-dark">Message<span class="text-danger">*</span></label>
                        <div class="input-group input-line">
                            <textarea name="message" rows="2" required="" class="form-control"
                                placeholder="Message"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <div class="col-xl-5 col-lg-3 col-sm-4">
                                <button name="submit" type="submit" value="Submit"
                                    class="btn btn-primary shadow-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <section>
        <div class="ec-main-slider section section-space-pb mt-5 mt-lg-9">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="clearfix mb-2 text-center">
                            <h3 class="top_tit_bg">Special <span>Package</span></h3>
                            <p>Moana Island Dubai is asked to captivate tourists in Dubai, a city known for its luxury and creative thought. </p>
                            <div class="dz-separator style-2 mb-2 text-center"></div>
                        </div>
                    </div>
                </div>
                <div class="swiper-container main-slider ec-slider swiper-container main-slider-nav main-slider-dot mt-5 mt-lg-9">
                    <!-- Main slider -->
                    <div class="swiper-wrapper">
                        <div class="swiper-slide ec-slide-item swiper-slide d-flex slide-1">
                            <div class="container align-self-center">
                                <div class="row">
                                    <div class="col-sm-12 align-self-center">
                                        <div class="ec-slide-content slider-animation">
                                            <h2 class="ec-slide-stitle">Special offer</h2>
                                            <h1 class="ec-slide-title">MOANA ISLAND DUBAI</h1>
                                            <div class="ec-slide-desc">
                                                <p>starting at  <b>5000</b>.00 USD</p>
                                                <a href="<?=base_url('moana-island-dubai')?>" class="btn btn-lg btnks1">Read More <i
                                                        class="ecicon eci-angle-double-right"
                                                        aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination swiper-pagination-white"></div>
                    <div class="swiper-buttons">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Slider 2 -->
    <section class="content-inner-1 overflow-hidden pb-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="clearfix mb-2 text-center">
                        <h3 class="top_tit_bg">Swafe <span>Programmes</span></h3>
                        <p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptates distinctio quisquam et
                            dignissimos
                            asperiores voluptas, rerum natus eius soluta, quod praesentium ipsum modi excepturi beatae
                            fugit itaque
                            sequi minus impedit. </p>
                        <div class="dz-separator style-2 mb-2 text-center"></div>
                    </div>
                </div>
            </div>


            <div class="row justify-content-center mt-5">
                <div class="swiper-container blog-slider-full blog-slider-wrapper mt-5">
                    <div class="swiper-wrapper">

                        <?php foreach ($packages as $pckg) { ?>
                        <div class="swiper-slide wow fadeInUp" data-wow-delay="0.2s">
                            <div class="dz-team m-b30 style-3">
                                <div class="dz-media">
                                    <img width="60px"
                                        src="<?= base_url('uploads/packages/') . (($pckg->image != '') ? $pckg->image : "no-image.jpg") ?>"
                                        alt="">

                                </div>
                                <div class="dz-content text-center">
                                    <h5 class="dz-name"><a href="<?= base_url('programme/').$pckg->slug;?>">
                                            <?= $pckg->package_name; ?>
                                        </a></h5>
                                    <div class="dlab-divider bg-gray text-gray icon-center"><i
                                            class="fas fa-circle bg-white text-gray-dark"></i></div>
                                    <span>Nights: <strong>
                                            <?= explode(':', $pckg->package_duration)[0]; ?> to
                                            <?= explode(':', $pckg->package_duration)[1]; ?>
                                        </strong></span><br>
                                    <!-- <span class="mb-2">Level: <strong></strong></span> -->
                                    <div class="progrm_pp mt-1">
                                        <?=  strip_tags( substr($pckg->description, 0, 80)); ?>
                                        <?= (strlen(strip_tags($pckg->description))> 80) ? '...' : ''; ?>
                                    </div>
                                    <div class="cll_to_ac d-flex">

                                        <a href="<?= base_url('programme/').$pckg->slug;?>" class="hny_rd-morre">Read
                                            More</a>

                                        <input type="hidden" id="min_nights">
                                        <input type="hidden" id="max_nights">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                            id="act_packages_<?= $pckg->id; ?>"
                                            class="modalBtn btn btn-rounded btn-primary m-b10 program_btn"
                                            style="padding: 7px 22px;">Book Now
                                            <span class="btn-icon-left"><i class="flaticon-sent"></i></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- form itself -->
                        <div id="pckgDetails_<?= $pckg->id; ?>" class="mfp-hide white-popup-block">

                            <div class="modal-content">
                                <div class="modal-header hny_head">
                                    <h5 class="modal-title" id="staticBackdropLabel"><?= $pckg->package_name; ?></h5>
                                    <br>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">

                                                <img width="60px"
                                                    src="<?= base_url('uploads/packages/') . (($pckg->image != '') ? $pckg->image : "no-image.jpg") ?>"
                                                    alt="">

                                                <span>Nights: <strong>
                                                        <?= explode(':', $pckg->package_duration)[0]; ?> to
                                                        <?= explode(':', $pckg->package_duration)[1]; ?>
                                                    </strong></span>


                                                <?= $pckg->description; ?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <?php } ?>

                    </div>
                </div>
                <!-- <div class="col-12 d-none d-md-block m-b40 wow fadeInUp text-center" data-wow-delay="0.6s">
          <a href="javascript:void(0);" class="btn btn-primary">View All</a>
        </div> -->
            </div>
        </div>
    </section>

    <!-- Tab Style-5 -->
    <section class="content-inner" style="padding-top: 50px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="clearfix text-right">
                        <div class="dz-tabs style-5 d-flex justify-content-between">
                            <div class="clearfix mb-2 text-start">
                                <h3 class="top_tit_bg">Swafe <span>Programmes</span></h3>
                                <p class="text-start"> Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                    Voluptates distinctio
                                    quisquam et dignissimos asperiores voluptas, rerum natus eius soluta, quod
                                    praesentium ipsum modi
                                    excepturi beatae fugit itaque sequi minus impedit. </p>
                                <div class="dz-separator style-2 mb-2 text-center"></div>
                            </div>
                            <ul class="nav nav-tabs" id="nav-tab-1" role="tablist">
                                <li class="nav-link active" id="nav-7-tab" data-bs-toggle="tab" data-bs-target="#nav-7"
                                    role="tab" aria-controls="nav-7" aria-selected="true">
                                    <img src="front_assets/images/coach.png" alt="">
                                    <span class="title">Trainer At <br> Home </span>
                                </li>
                                <li class="nav-link" id="nav-8-tab" data-bs-toggle="tab" data-bs-target="#nav-8"
                                    role="tab" aria-controls="nav-flow" aria-selected="false">
                                    <img src="front_assets/images/meditation.png" alt="">
                                    <span class="title"> Swafe <br> Center</span>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="nav-tabContent-5">
                            <div class="tab-pane fade show active" id="nav-7" role="tabpanel"
                                aria-labelledby="nav-7-tab" tabindex="0">
                                <div class="row">

                                    <?php foreach ($trainers as $trainer): ?>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="image-box-wrapper style-1 box-hover m-b30">
                                            <div class="dz-content">
                                                <h5 class="dz-title m-b10"><a href="javascript:;">
                                                        <?= $trainer->trainer_name; ?>
                                                    </a>
                                                </h5>
                                                <p>
                                                    <?= substr($trainer->description, 0, 50); ?>...
                                                </p>
                                                <a href="#test-form<?= $trainer->id; ?>" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal<?= $trainer->id; ?>"
                                                    class="trnrbtn btn-link btn-underline popup-with-form">Book
                                                    Now</a>

                                            </div>
                                            <div class="dz-media">
                                                <span> <img
                                                        src="<?= base_url(); ?>uploads/trainers/<?= $trainer->image; ?>"
                                                        alt=""> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- link that opens popup -->


                                    <!-- form itself -->
                                    <div id="test-form<?= $trainer->id; ?>" class="mfp-hide white-popup-block ksfrm">

                                        <div class="modal-content">
                                            <div class="modal-header hny_head">
                                                <h5 class="modal-title" id="staticBackdropLabel">BOOK YOUR PROGRAMME
                                                </h5><br>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-12">

                                                            <!-- trainer select  -->
                                                            <form
                                                                action="<?= base_url(route_to('check.availability')); ?>"
                                                                method="get" id="modalForm">
                                                                <div class="book_servi" id="trainer_select">
                                                                    <label class="form-label text-hny">Programme</label>
                                                                    <div class="input-group input-line input-white">
                                                                        <input type="hidden" name="trainereId"
                                                                            value="<?= $trainer->id;?>">
                                                                        <select class="form-select"
                                                                            id="trainerProgSelct" name="programmeId">
                                                                            <option selected disabled value="">-- Select
                                                                                --</option>
                                                                            <?php
                                          $data2 = _getWhere('sw_trainers', ['id' => $trainer->id]);
                                          $myProgrammes = explode(',', $data2->services_offered);
                                          foreach ($myProgrammes as $prm) {
                                            $service = _getWhere('sw_packages', ['id' => $prm]);
                                            if($service->status == '1' && $service->trash == '0'){ ?>
                                                                            <option value="<?= $service->id; ?>">
                                                                                <?= $service->package_name; ?></option>
                                                                            <?php } } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="hny_bbst d-flex">
                                                                    <div class="dtae_pinker">
                                                                        <label
                                                                            class="form-label text-hny">Arrival</label>
                                                                        <div class="input-group input-line input-white">
                                                                            <i class="calendar icon"></i>
                                                                            <input name="dateSelect" required=""
                                                                                type="date"
                                                                                min="<?php echo date('Y-m-d'); ?>"
                                                                                class="form-control hny"
                                                                                placeholder="Pick a Date">
                                                                        </div>
                                                                    </div>
                                                                    <div class="dtae_pinker">
                                                                        <label
                                                                            class="form-label text-hny">Adults</label>
                                                                        <div
                                                                            class="input-group input-line input-white hny">
                                                                            <button type="button"
                                                                                class="btn btn-primary btks"
                                                                                onclick="decreaseCount(this)">-</button>
                                                                            <input value="1" class="form-control hny"
                                                                                style="text-align: center;border-radius: 0 !important;background: white;color: black;border: 1px solid #cacaca;"
                                                                                type="text" maxlength="2"
                                                                                oninput="this.value = this.value.replace(/\D+/g, '');"
                                                                                name="adults">
                                                                            <button type="button"
                                                                                class="btn btn-primary btks"
                                                                                onclick="increaseCount(this)">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="check_avail">
                                                                    <button type="submit"
                                                                        class="btn btn-dark w-100">Check
                                                                        Availability</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>



                                    <?php endforeach; ?>

                                    <!-- <div class="col-12 d-none d-md-block m-b40 wow fadeInUp text-center" data-wow-delay="0.6s">
                    <a href="javascript:;" class="btn btn-primary">View All</a>
                  </div> -->

                                </div>
                            </div>

                            <div class="tab-pane fade" id="nav-8" role="tabpanel" aria-labelledby="nav-8-tab"
                                tabindex="0">
                                <div class="row">
                                    <?php foreach ($centers as $center): ?>
                                    <div class="col-lg-4 col-md-6 m-b30">
                                        <div class="dz-card style-1 overlay-shine">
                                            <div class="dz-media">
                                                <a href="javascript:;"><img
                                                        src="<?= base_url(); ?><?= ($center->center_img != '') ? 'uploads/centers/' . $center->center_img : 'uploads/no-image.jpg'; ?>"
                                                        alt=""></a>
                                            </div>
                                            <div class="dz-info">
                                                <div class="post-author"></div>
                                                <h4 class="dz-title"><a href="javascript:;">
                                                        <?= $center->center_name;?>
                                                        <!--<?= _getWhere('countries', ['id' => $center->country])->name; ?>-->
                                                    </a></h4>
                                                <div class="dz-meta">
                                                    <ul>
                                                        <li class="post-date">
                                                            <a href="javascript:void(0);">
                                                                <i class="flaticon-calendar"></i>
                                                                <span>Open On:

                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li class="post-date">
                                                            <span>
                                                                <?php if ($center->days_open != ''):
                                      foreach (explode(',', $center->days_open) as $day) { ?>
                                                                <span class="badge rounded-pill bg-light text-dark">
                                                                    <?= $weekDays[$day]; ?>
                                                                </span>
                                                                <?php }
                                    endif; ?>
                                                            </span>
                                                        </li>
                                                        <li class="post-time">
                                                            <a href="javascript:void(0);">
                                                                <i class="flaticon-clock-circular-outline"></i>
                                                                <span>
                                                                    <?= $center->from_time . ' to ' . $center->to_time; ?>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <?php if ($center->city != '') {
                                $city = _getWhere('cities', ['id' => $center->city])->name; ?>
                                                        <li class="post-map">
                                                            <a href="javascript:void(0);">
                                                                <i class="flaticon-pin"></i>
                                                                <span>
                                                                    <?= $city; ?>,
                                                                    <?= _getWhere('countries', ['id' => $center->country])->name; ?>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <?php }
                              ; ?>
                                                    </ul>
                                                </div>

                                                <a href="#center-form<?= $center->id; ?>"
                                                    class="btn btn-primary popup-with-form">Book Now</a>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- form itself -->
                                    <div id="center-form<?= $center->id; ?>" class="mfp-hide white-popup-block ksfrm">

                                        <div class="modal-content">
                                            <div class="modal-header hny_head">
                                                <h5 class="modal-title" id="staticBackdropLabel">BOOK YOUR PROGRAMME
                                                </h5><br>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-12">

                                                            <!-- trainer select  -->
                                                            <form
                                                                action="<?= base_url(route_to('check.availability')); ?>"
                                                                method="get" id="modalForm">
                                                                <div class="book_servi" id="trainer_select">
                                                                    <label class="form-label text-hny">Programme</label>
                                                                    <div class="input-group input-line input-white">
                                                                        <input type="hidden" name="centerId"
                                                                            value="<?= $center->id;?>">
                                                                        <select required class="form-select"
                                                                            id="trainerProgSelct" name="programmeId">
                                                                            <option selected disabled value="">-- Select
                                                                                --</option>
                                                                            <?php
                                          $data2 = _getWhere('sw_packages', ['status' => '1' , 'trash'=> '0'], 'yes');
                                         
                                          foreach ($data2 as $prm) { ?>
                                                                            <option value="<?= $prm->id; ?>">
                                                                                <?= $prm->package_name; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="hny_bbst d-flex">
                                                                    <div class="dtae_pinker">
                                                                        <label
                                                                            class="form-label text-hny">Arrival</label>
                                                                        <div class="input-group input-line input-white">
                                                                            <i class="calendar icon"></i>
                                                                            <input name="dateSelect" required=""
                                                                                type="date"
                                                                                min="<?php echo date('Y-m-d'); ?>"
                                                                                class="form-control hny"
                                                                                placeholder="Pick a Date">
                                                                        </div>
                                                                    </div>
                                                                    <div class="dtae_pinker">
                                                                        <label
                                                                            class="form-label text-hny">Adults</label>
                                                                        <div
                                                                            class="input-group input-line input-white hny">
                                                                            <button type="button"
                                                                                class="btn btn-primary btks"
                                                                                onclick="decreaseCount(this)">-</button>
                                                                            <input value="1" required
                                                                                class="form-control hny"
                                                                                style="text-align: center;border-radius: 0 !important;background: white;color: black;border: 1px solid #cacaca;"
                                                                                type="text" maxlength="2"
                                                                                oninput="this.value = this.value.replace(/\D+/g, '');"
                                                                                name="adults">
                                                                            <button type="button"
                                                                                class="btn btn-primary btks"
                                                                                onclick="increaseCount(this)">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="check_avail">
                                                                    <button type="submit"
                                                                        class="btn btn-dark w-100">Check
                                                                        Availability</button>
                                                                </div>

                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <?php endforeach; ?>


                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Tab Style-5 End -->

    <!-- Our Services -->
    <section class="content-inner section-wrapper3 overflow-hidden">
        <div class="container">
            <div class="clearfix mb-2">
                <h3 class="top_tit_bg">Our <span>Speciallization</span></h3>
                <div class="dz-separator style-2 mb-2"></div>
            </div>
            <div class="swiper-container blog-slider-full blog-slider-wrapper mt-5">
                <div class="swiper-wrapper">
                    <?php foreach ($specialization as $special): ?>
                    <div class="swiper-slide wow fadeInUp" data-wow-delay="0.2s">
                        <div class="dz-card style-1 overlay-shine">
                            <div class="dz-media">
                                <a href="javascript:;"><img
                                        src="<?= base_url(); ?>uploads/packages/<?= $special->image; ?>" alt=""></a>
                            </div>
                            <div class="dz-info">
                                <div class="post-author"></div>
                                <a href="javascript:;" class="text-secondary post-category">Swafe</a>
                                <h4 class="dz-title"><a href="<?= base_url('programme/').$special->slug;?>">
                                        <?= $special->package_name; ?>
                                    </a></h4>

                                <div>
                                    <?= $special->description; ?>
                                </div>
                                <a href="<?= base_url('programme/').$special->slug;?>" class="btn btn-primary">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
        <svg class="bg-image" viewbox="0 0 1919 379" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M73.3165 123.52C157.912 108.819 150.516 156.618 189.162 158.467C227.762 160.317 227.762 145.616 271.909 162.166C316.056 178.715 325.208 213.663 367.506 208.115C409.804 202.614 409.804 178.715 441.054 209.965C472.303 241.214 485.201 266.963 536.651 298.212C588.149 329.462 619.398 305.562 645.147 292.711C670.895 279.86 657.998 272.464 698.447 285.361C738.895 298.212 849.193 270.661 893.34 265.114C937.487 259.613 981.588 217.315 1010.99 202.614C1040.39 187.914 1101.09 230.212 1126.83 244.912C1152.58 259.613 1178.33 239.411 1209.58 230.212C1240.83 221.013 1273.93 222.862 1329.08 198.963C1384.23 175.063 1429.11 187.637 1472.57 176.958C1535.07 161.565 1551.15 180.425 1636.12 211.814C1679.34 227.808 1679.02 227.115 1698.62 206.313C1708.14 196.189 1719.7 210.612 1733.15 213.524C1751.64 217.5 1767.64 208.901 1806.23 192.352C1837.62 178.9 1894.94 148.251 1920 156.757V373.436H0.0465088V134.614C17.844 132.442 41.9283 129.021 73.3165 123.52Z"
                fill="var(--rgba-primary-s)"></path>
            <path
                d="M747.309 336.865C747.309 336.865 760.53 330.532 761.084 321.009C755.815 321.518 746.292 331.04 746.292 331.04C746.292 331.04 751.053 318.328 742.039 310.932C740.975 318.883 744.443 330.624 744.443 330.624C744.443 330.624 742.177 327.111 736.769 325.493C737.971 329.422 740.513 333.537 747.309 336.865Z"
                fill="var(--secondary-hny)"></path>
            <path
                d="M1708.14 273.534C1708.14 273.534 1732.04 262.07 1732.96 244.873C1723.4 245.844 1706.2 263.04 1706.2 263.04C1706.2 263.04 1714.8 240.112 1698.57 226.752C1696.68 241.082 1702.92 262.301 1702.92 262.301C1702.92 262.301 1698.8 255.968 1689.05 253.055C1691.27 260.082 1695.84 267.524 1708.14 273.534Z"
                fill="var(--secondary-hny)"></path>
            <path
                d="M343.56 303.582C343.56 303.582 353.314 302.935 354.886 294.475C353.314 290.407 347.952 299.191 347.952 299.191C347.952 299.191 346.057 284.121 337.597 278.435C342.312 291.332 345.456 299.191 345.456 299.191C345.456 299.191 338.522 289.113 330.386 288.512C332.882 296.648 343.56 303.582 343.56 303.582Z"
                fill="var(--secondary-hny)"></path>
            <path
                d="M1438.27 246.676C1438.27 246.676 1448.02 246.029 1449.59 237.57C1448.02 233.502 1442.66 242.285 1442.66 242.285C1442.66 242.285 1440.76 227.215 1432.3 221.529C1437.02 234.426 1440.16 242.285 1440.16 242.285C1440.16 242.285 1433.23 232.207 1425.09 231.606C1427.59 239.742 1438.27 246.676 1438.27 246.676Z"
                fill="var(--secondary-hny)"></path>
            <path
                d="M102.624 254.257L116.539 238.263C111.407 237.246 101.607 249.08 101.607 249.08C101.607 249.08 105.722 237.754 94.9044 223.84C91.2525 237.246 102.624 254.257 102.624 254.257Z"
                fill="var(--secondary-hny)"></path>
            <path d="M234.557 199.849V286.201" stroke="var(--secondary-hny)" stroke-width="3.1879"
                stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M259.982 204.471C259.982 217.507 255.128 223.193 235.62 222.315" stroke="var(--secondary-hny)"
                stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M208.716 222.547C208.716 235.583 213.57 241.269 233.078 240.391" stroke="var(--secondary-hny)"
                stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M1025.74 221.899V308.251" stroke="var(--secondary-hny)" stroke-width="3.1879"
                stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M1051.16 226.521C1051.16 239.558 1046.31 245.243 1026.8 244.365" stroke="var(--secondary-hny)"
                stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M999.894 244.597C999.894 257.633 1004.75 263.319 1024.26 262.441" stroke="var(--secondary-hny)"
                stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M1848.26 175.394V261.746" stroke="var(--secondary-hny)" stroke-width="3.1879"
                stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M1873.68 180.017C1873.68 193.053 1868.83 198.739 1849.32 197.86" stroke="var(--secondary-hny)"
                stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
            <path d="M1822.41 198.092C1822.41 211.128 1827.27 216.814 1846.78 215.936" stroke="var(--secondary-hny)"
                stroke-width="3.1879" stroke-miterlimit="10" stroke-linecap="round"></path>
            <path
                d="M111.593 249.312C144.09 234.01 144.09 232.115 174.646 258.881C205.203 285.646 235.759 283.705 235.759 283.705C235.759 283.705 298.813 274.136 348.461 302.796C398.109 331.457 407.678 350.549 476.464 354.386C545.25 358.223 741.993 329.562 787.85 329.562C833.707 329.562 803.151 348.654 854.695 327.667C906.284 306.633 885.251 302.843 975.07 299.006C1064.84 295.169 1196.68 277.972 1311.28 264.613C1425.92 251.253 1450.93 227.354 1607.74 253.657C1664.46 263.18 1732.64 268.773 1799.86 255.876C1834.48 249.219 1875.07 252.501 1919.95 263.087V378.344H0V187.229C41.8356 191.666 83.2553 262.671 111.593 249.312Z"
                fill="var(--secondary-hny)"></path>
            <path
                d="M1698.14 69.1968C1698.14 69.1968 1690.38 71.626 1688.36 73.3145C1686.38 75.0031 1686.08 77.8173 1680.69 76.899C1680.75 77.8765 1681.37 79.2393 1681.37 79.2393C1681.37 79.2393 1676.69 84.8973 1676.31 86.6155C1675.92 88.3337 1683.83 95.3545 1683.83 95.3545L1681.22 102.109C1681.22 102.109 1688.45 111.529 1690.35 107.767C1693.25 102.02 1697.25 98.1392 1697.25 98.1392C1697.25 98.1392 1705.69 96.8357 1711.77 90.911C1723.97 101.664 1732.15 85.2232 1716.36 82.6756C1716.09 72.6332 1699.77 64.7532 1698.14 69.1968Z"
                fill="var(--secondary-hny)"></path>
            <path
                d="M1679.59 19.7851C1681.52 18.215 1682.05 16.7042 1682.26 14.1862C1682.53 10.7499 1685.19 10.0389 1684.6 9.09097C1684.04 8.20226 1681.49 9.86112 1679 12.0829C1678.44 8.0837 1678.11 6.75064 1677.88 2.45521C1677.67 -1.04038 1672.96 -0.803332 1672.4 3.16624C1671.95 6.48409 1671.65 8.11335 1671.42 14.4232C1671.27 18.215 1671.48 20.496 1671.42 24.4952C1671.36 27.0725 1670.62 46.2686 1670.94 50.3567C1671.92 62.8579 1670.53 69.8787 1670.35 73.2262C1670 80.4247 1669.46 97.0435 1669.46 97.0435C1669.46 97.0435 1668.96 102.642 1663.33 110.196C1659.72 115.025 1655.3 118.876 1663 128.563C1665.34 152.677 1666.53 166.037 1666.53 166.037C1666.53 166.037 1626.48 190.032 1623.49 193.024C1620.49 196.016 1619.43 199.689 1618.95 205.407C1618.33 213.257 1617.62 248.124 1617.62 248.124L1591.97 262.492L1624.4 257.544C1624.4 257.544 1625.56 237.637 1633.71 222.411C1638.74 213.02 1637.77 205.555 1637.77 205.555L1675.89 192.521C1675.89 192.521 1682.67 191.869 1685.64 193.913C1699.15 203.215 1720.15 218.974 1726.64 222.115C1745.06 231.061 1759.37 241.637 1770.6 251.827C1762.21 252.775 1759.4 255.589 1759.4 255.589L1787.42 260.092C1787.42 260.092 1787.01 255.886 1781.23 251.768C1772.97 245.873 1758.45 223.981 1734.46 208.547C1726.73 203.57 1724.03 199.838 1717.54 191.81C1706.58 178.242 1700.6 170.362 1697.78 165.208C1696.06 161.297 1690.08 145.804 1690.08 131.289C1690.08 114.107 1696.03 107.234 1691.47 100.184C1684.87 90.0228 1683.09 91.9779 1679.74 78.7954C1679.06 76.1589 1677.28 62.7986 1678.53 50.0604C1679.42 41.0548 1678.35 31.0124 1678.35 26.6873C1678.38 22.3919 1679.59 19.7851 1679.59 19.7851Z"
                fill="var(--secondary-hny)"></path>
        </svg>
        <div class="circle1"></div>
    </section>
    <!-- Our Services -->

    <!-- Course Category -->
    <section class="about-wrapper2 p-t50 pb-4">
        <div class="container">
            <div class="row about-bx2 align-items-center">
                <div class="col-lg-6 mb-lg-0 ">
                    <div class="dz-media wow fadeInLeft" data-wow-delay="0.2s">
                        <img src="front_assets/images/about/girl.png" alt="">
                        <img class="bg-media rotate-360" src="front_assets/images/pattern/media.svg" alt="">
                        <div class="image-box">
                            <div class="info-box-1">
                                <span>
                                    Balance Body & Mind
                                </span>
                            </div>
                            <div class="info-box-2">
                                <span>
                                    Swafe Health
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 about-content">
                    <div class="section-head m-b30">
                        <span class="sub-title wow fadeInUp" data-wow-delay="0.2s" style="color: #5f5f5f;">ABOUT
                            US</span>
                        <h2 class="title text-white wow fadeInUp" data-wow-delay="0.4s">About Swafe Wellness</h2>
                        <p class="p-big wow fadeInUp" data-wow-delay="0.6s">Swafe Wellness is a contemporary health spa
                            & wellness
                            center built around a man-made salt cave made entirely from Himalayan rock salt. Swafe
                            Wellness is the
                            world known name in the market of equipment for professional salt rooms and we aspire to be
                            the most
                            respected partner for salt therapy technologies worldwide.</p>
                    </div>
                    <ul class="list-check list-box">
                        <li class="wow fadeInUp" data-wow-delay="0.2s">
                            <i class="flaticon-verify text-secondary-hny"></i>
                            Salt Therapy has been popular in Europe.
                        </li>
                        <li class="wow fadeInUp" data-wow-delay="0.4s">
                            <i class="flaticon-verify text-secondary-hny"></i>
                            Salt Cave is the center-piece of the spa.
                        </li>

                    </ul>
                    <a href="javascript:;" class="btn btn-dark">Read More..</a>
                </div>
            </div>
        </div>
        <img class="bg-image" src="front_assets/images/pattern/pattern5.svg" alt="">
    </section>
    <!-- Course Category -->

    <!-- Testimonials style 1 -->
    <?= $this->include('front/includes/_testimonials'); ?>

</div>



<?= $this->endSection(); ?>