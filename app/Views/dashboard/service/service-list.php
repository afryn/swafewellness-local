<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Service List
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action) {

        if (action == 'chngeStts') {
            msg = 'Are you sure you want to change status?'
        }
        else if (action == 'trash') {
            msg = 'Are You sure! You want to delete this service?'
        }
        confirmDialog('', msg, function () {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(route_to('service.status')) ?>",
                data: { id: id, action: action },

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
                            <h3>Service List</h3>

                        </div>
                        <?php
                        _registerFunction(['function_name' => 'service_add', 'alias' => 'Add Service', 'category' => 'Service']);
                        if (
                            authChecker('admin', [
                                'service_add',
                            ])
                        ): ?>
                            <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">

                                <a class="btn btn-primary" href="<?= base_url(route_to('add.service')) ?>" class="nav-link">
                                    Add Service
                                </a>

                            </div>
                        <?php endif; ?>
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
                                                    <th>Service</th>
                                                    <th>Duration</th>
                                                    <?php _registerFunction(['function_name' => 'service_status_toggle', 'alias' => 'Service Status Toggle', 'category' => 'Service']);

                                                    if (
                                                        authChecker('admin', [
                                                            'service_status_toggle',
                                                        ])
                                                    ) { ?>
                                                        <th>Status</th>
                                                    <?php } ?>
                                                    <th>Created At</th>
                                                    <?php
                                                            _registerFunction(['function_name' => 'service_edit', 'alias' => 'Edit Service', 'category' => 'Service']);
                                                            _registerFunction(['function_name' => 'service_remove', 'alias' => 'Remove Service', 'category' => 'Service']);

                                                            if (
                                                                authChecker('admin', [
                                                                    'service_edit',
                                                                    'service_remove',
                                                                ])
                                                            ) { ?>

                                                    <th>Actions</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($services as $service) { ?>
                                                    <tr id="<?= lock($service->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td><img width="60px"
                                                                src="<?= base_url('uploads/services/') . (($service->image != '') ? $service->image : "no-image.jpg") ?>"
                                                                alt=""><?= $service->service_name; ?></td>
                                                        <td>
                                                            <?= $service->service_duration; ?>
                                                        </td>

                                                      
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'service_status_toggle',
                                                                ])
                                                            ) { ?>  <td>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        onchange="changeStatus('<?= lock($service->id); ?>','chngeStts')"
                                                                        class="form-check-input" type="checkbox"
                                                                        id="flexSwitchCheckChecked" <?= ($service->status) ? 'checked' : ''; ?>>
                                                                </div>   </td>
                                                            <?php } ?>
                                                     
                                                        <td>
                                                            <?= $service->date_time; ?>
                                                        </td>
                                                        <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'service_edit',
                                                                    'service_remove',
                                                                ])
                                                            ) { ?>
                                                        <td>
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'service_edit',
                                                                ])
                                                            ) { ?>

                                                                <a
                                                                    href="<?= base_url('admin/service-edit/') . lock($service->id); ?>"><i
                                                                        class="fa fa-edit text-dark"></i></a>

                                                            <?php } ?>
                                                            <?php 

                                                            if (
                                                                authChecker('admin', [
                                                                    'service_remove',
                                                                ])
                                                            ) { ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="changeStatus('<?= lock($service->id); ?>','trash')"
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
        </div>
    </div>
</div>


<?= $this->endSection() ?>