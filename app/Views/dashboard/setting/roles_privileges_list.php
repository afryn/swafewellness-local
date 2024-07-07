<?= $this->extend('dashboard/main_tmplt') ?>

<?= $this->section('page-title');?>
Privileges Setup
<?= $this->endSection();?>


<?= $this->section('styles') ?>
<style>
  .tab-content {
    border: 1px solid #80808014 !important;
  }
  table.dataTable.stripe tbody tr.odd, table.dataTable.display tbody tr.odd {
    background-color: #f9f9f9;
}
tr.odd td {
    border-bottom: 1px solid #e7e7e7;
}
tr.even td {
    border-bottom: 1px solid #e3e3e3;
}
.dataTables_wrapper {
    padding: 0px 15px;
}

button.btn.btn-primary.rolesedtbtn i {
    color: #1e1e2d;
}

button.btn.btn-primary.rolesedtbtn {
    background-color: #ffffff;
    border: 1px solid #1e1e2d !important;
    color: #1e1e2d;
    font-size: 15px;
}
button.btn.btn-primary.rolesedtbtn:hover {
    background-color: #1e1e2d !important;
}
table.dataTable.no-footer {
    border-top: 1px solid #bbbbbb;
}

.not_editable_button{
  background: #f5d0cd !important;
  border: 1px solid #fd5656 !important;
  border-radius: 3px !important;
  color: black !important;
}

.not_editable_button i.fa.fa-edit {
  color: black!important;
}

.not_editable_button:hover{
  background: #f5d0cd !important;
  border: 1px solid #fd5656 !important;
  border-radius: 3px !important;
  color: black !important;
}

.not_editable_button i.fa.fa-edit:hover {
  color: black!important;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// $("#myTable").DataTable({
//   paging: false, // turn off pagination
//   searching: false, // turn off search box
//   ordering: false, // turn off column sorting
// });
</script>
<?= $this->endSection() ?>

<?= $this->section('page-content') ?>

<div class="d-flex flex-column flex-column-fluid">
  <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">

    <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">

      <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
        
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
          Roles Capabilities
        </h1>
        
      </div>
      
    </div>
    
  </div>

  
  <div class="app-content flex-column-fluid">
    <div class="app-container container-xxl">
      <div class="card card-flush">
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane fade show active">
              <table class="table table-hover table-bordered" id="myTable">
                <thead>
                  <tr role="row">
                    <th>Role</th>
                    <th>Total Users</th>
                    <th>Total Granted</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($roles as $role){ ?>
                    <tr>
                      <td><?= $role->title ?></td>
                      <td>-</td>
                      <td>-</td>
                      <td>
                        <?php if($role->editable == 'no'){ ?>
                          <button class="btn not_editable_button" type="button"><i class="fa fa-edit"></i>Not Edit Capabilities</button>
                        <?php }else{ ?>
                          <a href="<?= base_url(route_to('role.capabilities', lock($role->id))) ?>">
                          <button class="btn btn-primary rolesedtbtn" type="button"><i class="fa fa-edit"></i> Edit Capabilities &nbsp;&nbsp;&nbsp;</button>
                        </a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  


</div>

<?= $this->endSection() ?>