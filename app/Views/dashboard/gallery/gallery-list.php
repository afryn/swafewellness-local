<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Gallery List
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action) {

        if (action == 'chngeStts') {
            msg = 'Are you sure you want to change status?'
        }
        else if (action == 'trash') {
            msg = 'Are You sure! You want to delete this image?'
        }
        confirmDialog('', msg, function () {
            $.ajax({
                type: 'POST',
                url: $("#baseUrl").val() + 'admin/changeGalleryStatus',
                data: { id: id, action : action },

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
                            <h3>Gallery List</h3>
                        </div>
                        <?php
                        _registerFunction(['function_name' => 'gallery_add', 'alias' => 'Add Gallery', 'category' => 'Gallery']);
                        if (
                            authChecker('admin', [
                                'gallery_add',
                            ])
                        ): ?>
                            <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">
                                <a class="btn btn-primary" href="<?= base_url(route_to('add.gallery')) ?>" class="nav-link">
                                    Add Gallery
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
        _registerFunction(['function_name' => 'gallery_list', 'alias' => 'Gallery List', 'category' => 'Gallery']);
        if (
                            authChecker('admin', [
                                'gallery_list',
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
                                                    <th>Image</th>
                                                    <th>Tags</th>
                                                    <?php 
                                                    _registerFunction(['function_name' => 'gallery_status_toggle', 'alias' => 'Gallery Status Toggle', 'category' => 'Gallery']);
                                                    if (
                                                        authChecker('admin', [
                                                            'gallery_status_toggle',
                                                        ])
                                                    ) { ?>
                                                    <th>Status</th>
                                                    <?php } ?>
                                                    <th>Created At</th>
                                                    <?php 
                                                    _registerFunction(['function_name' => 'gallery_remove', 'alias' => 'Gallery Remove', 'category' => 'Gallery']);

                                                           if (
                                                                authChecker('admin', [
                                                                    'gallery_remove',
                                                                ])
                                                            ) { ?>
                                                    <th>Actions</th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                $i = 1;
                                                foreach ($galleries as $gallery) { ?>
                                                    <tr id="<?= lock($gallery->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td><img width="40px"
                                                                src="<?=  (($gallery->image != '') ? base_url('uploads/gallery/').$gallery->image : base_url('uploads/'). "no-image.jpg") ?>"
                                                                alt=""></td>
                                                        <td>
                                                            <?php $tagsArr = explode(',',$gallery->tags );
                                                            $colorArr = ['danger', 'success', 'warning', 'info'];?>
                                                            <?php foreach ($tagsArr as $tag) {?>
                                                              <span class="badge rounded-pill bg-<?= $colorArr[array_rand($colorArr)];?> text-dark"><?= $tag;?></span>
                                                           <?php  } ?>
                                                        </td>
                                                            <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'gallery_status_toggle',
                                                                ])
                                                            ) { ?>
                                                             <td>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        onchange="changeStatus('<?= lock($gallery->id); ?>','chngeStts')"
                                                                        class="form-check-input" type="checkbox"
                                                                        id="flexSwitchCheckChecked" <?= ($gallery->status) ? 'checked' : ''; ?>>
                                                                </div>
                                                                </td>
                                                            <?php } ?>
                                                        
                                                        <td>
                                                            <?= $gallery->date_time; ?>
                                                        </td>
                                                        <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'gallery_remove',
                                                                ])
                                                            ) { ?>
                                                        <td>
                                                                <a href="javascript:void(0)"
                                                                    onclick="changeStatus('<?= lock($gallery->id); ?>','trash')"
                                                                    class="m-2"><i class="fa fa-trash text-danger"></i></a>
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