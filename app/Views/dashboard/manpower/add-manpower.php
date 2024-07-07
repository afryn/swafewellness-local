<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
<?= isset($manp_data)?'Edit':'Add';?> User
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
            url: "<?= base_url(route_to('add.manpower')) ?>",
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
                    window.location.href = $("#baseUrl").val() + 'admin/users-list';
                }

                if (data.success == false) {
                    sweetAlret(data.msg, 'error')
                    window.scrollTo({ top: 0, behavior: 'smooth' });
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
<?= $this->endSection() ?>

<?= $this->section('page-title');?>
<?= isset($manp_data)?'Edit':'Add';?> Manpower
<?= $this->endSection();?>

<?= $this->section('page-content') ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3><?= isset($manp_data)?'Edit':'Add';?> User</h3>
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
                                            accept="<?= base_url(route_to('add.manpower')) ?>">

                                            <input type="hidden" name="mId"
                                                value="<?= isset($manp_data) ? lock($manp_data->id) : ''; ?>">

                                            <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label">Role<span class="text-danger">*</span></label>
                                                <select class="form-select"  name="userRole" id="">
                                                    <?php foreach ($roles as $role) :?>
                                                    
                                                        <option value="<?=dynamicLock($role->id) ;?>" <?= (isset($manp_data->role_id) &&  $manp_data->role_id == $role->id )? 'selected': ''; ?>><?= $role->title;?></option>
                                                    <?php endforeach;?>
                                                </select>
                                                <div class="form-text text-danger ERROR__userRole">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Name <span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($manp_data->first_name) ? $manp_data->first_name : ''; ?>"
                                                    name="name" placeholder="Name" type="text"
                                                    class="form-control" id="exampleInputEmail1">
                                                <div id="emailHelp" class="form-text text-danger ERROR_name">
                                                </div>
                                            </div>

                                             <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($manp_data->email) ? $manp_data->email : ''; ?>"
                                                    name="email" placeholder="Email" type="email"
                                                    class="form-control" id="email">
                                                <div class="form-text text-danger ERROR__email">
                                                </div>
                                            </div>
                                            

                                           

                                            <div class="mb-3 col-md-6">
                                                <label for="mobile" class="form-label">Mobile<span class="text-danger">*</span></label>
                                                <input pattern="\d{7,15}" title="Enter 7 to 15 digits" maxlength="15" oninput="this.value = this.value.replace(/\D+/g, '')" maxlength="10" form="addPckgForm"
                                                    value="<?= isset($manp_data->phone_no) ? $manp_data->phone_no : ''; ?>"
                                                    name="mobile" placeholder="Mobile" type="text"
                                                    class="form-control" id="Mobile">
                                                <div class="form-text text-danger ERROR__mobile">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="mobile" class="form-label">Password<span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input form="addPckgForm"
                                                    value="<?= isset($manp_role_data) ? lock($manp_role_data->password, 'decrypt') : ''; ?>"
                                                    name="new_password" placeholder="Password" type="password"
                                                    class="form-control  passInp" id="">
                                                    <i class="fa fa-eye passtoggle" onclick="togglePass('passInp')"></i>
                                                </div>

                                                <div class="form-text passText">Must contain 1 uppercase, 1 lowercase, 1 special, 8 to 200 characters and 1 number. 
                                                </div>
                                                
                                                <div class="form-text text-danger ERROR__new_password">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Image <small>(Optional)(size : 200*200)</small></label>
                                                <input onchange="validateimg(this, 200, 200, '', '')" form="addPckgForm" type="file" class="form-control" name="image">
                                                <div class="form-text text-danger ERROR__image"></div>
                                            </div>
                                            
                                            <?php if (isset($manp_data->profile_photo) && $manp_data->profile_photo != '') { ?>
                                                <div class="mb-3 col-md-6">
                                                    <div>
                                                        <p>Current Image</p>
                                                        <img width="100px"
                                                            src="<?= base_url('uploads/manpowers/' . $manp_data->profile_photo); ?>"
                                                            alt="">
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="mb-3 col-md-12">
                                            <button type="submit" form="addPckgForm"
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