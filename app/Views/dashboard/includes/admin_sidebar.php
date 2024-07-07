<div class="app-menu navbar-menu">
  <!-- LOGO -->
  <div class="navbar-brand-box">
    <!-- Dark Logo-->
    <a href="<?= base_url('/admin'); ?>" class="logo logo-dark">
      <span class="logo-sm">
        <img src="<?= base_url(); ?>uploads/logo/logo.png" alt="" />
      </span>
      <span class="logo-lg">
        <img src="<?= base_url(); ?>uploads/logo/logo.png" alt="" />
      </span>
    </a>
    <!-- Light Logo-->
    <a href="<?= base_url('/admin'); ?>" class="logo logo-light">
      <span class="logo-sm">
        <img src="<?= base_url(); ?>uploads/logo/logo.png" alt="" />
      </span>
      <span class="logo-lg">
        <img src="<?= base_url(); ?>uploads/logo/logo.png" alt="" />
      </span>
    </a>
    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
      <i class="ri-record-circle-line"></i>
    </button>
  </div>

  <div id="scrollbar">
    <div class="container-fluid">
      <div id="two-column-menu"></div>
      <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/admin'); ?>">
            <i class="mdi mdi-speedometer"></i>
            <span data-key="t-dashboards">Dashboard</span>
          </a>
        </li>

        <?php
        // packages 
        _registerFunction(['function_name' => 'addNewPackages', 'alias' => 'Add Programmes', 'category' => 'Programmes']);
        _registerFunction(['function_name' => 'packge_list', 'alias' => 'Programmes List', 'category' => 'Programmes']);

        if (
          authChecker('admin', [
            'addNewPackages',
            'packge_list',
          ])
        ): ?>

          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">PROGRAMME MANAGEMENT</span>
          </li>

          <?php if (
            authChecker('admin', [
              'packge_list',
              'addNewPackages',
            ])
          ): ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('admin.packages-list')) ?>">
                <i class="mdi mdi-package"></i>
                <span data-key="t-apps">
                  Programme Management</span>
              </a>
            </li>
          <?php endif; ?>

        <?php endif; ?>

        <?php
        // testimonial 
        _registerFunction(['function_name' => 'add_testimonial', 'alias' => 'Add Testimonials', 'category' => 'Testimonials']);
        _registerFunction(['function_name' => 'testimonial_list', 'alias' => 'Testimonial List', 'category' => 'Testimonials']);

        // testimonial 
        _registerFunction(['function_name' => 'trainer_add', 'alias' => 'Add Trainer', 'category' => 'Trainers']);
        _registerFunction(['function_name' => 'trainer_list', 'alias' => 'Trainers List', 'category' => 'Trainers']);

        // manpower
        _registerFunction(['function_name' => 'manpower_list', 'alias' => 'Manpower List', 'category' => 'Manpower']);
        _registerFunction(['function_name' => 'new_manpower_create', 'alias' => 'New Manpower Create', 'category' => 'Manpower']);

        //  inquiries 
        _registerFunction(['function_name' => 'inquiries_list', 'alias' => 'Users Inquiries', 'category' => 'Inquiries']);
        _registerFunction(['function_name' => 'appointment_inquiry', 'alias' => 'Appointment Inquiries', 'category' => 'Inquiries']);
        _registerFunction(['function_name' => 'trashInquiry', 'alias' => 'Delete Inquiry', 'category' => 'Inquiries']);
        
          //  appointments 
        _registerFunction(['function_name' => 'appointments_list', 'alias' => 'Appointment List', 'category' => 'Appointments']);


        if (
          authChecker('admin', [
            'add_testimonial',
            'testimonial_list',

            'trainer_add',
            'trainer_list',

            'new_manpower_create',
            'manpower_list',
          ])
        ): ?>

          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">USER MANAGEMENT</span>
          </li>


          <?php
          if (
            authChecker('admin', [
              'new_manpower_create',
              'manpower_list',
            ])
          ): ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('manpower.list')) ?>">
                <i class="mdi mdi-account-circle-outline"></i>
                <span data-key="t-apps">
                  User</span>
              </a>
            </li>
          <?php endif; ?>
          
           <?php
          if (
            authChecker('admin', [
              'appointments_list',
            ])
          ): ?>
          
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('appointments.list')) ?>">
                <i class="mdi mdi-calendar-star"></i>
                <span data-key="t-apps">
                  All Appointments</span>
              </a>
            </li>
          
          <?php endif; ?>

          <?php
          if (
            authChecker('admin', [
              'trainer_add',
              'trainer_list',
            ])
          ): ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('admin.trainers-list')) ?>">
                <i class="mdi mdi-account-tie"></i>
                <span data-key="t-apps">
                  Trainer</span>
              </a>
            </li>
          <?php endif; ?>

          <?php
          if (
            authChecker('admin', [
              'add_testimonial',
              'testimonial_list',
            ])
          ): ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('testimonials.list')) ?>">
                <i class="mdi mdi-message-star-outline"></i>
                <span data-key="t-apps">
                  Testimonial</span>
              </a>
            </li>
          <?php endif; ?>

          <?php
          if (
            authChecker('admin', [
              'inquiries_list',
            ])
          ): ?>
          
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('app.inquiry')) ?>">
                <i class="mdi mdi-comment-question-outline"></i>
                <span data-key="t-apps">
                  Appointment Inquiry</span>
              </a>
            </li>

           
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('inquiries.list')) ?>">
                <i class="mdi mdi-comment-question-outline"></i>
                <span data-key="t-apps">
                  Inquiry</span>
              </a>
            </li>
          <?php endif; ?>

        <?php endif; ?>
        
        
         <?php //  appointments 
        _registerFunction(['function_name' => 'view_revenue', 'alias' => 'View Earnings', 'category' => 'Revenue']);
         _registerFunction(['function_name' => 'view_txn_history', 'alias' => 'View Transactions', 'category' => 'Revenue']);
        ?>

          <?php
          if (
            authChecker('admin', [
              'view_revenue',
              'view_txn_history'
            ])
          ): ?>
        
          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">Revenue</span>
          </li>
          
          
          <?php
          if (
            authChecker('admin', [
              'view_txn_history'
            ])
          ): ?>
           <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('total.revenue')) ?>">
                <i class="mdi mdi-history
"></i>
                <span data-key="t-apps">
                  Payment History</span>
              </a>
            </li>
            <?php endif; ?>
            
            
             <?php
          if (
            authChecker('admin', [
              'view_revenue'
            ])
          ): ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('total.earnings')) ?>">
                <i class="mdi mdi-bitcoin"></i>
                <span data-key="t-apps">
                  Total Earnings</span>
              </a>
            </li>
              <?php endif; ?>
            
            <?php endif; ?>
            
            
            
          
          

        <?php
        _registerFunction(['function_name' => 'center_add', 'alias' => 'Add Center', 'category' => 'Centers']);
        _registerFunction(['function_name' => 'center_list', 'alias' => 'Center List', 'category' => 'Centers']);

        if (
          authChecker('admin', [
            'center_add',
            'center_list',
          ])
        ): ?>

          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">CENTER MANAGEMENT</span>
          </li>


          <li class="nav-item">
            <a class="nav-link menu-link" href="<?= base_url(route_to('center.list')) ?>">
              <i class="mdi mdi-home-variant-outline"></i>
              <span data-key="t-apps">
                Center Management</span>
            </a>
          </li>

        <?php endif; ?>

        <?php
        _registerFunction(['function_name' => 'gallery_add', 'alias' => 'Add Gallery', 'category' => 'Gallery']);
        _registerFunction(['function_name' => 'gallery_list', 'alias' => 'Gallery List', 'category' => 'Gallery']);

        if (
          authChecker('admin', [
            'gallery_add',
            'gallery_list',
          ])
        ): ?>

          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">GALLERY</span>
          </li>

          <li class="nav-item">
            <a class="nav-link menu-link" href="<?= base_url(route_to('gallery.list')) ?>">
              <i class="mdi mdi-view-gallery-outline"></i>
              <span data-key="t-apps">
                Gallery Management</span>
            </a>
          </li>
        <?php endif; ?>

        <?php
        _registerFunction(['function_name' => 'web_content_manage', 'alias' => 'Add / Edit Content', 'category' => 'Website Content Management']);
        // _registerFunction(['function_name' => 'privacy_policy_edit', 'alias' => 'Edit Privacy Policy', 'category' => 'Website Content Management']);
        // _registerFunction(['function_name' => 't_n_c_edit', 'alias' => 'Edit Terms and Conditions', 'category' => 'Website Content Management']);

        if (
          authChecker('admin', [
            'web_content_manage',
            // 'privacy_policy_edit',
            // 't_n_c_edit',
          ])
        ): ?>

          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">Website Content</span>
          </li>
          <?php
          if (
            authChecker('admin', [
              'web_content_manage',
            ])
          ): ?>
            <li class="nav-item">
              <a class="nav-link menu-link" href="<?= base_url(route_to('footer.content')) ?>">
                <i class="mdi mdi-information-outline"></i>
                <span data-key="t-apps">
                  Website Info</span>
              </a>
            </li>
          <?php endif; ?>

        <?php endif; ?>


        <?php
        _registerFunction(['function_name' => 'security_permission_role_list', 'alias' => 'Role List', 'category' => 'Security Permission']);
        _registerFunction(['function_name' => 'roles_capabilities_list_and_edit', 'alias' => 'Roles Capabilities List & Edit', 'category' => 'Security Permission']);
        _registerFunction(['function_name' => 'security_permission_new_role_create', 'alias' => 'New Role Create', 'category' => 'Security Permission']);
        _registerFunction(['function_name' => 'security_permission_role_edit', 'alias' => 'Role Edit', 'category' => 'Security Permission']);
        _registerFunction(['function_name' => 'security_permission_role_remove', 'alias' => 'Role Remove', 'category' => 'Security Permission']);


        if (
          authChecker('admin', [
            'security_permission_new_role_create',
            'roles_capabilities_list_and_edit',
            'security_permission_role_remove',
            'security_permission_role_list',
            'security_permission_role_edit',
          ])
        ): ?>
          <li class="menu-title">
            <i class="ri-more-fill"></i>
            <span data-key="t-pages">SECURITY & ACCESS CONTROL</span>
          </li>
          <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button"
              aria-expanded="false" aria-controls="sidebarApps">
              <i class="mdi mdi-security"></i>
              <span data-key="t-apps">
                Roles & Privileges</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarApps">
              <ul class="nav nav-sm flex-column">
                <?php

                if (
                  authChecker('admin', [
                    'security_permission_new_role_create',
                    'security_permission_role_list',
                  ])
                ): ?>

                  <li class="nav-item menu-link">
                    <a href="<?= base_url(route_to('roles')) ?>" class="nav-link">
                      Role
                    </a>
                  </li>

                <?php endif; ?>

                <?php
                if (
                  authChecker('admin', [
                    'roles_capabilities_list_and_edit',
                    'security_permission_role_edit',
                    'security_permission_role_remove',
                  ])
                ): ?>
                  <li class="nav-item">
                    <a href="<?= base_url(route_to('roles.list')) ?>" class="nav-link">
                      Privilege Setup
                    </a>
                  </li>
                <?php endif; ?>

              </ul>
            </div>
          </li>
        <?php endif; ?>

      </ul>
    </div>
    <!-- Sidebar -->
  </div>

  <div class="sidebar-background"></div>
</div>

<script>

  function imageSlideBox() {
    $('a.popup_gallery_box').each(function () {
      var gallery = new SimpleLightbox(this, {});
    });
  }

  function loadingScreen_ON() {
    Swal.fire({
      title: "<span><h4>Please Wait...</h4> <div class='SWLoader'></div></span>",
      html: "Request under processing, please do not lock the screen or leave the page.",
      showCancelButton: false,
      showConfirmButton: false,
      allowOutsideClick: false,
      allowEscapeKey: false,
      onOpen: function () {
        Swal.showLoading()
      }
    });
  }

  function loadingScreen_OFF() {
    swal.close();
  }

            <?php if ((session()->get('flash_array') && isset(session()->get('flash_array')['success']))) { ?>
      $.toast({
        text: '<?= session()->get('flash_array')['success'] ?>',
        showHideTransition: 'fade',
        position: "<?= TOAST_SUCCESS_POSITION ?>",
        icon: 'success',
        hideAfter: 12000,
        showHideTransition: 'slide'
      })
    <?php } ?>
</script>