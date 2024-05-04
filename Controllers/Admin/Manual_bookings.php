<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;


class Manual_bookings extends BaseController {
    
    protected $c_model;
    protected $session;
    protected $table;
    protected $page_type;
    
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        // $this->table = 'dt_all_cms_data';
        // $this->page_type = 'common';
    }
    
    
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type']  = $loginData['role'];
        $data["menu"]       = "Manual Booking";
        $data["title"]      = "Manual Booking";
        $data['access']     = checkWriteMenus(getUri(2));
        
        adminview('manual-booking', $data);
    }
    
}