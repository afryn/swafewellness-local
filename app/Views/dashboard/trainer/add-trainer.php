<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
<?= isset($pkg_data) ? 'Edit' : 'Add'; ?> Trainer
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
$('#servicesAvlbl').on('select2:select', function (){
    console.log($('#servicesAvlbl').val())
    var html = '';
    if($('#servicesAvlbl').val()!= ''){
        
            var services = $('#servicesAvlbl').val();
            var k = 0;
            var selectedSer = $('#servicesAvlbl').val().join(',');
            $('#selectedServices').val(selectedSer);
            
             services.forEach(element => {
                 
                  var data = $('#servicesAvlbl').select2('data')
                  var servName = data[k].text 
                  
                  if(document.querySelector('[data-id="'+services[k]+'"]') == null){
                        html += '<label id="label_'+services[k]+'">Price for '+servName+' : </label><input data-id="'+ services[k] +'" form="addPckgForm" class="form-control" onkeyup="putVal(this)" required type="number" name="prices[]"  placeholder = "Enter Price"><input type="hidden" name="price_'+services[k]+'">';
                  }
           k ++;
            });
            $('#servicesPrice').removeClass('d-none');
            $('#servicesPrice').append(html)
    }
    else{
           $('#servicesPrice').addClass('d-none');
    }

})
function findUniqueValues(array1, array2) {
  return array1.concat(array2).filter((value, index, arr) => arr.indexOf(value) === arr.lastIndexOf(value));
}

$('#servicesAvlbl').on('select2:unselect', function(e){
       
       var selected = $('#selectedServices').val().split(',');
       var current = $('#servicesAvlbl').val();
       
      var deletedOptions = findUniqueValues(selected, current);
      
        deletedOptions.forEach(element => {
            console.log(element)
          $('[data-id="'+element+'"]').remove();
        $('[name="price_'+element+'"]').remove();
        $('#label_' + element).remove();
    });
})

function putVal(elem){
    $(elem).next().val($(elem).val());
}
    $(document).on('submit', '#addPckgForm', function (ev) {

        ev.preventDefault();
        var frm = $('#addPckgForm');
        var form = $('#addPckgForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('admin.trainer-add')) ?>",
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
                    window.location.href = $("#baseUrl").val() + 'admin/trainers-list';
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

<?= $this->section('page-title'); ?>
<?= isset($trainer_data) ? 'Edit' : 'Add'; ?> Trainer
<?= $this->endSection(); ?>

<?= $this->section('page-content') ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3>
                                <?= isset($trainer_data) ? 'Edit' : 'Add'; ?> Trainer
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
                                        <form class="row" id="addPckgForm" method="post" enctype="multipart/form-data"
                                            accept="<?= base_url(route_to('admin.trainer-add')) ?>">


                                            <input type="hidden" name="trainer"
                                                value="<?= isset($trainer_data) ? lock($trainer_data->id) : ''; ?>">
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Trainer Name <span
                                                        class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($trainer_data->trainer_name) ? $trainer_data->trainer_name : ''; ?>"
                                                    name="trainer_name" placeholder="Trainer Name" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__trainer_name">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Trainer
                                                    Email <span class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($trainer_data->email) ? $trainer_data->email : ''; ?>"
                                                    type="email" placeholder="Email" class="form-control"
                                                    name="trainer_email">
                                                <div class="form-text text-danger ERROR__trainer_email"></div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Trainer
                                                    Mobile <span class="text-danger">*</span></label>
                                                <input pattern="\d{7,15}" title="Enter 7 to 15 digits" maxlength="15" oninput="this.value = this.value.replace(/\D+/g, '')" form="addPckgForm"
                                                    value="<?= isset($trainer_data->mobile) ? $trainer_data->mobile : ''; ?>"
                                                    type="text" placeholder="Mobile Number" class="form-control"
                                                    name="mobile">
                                                <div class="form-text text-danger ERROR__mobile"></div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label ">Programmes
                                                    Offered <span class="text-danger">*</span></label>
                                                    
                                                    <input id = "selectedServices" type="hidden" value="<?= isset($trainer_data)? $trainer_data->services_offered: '';?>">
                                                <select form="addPckgForm" name="services[]" multiple id="servicesAvlbl"
                                                    class="form-control select2_inp">

                                                    <?php foreach ($services as $service): ?>
                                                        <option value="<?= $service->id; ?>"
                                                            <?= (isset($trainer_data->services_offered) && in_array($service->id, explode(',', $trainer_data->services_offered))) ? 'selected' : ''; ?>><?= $service->package_name; ?></option>

                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="form-text text-danger ERROR__services"></div>
                                            </div>
                                            
                                               <div class="mb-3 col-md-6 <?= (isset($trainer_data) && $trainer_data != '')? '' : 'd-none';?>" id="servicesPrice">
                                                 
                                                 <?php if(isset($trainer_data) && $trainer_data != ''){
                                                     $pricing = _getWhere('sw_pricing', ['type' => 'trainer', 'type_id' => $trainer_data->token], 'yes');
                                                    
                                        
                                                     foreach ($pricing as $price ) {
                                                     $progrmmeName = _getWhere('sw_packages', ['id'=> $price->progrm_id]);
                                                      if(in_array($progrmmeName->id, explode(',',$trainer_data->services_offered))){
                                                     
                                                     ?>
    
                                       
                                                 
                                                 <label id="label_<?= $progrmmeName->id;?>">Price for <?= $progrmmeName->package_name;?> : </label>
                                                 <input form="addPckgForm" data-id="<?= $progrmmeName->id;?>" class="form-control" required onkeyup="putVal(this)" type="number" value="<?= $price->amount;?>" name="prices[]" placeholder = "Enter Price">
                                                 
                                                 <input type="hidden" name="price_<?=$progrmmeName->id;?>" value="<?= $price->amount;?>">
                                                     <?php  }
                                                 ?>
                                                 
                                                     
                                                <?php }} ?>
                                               
                                                  </div>


                                            
                                           

                                            <div class="mb-3 col-md-6">
                                                <label for="" class="form-label">Availability <span
                                                        class="text-danger">*</span></label>

                                                <div>
                                                    <?php
                                                    if (isset($trainer_data->days_availability)) {
                                                        $daysArr = explode(',', $trainer_data->days_availability);
                                                    } ?>
                                                    <div class="mb-4 d-flex flex-wrap">
                                                        Days:
                                                        <?php foreach ($weekDays as $day): ?>

                                                            <div class="form-check mb-3 mx-2">
                                                                <input class="form-check-input" <?= (isset($daysArr) && in_array($day['id'], $daysArr)) ? 'checked' : ''; ?> type="checkbox"
                                                                name="days_availability[]" value="<?= $day['id']; ?>"
                                                                id="day<?= $day['id']; ?>">
                                                                <label class="form-check-label" for="day<?= $day['id']; ?>">
                                                                <?= $day['day']; ?>
                                                                </label>
                                                            </div>



                                                        <?php endforeach; ?>
                                                        <div class="form-text text-danger ERROR__days_availability">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex">

                                                        <div class="d-flex align-items-center flex-column">
                                                            <div class="d-flex align-items-center">
                                                                <label for="from_time" class="mx-2">From</label>
                                                                <input
                                                                    value="<?= (isset($trainer_data->from_time)) ? date("H:i", strtotime($trainer_data->from_time)) : ''; ?>"
                                                                    class="form-control" id="from_time" type="time"
                                                                    name="avlblty_time_from"> 
                                                            </div>
                                                            <div class="form-text text-danger ERROR__avlblty_time_from">
                                                            </div>
                                                        </div>

                                                        <div class="d-flex align-items-center mx-2 flex-column">
                                                            <div class="d-flex align-items-center">
                                                                <label for="to_time" class="mx-2">To</label>
                                                                <input
                                                                    value="<?= (isset($trainer_data->to_time)) ? date("H:i", strtotime($trainer_data->to_time)) : ''; ?>"
                                                                    class="form-control" id="to_time" type="time"
                                                                    name="avlblty_time_to">
                                                            </div>
                                                            <div class="form-text text-danger ERROR__avlblty_time_to">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1"
                                                    class="form-label">Description <span class="text-danger">*</span></label>
                                                <div class="form-floating">
                                                    <textarea form="addPckgForm" name="short_desc" class="form-control"
                                                        placeholder="Description" id="floatingTextarea2"
                                                        style="height: 100px"><?= isset($trainer_data->description) ? $trainer_data->description : ''; ?></textarea>
                                                    <label for="floatingTextarea2">Description</label>
                                                </div>
                                                <div class="form-text text-danger ERROR__short_desc"></div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <div>
                                                    <label for="exampleInputPassword1" class="form-label">Profile Image
                                                    <small>(Dimensions should be 500 x 450)</small><spane class="text-danger">*</spane></label>
                                                    <input  onchange="validateimg(this, 500, 450, '', '')" accept="image/*" form="addPckgForm" type="file" class="form-control" name="image">
                                                    <div class="form-text text-danger ERROR__image"></div>
                                                    <?php if (isset($trainer_data->image) && $trainer_data->image != '') { ?>
                                                        <div>
                                                            <p>Current Profile Image</p>
                                                            <img width="100px"
                                                                src="<?= base_url('uploads/trainers/' . $trainer_data->image); ?>"
                                                                alt="">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>  

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Password <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                       <input form="addPckgForm" form="passInp"
                                                    value="<?= isset($role_data->password) ? lock($role_data->password, 'decrypt') : ''; ?>"
                                                    type="password" placeholder="Password" id="passInp" class="form-control passInp"
                                                    name="new_password">
                                                    <i class="fa fa-eye passtoggle" onclick="togglePass('passInp')"></i>
                                                </div>
                                                <div class="form-text passText">Must contain 1 uppercase, 1 lowercase, 1 special, 8 to 200 characters and 1 number. 
                                                </div>
                                             
                                                <div class="form-text text-danger ERROR__new_password"></div>
                                            </div>

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