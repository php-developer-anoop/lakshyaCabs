<?php 

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Common_model;
 
class Customer extends BaseController{
    
    protected $c_model;
    protected $table;
    
    public function __construct(){
        $this->table = 'dt_customer_list';
        $this->c_model = new Common_model();
    }
    public function index(){
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Customer Master";
        $data["title"] = "Customer List";
        $data['access'] = checkWriteMenus(getUri(2));
        adminview('view-customer-list', $data);
    }
    function add_customer() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        $data["menu"] = "Customer Master";
        $data["title"] = !empty($id) ? "Edit Customer" : "Add Customer";
        $data['state_list'] = $this->c_model->getAllData('states', 'id,state_name', ['status' => 'Active']);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['name'] = !empty($savedData['name']) ? $savedData['name'] : '';
        $data['mobile_no'] = !empty($savedData['mobile_no']) ? $savedData['mobile_no'] : '';
        $data['email'] = !empty($savedData['email']) ? $savedData['email'] : '';
        $data['stateid'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['cityid'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['address'] = !empty($savedData['address']) ? $savedData['address'] : '';
        $data['pin_code'] = !empty($savedData['pin_code']) ? $savedData['pin_code'] : '';
        $data['company_name'] = !empty($savedData['company_name']) ? $savedData['company_name'] : '';
        $data['company_pan_number'] = !empty($savedData['company_pan_number']) ? $savedData['company_pan_number'] : '';
        $data['gstin_number'] = !empty($savedData['gstin_number']) ? $savedData['gstin_number'] : '';
        $data['company_state'] = !empty($savedData['company_state']) ? $savedData['company_state'] : '';
        $data['company_city'] = !empty($savedData['company_city']) ? $savedData['company_city'] : '';
        $data['company_pin_code'] = !empty($savedData['company_pin_code']) ? $savedData['company_pin_code'] : '';
        $data['company_address'] = !empty($savedData['company_address']) ? $savedData['company_address'] : '';
        $data['profile_image'] = !empty($savedData['profile_image']) ? $savedData['profile_image'] : '';
        $data['profile_status'] = !empty($savedData['profile_status']) ? $savedData['profile_status'] : 'Active';
        adminview('add-customer', $data);
    }
    public function save_customer() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['name'] = trim($post['name']);
        $data['mobile_no'] = trim($post['mobile_no']);
        $data['email'] = trim($post['email']);
        $state = !empty($post['state_id'])?explode(',',$post['state_id']):[];
        $data['state_id'] = $state[0]??'';
        $city = !empty($post['city_id'])?explode(',',$post['city_id']):[];
        $data['city_id'] = $city[0]??'';
        $data['address'] = trim($post['address']);
        $data['pin_code'] = trim($post['pin_code']);
        $data['company_name'] = trim($post['company_name']);
        $company_state = !empty($post['company_state'])?explode(',',$post['company_state']):[];
        $data['company_state'] = $company_state[0]??'';
 
        $data['company_city'] = trim($post['company_city']);
        $data['company_pin_code'] = trim($post['company_pin_code']);
        $data['company_address'] = trim($post['company_address']);
        $data['company_pan_number'] = trim($post['company_pan_number']);
        $data['gstin_number'] = trim($post['gstin_number']);
        $data['profile_status'] = trim($post['profile_status']);
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
       
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully ');
        } else {
            $data['update_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
        return redirect()->to(base_url(ADMINPATH . 'edit-customer?id=' . $id));
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
            $where["name LIKE '%" . $searchString . "%' OR mobile_no LIKE '%" . $searchString . "%' OR email LIKE '%" . $searchString . "%' OR address LIKE '%" . $searchString . "%' OR pin_code LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
       
        if ($is_count == "yes") {
            $countData = $this->c_model->countRecords($this->table, $where, 'id');
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
                $push["state_name"] = getStateName($value['state_id']);
                $push["city_name"] = getCityStateName($value['city_id']);
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