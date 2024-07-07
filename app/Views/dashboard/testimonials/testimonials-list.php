<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
Testimonial List
<?= $this->endSection();?>

<?= $this->section('styles') ?>
<style>
 

.star {
  float: right;
  font-size: 10px;
  color: yellow;
  cursor: pointer;
}

.star:before {
  content: '\2605'; /* Unicode character for a star */
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action) {

        if (action == 'chngeStts') {
            msg = 'Are you sure you want to change status?'
        }
        else if (action == 'trash') {
            msg = 'Are You sure! You want to delete this testimonial?'
        }
        confirmDialog('', msg, function () {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(route_to('testimonials.status')) ?>",
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
                            <h3>Testimonial List</h3>
                        </div>
                       
                             <?php
                if(authChecker('admin', [
                 'add_testimonial',
                ])): ?>
 <div class="col-12 col-sm-6 d-flex justify-content-end mb-2">
                  <a class="btn btn-primary" href="<?= base_url(route_to('add.testimonial')) ?>" class="nav-link">
                   Add Testimonial
                  </a>
 </div>
                <?php endif; ?>
                       
                    </div>
                </div>
            </div>

            <?php
                if(authChecker('admin', [
                 'testimonial_list',
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
                                                    <th>Name</th>
                                                    <th>Profession</th>
                                                    <th>Rating</th>
                                                    <?php
                                                        _registerFunction(['function_name' => 'testimonial_status_toggle', 'alias' => 'Testimonial Status Toggle', 'category' => 'Testimonials']);

                                                        if (
                                                            authChecker('admin', [
                                                                'testimonial_status_toggle',
                                                            ])
                                                        ) { ?>
                                                    <th>Status</th>
                                                    <?php } ?>
                                                    <th>Added on</th>
                                                    <?php _registerFunction(['function_name' => 'testimonial_edit', 'alias' => 'Testimonial Edit', 'category' => 'Testimonials']);
                                                            _registerFunction(['function_name' => 'testimonial_remove', 'alias' => 'Testimonial Remove', 'category' => 'Testimonials']);

                                                            if (
                                                                authChecker('admin', [
                                                                    'testimonial_edit',
                                                                    'testimonial_remove',
                                                                ])
                                                            ) { ?>
                                                    <th>Actions</th>
                                                    <?php } ?>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($testimonials as $test) { ?>
                                                    <tr id="<?= lock($test->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td>
                                                            <img width="30px"
                                                                src="<?= base_url('uploads/testimonials/') . (($test->image != '') ? $test->image : "no-image.jpg") ?>"
                                                                alt="">
                                                            <?= $test->name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test->profession; ?>
                                                        </td>

                                                        <td>
                                                           <div class="rating">
                                                   
                                                    <span class="badge bg-success"><i class="star"></i><?=$test->rating;?></span>

                                                </div>
                                                </td>
                                                        
                                                            <?php
                                                          _registerFunction(['function_name' => 'testimonial_status_toggle', 'alias' => 'Testimonial Status Toggle', 'category' => 'Testimonials']);

                                                            if (
                                                                authChecker('admin', [
                                                                    'testimonial_status_toggle',
                                                                ])
                                                            ) { ?><td>
                                                                <div class="form-check form-switch">
                                                                    <input
                                                                        onchange="changeStatus('<?= lock($test->id); ?>','chngeStts')"
                                                                        class="form-check-input" type="checkbox"
                                                                        id="flexSwitchCheckChecked" <?= ($test->status) ? 'checked' : ''; ?>>
                                                                </div> </td>
                                                            <?php } ?>
                                                       
                                                          <td>
                                                            <?= $test->date_time; ?>
                                                        </td>
                                                        <?php 
                                                            if (
                                                                authChecker('admin', [
                                                                    'testimonial_edit',
                                                                    'testimonial_remove',
                                                                ])
                                                            ) { ?>
                                                        <td>
                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'testimonial_edit',
                                                                ])
                                                            ) { ?>

                                                                <a
                                                                    href="<?= base_url('admin/testimonial-edit/') . lock($test->id); ?>"><i
                                                                        class="fa fa-edit"></i></a>

                                                            <?php } ?>
                                                            <?php 

                                                            if (
                                                                authChecker('admin', [
                                                                    'testimonial_remove',
                                                                ])
                                                            ) { ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="changeStatus('<?= lock($test->id); ?>','trash')"
                                                                    class="m-2"><i class="fa fa-trash"></i></a>
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