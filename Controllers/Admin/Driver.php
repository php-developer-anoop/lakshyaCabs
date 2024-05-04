<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Driver extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_driver_list"; 
    }
    
    
    public function index() {
        
        $input = $this->request->getVar();
        $id = !empty($input['id']) ? $input['id'] : '';
        
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type']  = $loginData['role'];
        $data["menu"]       = "Driver";
        $data["title"]      = "";
        $data['access']     = checkWriteMenus(getUri(2));
        $data['post_url']   = base_url( ADMINPATH.'save-driver'); 
        
        //get edit data
        $getData = !empty($id) ? $this->c_model->getSingle('dt_driver_list','*', ['md5(id)'=>$id] ) : [];
        
        $data['id'] = !empty($getData['id']) ? $getData['id'] : ''; 
        $data['login_id'] = !empty($getData['login_id']) ? $getData['login_id'] : '';
        $data['unique_code'] = !empty($getData['unique_code']) ? $getData['unique_code'] : '';
        $data['partner_id'] = !empty($getData['partner_id']) ? $getData['partner_id'] : '';
        $data['password'] = !empty($getData['password']) ? $getData['password'] : '';
        $data['enc_password'] = !empty($getData['enc_password']) ? $getData['enc_password'] : '';
        $data['full_name'] = !empty($getData['full_name']) ? $getData['full_name'] : '';
        $data['email_id'] = !empty($getData['email_id']) ? $getData['email_id'] : '';
        $data['mobile_no'] = !empty($getData['mobile_no']) ? $getData['mobile_no'] : '';
        $data['alt_mobile_no'] = !empty($getData['alt_mobile_no']) ? $getData['alt_mobile_no'] : '';
        $data['city_name'] = !empty($getData['city_name']) ? $getData['city_name'] : '';
        $data['city_id'] = !empty($getData['city_id']) ? $getData['city_id'] : '';
        $data['state_name'] = !empty($getData['state_name']) ? $getData['state_name'] : '';
        $data['state_id'] = !empty($getData['state_id']) ? $getData['state_id'] : '';
        $data['address'] = !empty($getData['address']) ? $getData['address'] : '';
        $data['rc_file'] = !empty($getData['rc_file']) ? $getData['rc_file'] : '';
        $data['dl_file'] = !empty($getData['dl_file']) ? $getData['dl_file'] : '';
        $data['ic_file'] = !empty($getData['ic_file']) ? $getData['ic_file'] : '';
        $data['profile_status'] = !empty($getData['profile_status']) ? $getData['profile_status'] : 'Active';
        $data['kyc_status'] = !empty($getData['kyc_status']) ? $getData['kyc_status'] : 'Approved'; 
        $data['profile_image'] = !empty($getData['profile_image']) ? $getData['profile_image'] : '';
        $data['aadhaar_front_file'] = !empty($getData['aadhaar_front_file']) ? $getData['aadhaar_front_file'] : '';
        $data['aadhaar_back_file'] = !empty($getData['aadhaar_back_file']) ? $getData['aadhaar_back_file'] : '';
        $data['aadhaar_no'] = !empty($getData['aadhaar_no']) ? $getData['aadhaar_no'] : '';
        
        $data['state_list'] = $this->c_model->getAllData('dt_states', 'id,state_name', ['status' => 'Active']);
        $data['vendor_list'] = $this->c_model->getAllData('dt_vendor_list', "id,full_name,mobile_no,business_name", ['profile_status' => 'Active','kyc_status' => 'Approved']);
        
        
        adminview('driver/add-driver', $data);
    }
    
    
    public function saveDriver(){
        $post = $this->request->getVar(); 
        
        $id = !empty($post['id']) ? trim($post['id']) : '';
        $saveData = [];
        if(empty($id)){
        $saveData['login_id'] = trim($post['mobile_no']);
        }
        
        $saveData['aadhaar_no'] = trim($post['aadhaar_no']);
        $saveData['full_name'] = trim($post['full_name']);
        $saveData['mobile_no'] = trim($post['mobile_no']);
        $saveData['email_id'] = trim($post['email_id']);
        $saveData['password'] = trim($post['password']);
        $saveData['enc_password'] = md5($saveData['password']); 
        $saveData['alt_mobile_no'] = trim($post['alt_mobile_no']); 
        
        $city_data = !empty($post['city_id']) ? explode(',', $post['city_id']) : []; 
        $saveData['city_name'] = !empty($city_data[1]) ? trim($city_data[1]) : '';
        $saveData['city_id'] = !empty($city_data[0]) ? trim($city_data[0]) : ''; 
        
        $state_data = !empty($post['state_id']) ? explode(',', $post['state_id']) : [];  
        $saveData['state_id'] = !empty($state_data[0]) ? trim($state_data[0]) : '';
        $saveData['state_name'] = !empty($state_data[1]) ? trim($state_data[1]) : '';
        
        $partner_data = !empty($post['partner_id']) ? explode(',', $post['partner_id']) : []; 
        $saveData['partner_business_name'] = !empty($partner_data[1]) ? trim($partner_data[1]) : '';
        $saveData['partner_id'] = !empty($partner_data[0]) ? trim($partner_data[0]) : ''; 
        
        
        $saveData['address'] = trim($post['address']);  
        $saveData['profile_status'] = trim($post['profile_status']);
        $saveData['kyc_status'] = trim($post['kyc_status']);  
         
        $saveData['updated_on'] = date('Y-m-d H:i:s');
        
        
        /************ Upload file related data Start Script **********/
        if ($file = $this->request->getFile('profile_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename_profile_image = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_profile_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_profile_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_profile_image']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename_profile_image);
                $saveData['profile_image'] = $filename_profile_image;
            }
        }
        if ($file = $this->request->getFile('rc_file')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename_rc_file = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_rc_file']) && file_exists(ROOTPATH . 'uploads/' . $post['old_rc_file'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_rc_file']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename_rc_file);
                $saveData['rc_file'] = $filename_rc_file;
            }
        }
        if ($file = $this->request->getFile('dl_file')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename_dl_file = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_dl_file']) && file_exists(ROOTPATH . 'uploads/' . $post['old_dl_file'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_dl_file']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename_dl_file);
                $saveData['dl_file'] = $filename_dl_file;
            }
        }
        if ($file = $this->request->getFile('ic_file')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename_ic_file = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_ic_file']) && file_exists(ROOTPATH . 'uploads/' . $post['old_ic_file'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_ic_file']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename_ic_file );
                $saveData['ic_file'] = $filename_ic_file;
            }
        } 
        
        if ($file = $this->request->getFile('aadhaar_front_file')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename_aadhaar_front_file = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_aadhaar_front_file']) && file_exists(ROOTPATH . 'uploads/' . $post['old_aadhaar_front_file'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_aadhaar_front_file']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename_aadhaar_front_file );
                $saveData['aadhaar_front_file'] = $filename_aadhaar_front_file;
            }
        } 
        
        if ($file = $this->request->getFile('aadhaar_back_file')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename_aadhaar_back_file = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_aadhaar_back_file']) && file_exists(ROOTPATH . 'uploads/' . $post['old_aadhaar_back_file'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_aadhaar_back_file']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename_aadhaar_back_file );
                $saveData['aadhaar_back_file'] = $filename_aadhaar_back_file;
            }
        } 
        
        
          
        
        $validation = null;
        
        if (empty($id)) {
            $validation = []; 
            $validation['mobile_no'] = trim($post['mobile_no']);
            $validation['profile_status !='] = 'Deleted';
            $saveData['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->saveupdate($this->table, $saveData, $validation ); 
            if(!empty($last_id)){
                 echo $unique_code = generateDriverUIDNumber($last_id); 
                 $this->c_model->saveupdate($this->table,['unique_code'=>$unique_code], null,['id'=>$last_id], $last_id );
                 $this->session->setFlashdata('success', 'Data Added Successfully');
            }else{
                 $this->session->setFlashdata('error', 'Duplicate Email Mobile No');
            } 
           
        } else { 
            $last_id = $this->c_model->saveupdate($this->table, $saveData, $validation,['id'=>$id], $id ); 
            $this->c_model->updateRecords($this->table, $saveData, ['id' => $id]); 
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
       
       
        return redirect()->to( base_url(ADMINPATH . 'add-driver'.( $id ? '?id='.md5($id) : '') ));
    }
    
    
    public function driverList() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type']  = $loginData['role'];
        $data["menu"]       = "Driver List";
        $data["title"]      = "";
        $data['access']     = checkWriteMenus(getUri(2)); 
        $data['list_url'] = base_url('admin/driver-data');
        $data['city_list'] = $this->c_model->getAllData('dt_cities', 'id,state_name,city_name', ['status' => 'Active']);
        
        adminview('view-driver', $data);
    }
    
    
    public function getRecords() {
        
        $post = $this->request->getVar(); 
        $limit = (int)(!empty($post["length"]) ? $post["length"] : 1);
        $start = (int)!empty($post["start"]) ? $post["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($post["recordstotal"]) ? $post["recordstotal"] : 0;
        
        $status_type = !empty($post["status_type"]) ? $post["status_type"] : '';
        $city_id = !empty($post["city_id"]) ? $post["city_id"] : '';
        $from_date = !empty($post["from_date"]) ? $post["from_date"] : '';
        $to_date = !empty($post["to_date"]) ? $post["to_date"] : '';
        
        
        $orderby = "DESC";
        $where = [];
        $searchString = null;
        
        /****** Apply Filter *********/
        if(in_array($status_type,['Active','Inactive','Blocked']) ){
            $where['profile_status'] = $status_type;
        }else{
            $where['profile_status !='] = 'Deleted';
        }
        
        if(in_array($status_type,['Pending','Approved','Rejected']) ){
            $where['kyc_status'] = $status_type;
        }
        
        if(!empty($from_date) && !empty($to_date)){
            $where['DATE(add_date) >='] = date('Y-m-d',strtotime($from_date));
            $where['DATE(add_date) <='] = date('Y-m-d',strtotime($from_date));
        }
        if(!empty($city_id)){
            $where['city_id'] = $city_id; 
        }
        
        
        if (!empty($post["search"]["value"])) {
            $searchString = trim($post["search"]["value"]);
            $where["(full_name LIKE '%" . $searchString . "%' OR email_id LIKE '%" . $searchString . "%' OR mobile_no LIKE '%" . $searchString . "%' OR city_name LIKE '%" . $searchString . "%' OR profile_status LIKE '%" . $searchString . "%' OR kyc_status LIKE '%" . $searchString . "%' ) "] = null;
            $limit = 100;
            $start = 0;
        }
        $countData = $this->c_model->countRecords($this->table, $where, 'id');
        if ($is_count == "yes") {
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($post["showRecords"])) {
            $limit = $post["showRecords"];
            $orderby = "DESC";
        }
        
        $url = base_url();
        $select = 'md5(id) as en_hash,id,login_id,partner_business_name,otp,unique_code,password,full_name,email_id,mobile_no,alt_mobile_no,city_name,state_name,address,rc_file,dl_file,ic_file,profile_status,kyc_status,otp,DATE_FORMAT(add_date , "%d-%m-%Y  %h:%i %p") AS add_date,DATE_FORMAT(updated_on , "%d-%m-%Y %h:%i %p") AS updated_on';
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
        
        if (!empty($post["search"]["value"])) {
            $countItems = !empty($result) ? count($result) : 0;
            $json_data["draw"] = intval($post["draw"]);
            $json_data["recordsTotal"] = intval($countItems);
            $json_data["recordsFiltered"] = intval($countItems);
            $json_data["data"] = !empty($result) ? $result : [];
        } else {
            $json_data["draw"] = intval($post["draw"]);
            $json_data["recordsTotal"] = intval($totalRecords);
            $json_data["recordsFiltered"] = intval($totalRecords);
            $json_data["data"] = !empty($result) ? $result : [];
        }
        echo json_encode($json_data);
    }
    
    public function deleteAccount() {
        
        if (!$this->request->isAJAX()) { 
            return redirect()->to( base_url('/404'))->with('error', 'This is not an AJAX request.');
        }
        
        $post = $this->request->getVar();
        $id = !empty($post['id']) ? $post['id'] : '';
        
        $response = [];
        
        if(empty($id)){
            $response['status'] = false; 
            $response['message'] = 'ID is Blank';
            echo json_encode($response); exit;
        }
        
        
        $this->c_model->saveupdate($this->table,['profile_status'=>'Deleted'], null,['id'=>$id], $id );  
        
        $response['status'] = true; 
        $response['message'] = 'Driver Deleted Successfully';
        echo json_encode($response); exit;
    
        
    }
    
     
}