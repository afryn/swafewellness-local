<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
<?= isset($pkg_data) ? 'Edit' : 'Add'; ?> Testimonial
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    $(document).on('submit', '#testForm', function (ev) {
        $('body').css('pointer-events', 'none');
        ev.preventDefault();
        var frm = $('#testForm');
        var form = $('#testForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('add.testimonial')) ?>",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: data,
            beforeSend: function () {
                $('div[class*="ERROR__"]').html('');
               
            },
            success: function (data) {
                if (data.success == true) {
                    sweetAlret(data.msg, 'success')
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    window.location.href = "<?= base_url(route_to('testimonials.list')) ?>";
                }

                if (data.success == false) {
                    sweetAlret(data.msg, 'error')
                    window.scrollTo({ top: 0, behavior: 'smooth' });

                    $.each(data.errors, function (field, message) {
                        $('.ERROR__' + field).html('<div class="text-danger">' + message + '</div>');
                    });
                }
                $('#testForm').trigger('reset');
                $('body').css('pointer-events', 'all');

            },

        });

    });
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .rating {
        display: inline-block;
        unicode-bidi: bidi-override;
        direction: rtl;
    }

    .rating>input {
        display: none;
    }

    .rating>label {
        float: right;
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
    }

    .rating>label:before {
        content: '\2605';
        /* Unicode character for a star */
    }

    .rating>input:checked~label {
        color: #FFD700;
        /* Color for selected stars */
    }

    .rating>input:not(:checked)~label:hover,
    .rating>input:not(:checked)~label:hover~label {
        color: #FFD700;
        /* Color for hovered stars */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('page-content') ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3>
                                <?= isset($test_data) ? 'Edit' : 'Add'; ?> Testimonial
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Zero Configuration  Starts-->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <form class="row" id="testForm" method="post" enctype="multipart/form-data"
                                            accept="<?= base_url(route_to('add.testimonial')) ?>">

                                            <input type="hidden" name="test"
                                                value="<?= isset($test_data) ? lock($test_data->id) : ''; ?>">
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                                <input form="testForm"
                                                    value="<?= isset($test_data->name) ? $test_data->name : ''; ?>"
                                                    name="name" placeholder="Name" type="text" class="form-control"
                                                    id="exampleInputEmail1" aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__name">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Profession</label>
                                                <input form="testForm"
                                                    value="<?= isset($test_data->profession) ? explode(':', $test_data->profession)[0] : ''; ?>"
                                                    type="text" placeholder="Profession" class="form-control"
                                                    name="profession">
                                                <div class="form-text text-danger ERROR__profession"></div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Comment</label>

                                                <div class="form-floating">
                                                    <textarea form="testForm" name="comment" class="form-control"
                                                        placeholder="Description" id="floatingTextarea2"
                                                        style="height: 100px"><?= isset($test_data->comment) ? $test_data->comment : ''; ?></textarea>
                                                    <label for="floatingTextarea2">Comment</label>
                                                </div>
                                                <div class="form-text text-danger ERROR__short_desc"></div>
                                            </div>

                                            <div class="mb-3 d-flex align-items-center flex-column col-md-6">
                                                <div class=" d-flex align-items-center ">
                                                    <label for="">Rating: </label>
                                                    <div class="rating">
                                                        <?php for ($i = 5; $i > 0; $i--): ?>
                                                            <input <?= (isset($test_data->rating) && $test_data->rating == $i) ? 'checked' : ''; ?> type="radio" value="<?= $i; ?>"
                                                                name="rating" id="star<?= $i; ?>">
                                                            <label for="star<?= $i; ?>"></label>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>


                                                <div class="form-text text-danger ERROR__profession"></div>
                                            </div>




                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Image
                                                    <small>(Dimensions should be 120 x 120 pixels)</small></label>
                                                <input onchange="validateimg(this, 120, 120, '', '')" form="testForm" type="file" class="form-control" name="image">
                                                <div class="form-text text-danger ERROR__image"></div>
                                            </div>
                                            <?php if (isset($test_data->image) && $test_data->image != '') { ?>
                                                <div class="mb-3 col-md-6">
                                                    <div>
                                                        <p>Current Image</p>
                                                        <img width="100px"
                                                            src="<?= base_url('uploads/testimonials/' . $test_data->image); ?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="mb-3 col-md-12">
                                            <button type="submit" form="testForm"
                                                class="btn btn-primary">Submit</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
    </div>
</div>


<?= $this->endSection() ?>