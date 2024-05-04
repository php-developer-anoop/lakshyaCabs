<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;

class Bookings extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = 'dt_bookings';
    }
    
    
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Bookings List";
        $data["title"] = "Bookings List";
        $data['access'] = checkWriteMenus(getUri(2));
        
        $data['list_url'] = base_url('admin/booking-data');
        $data['type'] = $this->request->getVar('type') ? $this->request->getVar('type') : 'new' ;
        
        adminview('booking-list', $data);
    } 
    
    
    public function getCityRecords(){
        $post = $this->request->getVar();
        $searchKeyword = !empty($post['search']) ? $post['search'] : '';
        $cityList = [];
        $where = [];
        $where["city_name LIKE '%".$searchKeyword."%' "] = NULL;
        $where["status"] = 'Active';
        $cityList = $this->c_model->getAllData('dt_cities', 'id, city_name as text', $where ,10,null,'ASC','city_name'); 
          
        echo json_encode($cityList);
    }
    
    public function getRecords() {
        
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["total_records"]) ? $get["total_records"] : 0;
        
        
        //filter values
        $booking_status = !empty($get["booking_status"]) ? $get["booking_status"] : '';
        $from_date = !empty($get["from_date"]) ? $get["from_date"] : '';
        $to_date = !empty($get["to_date"]) ? $get["to_date"] : '';
        $city_id = !empty($get["city_id"]) ? $get["city_id"] : '';
        
        
        $orderby = "DESC";
        $where = [];
        
        //add booking type filter
        if( in_array($booking_status, ['new','approved','completed'] ) ){
            $where['booking_status'] = $booking_status;
        }
        else if( in_array($booking_status, ['pendingdriver'] ) ){
            $where['booking_status'] = 'approved';
            $where['driver_mobile_no'] = '';
        } 
        else if( in_array($booking_status, ['assigneddriver'] ) ){
            $where['booking_status'] = 'approved';
            $where['driver_mobile_no !='] = '';
        }
        else if( in_array($booking_status, ['inprogress'] ) ){
            $where['booking_status'] = 'approved';
            $where['DATE(pickup_date_time) <='] = date('Y-m-d');
            $where['DATE(drop_date_time) >='] = date('Y-m-d'); 
        }else{
             $where['booking_status !='] = 'temp';
        }
        
        //apply date filter
        if( !empty($from_date) && !empty($to_date) ){ 
            $where['DATE(pickup_date_time) >='] = date('Y-m-d',strtotime($from_date));
            $where['DATE(pickup_date_time) <='] = date('Y-m-d',strtotime($to_date));
        }
        
        /**Apply City ID*/
        if(!empty($city_id)){
            $where['pickup_city_id'] = $city_id;
        }
        
         
        $searchString = null;
        
        
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where["(booking_id LIKE '%" . $searchString . "%' OR guest_name LIKE '%" . $searchString . "%' OR guest_mobile_no LIKE '%" . $searchString . "%' OR pickup_city_name LIKE '%" . $searchString . "%' ) "] = null;
            $limit = 100;
            $start = 0;
        }
        
        
        if ( $is_count == "yes" ) {
            $countData = $this->c_model->countRecords($this->table, $where, 'id');
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        
        
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderby = "DESC";
        }
        
        $url = base_url();
        $orderBy = null;
        $orderByKeys = null;
        
        
        $joinArray = null;
        
        $columNames = 'md5(id) as en_id, id,booking_id,guest_name,guest_mobile_no,guest_email_id,broadcast_status,model_name,category_name,guest_gstin,pickup_city_id,vehicle_no,pickup_city_name,drop_city_name,trip_type,booking_status,package_name,,DATE_FORMAT(created_date , "%d-%m-%Y %p") AS created_date,DATE_FORMAT(pickup_date_time , "%d-%m-%Y %h:%i %p") AS pickup_date_time,guest_uid, trip_mode,partner_id,partner_name,partner_mobile_no,driver_name,driver_mobile_no,';
        $listData = $this->c_model->getBulkRecords( $this->table, $where, $columNames,'get', $orderBy, $orderByKeys, $start, $limit, $joinArray);
        //echo $this->c_model->db()->getLastQuery();
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
    
    
    /**************** Approve / Reject / Cancel Booking ****************/
    public function approveRejectCancelBooking(){
        $post = $this->request->getVar();
        if (!$this->request->isAJAX()) { 
            return redirect()->to( base_url('/404'))->with('error', 'This is not an AJAX request.');
        }
        
        $response = [];
        $response['status'] = false;
        
        $id = !empty($post['id']) ? $post['id'] : '';
        $type = !empty($post['type']) ? $post['type'] : '';
        if( empty($id) ){
            $response['status'] = false;
            $response['message'] = 'Booking Table ID is Blank';
            echo json_encode( $response ); exit;
        }else if( empty($type) ){
            $response['status'] = false;
            $response['message'] = 'Type is Blank';
            echo json_encode( $response ); exit;
        }
        
         
        $this->c_model->updateRecords('dt_bookings',['booking_status'=>$type], ['id'=>$id]);
        
        $response['status'] = true;
        $response['message'] = 'Booking '.ucfirst($type).' Sucessfully';
        echo json_encode( $response ); exit; 
    }
    
    
    /**************** Booking Details ****************/
    public function details(){
        $post = $this->request->getVar();
        if (!$this->request->isAJAX()) { 
            return redirect()->to( base_url('/404'))->with('error', 'This is not an AJAX request.');
        }
        
        $response = [];
        $response['status'] = false; 
        
        $getData = $this->c_model->getSingle( 'dt_bookings', '*',['id'=>$id] );
        
        print_r($getData);
        $html = '';
        
        
    }
    
    
    
    /**************** Vendor Drop Down List ****************/
    public function vendorDropDownList(){
        $post = $this->request->getVar();
        if (!$this->request->isAJAX()) { 
            return redirect()->to( base_url('/404'))->with('error', 'This is not an AJAX request.');
        }
        
        $response = [];
        $response['status'] = false;
        
        $id = !empty($post['id']) ? $post['id'] : '';
        $pickup_city_id = !empty($post['pickup_city_id']) ? $post['pickup_city_id'] : '';
        
        if(empty($id)){
            $response['message'] = 'Booking id is blank';
            echo json_encode($response); exit;
        }
        else if(empty($pickup_city_id)){
            $response['message'] = 'City id is blank';
            echo json_encode($response); exit;
        }
        
        $where = [];
        $where['business_city_id'] = $pickup_city_id;
        $where['kyc_status']        = 'Approved';
        $where['profile_status']    = 'Active'; 
        
        $orderBy = 'ASC';
        $orderByKeys = 'business_name';
         
        $getData = $this->c_model->getBulkRecords( 'dt_vendor_list', $where, 'id,unique_id,business_name,mobile_no', 'get', $orderBy, $orderByKeys);
        
        $html = '<option value="">--Choose Vendor--</option>';
        
        if(!empty($getData)){
            foreach($getData as $key=>$value ){
                $ptValue = $value['unique_id'].' | '.$value['mobile_no'].' | '.$value['business_name'];
                $html .= '<option value="'.$value['id'].'" datavalue="'.$ptValue.'">'.$ptValue.'</option>';
            }
        }
        
        echo $html;  exit;
    }
    
    /**************** Broadcast Booking Save Data ****************/
    public function broadCastBooking(){
        $post = $this->request->getVar();
        if (!$this->request->isAJAX()) { 
            return redirect()->to( base_url('/404'))->with('error', 'This is not an AJAX request.');
        }
        
        $response = [];
        $response['status'] = false;
        
        $id = !empty($post['id']) ? $post['id'] : '';
        $partner_id = !empty($post['partner_id']) ? $post['partner_id'] : '';
        $broadcast_amount = !empty($post['broadcast_amount']) ? $post['broadcast_amount'] : 0;
        $broadcast_rate_perkm = !empty($post['broadcast_rate_perkm']) ? $post['broadcast_rate_perkm'] : 0;
        
        if(empty($id)){
            $response['message'] = 'Booking id is blank';
            echo json_encode($response); exit;
        }
        else if( (int)$broadcast_amount == 0){
            $response['message'] = 'Broadcast Vendor Amount is Blank';
            echo json_encode($response); exit;
        }
        else if( (int)$broadcast_rate_perkm == 0){
            $response['message'] = 'Broadcast Rate / Km Amount is Blank';
            echo json_encode($response); exit;
        }
        
        
        
        $where = [];
        $where['id']    = $id;  
        
        $save = [];
        $save['broadcast_amount'] = (float) $broadcast_amount; 
        $save['broadcast_rate_per_km'] = (float) $broadcast_rate_perkm;
        $save['broadcast_status'] = 'yes'; 
        $save['broadcast_date'] = date('Y-m-d H:i:s'); 
        
        if(!empty($partner_id)){
             $getPartnerData = $this->c_model->getSingle('dt_vendor_list','business_name,mobile_no', ['id'=>$partner_id] ) ;
             if(!empty($getPartnerData)){
                 $save['partner_id'] = $partner_id; 
                 $save['partner_name'] = $getPartnerData['business_name']; 
                 $save['partner_mobile_no'] = $getPartnerData['mobile_no'];
             }
        }
         
        $getData = $this->c_model->updateData('dt_bookings', $save, $where );
        
        $response['status'] = true;
        $response['message'] = 'Booking '.( $partner_id ? 'Assigned Successfully' : 'Broadcast was Successful');
        echo json_encode($response); exit;
            
    }
    
    public function assignDriver(){
        $post = $this->request->getVar();
        
        $id = !empty($post['id']) ? $post['id'] : '';
        
        if(empty($id)){
            $response['message'] = 'Booking id is blank';
             return redirect()->to( base_url('admin/booking-list'))->with('error', 'Invalid Booking ID'); exit;
        }
        
        $getData = $this->c_model->getSingle('dt_bookings','*', ['md5(id)'=>$id] ) ;
        
        if(empty($getData)){
            $response['message'] = 'Booking id is blank';
             return redirect()->to( base_url('admin/booking-list'))->with('error', 'Invalid Booking ID'); exit;
        }
        
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Assign Booking";
        $data["title"] = "";
        $data['access'] = checkWriteMenus(getUri(2)); 
        
        $data['id'] = $id ;
        $data['list'] = $getData ;
        
        
        //get vendor list
        $where = [];
        $where['business_city_id'] = $getData['pickup_city_id'];
        $where['kyc_status']        = 'Approved';
        $where['profile_status']    = 'Active'; 
        
        $orderBy = 'ASC';
        $orderByKeys = 'business_name';
         
        $getData = $this->c_model->getBulkRecords( 'dt_vendor_list', $where, 'id,unique_id,business_name,mobile_no', 'get', $orderBy, $orderByKeys );
        
        $data['vendor_list'] = $getData;
        
        //echo '<pre>';
        //print_r( $data ); exit;
        
        adminview('assign-driver', $data); 
        
    }
    
    
    public function driverDropDownList(){
        
        $post = $this->request->getVar();
        $id   = !empty($post['id']) ? $post['id'] : '';
        
        
    }
    
    
}