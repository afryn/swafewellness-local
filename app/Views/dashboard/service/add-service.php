<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
<?= isset($service_data)?'Edit':'Add';?> Service
<?= $this->endSection();?>

<?= $this->section('scripts') ?>
<script>
    $(document).on('submit', '#addPckgForm', function (ev) {

        ev.preventDefault();
        var frm = $('#addPckgForm');
        var form = $('#addPckgForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('add.service')) ?>",
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
                    window.location.href = $("#baseUrl").val() + 'admin/service-list';
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
            error: function (err) {

                //

            },
            complete: function (data) {

                $('body').css('pointer-events', 'auto');
                // getRecords();

            }

        });

    });
</script>
<?= $this->endSection() ?>

<?= $this->section('page-content') ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3><?= isset($service_data)?'Edit':'Add';?> Service</h3>
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
                                        <form class="row" id="addPckgForm" method="post" enctype="multipart/form-data"
                                            accept="<?= base_url(route_to('add.service')) ?>">
                                            
                                        
                                            <input type="hidden"  name="service" value="<?= isset($service_data)? lock($service_data->id) : '';?>">
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Service Name <span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($service_data->service_name) ? $service_data->service_name : ''; ?>"
                                                    name="service_name" placeholder="Service Name" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__service_name">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="d_days" class="form-label">
                                                    Duration Days <span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($service_data->service_duration) ? explode(':', $service_data->service_duration)[0] : ''; ?>"
                                                    type="number" placeholder="Days" class="form-control"
                                                    name="duration_days" id="d_days">
                                                <div class="form-text text-danger ERROR__duration_days"></div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1"
                                                    class="form-label">Description <span class="text-danger">*</span></label>

                                                <div class="form-floating">
                                                    <textarea form="addPckgForm" name="short_desc" class="form-control" placeholder="Description"
                                                        id="floatingTextarea2" style="height: 100px"><?= isset($service_data->description) ? $service_data->description : ''; ?></textarea>
                                                    <label for="floatingTextarea2">Description</label>
                                                </div>
                                                <div class="form-text text-danger ERROR__short_desc"></div>
                                            </div>
                                            

                                            <div class="mb-3 col-md-6">
                                            <label for="d_nights" class="form-label">
                                                    Duration Nights <span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($service_data->service_duration) ? explode(':', $service_data->service_duration)[1] : ''; ?>"
                                                    type="number" placeholder="Nights" class="form-control"
                                                    name="duration_nights" id="d_nights">
                                                <div class="form-text text-danger ERROR__duration_nights"></div>
                                            </div>

                                           

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Image (max size 5MB)<span class="text-danger">*</span></label>
                                                <input form="addPckgForm" type="file" class="form-control" name="image">
                                                <div class="form-text text-danger ERROR__image"></div>
                                            </div>
                                            <?php if(isset($service_data->image) && $service_data->image != ''){?>
                                            <div class="mb-3">
                                                <div>
                                                    <p>Current Image</p>
                                                    <img width="100px" src="<?=base_url('uploads/services/'. $service_data->image );?>" alt="">
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="mb-3 col-md-12">
                                            <button type="submit" form="addPckgForm" class="btn btn-primary">Submit</button>
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