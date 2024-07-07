<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


$routes->match(['get', 'post'], 'user-login', 'Login::userLogin', ['as' => 'user.login']); //users login
$routes->match(['get', 'post'], 'register', 'Login::userRegister', ['as' => 'user.register']); //users register
$routes->match(['get'], 'logout', 'Login::userlogout', ['as' => 'user.logout']);


$routes->match(['get'], 'login', 'Login::index', ['as' => 'login.page']);

$routes->match(['get'], 'fetch-states', 'Home::fetchStates', ['as' => 'fetch.states']);
$routes->match(['get'], 'fetch-cities', 'Home::fetchCities', ['as' => 'fetch.cities']);
$routes->match(['get', 'post'], 'moana-island-dubai', 'Home::resort_details', ['as' => 'resort.details']); //users register

$routes->get('/', 'Home::index');
$routes->match(['get'], 'about', 'Home::aboutUs', ['as' => 'about.us']);
$routes->match(['get'], 'programmes', 'Home::services', ['as' => 'all.services']);
$routes->match(['get'], 'gallery', 'Home::gallery', ['as' => 'gallery']);
$routes->match(['get'], 'contact-us', 'Home::contact', ['as' => 'contact.us']);
$routes->match(['get'], 'programme/(:any)', 'Home::programmeDetail/$1', ['as' => 'programme.detail']);
$routes->match(['get'], 'checkout', 'Home::checkout', ['as' => 'checkout']);
$routes->match(['post'], 'storeToBucket', 'Home::storeToBucket', ['as' => 'storeToBucket']);
$routes->match(['get'], 'check-basket', 'Home::checkBasketStatus', ['as' => 'check.basket']);



// APIs 
$routes->match(['post'], 'api/user-login', 'ApiController::login');
$routes->match(['get'], 'login-token/(:any)', 'ApiController::loginToken/$1');
$routes->match(['post'], 'api/user-register', 'ApiController::signup');
$routes->match(['post'], 'api/account-verification', 'ApiController::verification');
$routes->match(['post'], 'api/otp-email', 'ApiController::forgotPasswordEmail');
$routes->match(['post'], 'api/change-password', 'ApiController::changePassword');
$routes->match(['post'], 'api/resend-verification-mail', 'ApiController::accountVerEmail');


// packages and appointment
$routes->match(['post', 'get'], 'check-avaliability', 'Home::checkAvailability', ['as' => 'check.availability']);
$routes->match(['get'], 'check-availability', 'Home::availableData', ['as' => 'available.data']); 

$routes->match(['post'], 'check-trainer', 'Home::checkTrainerAvailibility', ['as' => 'check.trainer']);

$routes->match(['post'], 'make-payment', 'StripePayment::create', ['as' => 'stripe.pay']);
$routes->match(['get'], 'payment-success', 'StripePayment::success', ['as' => 'StripePayment.success']);

$routes->match(['get'], 'payment-failed', 'StripePayment::cancel', ['as' => 'StripePayment.failed']);

// terms and conditions and privacy policy 
$routes->match(['get'], 'privacy-policy', 'Home::privacyPolicy', ['as' => 'privacy.policy']);
$routes->match(['get'], 'terms-and-conditions', 'Home::termsNConditions', ['as' => 'terms.conditions']);



$routes->post('/login-account', 'Login::login');
$routes->post('/add-query', 'Home::addQuery', ['as' => 'add.query']);


// ADMIN 
$routes->group('', ['filter' => 'isLoggedIn'], function ($routes) {

    /* =====[ Admin Dashboard ]===== */
    $routes->match(['get'], 'admin', 'Admin::index', ['as' => 'dashboard.index']);

    $routes->group('admin', function ($routes) {
        
        // chart 
        $routes->match(['post', 'get'], 'fetchChartData', 'Admin::fetchChartData', ['as' => 'fetchChartData']);
        
           $routes->match(['post', 'get'], 'total-revenue', 'Admin::totalRevenue', ['as' => 'total.revenue']);
           
            $routes->match(['post', 'get'], 'total-earnings', 'Admin::totalEarnings', ['as' => 'total.earnings']);
            
         
        
        // packges 
        $routes->match(['get', 'post'], 'add-programme', 'Admin::addPackages', ['as' => 'admin.addpackages']);
        $routes->match(['get'], 'programmes-list', 'Admin::packagesList', ['as' => 'admin.packages-list']);
        $routes->match(['post'], 'changePkgStatus', 'Admin::changePkgStatus', ['as' => 'admin.changePkgStatus']);
        $routes->match(['get', 'post'], 'programme-edit/(:any)', 'Admin::packageEdit/$1', ['as' => 'admin.packageEdit']);
        $routes->match(['get', 'post'], 'package-trash', 'Admin::trashPackage', ['as' => 'admin.trashPackage']);

        // roles and privileges 
        $routes->match(['get', 'post'], 'edit/(:any)', 'RolesController::edit/$1', ['as' => 'roles.edit']);
        $routes->match(['post'], 'remove/(:any)', 'RolesController::remove/$1', ['as' => 'roles.remove']);
        $routes->match(['get', 'post'], 'role/(:any)', 'RolesController::roleCapabilities/$1', ['as' => 'role.capabilities']);
        $routes->match(['post'], 'status-ajax', 'RolesController::StatusAjax', ['as' => 'roles.status.ajax']);
        $routes->match(['post'], 'list', 'RolesController::rolesList', ['as' => 'roles.ajax']);
        $routes->match(['get', 'post'], 'list', 'RolesController::list', ['as' => 'roles.list']);
        $routes->match(['get', 'post'], 'setting', 'RolesController::setting', ['as' => 'setting.list']);

        // trainers
        $routes->match(['get', 'post'], 'add-trainer', 'Admin::addTrainer', ['as' => 'admin.trainer-add']);
        $routes->match(['get'], 'trainers-list', 'Admin::trainerList', ['as' => 'admin.trainers-list']);
        $routes->match(['get', 'post'], 'trainers-status', 'Admin::changeTrainerStatus', ['as' => 'admin.trainers-status']);
        $routes->match(['get', 'post'], 'trainer-edit/(:any)', 'Admin::editTrainer/$1', ['as' => 'admin.trainer-edit']);

        // testimonials 
        $routes->match(['get', 'post'], 'add-testimonial', 'User::addTestimonial', ['as' => 'add.testimonial']);
        $routes->match(['get'], 'testimonials', 'User::testimonialList', ['as' => 'testimonials.list']);
        $routes->match(['get'], 'testimonial-edit/(:any)', 'User::testimonialEdit/$1', ['as' => 'testimonials.edit']);
        $routes->match(['get', 'post'], 'testimonial-status', 'User::testimonialStatus', ['as' => 'testimonials.status']);

        // services 
        $routes->match(['get', 'post'], 'add-service', 'Service::addService', ['as' => 'add.service']);
        $routes->match(['get'], 'service-list', 'Service::serviceList', ['as' => 'service.list']);
        $routes->match(['get'], 'service-edit/(:any)', 'Service::serviceEdit/$1', ['as' => 'service.edit']);
        $routes->match(['get', 'post'], 'service-status', 'Service::serviceStatusToggle', ['as' => 'service.status']);

        // centers 
        $routes->match(['get', 'post'], 'add-center', 'Centers::addCenter', ['as' => 'add.center']);
        $routes->match(['get'], 'center-list', 'Centers::centersList', ['as' => 'center.list']);
        $routes->match(['get'], 'center-edit/(:any)', 'Centers::centerEdit/$1', ['as' => 'center.edit']);
        $routes->match(['get', 'post'], 'center-status', 'Centers::centerStatusToggle', ['as' => 'center.status']);

        // manpowers 
        $routes->match(['get', 'post'], 'add-user', 'User::create', ['as' => 'add.manpower']);
        $routes->match(['get'], 'users-list', 'User::manpowerList', ['as' => 'manpower.list']);
        $routes->match(['get'], 'user-edit/(:any)', 'User::manpEdit/$1', ['as' => 'manpower.edit']);
        $routes->match(['get', 'post'], 'user-status', 'User::manpStatusToggle', ['as' => 'manp.status']);

        // manpowers 
        $routes->match(['get', 'post'], 'add-gallery', 'Home::addGallery', ['as' => 'add.gallery']);
        $routes->match(['get'], 'gallery-list', 'Home::galleryList', ['as' => 'gallery.list']);
        $routes->match(['get'], 'gallery-edit/(:any)', 'Home::galleryEdit/$1', ['as' => 'gallery.edit']);
        $routes->match(['get', 'post'], 'changeGalleryStatus', 'Home::changeGalleryStatus', ['as' => 'gallery.status']);

        // website content 
        $routes->match(['get', 'post'], 'info-update2', 'Home::websiteInfoUpdate', ['as' => 'update.info']);
        $routes->match(['get', 'post'], 'info-update', 'Home::websiteInfoUpdate', ['as' => 'footer.content']);
        
        // appointments 
         $routes->match(['get', 'post'], 'appointments', 'Appointments::list', ['as' => 'appointments.list']);
         $routes->match(['get', 'post'], 'appointment-details/(:any)', 'Appointments::details/$1',['as' => 'appointments.details']);
         
         $routes->match(['get'], 'appointment-inquiries', 'Admin::appInquiries', ['as' => 'app.inquiry']);

        
    });

    $routes->group('users', function ($routes) {
        // inquiries 
        $routes->match(['get', 'post'], 'inquiries-list', 'Home::inquiriesList', ['as' => 'inquiries.list']);
        
          $routes->match(['post', 'get'], 'messages', 'Admin::messages', ['as' => 'messages.list']);
        
        $routes->match(['get', 'post'], 'inquiry-trash', 'Home::trashInquiry', ['as' => 'inquiries.trash']);
        $routes->match(['get', 'post'], 'inquiry-status', 'Home::changeInqStatus', ['as' => 'change.inq.status']);
        
        $routes->match(['get', 'post'], 'approve-appointment', 'Home::approveAppointment', ['as' => 'approve.appointment']);
        
    });


    $routes->group('security', function ($routes) {
        $routes->match(['get', 'post'], 'roles', 'RolesController::roles', ['as' => 'roles']);

        $routes->match(['get', 'post'], 'edit/(:any)', 'RolesController::edit/$1', ['as' => 'roles.edit']);
        $routes->match(['post'], 'remove/(:any)', 'RolesController::remove/$1', ['as' => 'roles.remove']);
        $routes->match(['get', 'post'], 'role/(:any)', 'RolesController::roleCapabilities/$1', ['as' => 'role.capabilities']);
        $routes->match(['post'], 'status-ajax', 'RolesController::StatusAjax', ['as' => 'roles.status.ajax']);
        $routes->match(['post'], 'list', 'RolesController::rolesList', ['as' => 'roles.ajax']);
        $routes->match(['post'], 'remove-role', 'RolesController::removeRole', ['as' => 'roles.remove.ajax']);
        $routes->match(['get', 'post'], 'list', 'RolesController::list', ['as' => 'roles.list']);
        // $routes->match(['get', 'post'], 'setting', 'RolesController::setting', ['as' => 'setting.list']);
    });

    $routes->group('user', function ($routes) {
        $routes->match(['post'], 'remove-doc-ajax', 'User::RemoveDocAjax', ['as' => 'userdoc.remove.ajax']);
    });


});

$routes->get('login', 'Login::index');
$routes->get('logout', 'Login::logout');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}