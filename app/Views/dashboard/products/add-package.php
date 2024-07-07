<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
<?= isset($pkg_data)?'Edit':'Add';?> Programme
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
            url: "<?= base_url(route_to('admin.addpackages')) ?>",
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
                    window.location.href = $("#baseUrl").val() + 'admin/programmes-list';
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
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
      removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
    })
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    function checkMinduration(k, elem){
        elem.value = elem.value.replace(/\D+/g, '');

        if(Number($('#d_nights').val()) != '' &&  Number($('#d_nights').val()) < Number(elem.value)){
            $(elem).next().text("Minimum duration can't be more than Maximum duration")
            $('#submitBtn').attr('disabled', true)
        }
        else{
            $(elem).next().text("")
            $('#submitBtn').removeAttr('disabled')

        }
    }
    function checkMaxduration(k, elem){
        elem.value = elem.value.replace(/\D+/g, '');

        if(Number($('#d_days').val()) > Number(elem.value)){
            $('#submitBtn').attr('disabled', true)
            $(elem).next().text("Maximum duration can't be less than Minimum duration")
        }
        else{
            $(elem).next().text("")
            $('#submitBtn').removeAttr('disabled')
        }
    }

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
                            <h3><?= isset($pkg_data)?'Edit':'Add';?> Programme</h3>
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
                                            accept="<?= base_url(route_to('admin.addpackages')) ?>">
                                            
                                        
                                            <input type="hidden"  name="pkg" value="<?= isset($pkg_data)? lock($pkg_data->id) : '';?>">
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Programme Name <span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($pkg_data->package_name) ? $pkg_data->package_name : ''; ?>"
                                                    name="package_name" placeholder="Programme Name" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__package_name">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="d_days" class="form-label">
                                                    Minimum Nights  <span class="text-danger">*</span></label>
                                                <input oninput="checkMinduration('min', this)" form="addPckgForm"
                                                    value="<?= isset($pkg_data->package_duration) ? explode(':', $pkg_data->package_duration)[0] : ''; ?>"
                                                    type="number" placeholder="Days" class="form-control"
                                                    name="duration_days" id="d_days">
                                                <div class="form-text text-danger ERROR__min_nights"></div>
                                            </div>

                                            
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1"
                                                    class="form-label">Description<span class="text-danger">*</span></label>

                                                    <textarea form="addPckgForm" name="short_desc" class="form-control" placeholder="Description"
                                                        id="editor" style="height: 100px"><?= isset($pkg_data->description) ? $pkg_data->description : ''; ?></textarea>
                                                    <!--<label for="floatingTextarea2">Description</label>-->
                                               
                                                <div class="form-text text-danger ERROR__short_desc"></div>
                                            </div>


                                            <div class="mb-3 col-md-6">
                                            <label for="d_nights" class="form-label">
                                                    Maximum Nights <span class="text-danger">*</span></label>
                                                <input oninput="checkMaxduration('max', this)" form="addPckgForm"
                                                    value="<?= isset($pkg_data->package_duration) ? explode(':', $pkg_data->package_duration)[1] : ''; ?>"
                                                    type="number" placeholder="Nights" class="form-control"
                                                    name="duration_nights" id="d_nights">
                                                <div class="form-text text-danger ERROR__max_nights"></div>
                                            </div>

                                            <!-- <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Level</label>
                                                <select form="addPckgForm" name="level" id="" class="form-control">
                                                    <option value="" selected disabled>---Select level---</option>
                                                    <option value="Comprehensive" <?= (isset($pkg_data->level) && $pkg_data->level == 'Comprehensive') ? 'selected' : ''; ?>>Comprehensive</option>
                                                </select>
                                                <div class="form-text text-danger ERROR__level"></div>
                                            </div> -->
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Image (size 370 * 400)<span class="text-danger">*</span></label>
                                                <input onchange="validateimg(this, 370, 400, '', '')" form="addPckgForm" type="file" class="form-control" name="image">
                                                <div class="form-text text-danger ERROR__image"></div>
                                            </div>
                                            <?php if(isset($pkg_data->image) && $pkg_data->image != ''){?>
                                            <div class="mb-3 col-md-6">
                                                <div>
                                                    <p>Current Image</p>
                                                    <img width="100px" src="<?=base_url('uploads/packages/'. $pkg_data->image );?>" alt="">
                                                </div>
                                            </div>
                                           
                                            <?php } ?>



                                            <div class="mb-3 col-md-6">
                                                <input value="Yes" <?= (isset($pkg_data) && $pkg_data->specialization == 'Yes') ? 'checked' : ''; ?> type="checkbox" name="specialize" id="specialize">
                                                <label for="d_nights" class="form-label">
                                                       Specialization</label>
                                            </div>

                                            <!--<div class="mb-3 col-md-6">-->
                                            <!--<label for="price" class="form-label">-->
                                            <!--        Price <span class="text-danger">*</span></label>-->
                                            <!--    <input form="addPckgForm"-->
                                            <!--        value="<?= isset($pkg_data->price)? $pkg_data->price : ''; ?>"-->
                                            <!--        type="number" placeholder="Price" class="form-control"-->
                                            <!--        name="price" id="price">-->
                                            <!--    <div class="form-text text-dan  ger ERROR__price"></div>-->
                                            <!--</div>-->


                                            <div class="mb-3 col-md-12">
                                                <button id="submitBtn" type="submit" form="addPckgForm" class="btn btn-primary">Submit</button>
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