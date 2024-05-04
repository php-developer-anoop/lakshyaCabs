<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Vendor_registration extends BaseController {
    protected $c_model;
    protected $session;
    protected $cookieName;
    public function __construct() {
        $this->session = session();
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data["title"]      = "Register Vendor";
        $company            = websetting('*');
        $data['favicon']    = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo']       = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        echo view(VENDORPATH . "register", $data);
    }
    public function vendorAsRegistration() {
        $data = [];
        $data["title"]      = "Register Vendor";
        $company            = websetting('*');
        $data['favicon']    = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo']       = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        $data['vendor']     = getVendorId();
        
        $data['state_list'] = $this->c_model->getAllData('states', 'id,state_name', ['status' => 'Active'], null, null, 'ASC', 'state_name');
        echo view(VENDORPATH . "registration-vendor", $data);
    }
    public function saveBasicDetails() {
        $response = [];
        $post = $this->request->getVar();
        $full_name = !empty($post['full_name']) ? trim($post['full_name']) : '';
        $mobile_no = !empty($post['mobile_no']) ? trim($post['mobile_no']) : '';
        $email_id  = !empty($post['email_id']) ? trim($post['email_id']) : '';
        $address   = !empty($post['address']) ? trim($post['address']) : '';
        $pincode   = !empty($post['pincode']) ? trim($post['pincode']) : '';
        $state     = !empty($post['state']) ? explode(',', trim($post['state'])) : [];
        $city      = !empty($post['city']) ? trim($post['city']) : '';
        
        if (empty($full_name)) {
            $response = ['status' => false, 'message' => 'Enter Full Name'];
            echo json_encode($response);
            exit;
        }
        if (empty($mobile_no)) {
            $response = ['status' => false, 'message' => 'Enter Mobile Number'];
            echo json_encode($response);
            exit;
        }
        if (empty($email_id)) {
            $response = ['status' => false, 'message' => 'Enter Email Id'];
            echo json_encode($response);
            exit;
        }
        if (empty($address)) {
            $response = ['status' => false, 'message' => 'Enter Full Address'];
            echo json_encode($response);
            exit;
        }
        if (empty($pincode)) {
            $response = ['status' => false, 'message' => 'Enter Pincode'];
            echo json_encode($response);
            exit;
        }
        if (empty($state)) {
            $response = ['status' => false, 'message' => 'Select State'];
            echo json_encode($response);
            exit;
        }
        if (empty($city)) {
            $response = ['status' => false, 'message' => 'Select City'];
            echo json_encode($response);
            exit;
        }
        $data = [];
        if ($fileImage = $this->request->getFile('profile_image')) {
            $fileDataImage = uploadJpgWebp($fileImage, true);
            if (!empty($fileDataImage)) {
                if (!empty($fileDataImage['jpg'])) {
                    $data['profile_image'] = $fileDataImage['jpg'];
                }
            }
        }
        // $check = $this->c_model->getSingle('vendor_list', 'kyc_status', ['email_id' => $email_id]);
        // if (!empty($check) && ($check['kyc_status'] != "Approved")) {
        //     $response = ['status' => false, 'message' => 'You are already registered and your KYC status is ' . $check['kyc_status']];
        //     echo json_encode($response);
        //     exit;
        // }
        $data['unique_id']  = 'LCV' . rand(00000, 99999);
        $data['full_name']  = $full_name;
        $data['mobile_no']  = $mobile_no;
        $data['email_id']   = $email_id;
        $data['state_id']   = $state[0];
        $data['state_name'] = $state[1];
        $data['city_id']    = $city;
        $data['city_name']  = getCityStateName($city);
        $data['address']    = $address;
        $data['pincode']    = $pincode;
        $data['form_step']  = '2';
        $data['add_date']   = date('Y-m-d H:i:s');
        
        $this->c_model->deleteRecords('vendor_list', ['email_id' => $email_id]);
        $vendor_id = $this->c_model->insertRecords('vendor_list', $data);
        
        if ($vendor_id) {
            session()->set('vendor_id', $vendor_id);
            $response = ['status' => true, 'message' => 'Basic Details Saved Successfully', 'vendor_id' => $vendor_id];
            echo json_encode($response);
            exit;
        }
    }
    public function saveBusinessDetails() {
        $response               = [];
        $post                   = $this->request->getVar();
        $business_name          = !empty($post['business_name']) ? trim($post['business_name']) : '';
        $business_registered_as = !empty($post['business_registered_as']) ? trim($post['business_registered_as']) : '';
        $business_pan_no        = !empty($post['business_pan_no']) ? trim($post['business_pan_no']) : '';
        $business_gst_no        = !empty($post['business_gst_no']) ? trim($post['business_gst_no']) : '';
        $business_address       = !empty($post['business_address']) ? trim($post['business_address']) : '';
        $business_pincode       = !empty($post['business_pincode']) ? trim($post['business_pincode']) : '';
        $business_state         = !empty($post['business_state']) ? explode(',', trim($post['business_state'])) : [];
        $business_city_id       = !empty($post['business_city_id']) ? trim($post['business_city_id']) : '';
        
        if (empty($business_name)) {
            $response = ['status' => false, 'message' => 'Enter Business Name'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_registered_as)) {
            $response = ['status' => false, 'message' => 'Select Business Registered Type'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_state)) {
            $response = ['status' => false, 'message' => 'Select Your Business State'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_city_id)) {
            $response = ['status' => false, 'message' => 'Select Your Business City'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_address)) {
            $response = ['status' => false, 'message' => 'Enter Your Full Business Address'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_pincode)) {
            $response = ['status' => false, 'message' => 'Enter Your Business Pincode'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_pan_no)) {
            $response = ['status' => false, 'message' => 'Enter Business Pan Number'];
            echo json_encode($response);
            exit;
        }
        if (empty($business_gst_no)) {
            $response = ['status' => false, 'message' => 'Enter Your Business GST Number'];
            echo json_encode($response);
            exit;
        }
        $data = [];
        if ($fileImage = $this->request->getFile('business_logo')) {
            $fileDataImage = uploadJpgWebp($fileImage, true);
            if (!empty($fileDataImage)) {
                if (!empty($fileDataImage['jpg'])) {
                    $data['business_logo'] = $fileDataImage['jpg'];
                }
            }
        }
        $data['business_name']          = $business_name;
        $data['business_registered_as'] = $business_registered_as;
        $data['business_state_id']      = $business_state[0];
        $data['business_state_name']    = $business_state[1];
        $data['business_city_id']       = $business_city_id;
        $data['business_city_name']     = getCityStateName($business_city_id);
        $data['business_address']       = $business_address;
        $data['business_pincode']       = $business_pincode;
        $data['business_pan_no']        = $business_pan_no;
        $data['business_gst_no']        = $business_gst_no;
        $data['form_step']              = '3';
        
        $vendor_id = !empty(session()->get('vendor_id')) ? session()->get('vendor_id') : '';
        if (!empty($vendor_id)) {
            $this->c_model->updateRecords('vendor_list', $data, ['id' => $vendor_id]);
            $response = ['status' => true, 'message' => 'Business Details Saved Successfully'];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => false, 'message' => 'Something Went Wrong'];
            echo json_encode($response);
            exit;
        }
    }
    public function save_image() {
        $post = $this->request->getPost();
        if ($file = $this->request->getFile('image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (!empty($post['old_image']) && is_file(ROOTPATH . 'uploads/' . $post['old_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_image']);
                }
                $file->move(ROOTPATH . 'uploads/', $filename);
                $data[$post['type']] = $filename;
                $this->c_model->updateRecords('vendor_list', $data, ['id' => $post['vendor_id']]);
                echo "Image Uploaded Successfully";
            } else {
                echo "Invalid file.";
            }
        } else {
            echo "No file uploaded.";
        }
    }
}
