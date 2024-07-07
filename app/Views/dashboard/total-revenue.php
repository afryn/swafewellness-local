<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
Payment History
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

<?= $this->endSection() ?>

<?= $this->section('page-content') ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3>Payment History</h3>
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
                                                    <th>Payer Email</th>
                                                    <th>Transaction Id</th>
                                                    <th>Amount</th>
                                                    <th>Payment Status</th>
                                                    <th>Date & Time</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $i = 1;
                                                foreach ($totalPayments as $test) { ?>
                                                    <tr id="<?= lock($test->id); ?>">
                                                        <td>
                                                            <?= $i; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test->user_email; ?>
                                                        </td>
                                                        <td>
                                                            <?= $test->txn_id; ?>
                                                        </td>

                                                        <td>
                                                      &#8377;<?= number_format($test->amount);?>
                                                </td>
                                                        <td>
                                                            <?php
                                                            if($test->payment_status == 'Completed'){ $color = 'success';}else if($test->payment_status == 'Pending'){
                                                               $color = 'warning'; 
                                                            }else if ($test->payment_status == 'Failed'){ $color = 'danger';}?>
                                                            
                                                            
                                                            <span class="badge border border-<?= $color;?> text-<?= $color;?>"><?= $test->payment_status;?></span>
                                                                 </td>
                                                           
                                                          <td>
                                                            <?= $test->date_time; ?>
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