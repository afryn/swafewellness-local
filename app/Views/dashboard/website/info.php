<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
<?= isset($info)?'Edit':'Add';?> Information
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
            url: "<?= base_url(route_to('footer.content')) ?>",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: data,
            beforeSend: function () {

                $('div[class*="ERROR__"]').html('');
                // loadingScreen_ON();
                $('body').css('pointer-events', 'none');


            },
            success: function (data) {

                if (data.success == true) {
                    sweetAlret(data.msg, 'success')
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    // window.location.href = $("#baseUrl").val() + 'admin/programmes-list';
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
                            <h3><?= isset($info)?'Edit':'Add';?> Information</h3>
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
                                            accept="<?= base_url(route_to('footer.content')) ?>">
                                            
                                        
                                            <input type="hidden"  name="id" value="<?= isset($info)? lock($info->id) : '';?>">
                                            
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Phone Number<span class="text-danger">*</span></label>
                                                <input form="addPckgForm" title="Enter 7 to 15 digits" maxlength="15"
                                                    value="<?= isset($info->mobile) ? $info->mobile : ''; ?>"
                                                    name="mobile" placeholder="Phone" type="text" oninput="this.value = this.value.replace(/[^+\d]+/g, '')"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__mobile">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Email<span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($info->email) ? $info->email : ''; ?>"
                                                    name="email" placeholder="Email" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__email">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Address<span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($info->address) ? $info->address : ''; ?>"
                                                    name="address" placeholder="Address" type="text"
                                                    class="form-control" 
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__address">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Facebook URL<span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($info->facebook) ? $info->facebook : ''; ?>"
                                                    name="facebook" placeholder="Facebook" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__facebook">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Instagram URL</label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($info->instagram) ? $info->instagram : ''; ?>"
                                                    name="insta" placeholder="Instagram" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__insta">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Likedin URL</label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($info->linkedin) ? $info->linkedin : ''; ?>"
                                                    name="linkedin" placeholder="Linkedin" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__linkedin">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Twitter URL</label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($info->twitter) ? $info->twitter : ''; ?>"
                                                    name="twitter" placeholder="Twitter" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__twitter">
                                                </div>
                                            </div>

                                          
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