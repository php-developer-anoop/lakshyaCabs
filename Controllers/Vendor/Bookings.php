<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Bookings extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data['title'] = 'Booking List';
        $data['menu'] = 'Booking List';
        $data['vendor_profile'] = getVendorProfile();
        $data['booking_status'] = !empty($this->request->getVar('booking_status'))?$this->request->getVar('booking_status'):'';
        $data['list_url'] = base_url(VENDORPATH.'booking-data');
        $data['city_list'] = $this->c_model->getAllData('cities','id,city_name,state_name',['status'=>'Active'],null,null,'ASC','state_name');
        vendorView('booking-list', $data);
    }
     public function getRecords() {
        
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $vendor_id = !empty($get["vendor_id"]) ? $get["vendor_id"] : "";
        $totalRecords = !empty($get["total_records"]) ? $get["total_records"] : 0;
        
        
        //filter values
        $booking_status = !empty($get["booking_status"]) ? $get["booking_status"] : '';
        $from_date = !empty($get["from_date"]) ? $get["from_date"] : '';
        $to_date = !empty($get["to_date"]) ? $get["to_date"] : '';
        $city_id = !empty($get["city_id"]) ? $get["city_id"] : '';
        
        
        $orderby = "DESC";
        $where = [];
        $vendor = getVendorProfile();
        // if ($booking_status == 'approved') {
        //     if ($vendor['kyc_status'] == "Approved") {
        //         $where['pickup_city_id'] = !empty($vendor['business_city_id']) ? $vendor['business_city_id'] : '';
        //         $where['DATE(pickup_date_time) >='] = date('Y-m-d'); 
        //         $where['broadcast_status'] = 'yes';   
        //     } else {
        //         $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     }
        //     $where['booking_status'] = 'approved';
        //     $where['is_partner_accepted'] = 'no';
        // } else {
        //     $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     $where['booking_status'] = 'approved';
        //     $where['is_partner_accepted'] = 'yes';
        // }

        // if( in_array($booking_status, ['new','approved'] ) ){
            
        //     if ($vendor['kyc_status'] == "Approved") {
        //         $where['pickup_city_id'] = !empty($vendor['business_city_id']) ? $vendor['business_city_id'] : '';
        //         $where['DATE(pickup_date_time) >='] = date('Y-m-d'); 
        //         $where['broadcast_status'] = 'yes';   
        //     } else {
        //         $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     }
        //     $where['booking_status'] = 'approved';
        //     $where['is_partner_accepted'] = 'no';
            
        // }
        // else if( in_array($booking_status, ['pendingdriver'] ) ){
        //     $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     $where['booking_status'] = 'approved';
        //     $where['driver_mobile_no'] = '';
        //     $where['is_partner_accepted'] = 'yes';
        // } 
        // else if( in_array($booking_status, ['assigneddriver'] ) ){
        //     $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     $where['booking_status'] = 'approved';
        //     $where['driver_mobile_no !='] = '';
        //     $where['is_partner_accepted'] = 'yes';
        // }
        // else if( in_array($booking_status, ['inprogress'] ) ){
        //     $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     $where['booking_status'] = 'approved';
        //     $where['DATE(pickup_date_time) <='] = date('Y-m-d');
        //     $where['DATE(drop_date_time) >='] = date('Y-m-d'); 
        //     $where['is_partner_accepted'] = 'yes';
        // }else {
        //     $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
        //     $where['booking_status'] = 'approved';
        //     $where['is_partner_accepted'] = 'yes';
        // }
        
        //add booking type filter
        $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : '';
        
        // Set booking_status to 'approved'
        $where['booking_status'] = 'approved';
        
        // Set is_partner_accepted to 'yes' by default
        $where['is_partner_accepted'] = 'yes';
        
        // Check $booking_status
        if (in_array($booking_status, ['new', 'approved'])) {
            if ($vendor['kyc_status'] == "Approved") {
                // Set pickup_city_id, pickup_date_time, and broadcast_status
                $where['pickup_city_id'] = !empty($vendor['business_city_id']) ? $vendor['business_city_id'] : '';
                $where['DATE(pickup_date_time) >='] = date('Y-m-d'); 
                $where['broadcast_status'] = 'yes';   
            } else {
                // Set partner_id if KYC is not approved
                $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
            }
        } elseif (in_array($booking_status, ['pendingdriver'])) {
            // Set conditions for pending driver
            $where['driver_mobile_no'] = '';
            $where['is_partner_accepted'] = 'yes';
        } elseif (in_array($booking_status, ['assigneddriver'])) {
            // Set conditions for assigned driver
            $where['driver_mobile_no !='] = '';
            $where['is_partner_accepted'] = 'yes';
        } elseif (in_array($booking_status, ['inprogress'])) {
            // Set conditions for in progress bookings
            $where['DATE(pickup_date_time) <='] = date('Y-m-d');
            $where['DATE(drop_date_time) >='] = date('Y-m-d'); 
            $where['is_partner_accepted'] = 'yes';
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
            $countData = $this->c_model->countRecords('bookings', $where, 'id');
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
        
        $columNames = 'id,booking_id,guest_name,guest_mobile_no,guest_email_id,model_name,category_name,guest_gstin,vehicle_no,pickup_city_name,drop_city_name,trip_type,booking_status,package_name,,DATE_FORMAT(created_date , "%d-%m-%Y %p") AS created_date,DATE_FORMAT(pickup_date_time , "%d-%m-%Y %h:%i %p") AS pickup_date_time,guest_uid, trip_mode,partner_name,partner_mobile_no,driver_name,driver_mobile_no,';
        $listData = $this->c_model->getBulkRecords('bookings', $where, $columNames,'get', $orderBy, $orderByKeys, $start, $limit, $joinArray);
        //echo $this->c_model->getLastQuery();exit;
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
    
    function acceptBooking(){
        $booking_id = $this->request->getVar('booking_id');
        $vendor = getVendorProfile();
        $saveData=[];
        $saveData['partner_id']=!empty($vendor['id'])?$vendor['id']:'';
        $saveData['partner_name']=!empty($vendor['full_name'])?$vendor['full_name']:'';
        $saveData['partner_mobile_no']=!empty($vendor['mobile_no'])?$vendor['mobile_no']:'';
        $saveData['is_partner_accepted']='yes';
        
        $response = [];
        $update=$this->c_model->updateData('bookings',$saveData,['id'=>$booking_id]);
        if($update){
            $response=['status'=>true,'message'=>'Booking Accepted Successfully'];
            echo json_encode($response);exit;
        }
            $response=['status'=>false,'message'=>'Something Went Wrong'];
            echo json_encode($response);exit;
    }
}
