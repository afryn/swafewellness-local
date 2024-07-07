<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
<?= isset($center_data) ? 'Edit' : 'Add'; ?> Center
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>

function sanitizeInput(input) {
    var pattern = /[^28°'0-9\s.NSEW]/g;

    input.value = input.value.replace(pattern, '');
}

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
                        html += '<lable id="label_'+services[k]+'">Price for '+servName+' : </label><input data-id="'+ services[k] +'" form="addPckgForm" class="form-control" onkeyup="putVal(this)" required type="number" name="prices[]" placeholder = "Enter Price"><input type="hidden" name="price_'+services[k]+'">';
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
   function fetchStates(cId){
    var html = '<option value="">---select---</option>';
    
    $('#city_select').html(html) // reset city select 

    $.ajax({
            type: 'GET',
            url: "<?= base_url(route_to('fetch.states')) ?>",
            dataType: "JSON",
            data: {
                cId : cId
            },
            success: function (data) {
                data.states.forEach(element => {
                    html += '<option value="'+ element.id+'">'  + element.name + '</option>';
                });
                $('#state_select').html(html);
            }
        });
   }

   function fetchCities(sId){
    $.ajax({
            type: 'GET',
            url: "<?= base_url(route_to('fetch.cities')) ?>",
            dataType: "JSON",
            data: {
                sId : sId
            },
            success: function (data) {
                var html = '<option value="">---select---</option>';
                data.cities.forEach(element => {
                    html += '<option value="'+ element.id+'">'  + element.name + '</option>';
                });
                $('#city_select').html(html);
            }
        });
   }
</script>
<script>

    $(document).on('submit', '#addPckgForm', function (ev) {

        ev.preventDefault();
        var frm = $('#addPckgForm');
        var form = $('#addPckgForm')[0];
        var data = new FormData(form);

        $.ajax({
            type: 'POST',
            url: "<?= base_url(route_to('add.center')) ?>",
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
                    setTimeout(() => {
                        
                        window.location.href = $("#baseUrl").val() + 'admin/center-list';
                    }, 1000);
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

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ), {
      removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'],
    })
        .catch( error => {
            console.error( error );
        } );
</script>
<?= $this->endSection() ?>

<?= $this->section('page-title'); ?>
<?= isset($center_data) ? 'Edit' : 'Add'; ?> Trainer
<?= $this->endSection(); ?>

<?= $this->section('page-content') ?>
<style>
  .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: auto;
    padding: 0.25rem 0.9rem;
    user-select: none;
    -webkit-user-select: none;
}
.select2-container--default .select2-selection--single {
    border: 1px solid #dbd9d9;
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3>
                                <?= isset($center_data) ? 'Edit' : 'Add'; ?> Center
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
                                            accept="<?= base_url(route_to('add.center')) ?>">


                                            <input type="hidden" name="cId"
                                                value="<?= isset($center_data) ? lock($center_data->id) : ''; ?>">
                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputEmail1" class="form-label">Center Name <span
                                                        class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($center_data->center_name) ? $center_data->center_name : ''; ?>"
                                                    name="center_name" placeholder="Center Name" type="text"
                                                    class="form-control" id="exampleInputEmail1"
                                                    aria-describedby="emailHelp">
                                                <div id="emailHelp" class="form-text text-danger ERROR__center_name">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="center_address" class="form-label">Address <span
                                                        class="text-danger">*</span></label>
                                                        <input form="addPckgForm" value="<?= isset($center_data->address) ? $center_data->address : ''; ?>" name="address" id="center_address" type="text" placeholder="Address"class="form-control" >
                                               
                                                <div class="form-text text-danger ERROR__address">
                                                </div>
                                            </div>

                                            <!-- country  -->
                                            <div class="mb-3 col-md-6">
                                                <label for="country_select" class="form-label">Country <span
                                                        class="text-danger">*</span></label>
                                                <select onchange="fetchStates(this.value)" form="addPckgForm" id="country_select" name="country"
                                                    class="form-select select2_inp_search" id="">
                                                    <option value="">---select---</option>
                                                    <?php foreach ($countries as $country): ?>
                                                        <option value="<?= $country->id; ?>"
                                                            <?= (isset($center_data->country) && $center_data->country == $country->id) ? 'selected' : ''; ?>>
                                                            <?= $country->name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="form-text text-danger ERROR__country">
                                                </div>
                                            </div>

                                             <!-- State  -->
                                             <div class="mb-3 col-md-6">
                                                <label for="state_select" class="form-label">State <span
                                                        class="text-danger">*</span></label>
                                                <select onchange="fetchCities(this.value)" form="addPckgForm" id="state_select" name="state"
                                                    class="form-select select2_inp_search" id="">
                                                    <option value="">---select---</option>
                                                    <?php //in case of edit
                                                    if(isset($center_data)) : 
                                                    foreach ($states as $state):?>

                                                        <option value="<?= $state->id; ?>"
                                                            <?= (isset($center_data->state) && $center_data->state == $state->id) ? 'selected' : ''; ?>>
                                                            <?= $state->name; ?></option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                                <div class="form-text text-danger ERROR__state">
                                                </div>
                                            </div>
                                            
                                             <!-- city  -->
                                             <div class="mb-3 col-md-6">
                                                <label for="city_select" class="form-label">City <span
                                                        class="text-danger">*</span></label>
                                                <select form="addPckgForm" id="city_select" name="city"
                                                    class="form-select select2_inp_search" id="">
                                                    <option value="">---select---</option>

                                                    <?php //in case of edit
                                                    if(isset($center_data)):
                                                    foreach ($cities as $city): ?>
                                                        <option value="<?= $city->id; ?>"
                                                            <?= (isset($center_data->city) && $center_data->city == $city->id) ? 'selected' : ''; ?>>
                                                            <?= $city->name; ?></option>
                                                    <?php endforeach; 
                                                    endif;?>
                                                </select>
                                                <div class="form-text text-danger ERROR__city">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="longitude" class="form-label">Longitude <span
                                                        class="text-danger">*</span></label>
                                                <input  form="addPckgForm"
                                                    value="<?= isset($center_data->longitude) ? $center_data->longitude : ''; ?>"
                                                    name="longitude" placeholder="Longitude" type="text"
                                                    class="form-control" id="longitude" aria-describedby="emailHelp">
                                                <div class="form-text text-danger ERROR__longitude">
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="latitude" class="form-label">Latitude <span
                                                        class="text-danger">*</span></label>
                                                <input  form="addPckgForm"
                                                    value="<?= isset($center_data->latitude) ? $center_data->latitude : ''; ?>"
                                                    name="latitude" placeholder="Latitude" type="text"
                                                    class="form-control" id="longitude" aria-describedby="emailHelp">
                                                <div class="form-text text-danger ERROR__latitude">
                                                </div>
                                            </div>


                                            <div class="mb-3 col-md-6">
                                                <label for="">Open Timing <span class="text-danger">*</span></label>

                                                <div class="d-flex p-2 border mb-3 justify-content-around">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <label for="from_time">From</label>
                                                            <input
                                                                value="<?= (isset($center_data->from_time)) ? date("H:i", strtotime($center_data->from_time)) : ''; ?>"
                                                                class="form-control" id="from_time" type="time"
                                                                name="avlblty_time_from">
                                                        </div>
                                                        <div class="form-text text-danger ERROR__avlblty_time_from">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-center mx-2">
                                                        <div class="d-flex gap-2 align-items-center">
                                                            <label for="to_time">To</label>
                                                            <input
                                                                value="<?= (isset($center_data->to_time)) ? date("H:i", strtotime($center_data->to_time)) : ''; ?>"
                                                                class="form-control" id="to_time" type="time"
                                                                name="avlblty_time_to">
                                                        </div>
                                                        <div class="form-text text-danger ERROR__avlblty_time_to"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                                 <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label ">Programmes
                                                    Available <span class="text-danger">*</span></label>
                                                       <input id = "selectedServices" type="hidden" value="<?= isset($center_data)? $center_data->services_offered: '';?>">
                                                     
                                                <select form="addPckgForm" name="services[]" multiple id="servicesAvlbl"
                                                    class="form-control select2_inp">
                                                    
                                                  

                                                    <?php foreach ($services as $service): ?>
                                                        <option value="<?= $service->id; ?>"
                                                            <?= (isset($center_data->services_offered) && in_array($service->id, explode(',', $center_data->services_offered))) ? 'selected' : ''; ?>><?= $service->package_name; ?></option>

                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="form-text text-danger ERROR__services"></div>
                                            </div>
                                            
                                             <div class="mb-3 col-md-6 <?= (isset($center_data) && $center_data != '')? '' : 'd-none';?>" id="servicesPrice">
                                                 
                                                 <?php if(isset($center_data) && $center_data != ''){
                                                     $pricing = _getWhere('sw_pricing', ['type' => 'center', 'type_id' => $center_data->token], 'yes');
                                                    
                                        
                                                     foreach ($pricing as $price ) {
                                                     $progrmmeName = _getWhere('sw_packages', ['id'=> $price->progrm_id]);
                                                      if(in_array($progrmmeName->id, explode(',',$center_data->services_offered))){
                                                     
                                                     ?>
    
                                       
                                                 
                                                 <label id="label_<?= $progrmmeName->id;?>">Price for <?= $progrmmeName->package_name;?> : </label>
                                                 <input form="addPckgForm" data-id="<?= $progrmmeName->id;?>" class="form-control" required onkeyup="putVal(this)" type="number" value="<?= $price->amount;?>" name="prices[]" placeholder = "Enter Price">
                                                 
                                                 <input type="hidden" name="price_<?=$progrmmeName->id;?>" value="<?= $price->amount;?>">
                                                     <?php  }
                                                 ?>
                                                 
                                                     
                                                <?php }} ?>
                                               
                                                  </div>

                                          

                                            <div class="mb-3 col-md-12">
                                                <label for="exampleInputPassword1" class="form-label">Description <span
                                                        class="text-danger">*</span></label>

                                                <div class="form-floating">
                                                    <textarea form="addPckgForm" name="short_desc" class="form-control"
                                                        placeholder="Description" id="editor"
                                                        style="height: 100px"><?= isset($center_data->short_desc) ? $center_data->short_desc : ''; ?></textarea>
                                                   
                                            <div class="form-text text-danger ERROR__short_desc"></div>
                                            </div>

                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Open on <span
                                                        class="text-danger">*</span></label>

                                                <div>
                                                    <?php
                                                    if (isset($center_data->days_open)) {
                                                        $daysArr = explode(',', $center_data->days_open);
                                                    } ?>
                                                    <div class="d-flex flex-wrap p-2 border mb-3">

                                                        <?php foreach ($weekDays as $day): ?>

                                                            <div class="form-check mb-3 mx-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="days_open[]" value="<?= $day['id']; ?>"
                                                                    id="day<?= $day['id']; ?>" <?= (isset($daysArr) && in_array($day['id'], $daysArr)) ? 'checked' : ''; ?>>
                                                                <label class="form-check-label" for="day<?= $day['id']; ?>">
                                                                    <?= $day['day']; ?>
                                                                </label>
                                                            </div>

                                                        <?php endforeach; ?>
                                                    </div>

                                                    <div class="form-text text-danger ERROR__days_open"></div>
                                                </div>
                                            </div>

                                            <!-- <div class="mb-3 col-md-6">
                                                <label for="longitude" class="form-label">Price <span
                                                        class="text-danger">*</span></label>
                                                <input form="addPckgForm"
                                                    value="<?= isset($center_data->price) ? $center_data->price : ''; ?>"
                                                    name="price" placeholder="Price" type="number"
                                                    class="form-control" id="longitude" aria-describedby="emailHelp">
                                                <div class="form-text text-danger ERROR__price">
                                                </div>
                                            </div> -->


                                            <div class="mb-3 col-md-6">
                                                <label for="exampleInputPassword1" class="form-label">Center Image
                                                    <small>(Size 370 * 296)</small><span
                                                        class="text-danger">*</span></label>
                                                <input onchange="validateimg(this, 370, 296, '', '')" form="addPckgForm" type="file" class="form-control" name="image">
                                                <div class="form-text text-danger ERROR__image"></div>
                                            </div>

                                            <?php if (isset($center_data->center_img) && $center_data->center_img != '') { ?>
                                                <div class="mb-3 col-md-6">
                                                    <div>
                                                        <p>Current Image</p>
                                                        <img width="100px"
                                                            src="<?= base_url('uploads/centers/' . $center_data->center_img); ?>"
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