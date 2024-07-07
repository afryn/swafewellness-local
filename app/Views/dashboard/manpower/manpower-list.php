<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
User List
<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<style>

@media (max-width: 1290px){
    table#myTable td {
        white-space: nowrap;
        font-size: 10px;
    }
}
</style>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action,e,elem) {
        e.preventDefault();

        // var changedStts = $(elem).prop('checked');

        if (action == 'chngeStts') {
            msg = 'Are you sure you want to change status?'
        }
        else if (action == 'trash') {
            msg = 'Are You sure! You want to delete this user?'
        }
        confirmDialog('', msg, function () {
            $.ajax({
                type: 'POST',
                url: $("#baseUrl").val() + 'admin/user-status',
                data: { id: id, action: action },

                success: function (data) {

                    if (data.success == true) {
                        sweetAlret(data.msg, 'success')

                        if (action == 'trash') {
                            $('#' + id).hide();
                        }
                        else if (action == 'chngeStts') {

if (data.updatedStatus == 1) {
    $(elem).prop('checked', true)
} else {
    $(elem).prop('checked', false)
}

}
                        
                    }
                    if (data.success == false) {
                        // if(action == 'chngeStts'){
                        //     if(changedStts){
                        //         $(elem).prop('checked', false);
                        //     }
                        //     else{
                        //         $(elem).prop('checked', true);
                        //     }
                        // }
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
                            <h3>User List</h3>
                        </div>

                        <?php
                        _registerFunction(['function_name' => 'new_manpower_create', 'alias' => 'New Manpower Create', 'category' => 'Manpower']);
                        if (
                            authChecker('admin', [
                                'new_manpower_create',
                            ])
                        ): ?>
                            <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">
                                <a class="btn btn-primary" href="<?= base_url(route_to('add.manpower')) ?>" class="nav-link">
                                    Add User
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <?php
        _registerFunction(['function_name' => 'manpower_list', 'alias' => 'Manpower List', 'category' => 'Manpower']);
        if (
                    authChecker('admin', [
                        'manpower_list',
                    ])
                ): ?>
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
                                                    <th>User</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <?php
                                                            _registerFunction(['function_name' => 'manpower_status_toggle', 'alias' => 'Manpower Status Toggle', 'category' => 'Manpower']);
                                                            if (
                                                                authChecker('admin', [
                                                                    'manpower_status_toggle',
                                                                ])
                                                            ) { ?>
                                                    <th>Status</th>
                                                    <?php } ?>
                                                    <th>Created At</th>
                                                    <?php _registerFunction(['function_name' => 'manpower_edit', 'alias' => 'Manpower Edit', 'category' => 'Manpower']);
                                                             _registerFunction(['function_name' => 'manpower_remove', 'alias' => 'Manpower Remove', 'category' => 'Manpower']);

if (
    authChecker('admin', [
        'manpower_edit',
        'manpower_remove',
    ])
) { ?>
                                                    <th>Actions</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($employeeList as $manp) { ?>
                                                    <tr id="<?= lock($manp->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td><img width="40px"
                                                                src="<?= base_url('uploads/') . (($manp->profile_photo != '') ? 'manpowers/' . $manp->profile_photo : "no-image.jpg") ?>"
                                                                alt=""><?= $manp->first_name; ?></td>
                                                        <td>
                                                            <?= $manp->email; ?>
                                                        </td>
                                                        <td>
                                                            <?= $manp->phone_no; ?>
                                                        </td>

                                                     
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'manpower_status_toggle',
                                                                ])
                                                            ) { ?>   <td>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        onclick="changeStatus('<?= lock($manp->id); ?>','chngeStts', event, this)"
                                                                        class="form-check-input" type="checkbox"
                                                                        id="flexSwitchCheckChecked" <?= ($manp->status) ? 'checked' : ''; ?>>
                                                                </div></td>
                                                            <?php } ?>
                                                        
                                                        <td>
                                                            <?= $manp->created_at; ?>
                                                        </td>
                                                        <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'manpower_edit',
                                                                    'manpower_remove',
                                                                ])
                                                            ) { ?>
                                                        <td>
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'manpower_edit',
                                                                ])
                                                            ) { ?>

                                                                <a
                                                                    href="<?= base_url('admin/user-edit/') . lock($manp->id); ?>"><i
                                                                        class="fa fa-edit text-dark"></i></a>

                                                            <?php } ?>
                                                            <?php

                                                            if (
                                                                authChecker('admin', [
                                                                    'manpower_remove',
                                                                ])
                                                            ) { ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="changeStatus('<?= lock($manp->id); ?>','trash', event, this)"
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
            <?php endif; ?>
            <!-- Container-fluid Ends-->
        </div>
    </div>
</div>


<?= $this->endSection() ?>