<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Appointment Details
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function approveAppointment(id, elem){
        $.ajax({
            url: '<?= base_url(route_to("approve.appointment"));?>',
            data : { id : id },
            method: 'POST',
            success : function (data){
               if (data.success == true) {
                    sweetAlret(data.msg, 'success')

                    $(elem).hide();
                    $(elem).next().removeClass('d-none');
                    
                }
                if (data.success == false) {
                    sweetAlret(data.msg, 'error')
                }
            }
        })
    }
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
                                Appointment Details
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

                                    <div class="col-md-12 row">
                                       

                                            <div class="mb-3 col-md-6">
                                                 <?php  $dateString = $app->appnmnt_date;
                                                        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
                                                
                                                        $formattedDate = $date->format('M j, Y');
                                                    ?>
                                                    <p><b>Appointment Date : </b><?= $formattedDate ; ?></p>
                                               
                                                <p><b>First Name : </b><?= (isset($app->firstname) )  ?    $app->lastname: ''; ?></p>
                                                    <p><b>Last Name : </b><?= (isset($app->lastname) )  ?    $app->lastname: ''; ?></p>
                                                     <p><b>Mobile : </b><?= (isset($app->mobile) )  ? $app->mobile: ''; ?></p>
                                                      <p><b>Email : </b><?= (isset($app->user_email) )  ?    $app->user_email: ''; ?></p>
                                                      <p><b>Adults : </b><?= (isset($app->adults) )  ?    $app->adults: ''; ?></p>
                                                       
                                                       
                                                       <p><b>Booked On : </b><?= ( isset($app->date_time))  ?  $app->date_time: ''; ?></p>   
                                                       <p><b>Payment Status : </b> <?php if(isset($app->payment_status) && $app->payment_status == 'Pending'){?>
                                                       
                                                       <span class="badge border border-warning text-dark">Pending</span>      
                                                       <?php }else if($app->payment_status == 'Completed'){?>
                                                            <span class="badge border border-success text-dark">Completed</span>
                                                       
                                                       <?php }else if($app->payment_status == 'Failed'){?>
                                                       <span class="badge border border-danger text-dark">Failed</span>
                                                       <?php } ?>
                                                       </p>
                                                       
                                                        <p><b>User Address : </b><?= (isset($addr->house_num) )  ?    $addr->house_num : ''; ?>
                                                        
                                                        <?= (isset($addr->street) )  ? ', '.   $addr->street: ''; ?>
                                                        
                                                         <?= (isset($addr->locality) )  ? ', ' .   $addr->locality: ''; ?>
                                                         
                                                         <?php if(isset($addr->city) && $addr->city != '' && $addr->city != 0){ echo ', '.  _getWhere('cities', ['id' => $addr->city])->name;}?>
                                                          <?= (isset($addr->zip_code) )  ? ', '.   $addr->zip_code: ''; ?>
                                                         
                                                         
                                                          <?php if(isset($addr->state) && $addr->state != '' && $addr->state != 0){ echo ', '.   _getWhere('states', ['id' => $addr->state])->name;}?>
                                                          
                                                            <?php if(isset($addr->countries) && $addr->countries != '' && $addr->countries != 0){ echo ', '.  _getWhere('states', ['id' => $addr->countries])->name;}?>
                                                        
                                                        </p>
                                                       
                                                   
                                                    <?php if($app->appntmnt_status == 'Pending'){?>
                                                    
                                                      <?php
                                                            _registerFunction(['function_name' => 'approve_appointment', 'alias' => 'Approve Appointment', 'category' => 'Appointments']);
                                                            if (
                                                                authChecker('admin', [                                                         
                                                                    'approve_appointment',
                                                                ])
                                                            ) { ?>
                                                    <button class="btn btn-primary" onclick="approveAppointment('<?= lock($app->id);?>', this)">Approve</button>
                                                    <?php }?>
                                                      <button class="d-none btn btn-outline-primary" style="cursor:default;" type="button">Approved</button>
                                                    
                                                    
                                                    <?php }else if($app->appntmnt_status == 'Approved'){ ?>
                                                    <button class="btn btn-outline-primary" style="cursor:default;" type="button">Approved</button>
                                                    <?php }?>
                                                
                                            </div>
                                             <div class="mb-3 col-md-6">
                                                 
                                        <div class="card mb-3" style="max-width: 340px;">
                                          <div class="row g-0">
                                            <div class="col-md-4">
                                              <img src="<?= base_url();?>uploads/packages/<?= $app->package_image;?>" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                              <div class="card-body">
                                                <h5 class="card-title">Programme</h5>
                                                <p class="card-text"><?= $app->package_name;?></p>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                      <?php if($app->type == 'center'){?>
                                      <div class="card mb-3" style="max-width: 340px;">
                                          <div class="row g-0">
                                            <div class="col-md-4">
                                              <img src="<?= base_url();?>uploads/centers/<?= $app->center_img;?>" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                              <div class="card-body">
                                                <h5 class="card-title">Center</h5>
                                                <p class="card-text"><?= $app->center_name;?></p>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      
                                      <?php }else if($app->type == 'trainer'){?>

                                       <div class="card mb-3" style="max-width: 340px;">
                                          <div class="row g-0">
                                            <div class="col-md-4">
                                              <img src="<?= base_url();?>uploads/trainers/<?= $app->triner_img;?>" class="img-fluid rounded-start" alt="...">
                                            </div>
                                            <div class="col-md-8">
                                              <div class="card-body">
                                                <h5 class="card-title">Trainer</h5>
                                                <p class="card-text"><?= $app->trainer_name;?></p>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                        <?php }?>
                                        
                                      
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