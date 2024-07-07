<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title'); ?>
Inquiry List
<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<style>
.action-btns {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-content: center;
    flex-wrap: wrap;
}
select#bulk-stts-chnge {
    width: 75%;
    padding: 0rem 2.7rem 0rem 0.9rem;
    height: 37px;
}

</style>
<?= $this->endSection(); ?>

<?= $this->section('scripts') ?>
<script>
    function changeStatus(id, action) {

        if (action == 'trash') {
            msg = 'Are You sure! You want to delete this inquiry?'
        }
        confirmDialog('', msg, function() {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(route_to('inquiries.trash')); ?>",
                data: {
                    id: id
                },

                success: function(data) {

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

<script>
    $('#changeStatus').on('click', function() {

        var inqIds = [];
        $('input[name="inqIds"]:checked').each(function() {
            inqIds.push($(this).val());
        });
        if (inqIds.length > 0) {
            if ($('#bulk-stts-chnge').val() == 'delete') {
                $('#confirmOk').text('Yes, delete')
                $('#confirmModalMsg').text('Are you sure you want to deleted selected Inquiries?')
            }

            confirmDialog('', "Are You sure! You want to remove?", function() {

                $.ajax({
                    url: "<?= base_url(route_to('change.inq.status')); ?>",
                    type: 'POST',
                    data: {
                        inqIds: inqIds,
                        action: $('#bulk-stts-chnge').val()
                    },
                    // dataType: 'JSON',
                    success: function(data) {

                        if (data.success) {
                            sweetAlret(data.msg, 'success');

                            setTimeout(() => {
                                window.location.reload();
                            }, 800);
                        } else {
                            sweetAlret(data.msg, 'error');
                        }
                    }
                })

            })

        } else {
            sweetAlret('No inquiry selected.', 'error');
        }

    })
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
                            <h3>Inquiry List</h3>
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

                                        <div class="action-btns">
                                            <select class="form-select" name="change-cat-stts" id="bulk-stts-chnge">
                                                <option value="delete">Delete</option>
                                            </select>

                                            <a href="javascript:void(0);" class="btn btn-primary squer-btn mr-2" id="changeStatus">Apply</a>
                                        </div>

                                        <table id="myTable">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>sno.</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <?php if($type != 'messages'):?>
                                                    <th>Programme</th>
                                                    <?php endif;?>
                                                    <th>Message</th>

                                                    <th>Action</th>
                                                    <th>Recieved at</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($inquiries as $inq) { ?>
                                                    <tr id="<?= lock($inq->id); ?>">
                                                        <td><input type="checkbox" class="selectInquiries" name="inqIds" value="<?= $inq->id; ?>"></td>
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td>
                                                            <?= $inq->user_name; ?>
                                                        </td>
                                                        <td>
                                                            <?= $inq->email; ?>
                                                        </td>
                                                        <td>
                                                            <?= $inq->phone; ?>
                                                        </td>
                                                        <?php if($type != 'messages'):?>
                                                        <td>
                                                        <span class="badge bg-light text-dark">  <?= _getWhere('sw_packages', ['id' => $inq->service ])->package_name; ?></span>
                                                        </td>
                                                            <?php endif;?>

                                                        <?php if(isset($messages)):?>
                                                        <td>
                                                            <?php if ($inq->service == 0) {
                                                                echo '-';
                                                            } else { ?>
                                                                <span class="badge bg-warning text-dark"><?= _getWhere('sw_packages', ['id' => $inq->service])->package_name; ?></span>
                                                            <?php } ?>

                                                        </td>
                                                        <?php endif;?>
                                                        <td>
                                                            <?= substr($inq->message, 0, 50); ?>...
                                                        </td>

                                                        <td class="d-flex">
                                                            <a href="javascript:void(0)" class="m-2"><i class="fa fa-eye text-warning" data-bs-toggle="modal" data-bs-target="#myModal<?= $inq->id; ?>"></i></a>

                                                            <?php
                                                            if (
                                                                authChecker('admin', [
                                                                    'trashInquiry',
                                                                ])
                                                            ) { ?>
                                                                <a href="javascript:void(0)" onclick="changeStatus('<?= lock($inq->id); ?>','trash')" class="m-2"><i class="fa fa-trash text-danger"></i></a>
                                                            <?php } ?>

                                                        </td>
                                                        <td>
                                                            <?= $inq->date_time; ?>
                                                        </td>

                                                    </tr>


                                                    <!-- Default Modals -->
                                                    <div id="myModal<?= $inq->id; ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myModalLabel">From :
                                                                        <span style="font-weight: normal !important;"><?= $inq->user_name; ?></span>
                                                                    </h5>&nbsp;
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <p><b>Email : </b><?= $inq->email; ?> </p>
                                                                    <p><b>Mobile Number : </b><?= $inq->phone; ?> </p>
                                                                    <p><b>Message : </b><?= $inq->message; ?> </p>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                    <!-- <button type="button" class="btn btn-primary ">Save
                                                                        Changes</button> -->
                                                                </div>

                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

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