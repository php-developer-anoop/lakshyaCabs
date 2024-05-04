<?php

use CodeIgniter\Router\RouteCollection;
$routes->get('/', 'Home::index');
$routes->get(ADMINPATH . "login", "Authentication::index", ["namespace" => "App\Controllers\Admin"]);
$routes->post(ADMINPATH . "checkLogin", "Authentication::checkLogin", ["namespace" => "App\Controllers\Admin"]);
$routes->get(ADMINPATH . "logout", "Authentication::logout", ["namespace" => "App\Controllers\Admin"]);
$routes->get(ADMINPATH . "dashboard", "Dashboard::index", ["filter" => "auth", "namespace" => "App\Controllers\Admin"]);
$routes->match(["get", "post"], ADMINPATH . "authenticate", "Authentication::authenticate", ["namespace" => "App\Controllers\Admin"]);
$routes->get(ADMINPATH . "printDutySlip", "Generate_pdf::printDutySlip", ["namespace" => "App\Controllers\Api\V1"]);
$routes->get(ADMINPATH . "printPaymentSlip", "Generate_pdf::printPaymentSlip", ["namespace" => "App\Controllers\Api\V1"]);
$routes->get(ADMINPATH . "printInvoiceSlip", "Generate_pdf::printInvoiceSlip", ["namespace" => "App\Controllers\Api\V1"]);

$routes->group("admin", ["filter" => 'auth', "namespace" => "App\Controllers\Admin"], function ($routes) {
    $routes->match(["get", "post"], "deleteRecords", "Ajax::index");
    $routes->match(["get", "post"], "getSlug", "Ajax::getSlug");
    $routes->match(["get", "post"], "changeStatus", "Ajax::changeStatus");
    $routes->match(["get", "post"], "changeProfileStatus", "Ajax::changeProfileStatus");
    $routes->match(["get", "post"], "changePopular", "Ajax::changePopular");
    $routes->match(["get", "post"], "changeMenu", "Ajax::changeMenu");
    $routes->match(["get", "post"], "changeHome", "Ajax::changeHome");
    $routes->match(["get", "post"], "changeSpecial", "Ajax::changeSpecial");
    $routes->match(["get", "post"], "assign-menus", "Ajax::assign_menus");
    $routes->match(["get", "post"], "getCount", "Ajax::getCount");
    $routes->match(["get", "post"], "checkDuplicate", "Ajax::checkDuplicate");
    $routes->match(["get", "post"], "getCitiesFromAjax", "Ajax::getCitiesFromAjax");
    $routes->match(["get", "post"], "getModelsFromAjax", "Ajax::getModelsFromAjax");
    $routes->match(["get", "post"], "getPacksFromAjax", "Ajax::getPacksFromAjax");
    $routes->match(["get", "post"], "getAirpoartFromAjax", "Ajax::getAirpoartFromAjax");
    $routes->match(["get", "post"], "fetchHoursKm", "Ajax::fetchHoursKm");
    $routes->match(["get", "post"], "getCity", "Ajax::getCity");
    $routes->match(["get", "post"], "getCityList", "Ajax::getCityList");
    $routes->match(["get", "post"], "exportFile", "Ajax::exportFile");
    $routes->match(["get", "post"], "importFile", "Ajax::importFile");
    $routes->match(["get", "post"], "assignmenu", "Ajax::assignmenu");
    $routes->match(["get", "post"], "deleteAllPage", "Ajax::deleteAllPage");
    $routes->match(["get", "post"], "finalClose", "Ajax::finalClose");
    // Web Setting
    $routes->match(["get", "post"], "save-setting", "Setting::save_setting");
    $routes->match(["get", "post"], "web-setting", "Setting::index");
    $routes->match(["get", "post"], "home-setting", "Setting::home_setting");
    $routes->match(["get", "post"], "save-home-setting", "Setting::save_home_setting");
    // Menu Master
    $routes->match(["get", "post"], "save-menu", "Menu::save_menu");
    $routes->match(["get", "post"], "menu-list", "Menu::index");
    $routes->match(["get", "post"], "menu-add", "Menu::add_menu");
    $routes->match(["get", "post"], "menu-data", "Menu::getRecords");
    $routes->match(["get", "post"], "assign-menu", "Menu::assign_menu");
    // User Master
    $routes->match(["get", "post"], "save-user", "User::save_user");
    $routes->match(["get", "post"], "user-list", "User::index");
    $routes->match(["get", "post"], "add-user", "User::add_user");
    $routes->match(["get", "post"], "user-data", "User::getRecords");
    $routes->match(["get", "post"], "change-password", "User::change_password");
    $routes->match(["get", "post"], "update-password", "User::update_password");
    //State Master
    $routes->match(["get", "post"], "save-state", "State::save_state");
    $routes->match(["get", "post"], "state-list", "State::index");
    $routes->match(["get", "post"], "add-state", "State::add_state");
    $routes->match(["get", "post"], "state-data", "State::getRecords");
    //Ratings
    $routes->match(["get", "post"], "ratings", "Ratings::index");
    $routes->match(["get", "post"], "ratings-data", "Ratings::getRecords");
    //City Master
    $routes->match(["get", "post"], "save-city", "City::save_city");
    $routes->match(["get", "post"], "city-list", "City::index");
    $routes->match(["get", "post"], "add-city", "City::add_city");
    $routes->match(["get", "post"], "city-data", "City::getRecords");
    //City Master
    $routes->match(["get", "post"], "save-ticket", "Ticket::save_ticket");
    $routes->match(["get", "post"], "subject-list", "Ticket::index");
    $routes->match(["get", "post"], "add-subject", "Ticket::add_ticket");
    $routes->match(["get", "post"], "ticket-data", "Ticket::getRecords");
    //Common CMS Master
    $routes->match(["get", "post"], "add-cms", "Cms::add_cms");
    $routes->match(["get", "post"], "save-cms", "Cms::save_cms");
    $routes->match(["get", "post"], "cms-list", "Cms::index"); 
    $routes->match(["get", "post"], "cms-data", "Cms::getRecords");
    
    //Popular Route Master
    $routes->match(["get", "post"], "save-route", "Popular_route::save_route");
    $routes->match(["get", "post"], "routes-list", "Popular_route::index");
    $routes->match(["get", "post"], "add-route", "Popular_route::add_route");
    $routes->match(["get", "post"], "route-data", "Popular_route::getRecords");
    
    //CMS Tab Master
    $routes->match(["get", "post"], "save-cms-tab", "CmsTabMaster::save_tab");
    $routes->match(["get", "post"], "cms-tab-list", "CmsTabMaster::index");
    $routes->match(["get", "post"], "add-cms-tabs", "CmsTabMaster::add_tab");
    $routes->match(["get", "post"], "cms-tab-data", "CmsTabMaster::getRecords");
    
    //Route CMS Master
    $routes->match(["get", "post"], "add_common_cms", "CmsMaster::addCommonCms");
    //$routes->match(["get", "post"], "save_common_cms", "Cms_master::index");
    //$routes->match(["get", "post"], "add-cms", "Cms_master::add_cms");
    //$routes->match(["get", "post"], "cms-data", "Cms_master::getRecords");
    
    //Destination Master
    $routes->match(["get", "post"], "save-destination", "Destination::save_destination");
    $routes->match(["get", "post"], "destination-list", "Destination::index");
    $routes->match(["get", "post"], "add-destination", "Destination::add_destination");
    $routes->match(["get", "post"], "destination-data", "Destination::getRecords");
    //Package Category Master
    $routes->match(["get", "post"], "save-package-category", "Package_category::save_package_category");
    $routes->match(["get", "post"], "package-category-list", "Package_category::index");
    $routes->match(["get", "post"], "add-package-category", "Package_category::add_package_category");
    $routes->match(["get", "post"], "package-category-data", "Package_category::getRecords");
    //Package Master
    $routes->match(["get", "post"], "save-package", "Package::save_package");
    $routes->match(["get", "post"], "package-list", "Package::index");
    $routes->match(["get", "post"], "add-package", "Package::add_package");
    $routes->match(["get", "post"], "package-data", "Package::getRecords");
    //Vehicle Category Master
    $routes->match(["get", "post"], "save-vehicle-category", "Vehicle_category::save_vehicle_category");
    $routes->match(["get", "post"], "vehicle-category-list", "Vehicle_category::index");
    $routes->match(["get", "post"], "add-vehicle-category", "Vehicle_category::add_vehicle_category");
    $routes->match(["get", "post"], "vehicle-category-data", "Vehicle_category::getRecords");
    //Vehicle Model  Master
    $routes->match(["get", "post"], "save-vehicle-model", "Vehicle_model::save_vehicle_model");
    $routes->match(["get", "post"], "vehicle-model-list", "Vehicle_model::index");
    $routes->match(["get", "post"], "add-vehicle-model", "Vehicle_model::add_vehicle_model");
    $routes->match(["get", "post"], "vehicle-model-data", "Vehicle_model::getRecords");
    //Fare Master
    $routes->match(["get", "post"], "save-fare", "Fare::save_fare");
    $routes->match(["get", "post"], "save-fare-local", "Fare::save_fare_local");
    $routes->match(["get", "post"], "save-fare-airpoart", "Fare::save_fare_transfer");
    
    $routes->match(["get", "post"], "fare-list", "Fare::index");
    $routes->match(["get", "post"], "add-fare", "Fare::add_fare");
 
    $routes->match(["get", "post"], "add-oneway-fare", "Fare::add_oneway_fare");
    $routes->match(["get", "post"], "update-oneway-fare", "Fare::add_oneway_fare");
    
    $routes->match(["get", "post"], "add-outstation-fare", "Fare::add_outstation_fare");
    $routes->match(["get", "post"], "update-outstation-fare", "Fare::add_outstation_fare");
    $routes->match(["get", "post"], "add-local-fare", "Fare::add_local_fare");
    $routes->match(["get", "post"], "update-local-fare", "Fare::add_local_fare");
    $routes->match(["get", "post"], "add-airport-fare", "Fare::add_airport_fare");
    $routes->match(["get", "post"], "update-airport-fare", "Fare::add_airport_fare");

    $routes->match(["get", "post"], "fare-data", "Fare::getRecords");
    $routes->match(["get", "post"], "import-export-fare", "Fare::import_export_fare");
    //Hourly Package Master
    $routes->match(["get", "post"], "save-hourly-package", "Hourly_package::save_hourly_package");
    $routes->match(["get", "post"], "hourly-package-list", "Hourly_package::index");
    $routes->match(["get", "post"], "add-hourly-package", "Hourly_package::add_hourly_package");
    $routes->match(["get", "post"], "hourly-package-data", "Hourly_package::getRecords");
    //Vendor Master
    $routes->match(["get", "post"], "save-vendor", "Vendor::save_vendor");
    $routes->match(["get", "post"], "vendor-master-list", "Vendor::index");
    $routes->match(["get", "post"], "edit-vendor", "Vendor::add_vendor");
    $routes->match(["get", "post"], "vendor-data", "Vendor::getRecords");
    //Customer Master
    $routes->match(["get", "post"], "save-customer", "Customer::save_customer");
    $routes->match(["get", "post"], "customer-master-list", "Customer::index");
    $routes->match(["get", "post"], "edit-customer", "Customer::add_customer");
    $routes->match(["get", "post"], "customer-data", "Customer::getRecords");
    //Airpoart Package Master
    $routes->match(["get", "post"], "save-airport", "Airport::save_airport");
    $routes->match(["get", "post"], "airport-list", "Airport::index");
    $routes->match(["get", "post"], "add-airport", "Airport::add_airport");
    $routes->match(["get", "post"], "airport-data", "Airport::getRecords");
    //Our Offices
    $routes->match(["get", "post"], "save-office", "Our_offices::save_office");
    $routes->match(["get", "post"], "office-list", "Our_offices::index");
    $routes->match(["get", "post"], "office-data", "Our_offices::getRecords");
    //Queries
    $routes->match(["get", "post"], "recharge-history", "Recharge_history::index");
    $routes->match(["get", "post"], "recharge-data", "Recharge_history::getRecords");
    //Queries
    $routes->match(["get", "post"], "contact-queries", "Queries::index");
    $routes->match(["get", "post"], "queries-data", "Queries::getRecords");
    //Pack Queries
    $routes->match(["get", "post"], "package-queries", "Queries::package_queries");
    $routes->match(["get", "post"], "package-queries-data", "Queries::getPackQueryRecords");
     
    
    //Driver Queries
    $routes->match(["get", "post"], "driver-queries", "Queries::driver_queries");
    $routes->match(["get", "post"], "driver-queries-data", "Queries::getDriverQueryRecords");
    //Latest Queries
    $routes->match(["get", "post"], "latest-query", "Queries::latest_query");
    $routes->match(["get", "post"], "latest-query-data", "Queries::getLatestQueryRecords");
    $routes->match(["get", "post"], "query-detail", "Queries::query_detail");
    //Why Choose Us
    $routes->match(["get", "post"], "save-choose", "Why_master::save_choose");
    $routes->match(["get", "post"], "why-choose-us", "Why_master::index");
    $routes->match(["get", "post"], "add-choose", "Why_master::add_choose");
    $routes->match(["get", "post"], "choose-data", "Why_master::getRecords");
    //Why Choose Us
    $routes->match(["get", "post"], "save-drive", "Why_master::save_drive");
    $routes->match(["get", "post"], "why-choose-drive", "Why_master::why_choose_drive");
    $routes->match(["get", "post"], "add-drive", "Why_master::add_drive");
    $routes->match(["get", "post"], "drive-data", "Why_master::getDriveRecords");
    //Testimonial Master
    $routes->match(["get", "post"], "save-testimonial", "Testimonial::save_testimonial");
    $routes->match(["get", "post"], "testimonial-list", "Testimonial::index");
    $routes->match(["get", "post"], "add-testimonial", "Testimonial::add_testimonial");
    $routes->match(["get", "post"], "testimonial-data", "Testimonial::getRecords");
    //Taxi Package Master
    $routes->match(["get", "post"], "save-taxi-package", "Taxi_packages::save_taxi_package");
    $routes->match(["get", "post"], "taxi-packages-list", "Taxi_packages::index");
    $routes->match(["get", "post"], "add-taxi-package", "Taxi_packages::add_taxi_package");
    $routes->match(["get", "post"], "taxi-package-data", "Taxi_packages::getRecords");
    
    //Recharge Plan Master
    $routes->match(["get", "post"], "save-plan", "Recharge_plan::save_plan");
    $routes->match(["get", "post"], "plan-list", "Recharge_plan::index");
    $routes->match(["get", "post"], "add-plan", "Recharge_plan::add_plan");
    $routes->match(["get", "post"], "plan-data", "Recharge_plan::getRecords");
    //Role User Master
    $routes->match(["get", "post"], "save-role-user", "Role_user::save_role_user");
    $routes->match(["get", "post"], "role-user-list", "Role_user::index");
    $routes->match(["get", "post"], "add-role-user", "Role_user::add_role_user");
    $routes->match(["get", "post"], "role-user-data", "Role_user::getRecords");
    //Booking List 
    $routes->match(["get", "post"], "booking-list", "Bookings::index");
    $routes->match(["get", "post"], "booking-data", "Bookings::getRecords");
    $routes->match(["get", "post"], "get_search_city_list", "Bookings::getCityRecords");
    $routes->match(["get", "post"], "approve_reject_cancel_booking", "Bookings::approveRejectCancelBooking");
    $routes->match(["get", "post"], "booking_details", "Bookings::details");
    $routes->match(["get", "post"], "vendor-drop-down-list", "Bookings::vendorDropDownList");
    $routes->match(["get", "post"], "broadcast-booking", "Bookings::broadCastBooking");
    $routes->match(["get", "post"], "driver-drop-down-list", "Bookings::driverDropDownList");
    $routes->match(["get", "post"], "assign-driver", "Bookings::assignDriver");
    
    //Driver 
    $routes->match(["get", "post"], "add-driver",  "Driver::index");
    $routes->match(["get", "post"], "save-driver", "Driver::saveDriver");
    $routes->match(["get", "post"], "driver-list", "Driver::driverList");
    $routes->match(["get", "post"], "driver-data", "Driver::getRecords");
    $routes->match(["get", "post"], "delete-driver-account", "Driver::deleteAccount");
    
    //Manual Booking
    $routes->match(["get", "post"], "manual-booking", "Manual_bookings::index");
    
    //Booking Conditions And Conditions
    $routes->match(["get", "post"], "booking-conditions", "Booking_conditions::index");
    $routes->match(["get", "post"], "save-booking-conditions", "Booking_conditions::saveBookingData");
    $routes->match(["get", "post"], "calender-booking-conditions", "Booking_conditions::calender");
    $routes->match(["get", "post"], "save-calender-booking-conditions", "Booking_conditions::saveCalenderBookingData");
    $routes->match(["get", "post"], "booking-conditions-list", "Booking_conditions::listData");
    $routes->match(["get", "post"], "get-record-booking-conditions", "Booking_conditions::getRecords");
    
    //Coupon Master
    $routes->match(["get", "post"], "save-coupon", "Coupon::save_coupon");
    $routes->match(["get", "post"], "coupon-list", "Coupon::index");
    $routes->match(["get", "post"], "add-coupon", "Coupon::add_coupon");
    $routes->match(["get", "post"], "coupon-data", "Coupon::getRecords");
    
    // Configure City Page
    $routes->match(["get", "post"], "configure-city-page", "Configurecitypage::index");
    $routes->match(["get", "post"], "configure-city-data", "Configurecitypage::getRecords");
    $routes->match(["get", "post"], "createPage", "Configurecitypage::createPage");
    $routes->match(["get", "post"], "edit-city-seo-page", "Configurecitypage::edit_city_seo_page");
    $routes->match(["get", "post"], "save-city-seo-page", "Configurecitypage::save_city_seo_page");
    $routes->match(["get", "post"], "edit-tab-city-seo-page", "Configurecitypage::edit_tab_city_seo_page");
    $routes->match(["get", "post"], "save-tab-city-seo-page", "Configurecitypage::save_tab_city_seo_page");
    //Raised Ticket List
    $routes->match(["get", "post"], "raised-ticket-list", "Raised_ticket::index");
    $routes->match(["get", "post"], "view-raised-ticket", "Raised_ticket::view_raised_ticket");
    $routes->match(["get", "post"], "save-raised-ticket", "Raised_ticket::save_raised_ticket");
    $routes->match(["get", "post"], "raised-ticket-data", "Raised_ticket::getRecords");
    //Vehicle Page Master
    $routes->match(["get", "post"], "save-vehicle-page", "Vehicle_page::save_vehicle_page");
    $routes->match(["get", "post"], "vehicle-page-list", "Vehicle_page::index");
    $routes->match(["get", "post"], "add-vehicle-page", "Vehicle_page::add_vehicle_page");
    $routes->match(["get", "post"], "vehicle-page-data", "Vehicle_page::getRecords");
});

// User Panel Filters
$routes->group("user", ["filter" => 'user', "namespace" => "App\Controllers\User"], function ($routes) {
    $routes->match(["get", "post"], "my-bookings", "BookingList::itemsList");
    $routes->match(["get", "post"], "rateUs", "BookingList::rateUs");
    $routes->match(["get", "post"], "my-profile", "Home::my_profile");
    $routes->match(["get", "post"], "logout", "Home::logout");
    $routes->match(["get", "post"], "save-profile", "Profile::index");
    $routes->match(["get", "post"], "my-wallet", "Home::my_wallet");
    $routes->match(["get", "post"], "getToken", "Home::getToken");
    $routes->match(["get", "post"], "cashfree_success", "Home::cashfree_success");
    $routes->match(["get", "post"], "my-wallet-data", "Home::my_wallet_records");
});
$routes->get(USERPATH . "printInvoiceSlip", "Generate_pdf::printInvoiceSlip", ["namespace" => "App\Controllers\Api\V1"]);
$routes->get(USERPATH . "downloadReceipt", "Generate_pdf::index", ["namespace" => "App\Controllers\Api\V1"]);
/*Customer API Section*/
$routes->group("api/v1/customer", ["namespace" => "App\Controllers\Api\V1\Customer"], function ($routes) {
    $routes->match(["get", "post"], 'generate_orderid', 'Generate_orderid::index');
    $routes->match(["get", "post"], 'add_amount', 'Add_amount::index');
    $routes->match(["get", "post"], 'search_cab', 'BookingSystem::search');
    $routes->match(["get", "post"], 'create_booking', 'BookingSystem::createBooking');
    $routes->match(["get", "post"], 'coupon_list', 'CouponList::index');
    $routes->match(["get", "post"], 'apply_coupon', 'CouponList::applyCoupon');
    $routes->match(["get", "post"], 'booking_list', 'BookingList::index');
    $routes->match(["get", "post"], 'booking_details', 'BookingList::details');
    $routes->match(["get", "post"], 'confirm_booking', 'BookingSystem::confirmBooking');
    $routes->match(["get", "post"], 'getBookingDetails', 'BookingList::getBookingDetails');
});

// Vendor Routes

//Vendor Authentication
$routes->get(VENDORPATH . "login", "Authentication::index", ["namespace" => "App\Controllers\Vendor"]);
$routes->get(VENDORPATH . "logout", "Authentication::logout", ["namespace" => "App\Controllers\Vendor"]);
$routes->get(VENDORPATH . "forgot-password", "Authentication::forgot_password", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "forgotPassword", "Authentication::forgotPassword", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "checkLogin", "Authentication::checkLogin", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "resendOtp", "Authentication::resendOtp", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "validateOtp", "Authentication::validateOtp", ["namespace" => "App\Controllers\Vendor"]);
// Vendor Registration
$routes->get(VENDORPATH . "register", "Vendor_registration::index", ["namespace" => "App\Controllers\Vendor"]);
$routes->get(VENDORPATH . "register_as_vendor", "Vendor_registration::vendorAsRegistration", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "saveBasicDetails", "Vendor_registration::saveBasicDetails", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "saveBusinessDetails", "Vendor_registration::saveBusinessDetails", ["namespace" => "App\Controllers\Vendor"]);
$routes->post(VENDORPATH . "save-image", "Vendor_registration::save_image", ["namespace" => "App\Controllers\Vendor"]);
$routes->get(VENDORPATH . "downloadReceipt", "Generate_pdf::index", ["namespace" => "App\Controllers\Api\V1"]);
$routes->get(VENDORPATH . "printDutySlip", "Generate_pdf::printDutySlip", ["namespace" => "App\Controllers\Api\V1"]);
$routes->get(VENDORPATH . "printPaymentSlip", "Generate_pdf::printPaymentSlip", ["namespace" => "App\Controllers\Api\V1"]);
$routes->get(VENDORPATH . "printInvoiceSlip", "Generate_pdf::printInvoiceSlip", ["namespace" => "App\Controllers\Api\V1"]);
$routes->group("vendor", ["filter" => 'vendor', "namespace" => "App\Controllers\Vendor"], function ($routes) {
    $routes->match(["get", "post"], "dashboard", "Dashboard::index");
    $routes->match(["get", "post"], "getCount", "Dashboard::getCount");
    $routes->match(["get", "post"], "ratings", "Dashboard::ratings"); 
    $routes->match(["get", "post"], "getDayWiseBookings", "Dashboard::getDayWiseBookings");
    
    $routes->match(["get", "post"], "booking-paid", "Dashboard::booking_paid");
    //Wallet
    $routes->match(["get", "post"], "my-wallet", "Wallet::index");
    $routes->match(["get", "post"], "getToken", "Wallet::getToken");
    $routes->match(["get", "post"], "my-wallet-data", "Wallet::my_wallet_data");
    //Bookings
    $routes->match(["get", "post"], "booking-list", "Bookings::index");
    $routes->match(["get", "post"], "booking-data", "Bookings::getRecords");
    $routes->match(["get", "post"], "acceptBooking", "Bookings::acceptBooking");
    //Driver
    $routes->match(["get", "post"], "assign-driver", "Driver::index");
    $routes->match(["get", "post"], "assignDriver", "Driver::assignDriver");
    //Tickets 
    $routes->match(["get", "post"], "tickets", "Ticket::index");
    $routes->match(["get", "post"], "add-ticket", "Ticket::add_ticket");
    $routes->match(["get", "post"], "view-ticket", "Ticket::add_ticket");
    $routes->match(["get", "post"], "save-ticket", "Ticket::save_ticket");
    $routes->match(["get", "post"], "ticket-data", "Ticket::getRecords");
    
    $routes->match(["get", "post"], "cashfree_success", "Wallet::cashfree_success");
    $routes->match(["get", "post"], "my-profile", "Profile::index");
    //Notification
    $routes->match(["get", "post"], "notification-list", "Notification::index");
    $routes->match(["get", "post"], "notification-data", "Notification::my_notification_data");

});

//Webhook filters
$routes->post("api/cashfree_webhook", "Cashfree_webhook::index", ["namespace" => "App\Controllers\Api\Webhook"]);

//Frontend Filters
$routes->get("Sitemap.xml", "Sitemap::index", ["namespace" => "App\Controllers"]);
$routes->get("cab-list", "CabBooking::index", ["namespace" => "App\Controllers\Frontend"]);
$routes->post("fare-details", "CabBooking::fareSummary", ["namespace" => "App\Controllers\Frontend"]);
$routes->post("save-booking-search-data", "CabBooking::saveBookingSearchData", ["namespace" => "App\Controllers\Frontend"]);
$routes->get("booking-details", "CabBooking::bookingDetails", ["namespace" => "App\Controllers\Frontend"]);
$routes->post("apply-coupon", "CabBooking::applyCoupon", ["namespace" => "App\Controllers\Frontend"]);
$routes->post("create-booking", "CabBooking::createBooking", ["namespace" => "App\Controllers\Frontend"]);
$routes->post("confirm-booking", "CabBooking::confirmBooking", ["namespace" => "App\Controllers\Frontend"]);



$routes->post("getRandomCaptcha", "Ajax::index", ["namespace" => "App\Controllers"]);
$routes->post("getDestination", "Ajax::getDestination", ["namespace" => "App\Controllers"]);
$routes->post("getPackages", "Ajax::getPackages", ["namespace" => "App\Controllers"]);
$routes->post("getSpecialPacks", "Ajax::getSpecialPacks", ["namespace" => "App\Controllers"]);
$routes->post("save-form", "Query::index", ["namespace" => "App\Controllers"]);
$routes->post("save-pack-form", "Query::save_pack_form", ["namespace" => "App\Controllers"]);
$routes->post("save-driver", "Query::save_driver", ["namespace" => "App\Controllers"]);
$routes->post("getCities", "Ajax::getCities", ["namespace" => "App\Controllers"]);
$routes->post("validateUser", "Ajax::validateUser", ["namespace" => "App\Controllers"]); 
$routes->post("validateOtp", "Ajax::validateOtp", ["namespace" => "App\Controllers"]);
$routes->post("resendOtp", "Ajax::resendOtp", ["namespace" => "App\Controllers"]);
$routes->post("save-address", "Ajax::save_address", ["namespace" => "App\Controllers"]);
$routes->post("get-address", "Ajax::get_address", ["namespace" => "App\Controllers"]);

$routes->get("taxi-list", "Common::get_address", ["namespace" => "App\Controllers"]);
$routes->get("taxi-details", "Common::get_address", ["namespace" => "App\Controllers"]);
$routes->post("get-local-package", "Ajax::getHourlyPackage", ["namespace" => "App\Controllers"]);
$routes->post("getSeoPackages", "Ajax::getSeoPackages", ["namespace" => "App\Controllers"]);

$routes->get("(:any)", "Common::index", ["namespace" => "App\Controllers"]);

