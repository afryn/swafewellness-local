<?=$this->extend('dashboard/main_tmplt')?>

<?= $this->section('page-title');?>
Role Edit
<?= $this->endSection();?>

<?=$this->section('styles')?>
<style>
    .not_editable{
        background: #f5d0cd !important;
        border: 1px solid #fd5656 !important;
        padding: 4px !important;
        border-radius: 3px !important;
        color: black !important;
    }
</style>
<?=$this->endSection()?>

<?=$this->section('scripts')?>
<script>

    $(document).on('submit', '#formElement', function(ev) {
    
        ev.preventDefault();
        var frm = $('#formElement');
        var form = $('#formElement')[0];
        var data = new FormData(form);
    
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: data,
            beforeSend: function() {

                $('span[class*="ERROR__"]').html("");
                $("body").css("pointer-events", "none");

            },
            success: function(data) {
    
                if (data.success == true) {
                   sweetAlret(data.msg, 'success')
                }

                if (data.success == false) {
                    sweetAlret(data.msg, 'error')
                   
                    if (data.success == false) {
                        $.each(data.errors, function (field, message) {
                            $(".ERROR__" + field).html('<div class="text-danger">' + message + "</div>");
                        });
                    }

                    /*= = [ IF ERROR EXISTS THEN SCROLL ON THIS ERROR :: START ] = =*/
                    $(document).ready(function() {
                        try {
                            $("span[class*='ERROR__']").filter(function() {
                                return $(this).html().trim().length > 0;
                            }).eq(0).each(function() {
                                $(this).scrollToCenter();
                            });
                        } catch (e) {
                            console.log('An error occurred: ' + e.message);
                        }
                    });
                    /*= = [ IF ERROR EXISTS THEN SCROLL ON THIS ERROR :: END ] = =*/

                }
    
            },
            error: function(err) {
    
                //
    
            },
            complete: function(data) {

                $("body").css("pointer-events", "auto");
    
            }
    
        });
    
    });

</script>

<script>
function rolesStatusToggle($uid){

    $.ajax({
        type: 'POST',
        url: "<?= base_url(route_to('roles.status.ajax')) ?>",
        dataType:'json',
        data: { uid: $uid },
        beforeSend: function() {

            $('body').css('pointer-events','none');

        },
        success: function(data) {

              if(data.success == true){
                sweetAlret("Changes saved!", 'success')
                
             }else{
                   sweetAlret("Whoops!", 'error')
            }


        },
        error: function(err) {

            //

        },
        complete: function () {

            $('body').css('pointer-events','auto');

        }
    });

}


/* = = = [ Remove document :: START ] = = = */
function removeRoles( $uuid ) {
  confirmDialog('','Are you sure you want to delete this role?', function () {

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('roles.remove', $uuid)) ?>",
            dataType:'json',
            beforeSend: function() {
                $('body').css('pointer-events','none');
            },
            success: function(data) {
                 $('body').css('pointer-events','all');

                if(data.success == true){
                     sweetAlert(data.msg, 'success')
                     $('#'+ uuid).hide();
                }else{
                    sweetAlert(data.msg, 'error')
                }
            },
        });
    });


}

</script>
<?=$this->endSection()?>

<?=$this->section('page-content')?>
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid mt-5">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <!-- <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Category setup</h1> -->
                <!--end::Title-->
            </div>
        </div>
    </div>

    <!--begin::Content-->
    <div class="app-content flex-column-fluid">
        <div class="app-container container-xxl">
            <div class="card card-flush">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active">
                            <form class="form" method="POST" action="<?= base_url(route_to('roles.edit', $uuid)) ?>" id="formElement">
                                <div class="row mb-7">
                                    <div class="col-md-9 offset-md-3">
                                        <h2>Edit Role</h2>
                                    </div>
                                </div>

                                <div class="row fv-row mb-7">
                                    <div class="col-md-3 text-md-end">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span class="required">Name</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control form-control-solid" name="name" maxlength="50" value="<?= $getInfo->title ?>" required />
                                        <span class="text-danger ERROR__name"></span>
                                    </div>
                                </div>

                                <div class="row fv-row mb-7">
                                    <div class="col-md-3 text-md-end">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <span>Status</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-select form-select-solid" name="status" data-control="select2" data-hide-search="true">
                                            <option value="active" <?= $getInfo->status == 'active' ? 'selected' : '' ?>>Active</option>
                                            <option value="inactive" <?= $getInfo->status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                        <span class="text-danger ERROR__status"></span>
                                    </div>
                                </div>


                                <div class="row fv-row mb-7">
                                    <div class="col-md-3 text-md-end">
                                        <label class="fs-6 fw-semibold form-label mt-3"></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="submit" name="save_as_publish" value="Save changes" class="btn btn-sm fw-bold btn-primary">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
<?=$this->endSection()?>
