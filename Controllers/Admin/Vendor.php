<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Vendor extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = 'dt_vendor_list';
    }
    public function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Vendor Master";
        $data["title"] = "Vendor List";
        $data['access'] = checkWriteMenus(getUri(2));
        adminview('view-vendor-list', $data);
    }
    function add_vendor() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        $data["menu"] = "Vendor Master";
        $data["title"] = !empty($id) ? "Edit Vendor" : "Add Vendor";
        $data['state_list'] = $this->c_model->getAllData('states', 'id,state_name', ['status' => 'Active']);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['full_name'] = !empty($savedData['full_name']) ? $savedData['full_name'] : '';
        $data['mobile_no'] = !empty($savedData['mobile_no']) ? $savedData['mobile_no'] : '';
        $data['email_id'] = !empty($savedData['email_id']) ? $savedData['email_id'] : '';
        $data['stateid'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['statename'] = !empty($savedData['state_name']) ? $savedData['state_name'] : '';
        $data['cityid'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['cityname'] = !empty($savedData['city_name']) ? $savedData['city_name'] : '';
        $data['address'] = !empty($savedData['address']) ? $savedData['address'] : '';
        $data['pincode'] = !empty($savedData['pincode']) ? $savedData['pincode'] : '';
        $data['business_name'] = !empty($savedData['business_name']) ? $savedData['business_name'] : '';
        $data['business_registered_as'] = !empty($savedData['business_registered_as']) ? $savedData['business_registered_as'] : '';
        $data['business_state_id'] = !empty($savedData['business_state_id']) ? $savedData['business_state_id'] : '';
        $data['business_state_name'] = !empty($savedData['business_state_name']) ? $savedData['business_state_name'] : '';
        $data['business_city_id'] = !empty($savedData['business_city_id']) ? $savedData['business_city_id'] : '';
        $data['business_city_name'] = !empty($savedData['business_city_name']) ? $savedData['business_city_name'] : '';
        $data['business_address'] = !empty($savedData['business_address']) ? $savedData['business_address'] : '';
        $data['business_pincode'] = !empty($savedData['business_pincode']) ? $savedData['business_pincode'] : '';
        $data['business_pan_no'] = !empty($savedData['business_pan_no']) ? $savedData['business_pan_no'] : '';
        $data['business_gst_no'] = !empty($savedData['business_gst_no']) ? $savedData['business_gst_no'] : '';
        $data['profile_image'] = !empty($savedData['profile_image']) ? $savedData['profile_image'] : '';
        $data['business_logo'] = !empty($savedData['business_logo']) ? $savedData['business_logo'] : '';
        $data['aadhaar_front'] = !empty($savedData['aadhaar_front']) ? $savedData['aadhaar_front'] : '';
        $data['aadhaar_back'] = !empty($savedData['aadhaar_back']) ? $savedData['aadhaar_back'] : '';
        $data['pan_image'] = !empty($savedData['pan_image']) ? $savedData['pan_image'] : '';
        $data['gst_image'] = !empty($savedData['gst_image']) ? $savedData['gst_image'] : '';
        $data['is_email_verified'] = !empty($savedData['is_email_verified']) ? $savedData['is_email_verified'] : 'No';
        $data['kyc_status'] = !empty($savedData['kyc_status']) ? $savedData['kyc_status'] : '';
        $data['profile_status'] = !empty($savedData['profile_status']) ? $savedData['profile_status'] : 'Active';
        adminview('add-vendor', $data);
    }
    public function save_vendor() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['full_name'] = trim($post['full_name']);
        $data['mobile_no'] = trim($post['mobile_no']);
        $data['email_id'] = trim($post['email_id']);
        $data['city_id'] = trim($post['city_id']);
        $data['city_name'] = !empty($post['city_id']) ? trim(getCityStateName($post['city_id'])) : '';
        $data['address'] = trim($post['address']);
        $data['pincode'] = trim($post['pincode']);
        $data['business_name'] = trim($post['business_name']);
        $data['business_registered_as'] = trim($post['business_registered_as']);
        $data['business_city_id'] = trim($post['business_city_id']);
        $data['business_city_name'] = !empty($post['business_city_id']) ? trim(getCityStateName($post['business_city_id'])) : '';
        $state = !empty($post['state']) ? explode(',', $post['state']) : [];
        $data['state_id'] = $state[0]??'';
        $data['state_name'] = $state[1]??'';
        $business_state = !empty($post['business_state_id']) ? explode(',', $post['business_state_id']) : [];
        $data['business_state_id'] = $business_state[0]??'';
        $data['business_state_name'] = $business_state[1]??'';
        $data['business_address'] = trim($post['business_address']);
        $data['business_pincode'] = trim($post['business_pincode']);
        $data['business_gst_no'] = trim($post['business_gst_no']);
        $data['business_pan_no'] = trim($post['business_pan_no']);
        $data['profile_status'] = trim($post['profile_status']);
        $data['kyc_status'] = trim($post['kyc_status']);
        if ($file = $this->request->getFile('profile_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_profile_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_profile_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_profile_image']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $data['profile_image'] = $filename;
            }
        }
        if ($file = $this->request->getFile('business_logo')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_business_logo']) && file_exists(ROOTPATH . 'uploads/' . $post['old_business_logo'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_business_logo']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $data['business_logo'] = $filename;
            }
        }
        if ($file = $this->request->getFile('aadhaar_front')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_aadhaar_front']) && file_exists(ROOTPATH . 'uploads/' . $post['old_aadhaar_front'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_aadhaar_front']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $data['aadhaar_front'] = $filename;
            }
        }
        if ($file = $this->request->getFile('aadhaar_back')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_aadhaar_back']) && file_exists(ROOTPATH . 'uploads/' . $post['old_aadhaar_back'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_aadhaar_back']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $data['aadhaar_back'] = $filename;
            }
        }
        if ($file = $this->request->getFile('pan_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_pan_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_pan_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_pan_image']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $data['pan_image'] = $filename;
            }
        }
        if ($file = $this->request->getFile('gst_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_gst_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_gst_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_gst_image']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $data['gst_image'] = $filename;
            }
        }
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully ');
        } else {
            $data['update_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $check = $this->c_model->getSingle($this->table, 'enc_password,kyc_status,email_id', ['id' => $id]);
            if (!empty($check) && empty($check['enc_password']) && ($check['kyc_status'] == "Approved")) {
                $password = generate_password(10);
                sendVendorEmailPassword($check['email_id'], $check['email_id'], $password);
                $this->c_model->updateRecords("vendor_list", ['enc_password' => md5($password),'raw_password'=>$password ], ['id' => $id]);
            }
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
        return redirect()->to(base_url(ADMINPATH . 'edit-vendor?id=' . $id));
    }
    public function getRecords() {
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["recordstotal"]) ? $get["recordstotal"] : 0;
        $orderby = "DESC";
        $where = [];
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where[" unique_id LIKE '%" . $searchString . "%' OR full_name LIKE '%" . $searchString . "%' OR mobile_no LIKE '%" . $searchString . "%' OR email_id LIKE '%" . $searchString . "%' OR state_name LIKE '%" . $searchString . "%' OR city_name LIKE '%" . $searchString . "%' OR address LIKE '%" . $searchString . "%' OR pincode LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
        $countData = $this->c_model->countRecords($this->table, $where, 'id');
        if ($is_count == "yes") {
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderby = "DESC";
        }
        $select = '*,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(update_date , "%d-%m-%Y %r") AS update_date';
        $listData = $this->c_model->getAllData($this->table, $select, $where, $limit, $start, $orderby);
        $result = [];
        if (!empty($listData)) {
            $i = $start + 1;
            foreach ($listData as $key => $value) {
                $push = [];
                $push = $value;
                $push["sr_no"] = $i;
                array_push($result, $push);
                $i++;
            }
        }
        $json_data = [];
        if (!empty($get["search"]["value"])) {
            $countItems = !empty($result) ? count($result) : 0;
            $json_data["draw"] = intval($get["draw"]);
            $json_data["recordsTotal"] = intval($countItems);
            $json_data["recordsFiltered"] = intval($countItems);
            $json_data["data"] = !empty($result) ? $result : [];
        } else {
            $json_data["draw"] = intval($get["draw"]);
            $json_data["recordsTotal"] = intval($totalRecords);
            $json_data["recordsFiltered"] = intval($totalRecords);
            $json_data["data"] = !empty($result) ? $result : [];
        }
        echo json_encode($json_data);
    }
}
