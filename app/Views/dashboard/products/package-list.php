<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Programme List
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action, e, elem) {
        e.preventDefault();
        if (action == 'chngeStts') {
            url = 'admin/changePkgStatus';
            msg = 'Are you sure you want to change status?'
        }
        else if (action == 'trash') {
            url = 'admin/package-trash';
            msg = 'Are You sure! You want to delete this programme?'
        }
        confirmDialog('', msg, function () {
            $.ajax({
                type: 'POST',
                url: $("#baseUrl").val() + url,
                data: { id: id },

                success: function (data) {

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
                            <h3>Programme List</h3>
                        </div>
                        <?php
                        _registerFunction(['function_name' => 'addNewPackages', 'alias' => 'Add Programmes', 'category' => 'Programmes']);
                        if (
                            authChecker('admin', [
                                'addNewPackages',
                            ])
                        ): ?>
                            <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">
                                <a class="btn btn-primary" href="<?= base_url(route_to('admin.addpackages')) ?>" class="nav-link">
                                    Add Programme
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        _registerFunction(['function_name' => 'packge_list', 'alias' => 'Programmes List', 'category' => 'Programmes']);
        if (
                            authChecker('admin', [
                                'packge_list',
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
                                                    <th>Programme</th>
                                                    <th>Duration</th>
                                                    <?php 
                                                    _registerFunction(['function_name' => 'package_status_toggle', 'alias' => 'Programmes Status Toggle', 'category' => 'Programmes']);
                                                    if (
                                                        authChecker('admin', [
                                                            'package_status_toggle',
                                                        ])
                                                    ) { ?>
                                                    <th>Status</th>
                                                    <?php } ?>
                                                    <th>Created At</th>
                                                    <?php _registerFunction(['function_name' => 'packge_edit', 'alias' => 'Programmes Edit', 'category' => 'Programmes']);
                                                           _registerFunction(['function_name' => 'packge_remove', 'alias' => 'Programmes Remove', 'category' => 'Programmes']);

                                                           if (
                                                                authChecker('admin', [
                                                                    'packge_edit',
                                                                    'packge_remove',
                                                                ])
                                                            ) { ?>
                                                    <th>Actions</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($packages as $pckg) { ?>
                                                    <tr id="<?= lock($pckg->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td><img width="40px"
                                                                src="<?= base_url('uploads/packages/') . (($pckg->image != '') ? $pckg->image : "no-image.jpg") ?>"
                                                                alt=""><?= $pckg->package_name; ?></td>
                                                        <td>
                                                            <?= explode(':', $pckg->package_duration)[0] . ' to  ' . explode(':', $pckg->package_duration)[1] . ' Nights '; ?>
                                                        </td>

                                                       
                                                            <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'package_status_toggle',
                                                                ])
                                                            ) { ?>
                                                             <td>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        onclick="changeStatus('<?= lock($pckg->id); ?>','chngeStts', event, this)"
                                                                        class="form-check-input" type="checkbox"
                                                                        id="flexSwitchCheckChecked" <?= ($pckg->status) ? 'checked' : ''; ?>>
                                                                </div>
                                                                </td>
                                                            <?php } ?>
                                                        
                                                        <td>
                                                            <?= $pckg->date_time; ?>
                                                        </td>
                                                        <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'packge_edit',
                                                                    'packge_remove',
                                                                ])
                                                            ) { ?>
                                                        <td>
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'packge_edit',
                                                                ])
                                                            ) { ?>
                                                                <a
                                                                    href="<?= base_url('admin/programme-edit/') . lock($pckg->id); ?>"><i
                                                                        class="fa fa-edit text-dark"></i></a>

                                                            <?php } ?>
                                                            <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'packge_remove',
                                                                ])
                                                            ) { ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="changeStatus('<?= lock($pckg->id); ?>','trash', event, this)"
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