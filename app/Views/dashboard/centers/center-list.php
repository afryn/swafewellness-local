<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Center List
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
    function changeStatus(id, action, e, elem) {
        e.preventDefault();
        if (action == 'chngeStts') {
            msg = 'Are you sure you want to change status?'
        } else if (action == 'trash') {
            msg = 'Are You sure! You want to delete this center?'
        }
        confirmDialog('', msg, function() {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(route_to('center.status')) ?>",
                data: {
                    id: id,
                    action: action
                },

                success: function(data) {

                    if (data.success == true) {
                        sweetAlret(data.msg, 'success')

                        if (action == 'trash') {
                            $('#' + id).hide();
                        } else if (action == 'chngeStts') {

                            if (data.updatedStatus == 1) {
                                $(elem).prop('checked', true)
                            } else {
                                $(elem).prop('checked', false)
                            }
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
                            <h3>Center List</h3>
                        </div>
                        <?php
                        _registerFunction(['function_name' => 'center_add', 'alias' => 'Add Center', 'category' => 'Centers']);
                        if (
                            authChecker('admin', [
                                'center_add',
                            ])
                        ) : ?>
                            <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">
                                <a class="btn btn-primary" href="<?= base_url(route_to('add.center')) ?>" class="nav-link">
                                    Add Center
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php
        _registerFunction(['function_name' => 'center_list', 'alias' => 'Center List', 'category' => 'Centers']);
        if (
                            authChecker('admin', [
                                'center_list',
                            ])
                        ) : ?>
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
                                                    <th>Center</th>
                                                    <th>Open Days</th>
                                                    <th>Timing</th>
                                                    <th>Address</th>
                                                    <?php
                                                    _registerFunction(['function_name' => 'center_status_toggle', 'alias' => 'Center Status Toggle', 'category' => 'Centers']);
                                                    if (
                                                        authChecker('admin', [
                                                            'center_status_toggle',
                                                        ])
                                                    ) { ?>
                                                        <th>Status</th>
                                                    <?php } ?>
                                                    <th>Added on</th>
                                                    <?php
                                                    _registerFunction(['function_name' => 'center_edit', 'alias' => 'Center Edit', 'category' => 'Centers']);
                                                    _registerFunction(['function_name' => 'center_remove', 'alias' => 'Center Remove', 'category' => 'Centers']);

                                                    if (
                                                        authChecker('admin', [
                                                            'center_edit',
                                                            'center_remove',
                                                        ])
                                                    ) { ?>
                                                        <th>Actions</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($centers as $center) { ?>
                                                    <tr id="<?= lock($center->id); ?>">
                                                        <td>
                                                            <?=  $i; ?>
                                                        </td>
                                                        <td>
                                                            <img width="30px" src="<?= base_url('uploads/centers/') . (($center->center_img != '') ? $center->center_img : "no-image.jpg") ?>" alt="">
                                                            <?= $center->center_name; ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach (explode(',', $center->days_open) as $day) { ?>
                                                                <span class="badge rounded-pill bg-light text-dark">
                                                                    <?= $weekDays[0][$day]; ?>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?= $center->from_time . ' to ' . $center->to_time; ?>
                                                        </td>
                                                        <td>
                                                            <?= $center->address; ?>
                                                        </td>



                                                        <?php
                                                        if (
                                                            authChecker('admin', [
                                                                'center_status_toggle',
                                                            ])
                                                        ) { ?><td>
                                                                <div class="form-check form-switch">
                                                                    <input onclick="changeStatus('<?= lock($center->id); ?>','chngeStts', event, this)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" <?= ($center->status) ? 'checked' : ''; ?>>
                                                                </div>
                                                            </td>
                                                        <?php } ?>

                                                        <td>
                                                            <?= $center->created_at; ?>
                                                        </td>
                                                        <?php
                                                        if (
                                                            authChecker('admin', [
                                                                'center_edit',
                                                                'center_remove',
                                                            ])
                                                        ) { ?>
                                                            <td>
                                                                <?php
                                                                if (
                                                                    authChecker('admin', [
                                                                        'center_edit',
                                                                    ])
                                                                ) { ?>
                                                                    <a href="<?= base_url('admin/center-edit/') . lock($center->id); ?>"><i class="fa fa-edit text-dark"></i></a>
                                                                <?php } ?>
                                                                <?php

                                                                if (
                                                                    authChecker('admin', [
                                                                        'center_remove',
                                                                    ])
                                                                ) { ?>
                                                                    <a href="javascript:void(0)" onclick="changeStatus('<?= lock($center->id); ?>','trash', event, this)" class="m-2"><i class="fa fa-trash text-danger"></i></a>
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
            <?php endif; ?>
            <!-- Container-fluid Ends-->
        </div>
    </div>
</div>


<?= $this->endSection() ?>