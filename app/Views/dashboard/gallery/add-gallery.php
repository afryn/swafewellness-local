<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
<?= isset($pkg_data)?'Edit':'Add';?> Gallery
<?= $this->endSection();?>

<?= $this->section('scripts') ?>
<script>
    function validateImages(){
		var imageInput = document.getElementById('imageInput');
            var files = imageInput.files;

            if(files.length > 8){
                alert('Maximum 8 images allowed at once')
            }

            var allowedTypes = ['image/jpeg', 'image/png'];
            var maxFileSize = 1 * 1024 * 1024; // 1MB

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                
                if (file.size > maxFileSize) {
                    event.preventDefault();
                    alert('File "' + file.name + '" is too large. Maximum size allowed is 1MB.');
                    // return;
                    imageInput.value = "";
                }

                if (!allowedTypes.includes(file.type)) {
                    event.preventDefault();
                    alert('File "' + file.name + '" is not a valid image file. Only JPEG and PNG are allowed.');
                    // return;
                    imageInput.value = "";
                }
            }
	}

    $(document).on('submit', '#addGalleryForm', function (ev) {

        ev.preventDefault();
        var frm = $('#addGalleryForm');
        var form = $('#addGalleryForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('add.gallery')) ?>",
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
                    window.location.href = $("#baseUrl").val() + 'admin/gallery-list';
                }

                if (data.success == false) {
                    $('body').css('pointer-events', 'auto');
                    sweetAlret(data.msg, 'error')
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }

                if (data.success == false) {
                    $('body').css('pointer-events', 'auto');
                    $.each(data.errors, function (field, message) {
                        $('.ERROR__' + field).html('<div class="text-danger">' + message + '</div>');
                    });
                }

            },
            error: function (err) {

                //

            },
            complete: function (data) {

                // $('body').css('pointer-events', 'auto');
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
                            <h3><?= isset($pkg_data)?'Edit':'Add';?> Gallery</h3>
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
                                        <form class="row" id="addGalleryForm" method="post" enctype="multipart/form-data"
                                            accept="<?= base_url(route_to('add.gallery')) ?>">
                                            
                                        
                                            <input type="hidden"  name="pkg" value="<?= isset($pkg_data)? lock($pkg_data->id) : '';?>">
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Tags<span class="text-danger">*</span></label>

                                                <?php $allTags = _getWhere('sw_gallery', ['trash' => '0'], 'yes');?>
                                                <?php $tagsArr=[];
                                                 foreach ($allTags as $tag) : 
                                                    $exploded = explode(',' , $tag->tags );
                                                    foreach ($exploded as $item) {
                                                        if(!in_array($item,$tagsArr)){
                                                        array_push($tagsArr, $item);
                                                      }
                                                    }
                                                 endforeach;?>

                                                <select multiple="multiple" class="form-select select3_inp"  name="gllry_tags[]" id="">
                                                   <?php foreach ($tagsArr as $tag) :?>
                                                    <option value="<?=$tag;?>"><?=$tag;?></option>
                                                   <?php endforeach;?>
                                                </select>
                                                <div id="emailHelp" class="form-text text-danger ERROR__gllry_cat">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Images (maximum 8 images, size 800 * 650)<span class="text-danger">*</span></label>
                                                <input onchange="validateimg(this, 800, 650, '','')" form="addGalleryForm"
                                                    name="image[]" multiple type="file" multiple
                                                    class="form-control" id="imageInput"
                                                    aria-describedby="emailHelp" >
                                                <div id="emailHelp" class="form-text text-danger ERROR__image">
                                                </div>

                                                <!-- <div id="images_box"></div> -->
                                            </div>
                                            <div class="mb-3 col-md-12">
                                                <button type="submit" form="addGalleryForm" class="btn btn-primary">Submit</button>
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