<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;

class Booking_conditions extends BaseController {
    
    protected $c_model;
    protected $session;
    protected $table;
    
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_booking_conditions";
    }
    
    public function index() {
        $data = [];
        $data['title'] = 'Booking Conditions';
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        
        $data['list'] = $this->c_model->getBulkRecords( $this->table, null,'*', 'get'); 
        
        adminview('booking-conditions', $data);
    }
    
    
    
    
    public function saveBookingData() {
    
        $post = $this->request->getVar(); 
        
        //echo '<pre>';
        //print_r($post); exit;
        
        
        $id = !empty($post['id']) ? $post['id'] : '';
        
        $saveData = []; 
        $saveData['condition_type'] = trim($post['condition_type']);
        isset($post['from_value']) ? $saveData['from_value'] = trim($post['from_value']) : null;
        isset($post['to_value']) ? $saveData['to_value'] = ($post['to_value']) : null;
        isset($post['apply_type']) ? $saveData['apply_type'] = trim($post['apply_type']) : null;
        isset($post['apply_value_type']) ? $saveData['apply_value_type'] = trim($post['apply_value_type']) : null;
        isset($post['apply_value']) ? $saveData['apply_value'] = trim($post['apply_value']) : null;
        $saveData['status'] = trim($post['status']); 
        
        $where = [];
        if(!empty($id)){
            $where['id'] = $id;
            $saveData['updated_date'] = date('Y-m-d H:i:s');
        }else{
           $saveData['add_date'] = date('Y-m-d H:i:s');
           $saveData['updated_date'] = date('Y-m-d H:i:s');
        }
        
        
        if( !empty($id) ){
           $this->c_model->updateRecords( $this->table, $saveData, $where );
           $this->session->setFlashdata('success', 'Data Updated Successfully');   
        }
        else if (empty($id)) {
            $this->c_model->insertRecords( $this->table, $saveData);
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } 
        
        return redirect()->to(base_url(ADMINPATH . 'booking-conditions'));
    }


    /*********************  Calender *********************/
    /*********************  Calender *********************/
    public function calender() {
        $data = [];
        $data['title'] = 'Calender Booking Conditions';
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        
        $post = $this->request->getVar(); 
        $getData = [];
        if(!empty($post['id'])){
            $getData = $this->c_model->getSingle( 'dt_calender_booking_conditions','*', ['id'=>$post['id']] ); 
        }
        
        $data['id'] = !empty($getData['id']) ? $getData['id'] : '';
        $data['state_id'] = !empty($getData['state_id']) ? $getData['state_id'] : '';
        $data['trip_type'] = !empty($getData['trip_type']) ? $getData['trip_type'] : '';
        $data['from_date'] = !empty($getData['from_date']) ? $getData['from_date'] : date('Y-m-d');
        $data['to_date'] = !empty($getData['to_date']) ? $getData['to_date'] : date('Y-m-d');
        $data['charge_type'] = !empty($getData['charge_type']) ? $getData['charge_type'] : '';
        $data['charge_value_type'] = !empty($getData['charge_value_type']) ? $getData['charge_value_type'] : '';
        $data['charge_value'] = !empty($getData['charge_value']) ? $getData['charge_value'] : '';
        $data['status'] = !empty($getData['status']) ? $getData['status'] : 'Active';
        
        $data['state_list'] = $this->c_model->getBulkRecords( 'dt_states', ['status'=>'Active'],'id,state_name', 'get');
        $data['trip_type_list'] = $this->c_model->getBulkRecords( 'dt_trip_type_master', ['status'=>'Active'],'id,trip_type', 'get');  
      
        
        adminview('calender-booking-conditions', $data);
    }
    
    
    
    
    public function saveCalenderBookingData() {
    
        $post = $this->request->getVar(); 
        
        $id = !empty($post['id']) ? $post['id'] : '';
        
        if( !empty($post['key']) ){
            
            foreach( $post['key'] as $key=>$value ){ 
        
                    $saveData = []; 
                    $saveData['state_id'] = trim($value['state_id']);
                    $saveData['trip_type'] = trim($value['trip_type']);
                    $saveData['from_date'] = date('Y-m-d',strtotime( $value['from_date']));
                    $saveData['to_date'] = date('Y-m-d',strtotime($value['to_date']));
                    $saveData['charge_type'] = trim($value['charge_type']);
                    $saveData['charge_value_type'] = trim($value['charge_value_type']);
                    $saveData['charge_value'] = trim($value['charge_value']);
                    $saveData['status'] = trim($value['status']); 
                    
                    $where = [];
                    if(!empty($id)){
                        $where['id'] = $id;
                        $saveData['updated_date'] = date('Y-m-d H:i:s');
                    }else{
                      $saveData['add_date'] = date('Y-m-d H:i:s');
                      $saveData['updated_date'] = date('Y-m-d H:i:s');
                    }
                    
                    //insert
                    if( !empty($id) ){
                        $this->c_model->updateRecords( 'dt_calender_booking_conditions', $saveData, $where ); 
                    }else if (empty($id)) {
                        $this->c_model->insertRecords( 'dt_calender_booking_conditions', $saveData); 
                    } 
            }
        } 
        
        
        if( !empty($id) ){ 
           $this->session->setFlashdata('success', 'Data Updated Successfully');   
        }
        else if (empty($id)) { 
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } 
        
        return redirect()->to(base_url(ADMINPATH . 'calender-booking-conditions'.($id ? '?id='.$id : '') ));
    }
   
   
    public function listData() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type']  = $loginData['role'];
        $data["menu"]       = "Booking Calender Conditions";
        $data["title"]      = "Booking Calender Conditions";
        $data['access']     = checkWriteMenus(getUri(2)); 
        
        adminview('booking-conditions-list', $data);
    }
    
    public function getRecords() {
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["recordstotal"]) ? $get["recordstotal"] : 0;
        
         
        $where = [];
         
       
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where["(b.state_name LIKE '%" . $searchString . "%' OR a.trip_type LIKE '%" . $searchString . "%'  OR a.charge_type LIKE '%" . $searchString . "%'  OR a.charge_value_type LIKE '%" . $searchString . "%') "] = null;
            $limit = 100;
            $start = 0;
        }
        
        
        if ($is_count == "yes") {
            $countData = $this->c_model->countRecords('dt_calender_booking_conditions', $where, 'id');
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"]; 
        }
        
        $fromTable = 'dt_calender_booking_conditions as a';
        $orderBy = 'DESC';
        $orderByKeys = 'a.id';
        $joinArray = [];
        $joinArray[0]['table'] = 'dt_states as b';
        $joinArray[0]['join_on'] = 'a.state_id = b.id';
        $joinArray[0]['join_type'] = 'LEFT';
        
        $joinArray[1]['table'] = 'dt_trip_type_master as c';
        $joinArray[1]['join_on'] = 'a.trip_type = c.trip_type';
        $joinArray[1]['join_type'] = 'LEFT';
        
         
        $selectKeys = ' a.*, b.state_name, c.display_name, DATE_FORMAT(a.add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(a.updated_date , "%d-%m-%Y %r") AS update_date';
        $listData = $this->c_model->getBulkRecords( $fromTable, $where, $selectKeys, 'get', $orderBy , $orderByKeys, $start, $limit, $joinArray );
        
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
?>