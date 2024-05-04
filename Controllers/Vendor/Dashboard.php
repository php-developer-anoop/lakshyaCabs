<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Dashboard extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    } 
    public function index() {
        $data = [];
        $data['title'] = 'Dashboard';
        $data['menu'] = 'Dashboard';
        $vendor = getVendorProfile();
        $data['ticket_list'] = $this->c_model->getAllData('ticket_list', 'id,ticket_id,user_name,user_mobile_no,urgency_type,status,add_date,update_date', ['parent_id' => 0, 'user_id' => $vendor['id']], 10, null, 'DESC', 'id');
        $data['ratings'] = $this->c_model->getAllData('ratings_list','rating,description,customer_name,DATE_FORMAT(add_date,"%d/%m/%Y, %r") as add_date',['partner_id'=>$vendor['id'],'status'=>'Active'],10,null,'DESC','id');
        $data['wallet_list'] = $this->c_model->getAllData('wallet','txn_amount,reference_id,remark,DATE_FORMAT(created_date,"%d/%m/%Y %r") as created_date',['user_id'=>$vendor['id'],'user_type'=>'Vendor'],5,null,'DESC','id');
        $data['booking_list'] = $this->c_model->getAllData('bookings','id,guest_name,guest_mobile_no,pickup_city_name,trip_type,driver_name,vehicle_no,DATE_FORMAT(pickup_date_time,"%h:%i %p") as pickup_time',['partner_id'=>$vendor['id'],'booking_status'=>'approved','DATE(pickup_date_time)'=>date('Y-m-d')],5,null,'DESC','id');
        vendorView('dashboard', $data);
    }
    public function ratings() {
        $data = [];
        $vendor = getVendorProfile();
        $data['title'] = 'Ratings';
        $data['menu'] = 'Ratings';
        $data['ratings'] = $this->c_model->getAllData('ratings_list','rating,description,customer_name,DATE_FORMAT(add_date,"%d/%m/%Y, %r") as add_date',['partner_id'=>$vendor['id'],'status'=>'Active'],null,null,'DESC','id');
        vendorView('rating-history', $data);
    }
    public function booking_paid() {
        $data = [];
        $data['title'] = 'Booking Paid';
        $data['menu'] = 'Booking Paid';
        vendorView('booking-paid', $data);
    }
    public function getCount() {
        $vendor = getVendorProfile();
        $booking_status = $this->request->getVar('type') ??"";
        $table = $this->request->getVar('table') ??"";
        //echo $type.' '.$table;exit; 
        $where=[];
        if( in_array($booking_status, ['new','approved','completed'] ) ){
            
            if ($vendor['kyc_status'] == "Approved") {
                $where['pickup_city_id'] = !empty($vendor['business_city_id']) ? $vendor['business_city_id'] : '';
                $where['DATE(pickup_date_time) >='] = date('Y-m-d'); 
                $where['broadcast_status'] = 'yes';   
            } else {
                $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
            }
            $where['booking_status'] = 'approved';
            $where['is_partner_accepted'] = 'no';
            
        }
        else if( in_array($booking_status, ['pendingdriver'] ) ){
            $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
            $where['booking_status'] = 'approved';
            $where['driver_mobile_no'] = '';
            $where['is_partner_accepted'] = 'yes';
        } 
        else if( in_array($booking_status, ['assigneddriver'] ) ){
            $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
            $where['booking_status'] = 'approved';
            $where['driver_mobile_no !='] = '';
            $where['is_partner_accepted'] = 'yes';
        }
        else if( in_array($booking_status, ['inprogress'] ) ){
            $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
            $where['booking_status'] = 'approved';
            $where['DATE(pickup_date_time) <='] = date('Y-m-d');
            $where['DATE(drop_date_time) >='] = date('Y-m-d'); 
            $where['is_partner_accepted'] = 'yes';
        }else {
            $where['partner_id'] = !empty($vendor['id']) ? $vendor['id'] : ''; 
            $where['booking_status'] = 'approved';
            $where['is_partner_accepted'] = 'yes';
        }
        
        $count = count_data('id', $table, $where);
        echo $count;
    }
    public function getDayWiseBookings(){
        $vendor = getVendorProfile();
        $pickup_date=$this->request->getVar('pickup_date');
        $booking_list = $this->c_model->getAllData('bookings','id,guest_name,guest_mobile_no,pickup_city_name,trip_type,driver_name,vehicle_no,DATE_FORMAT(pickup_date_time,"%h:%i %p") as pickup_time',['partner_id'=>$vendor['id'],'booking_status'=>'approved','DATE(pickup_date_time)'=>$pickup_date],5,null,'DESC','id');
         $html = '';
         $booking_count=0;
         if(!empty($booking_list)){foreach($booking_list as $blkey=>$blvalue){
             $booking_count = count($booking_list);
         $html.=' <div class="booking_row">
            <div class="bkng_dtls border-blue">
              <h5>'.$blvalue['guest_name'].'</h5>
              <span>'."+91 ".$blvalue['guest_mobile_no'].'</span>
              <div class="cabtype">
                <span class="cabtag">'.$blvalue['trip_type'].'</span>
                <span class="picktext">Pickup: '.$blvalue['pickup_city_name'].'</span>
              </div>
              <p class="drivrname">Driver name - '.$blvalue['driver_name'].' ('.$blvalue['vehicle_no'].')</p>
            </div>
            <div class="bkng_time">
              <h5>'.$blvalue['pickup_time'].'</h5> 
            </div>
            <div class="bkng_time">
              <a href="javascript:void(0)" onclick="return getBookingDetails('.$blvalue['id'].')" class="sitebtn">View</a>
            </div>
          </div>';
          
           }}else{
               $html = '<div class="d-flex justify-content-center align-items-center fs-3 fw-medium mt-5">No Record Found</div>';
           }
           $response = ['html'=>$html,'booking_count'=>$booking_count];
           echo json_encode($response);exit;
    }
}
