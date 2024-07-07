<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
  <meta charset="utf-8" />
  <title>Dashboard | <?= $this->renderSection('page-title');?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta content="Swafe Wellness" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?=base_url();?>uploads/logo/favicon.png" />
  <!-- nouisliderribute css -->
  <link rel="stylesheet" href="<?=base_url();?>assets/libs/nouislider/nouislider.min.css" />
  <link href="<?=base_url();?>assets/libs/dropzone/dropzone.css" rel="stylesheet" type="text/css" />
  <!-- jsvectormap css -->
  <link href="<?=base_url();?>assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="<?=base_url();?>assets/libs/gridjs/theme/mermaid.min.css" />

  <!--Swiper slider css-->
  <link href="<?=base_url();?>assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

  <!-- Layout config Js -->
  <script src="<?=base_url();?>assets/js/layout.js"></script>
  <!-- Bootstrap Css -->
  <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- Icons Css -->
  <link href="<?=base_url();?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
  <!-- App Css-->
  <link href="<?=base_url();?>assets/css/app.min.css" rel="stylesheet" type="text/css" />

  <link rel="stylesheet" href="<?=base_url();?>assets/css/custom_css/style.css">

 <!-- select 2  -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

 <!-- image uploader  -->
 <link rel="stylesheet" href="<?= base_url();?>imageuploader/src/image-uploader.css">
  
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- sweetalert2  -->
  <!-- <script src="<?=base_url();?>assets/libs/sweetalert2/sweetalert2.min.css"></script> -->

  <!-- custom Css-->
  <link href="<?=base_url();?>assets/css/custom.min.css" rel="stylesheet" type="text/css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<?php helper('dev_helper');?>
<?= $this->renderSection('styles');?>

<body>
  <style>
    span.logo-lg img {
      width: 46%;
    }
  </style>
  <input type="hidden" id="baseUrl" value="<?= base_url();?>">
  <!-- Begin page -->
  <div id="layout-wrapper">
    <header id="page-topbar">
      <div class="layout-width">
        <div class="navbar-header">
          <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box horizontal-logo">
              <a href="<?=base_url();?>" class="logo logo-dark">
                <span class="logo-sm">
                  <img src="<?=base_url();?>uploads/logo/logo.png" alt="" />
                </span>
                <span class="logo-lg">
                  <img src="<?=base_url();?>uploads/logo/logo.png" alt="" />
                </span>
              </a>

              <a href="<?=base_url();?>" class="logo logo-light">
                <span class="logo-sm">
                  <img src="<?=base_url();?>uploads/logo/logo.png" alt="" />
                </span>
                <span class="logo-lg">
                  <img src="<?=base_url();?>uploads/logo/logo.png" alt="" />
                </span>
              </a>
            </div>

            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
              <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
              </span>
            </button>

            <!-- App Search-->
            <!-- <form class="app-search d-none d-md-block">
              <div class="position-relative">
                <input type="text" class="form-control" autocomplete="off" id="search-options" value="" />
                <span class="mdi mdi-magnify search-widget-icon"></span>
                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
              </div>
              <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                <div data-simplebar="" style="max-height: 320px">
                  
                  <div class="dropdown-header">
                    <h6 class="text-overflow text-muted mb-0 text-uppercase">
                      Recent Searches
                    </h6>
                  </div>

                  <div class="dropdown-item bg-transparent text-wrap">
                    <a href="index.php" class="btn btn-soft-secondary btn-sm rounded-pill">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                    <a href="index.php" class="btn btn-soft-secondary btn-sm rounded-pill">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                  </div>
                  
                  <div class="dropdown-header mt-2">
                    <h6 class="text-overflow text-muted mb-1 text-uppercase">
                      Pages
                    </h6>
                  </div>

                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                    <span>Analytics Dashboard</span>
                  </a>

                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                    <span>Help Center</span>
                  </a>

               
                  <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                    <span>My account settings</span>
                  </a>

               
                  <div class="dropdown-header mt-2">
                    <h6 class="text-overflow text-muted mb-2 text-uppercase">
                      Members
                    </h6>
                  </div>

                  <div class="notification-list">
                 
                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                      <div class="d-flex">
                        <img src="<?=base_url();?>assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                        <div class="flex-grow-1">
                          <h6 class="m-0">Angela Bernier</h6>
                          <span class="fs-11 mb-0 text-muted">Manager</span>
                        </div>
                      </div>
                    </a>
                 
                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                      <div class="d-flex">
                        <img src="<?=base_url();?>assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                        <div class="flex-grow-1">
                          <h6 class="m-0">David Grasso</h6>
                          <span class="fs-11 mb-0 text-muted">Web Designer</span>
                        </div>
                      </div>
                    </a>
                 
                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                      <div class="d-flex">
                        <img src="<?=base_url();?>assets/images/users/avatar-5.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                        <div class="flex-grow-1">
                          <h6 class="m-0">Mike Bunch</h6>
                          <span class="fs-11 mb-0 text-muted">React Developer</span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>

                <div class="text-center pt-3 pb-1">
                  <a href="javascript:void(0)" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                </div>
              </div>
            </form> -->
          </div>

          <div class="d-flex align-items-center">
            <div class="dropdown d-md-none topbar-head-dropdown header-item">
              <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-search fs-22"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                <form class="p-3">
                  <div class="form-group m-0">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username" />
                      <button class="btn btn-primary" type="submit">
                        <i class="mdi mdi-magnify"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <div class="ms-1 header-item d-none d-sm-flex">
              <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                <i class="bx bx-fullscreen fs-22"></i>
              </button>
            </div>

            <div class="ms-1 header-item d-none d-sm-flex">
              <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                <i class="bx bx-moon fs-22"></i>
              </button>
            </div>

            <!-- <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
              <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-bell fs-22"></i>
                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
              </button>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                  <div class="p-3">
                    <div class="row align-items-center">
                      <div class="col">
                        <h6 class="m-0 fs-16 fw-semibold text-white">
                          Notifications
                        </h6>
                      </div>
                      <div class="col-auto dropdown-tabs">
                        <span class="badge bg-light-subtle text-body fs-13">
                          0 New</span>
                      </div>
                    </div>
                  </div>

                  <div class="px-2 pt-2">
                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                      <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                          All (0)
                        </a>
                      </li>
                   
                    </ul>
                  </div>
                </div>

                <div class="tab-content position-relative" id="notificationItemsTabContent">
                  <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                    <div data-simplebar="" style="max-height: 300px" class="pe-2">
                      <div class="text-reset notification-item d-block dropdown-item position-relative">
                        <div class="d-flex align-items-center">
                          <div class="avatar-xs me-3 flex-shrink-0">
                            <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                              <i class="bx bx-badge-check"></i>
                            </span>
                          </div>
                          <div class="flex-grow-1">
                            <a href="#!" class="stretched-link">
                              <h6 class="mt-0 lh-base">
                                No New Notification
                              </h6>
                            </a>
                          </div>
                          <div class="px-2 fs-15">
                            <div class="form-check notification-check">
                              <input class="form-check-input" type="checkbox" value="" id="all-notification-check01" />
                              <label class="form-check-label" for="all-notification-check01"></label>
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="my-3 text-center view-all">
                        <button type="button" class="btn btn-soft-success waves-effect waves-light">
                          View All Notifications
                          <i class="ri-arrow-right-line align-middle"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                
                  <div class="notification-actions" id="notification-actions">
                    <div class="d-flex text-muted justify-content-center">
                      Select
                      <div id="select-content" class="text-body fw-semibold px-1">
                        0
                      </div>
                      Result
                      <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">
                        Remove
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->

            <div class="dropdown ms-sm-3 header-item topbar-user">
              <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="d-flex align-items-center">
                  <img class="rounded-circle header-profile-user" src="<?= base_url();?>assets\images\users\user-dummy-img.jpg" alt="Header Avatar" />
                  <span class="text-start ms-xl-2">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= session()->get('first_name'). ' ' . session()->get('last_name');?></span>
                    <?php $role = _getWhere('sw_roles_type' , ['id' => dynamiclock(session()->get('user_type_id'), 'decrypt')]);?>
                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?= $role->title;?></span>
                  </span>
                </span>
              </button>
             
              <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <h6 class="dropdown-header">Welcome <?= session()->get('first_name'). ' ' . session()->get('last_name');?></h6>
                <!-- <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                  <span class="align-middle">Profile</span></a>
                <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                  <span class="align-middle">Change Password</span></a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= base_url('logout');?>"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                  <span class="align-middle" data-key="t-logout">Logout</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- removeNotificationModal -->
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
          </div>
          <div class="modal-body">
            <div class="mt-2 text-center">
              <lord-icon src="assets\js\gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width: 100px; height: 100px"></lord-icon>
              <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                <h4>Are you sure ?</h4>
                <p class="text-muted mx-4 mb-0">
                  Are you sure you want to remove this Notification ?
                </p>
              </div>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
              <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                Close
              </button>
              <button type="button" class="btn w-sm btn-danger" id="delete-notification">
                Yes, Delete It!
              </button>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- ========== App Menu ========== -->
    <?= $this->include('dashboard/includes/admin_sidebar.php');?>
  
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>



    
    <?= $this->renderSection('page-content');?>


    <footer class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <script>
          document.write(new Date().getFullYear());
        </script>
        © Swafe Wellness.
      </div>
      <div class="col-sm-6">
        <div class="text-sm-end d-none d-sm-block">
          Design & Develop by Maisha Infotech
        </div>
      </div>
    </div>
  </div>
</footer>
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
  <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
  <div id="status">
    <div class="spinner-border text-primary avatar-sm" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</div>


<div class="modal" id="confirmModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle"></h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
        <p id="confirmMessage">Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="confirmCancel" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmOk" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>


<!-- JAVASCRIPT -->
<script src="<?=base_url();?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url();?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?=base_url();?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?=base_url();?>assets/libs/feather-icons/feather.min.js"></script> 

<!-- ckeditor -->
<script src="<?=base_url();?>assets/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
 
<!-- dropzone js -->
<script src="<?=base_url();?>assets/libs/dropzone/dropzone-min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
<script src="<?=base_url();?>assets/js/app.js"></script>
<script src="<?=base_url();?>assets/js/custom_js/main.js"></script>
<!-- <script src="<?=base_url();?>assets/libs/sweetalert2/sweetalert2.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>-->
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    flatpickr(".fltpicker_timeInp", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i", // 24-hour format without AM/PM
    });
</script>

 <!-- datatables  -->
<script src="<?=base_url( 'assets/datatable/js/jquery.dataTables.min.js' )?>"></script>

<script>
    $('#myTable').DataTable()
      $('#myTable2').DataTable()

  </script>
<script>
  
  $(".select2_inp").select2({
    placeholder: "Select Programme",
  
  })
  $(".select3_inp").select2({
    placeholder: "Select Tags",
    tags: true
  })
  $(".select2_inp_search").select2({
  "text": "label attribute",
   tags: true,
  
});


</script>
<?= $this->renderSection('scripts');?>
</body>

</html>