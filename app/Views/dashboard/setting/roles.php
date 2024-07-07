<?= $this->extend('dashboard/main_tmplt') ?>
<?= $this->section('page-title');?>
Capabilities
<?= $this->endSection();?>
<?= $this->section( 'styles' ) ?>

<style>
.dataTables_info{
    display:none;
}
    .rolestablist {
        margin-top: 10px;
    }
    .rolestablist li.role-tab {
        cursor: pointer;
        border: 1px solid;
        padding: 10px 15px;
        border-bottom: 1px solid #00000040;
    }

    .rolestablist li.role-tab {
        cursor: pointer;
        padding: 10px 15px;
        border: 1px solid #236aa530;
        border-bottom: 1px solid #236aa514;
    }

    li.role-tab.active {
        background: #80808014;
        border: 1px solid #80808014;
    }
    li.role-tab.active a {
        color: #0878bbd1;
        font-weight: 600;
        font-size: 14px;
    }
    li.role-tab a {
        color: #338cc1;
        text-transform: capitalize;
    }

    .cmntbdcls {
        display: none;
    }
    .cmntbdcls.active {
        display: table-row-group;
    }

    .dataTables_wrapper table.dataTable td {
        padding: 3px 15px;
    }

    div#basic-1_length {
        display: none;
    }

    div#basic-1_filter {
        display: none;
    }

    .savechangebtn {
        padding-top: 25px;
    }

    input[type="radio"] {
        cursor: pointer;
    }

    .buttondiv {
        float: right;
        position: relative;
        bottom: 10px;
    }
    .rolestablist ul li {
        list-style: none;
    }
    tr {
        border-bottom: 1px solid gray !important;
        background-color: #cbdbe9;
    }

    .not_editable{
        background: #f5d0cd !important;
        border: 1px solid #fd5656 !important;
        padding: 4px !important;
        border-radius: 3px !important;
        color: black !important;
    }
</style>

<?=$this->endSection()?>

<?=$this->section( 'scripts' )?>

<script src="<?=base_url( 'assets/datatable/js/jquery.dataTables.min.js' )?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="<?=base_url( 'assets/datatable/js/datatable.custom.js' )?>"></script> -->
<script>
    $(document).ready(function () {
        $(document).on("click", ".role-tab", function () {
            var dataval = $(this).attr("tab-filter");

            $(".role-tab").removeClass("active");
            $(this).addClass("active");

            $(".cmntbdcls").removeClass("active");
            $(dataval).addClass("active");
        });

        $(".advTable").DataTable({
            paging: false, // turn off pagination
            searching: false, // turn off search box
            ordering: false, // turn off column sorting
        });
    });

    
    $(document).on('submit', '#roleCapabilitiesForm', function(ev) {
    
        ev.preventDefault();
        var frm = $('#roleCapabilitiesForm');
        var form = $('#roleCapabilitiesForm')[0];
        var data = new FormData(form);
    
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            data: data,
            beforeSend: function() {
    
                $('span[class*="ERROR__"]').html("");
                $("body").css("pointer-events", "none");
    
            },
            success: function(data) {
                
                if (data.success == true) {
                    sweetAlret(data.msg, 'success')
                }

                if (data.success == false) {
                    sweetAlret(data.msg, 'error')

                    if (data.success == false) {
                        $.each(data.errors, function (field, message) {
                            $(".ERROR__" + field).html('<div class="text-danger">' + message + "</div>");
                        });
                    }

                    /*= = [ IF ERROR EXISTS THEN SCROLL ON THIS ERROR :: START ] = =*/
                    $(document).ready(function() {
                        try {
                            $("span[class*='ERROR__']").filter(function() {
                                return $(this).html().trim().length > 0;
                            }).eq(0).each(function() {
                                $(this).scrollToCenter();
                            });
                        } catch (e) {
                            console.log('An error occurred: ' + e.message);
                        }
                    });
                    /*= = [ IF ERROR EXISTS THEN SCROLL ON THIS ERROR :: END ] = =*/

                }
    
            },
            error: function(err) {
    
                //
    
            },
            complete: function(data) {
    
                $("body").css("pointer-events", "auto");
    
            }
    
        });
    
    });

</script>

<?=$this->endSection()?>

<?=$this->section( 'page-content' )?>

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Edit Roles</h3>
                </div>
                <!-- <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php"> <i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Edit Roles</li>
                    </ol>
                </div> -->
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
                            <div class="col-md-3">
                                <div class="rolesaddbtndiv">
                                    <h4>
                                        <i class="fa fa-user"></i>
                                        <?php
                                            if(!empty($role_get_row)){
                                                echo $role_get_row['title'];
                                            }
                                          ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <!-- <div class="buttondiv">
                                    <a href="javascript:void(0);">
                                      <button class="btn btn-primary" type="button"><i class="fa fa-plus"></i> Add Custom Capability</button>
                                    </a>
                                </div> -->
                            </div>
                        </div>

                        <?php                            
                            $permission_funtion_array= array();
                            if($permisson_get_row){
                                $permission_funtion_array = explode(',', $permisson_get_row['function_id']);

                            }
                            if(!empty($front_function_cat_alias))
                            {
                        ?>
                        <form method="post" enctype="multipart/form-data" accept="<?= base_url(route_to('role.capabilities',$encrpyt_roldeid)) ?>" id="roleCapabilitiesForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="rolestablist">
                                        <ul>
                                            <?php 
                                                    $i=0;
                                                    foreach ($front_function_cat_alias as $key =>
                                            $value) { if($i==0){ $active_class = 'active'; } else{ $active_class = ''; } ?>
                                            <li class="role-tab <?php echo $active_class; ?>" tab-filter=".edittab-<?php echo $value['function_id']; ?>">
                                                <a href="javascript:void(0);">
                                                    <i class="fa fa-cog"></i>
                                                    <?php echo $value['category']; ?>
                                                </a>
                                            </li>
                                            <?php
                                                     $i++;   
                                                    }
                                                ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="table-responsive">
                                        <table class="table table-lg advTable">
                                            <thead>
                                                <tr>
                                                    <th>Capability</th>
                                                    <th>Grant</th>
                                                    <th>Deny</th>
                                                </tr>
                                            </thead>

                                            <?php 
                                                    $j=0;
                                                    foreach ($front_function_cat_alias as $key2 =>
                                            $value2) { if($j==0){ $active_class2 = 'active'; } else{ $active_class2 = ''; } ?>
                                            <tbody class="cmntbdcls edittab-<?php echo $value2['function_id']; ?> <?php echo $active_class2 ?>">
                                                <?php 
                                                                if(!empty($value2['category_data'])) {
                                                                    $tj=0;
                                                                    foreach ($value2['category_data'] as $key4 =>
                                                $category_val) { ?>

                                                <tr>
                                                    <td><?php echo $category_val['alias'] ?></td>
                                                    <td>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<input
                                                        <?php if(in_array($category_val['function_id'], $permission_funtion_array)){ echo "checked"; } else { echo "";}  ?>
                                                        type="radio" value="<?php echo $category_val['function_id']; ?>" name="permission_alias[<?php echo $category_val['function_id']; ?>]" >&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </td>
                                                    <td>
                                                        <input
                                                        <?php if(!in_array($category_val['function_id'], $permission_funtion_array)){ echo "checked"; } else { echo "";}  ?>
                                                        type="radio" value="" name="permission_alias[<?php echo $category_val['function_id']; ?>]">
                                                    </td>
                                                </tr>
                                                <?php   
                                                                    $tj++;
                                                                    } 
                                                                }
                                                            ?>
                                            </tbody>
                                            <?php 
                                                       $j++; 
                                                    }
                                                 ?>
                                            <?php
                                                    $value_cat_list=array();    
                                                    foreach ($front_function_cat_alias as $key20 =>
                                            $value_cat_all) { $value_cat_list1 =$value_cat_all['category_data']; foreach($value_cat_all['category_data'] as $v) { $value_cat_list[]=$v; } } ?>
                                            <?php
                                                    if(!empty($value_cat_list)){
                                                   ?>
                                            <tbody class="cmntbdcls edittab-all">
                                                <?php
                                                                foreach ($value_cat_list as $key30 =>
                                                $all_catlist) { ?>
                                                <tr>
                                                    <td><?php echo $all_catlist['alias'] ?></td>
                                                    <td>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<input
                                                        <?php if(in_array($all_catlist['function_id'], $permission_funtion_array)){ echo "checked"; } else { echo "";}  ?>
                                                        type="radio" value="<?php echo $all_catlist['function_id']; ?>" name="permission_alias_all[<?php echo $all_catlist['function_id']; ?>]" >&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </td>

                                                    <td>
                                                        <input
                                                        <?php if(!in_array($all_catlist['function_id'], $permission_funtion_array)){ echo "checked"; } else { echo "";}  ?>
                                                        type="radio" value="" name="permission_alias_all[<?php echo $all_catlist['function_id']; ?>]" />
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <?php } ?>

                                            <thead>
                                                <tr>
                                                    <th>Capability</th>
                                                    <th>Grant</th>
                                                    <th>Deny</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="savechangebtn">
                                        <button class="btn btn-primary" type="submit" data-bs-original-title="" title="" data-original-title="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
  </div>
</div>
<?=$this->endSection()?>
