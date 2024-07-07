<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Appointments List
<?= $this->endSection(); ?>

<?= $this->section('styles') ?>
<style>
    .star {
        float: right;
        font-size: 10px;
        color: yellow;
        cursor: pointer;
    }

    .star:before {
        content: '\2605';
        /* Unicode character for a star */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    function approveAppointment(id, elem){
        $.ajax({
            url: '<?= base_url(route_to("approve.appointment"));?>',
            data : { id : id },
            success : function (data){
               if (data.success == true) {
                    sweetAlret(data.msg, 'success')

                    $(elem).hide();
                    
                }
                if (data.success == false) {
                    sweetAlret(data.msg, 'error')
                }
            }
        })
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
                            <h3>Center List</h3>
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

                                        <table id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>sno.</th>
                                                    <th>Name</th>
                                                    <th>Appointment Date</th>
                                                    <th>Programme</th>
                                                    <th>Center</th>
                                                    <th>Booked on</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($centerAppointments as $app) { ?>
                                                    <tr id="<?= lock($app->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td>
                                                            
                                                            <?= $app->firstname . ' ' . $app->lastname  ; ?>
                                                        </td>
                                                        <td>
                                                            <?php  $dateString = $app->appnmnt_date;
                                                        $date = \DateTime::createFromFormat('Y-m-d', $dateString);
                                                
                                                        $formattedDate = $date->format('M j, Y');
                                                    ?>
                                                           <?= $formattedDate   ; ?>
                                                        </td>
                                                        <td>
                                                            <?=  $app->package_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $app->center_name; ?>
                                                        </td>
                                                       <td>
                                                       <?= $app->date_time  ; ?>
                                                            </td>
                                                            <td>
                                                                <a href="<?= base_url('admin/appointment-details');?>/<?= lock($app->id); ?>">
                                                                <i style="cursor:pointer;" class="fa fa-eye"></i>
                                                                </a>
                                                                <?php
                                                            _registerFunction(['function_name' => 'approve_appointment', 'alias' => 'Approve Appointment', 'category' => 'Appointments']);
                                                            if (
                                                                authChecker('admin', [                                                         
                                                                    'approve_appointment',
                                                                ])
                                                            ) { ?>
                                                            
                                                            <?php $app->id;?>
                                                            <?php  if($app->appntmnt_status == 'Pending'){?>
                                                            <button class="btn btn-sm btn-outline-primary" onclick="approveAppointment('<?= lock($app->id);?>', this)">Approve</button>
                                                            
                                                            <?php }
                                                            } ?>
                                                            </td>
                                                  
                                                    </tr>
                                                <?php $i++;
                                                } ?>
                                            </tbody>
                                        </table>
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