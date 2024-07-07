<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
Trainer List
<?= $this->endSection();?>

<?= $this->section('styles'); ?>
<style>

@media (max-width: 1290px){
    table#myTable td {
        font-size: 10px;
    }
}
</style>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action) {

        if (action == 'chngeStts') {
            msg = 'Are you sure you want to change status?'
        }
        else if (action == 'trash') {
            msg = 'Are You sure! You want to delete this trainer account?'
        }
        confirmDialog('', msg, function () {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(route_to('admin.trainers-status')) ?>",
                data: { id: id , action: action},

                success: function (data) {

                    if (data.success == true) {
                        sweetAlret(data.msg, 'success')

                        if (action == 'trash') {
                            $('#' + id).hide();
                        }
                    }
                    if (data.success == false) {
                        sweetAlret(data.msg, 'error')
                    }
                },
            });
        });
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
                            <h3>Trainer List</h3>
                        </div>
                           <?php

_registerFunction(['function_name' => 'trainer_add','alias' => 'Add Trainer','category' => 'Trainers']);

               if(authChecker('admin', [
            'trainer_add',

              ])): ?>
 <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">
                  <a class="btn btn-primary" href="<?= base_url(route_to('admin.trainer-add')) ?>" class="nav-link">
                   Add Trainer
                  </a> </div>
                   <?php endif; ?>
                       
                    </div>
                </div>
            </div>

            <?php 
            _registerFunction(['function_name' => 'trainer_list','alias' => 'Trainers List','category' => 'Trainers']);
           
            if(authChecker('admin', [
                'trainer_list',
    
                  ])): ?>
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
                                                    <th>Trainer</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Programmes Offered</th>
                                                    <?php
                                                            _registerFunction(['function_name' => 'trainer_status_toggle', 'alias' => 'Toggle Trainer Status', 'category' => 'Trainers']);
                                                            if (
                                                                authChecker('admin', [
                                                                    'trainer_status_toggle',
                                                                ])
                                                            ) { ?>
                                                    <th>Status</th>
                                                    <?php } ?>
                                                    <th>Created At</th>
                                                    <?php _registerFunction(['function_name' => 'trainer_edit', 'alias' => 'Edit Trainer', 'category' => 'Trainers']);
                                                          _registerFunction(['function_name' => 'trainer_remove', 'alias' => 'Remove Trainer', 'category' => 'Trainers']);

                                                           if (
                                                                authChecker('admin', [
                                                                    'trainer_edit',
                                                                    'trainer_remove',
                                                                ])
                                                            ) { ?>
                                                    <th>Actions</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($trainers as $trnr) { ?>
                                                    <tr id="<?= lock($trnr->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td><img width="30px"
                                                                src="<?= base_url('uploads/trainers/') . (($trnr->image != '') ? $trnr->image : "no-image.jpg") ?>"
                                                                alt="">
                                                            <?= $trnr->trainer_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $trnr->email; ?>
                                                        </td>
                                                        <td>
                                                            <?= $trnr->mobile; ?>
                                                        </td>
                                                        <td>
                                                            <?php $services = explode(',' ,  $trnr->services_offered);
                                                            foreach ($services as $service) {
                                                              $ser =  _getWhere('sw_packages', ['id' => $service]);
                                                              if($ser):?>
                                                             <span class="badge rounded-pill bg-light text-dark"> <?= $ser->package_name ;?></span>
                                                             <?php endif;?>
                                                             
  
                                                           <?php } ?>
                                                        </td>
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'trainer_status_toggle',
                                                                ])
                                                            ) { ?> <td>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        onchange="changeStatus('<?= lock($trnr->id); ?>','chngeStts')"
                                                                        class="form-check-input" type="checkbox"
                                                                        id="flexSwitchCheckChecked" <?= ($trnr->status) ? 'checked' : ''; ?>>
                                                                </div> </td>
                                                            <?php } ?>
                                                       
                                                             <td>
                                                            <?= $trnr->date_time; ?>
                                                        </td>
                                                        <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'trainer_edit',
                                                                    'trainer_remove',
                                                                ])
                                                            ) { ?>
                                                        <td>
                                                            <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'trainer_edit',
                                                                ])
                                                            ) { ?>

                                                                <a
                                                                    href="<?= base_url('admin/trainer-edit/') . lock($trnr->id); ?>"><i
                                                                        class="fa fa-edit text-dark"></i></a>

                                                            <?php } ?>
                                                            <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'trainer_remove',
                                                                ])
                                                            ) { ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="changeStatus('<?= lock($trnr->id); ?>','trash')"
                                                                    class="m-2"><i class="fa fa-trash text-danger"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                        <?php } ?>
                                                   
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
            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->endSection() ?>