<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Profile extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data['title'] = 'My Profile';
        $data['menu'] = 'My Profile';
        $data['profile'] = getVendorProfile();
        vendorView('profile', $data);
    }
}