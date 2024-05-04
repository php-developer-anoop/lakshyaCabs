<?php
namespace App\Controllers\Frontend;
use App\Controllers\BaseController;
use App\Models\Common_model;


class CabBooking extends BaseController {
    
    public $c_model;
    public $session;
    
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    
    public function index() {
        
        $data = [];
        $data['error_message'] = '';
        $post = $this->request->getVar(); 
        
        if(empty($post['trip_type'])){
            return redirect()->to( base_url() )->with('error','Inavlid Trip Type');
        }
        
        $data = $post;
        
        $pickup_date_time = !empty($post['pickup_date']) ? $post['pickup_date'] : '';
        $pickup_date_time .= !empty($post['pickup_time']) ? ' '.$post['pickup_time'] : '';
        
        $postUrl = base_url('api/v1/customer/search_cab'); 
        $headers = array('API-TOKEN:'.md5(md5(1234589785)) );
        
        $postData = []; 
        $postData['trip_type'] = !empty($post['trip_type']) ? $post['trip_type'] : ''; 
        $postData['trip_mode'] = !empty($post['trip_mode']) ? $post['trip_mode'] : '';
        $postData['pickup_city'] = !empty($post['pickup']) ? $post['pickup'] : '';
        $postData['drop_city'] = !empty($post['drop']) ? $post['drop'] : '';
        $postData['route_list'] = '';
        if( in_array($postData['trip_type'],['Outstation']) ){
            if( !empty($post['destination']) ){
                $route = $postData['pickup_city'].'|'.$postData['drop_city'].'|'.implode( '|',$post['destination']);
            }else{
                $route = $postData['pickup_city'].'|'.$postData['drop_city'];
            }
        $postData['route_list'] = $route;
        }
        $postData['pickup_date_time'] = $pickup_date_time;
        $postData['return_date_time'] = !empty($post['return_date']) ? $post['return_date'] : '';
        $postData['local_package'] = !empty($post['package_id']) ? $post['package_id'] : ''; 
         
        $apiResult = curlApisFun($postUrl,'POST', $postData , $headers , 30 ); 
        
        $data['meta_title'] = '';
        $data['meta_description'] = ''; 
        $data['meta_keyword'] = '';
        $data['list'] = !empty($apiResult['status']) ? $apiResult['data'] : []; 
        $data['search_payload'] = !empty($apiResult['status']) ? $apiResult['payload'] : []; 
        $data['error_message'] = empty($apiResult['status']) ? $apiResult['message'] : '';
        $data['seat_segment'] = 7;
        
        $userLoginDetails = $this->session->get('user_login_data');
        $data['is_logged_in'] = !empty($userLoginDetails) ? true : false;
        
        frontview('cab-list', $data);
    } 
    
    
    public function fareSummary() { 
        
        $html = ''; 
        $post = $this->request->getVar(); 
        
        $converedKms = $post['estimated_kms'];
        $estimatedFare = $post['total_trip_amount'];
        $gstPercentage = $post['gst_percentage'];
        $gstAmount = $post['gst_amount_on_total_trip_amount'];
        $totalAmount = $post['total_trip_amount_with_gst'];
        $perKmCharge = $post['per_km_charge'];
        $tripType = $post['trip_type'];
        $inclusions = $post['inclusions'];
        $exclusions = $post['exclusions'];
        
        $html .= '<div class="row fare-area">
          <div class="col-12 col-lg-12 col-md-12" id="loadfare">
            <div class="">
              <h4> <img src="'.getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') ).'"> Fare Breakup: </h4>
              <h5>Estimated  Amount   <span> ₹ '.$estimatedFare.' </span></h5>
              <h5>Covered Kms   <span>   Km(s) '.$converedKms.' </span></h5>
              <h5>GST ('.$gstPercentage.'%) <span> ₹  '.$gstAmount.'</span></h5>
              <h5>Total Cost  <span> ₹ '.$totalAmount.' </span></h5>
              <h4><img src="'.getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') ).'">Additional Charges ( If any ):</h4>
              <ul class="olclas">
                <li>Usable '.$tripType.' Limit '.$converedKms.' Km(s)</li>
                <li>After '.$converedKms.' Km(s) Extra Charges ₹. '.$perKmCharge.' Per KM</li>
              </ul>
            </div>
          </div>
        </div>
        
        <div class="row fare-area">
          <div class="col-lg-12">
            <h4 class="notesclas"><img src="'.getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') ).'">Inclusion :</h4>
            <ul>';
            
            if(!empty($inclusions)){
               $inclusionsList = generateCommaToArrayWithTwoItems( $inclusions ); 
               if(!empty($inclusionsList)){
                   foreach($inclusionsList as $row ){
                       $html .= '<li>'.$row.'</li>';
                   }
               }
            }
            
            $html .= ' 
            </ul>
            <h4 class="notesclas"><img src="'.getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') ).'">Exclusion :</h4>
            <ul>';
            
            if(!empty($exclusions)){
               $exclusionsList = generateCommaToArrayWithTwoItems( $exclusions ); 
               if(!empty($exclusionsList)){
                   foreach($exclusionsList as $row ){
                       $html .= '<li>'.$row.'</li>';
                   }
               }
            } 
            
            $html .= '</ul>
            <h4 class="notesclas"><img src="'.getImagePathUrl( base_url('assets/images/check.png'), base_url('assets/images/check.webp') ).'">Notes :</h4>
            <ul>
              <li>
                Kms &amp; Timing will be charged from customer location
              </li>
              <li>
                Car shall not be used for local use in '.$post['pickup_city_name'].' after completion of one way duty.
              </li>
              <li>
                In case of Booking wil be Cancelled then infrom to us before 24 Hrs in then Pickup Time
              </li>';
             if(!empty($exclusions)){
                  $html .= ' <li> '.$exclusions.' are excluded.</li>';
             }
             
             $html .= ' <li>
                Night Charge ₹ '.$post['night_charge'].' Applicable from  '.date('h:i A',strtotime($post['night_charge_from'])).' to '.date('h:i A',strtotime($post['night_charge_till'])).';
              </li>
            </ul>
          </div>
        </div>'; 
        
       echo $html; 
    }
    
  
    public function saveBookingSearchData(){
        $post = $this->request->getVar();
        $this->session->set( 'storeobjectdata', json_encode($post) );
    }
    
    
    public function bookingDetails(){ 
        
        $data = []; 
        
        $bookingData = $this->session->get( 'storeobjectdata');
        if(empty($bookingData)){
            return redirect()->to( base_url('') ); 
        }
        
        $bookingData = json_decode($bookingData, true ); 
        
        $data['title'] = '';
        $data['meta_title'] = '';
        $data['meta_description'] = '';
        $data['meta_keyword'] = ''; 
        $data['list'] = $bookingData;
        
        //check user login status
        $userLoginDetails = $this->session->get('user_login_data');
        $data['is_logged_in'] = !empty($userLoginDetails) ? true : false;
        $data['wallet_balance'] =  0;
        $data['name'] =  '';
        $data['email'] =  '';
        $data['mobile_no'] =  '';
        $data['company_name'] =  '';
        $data['company_pan_number'] =  '';
        $data['gstin_number'] =  '';
        $data['pickup_address'] =  '';
        
        if(!empty($data['is_logged_in'])){
             $profileData = $this->c_model->getSingle('dt_customer_list','*', ['id'=>$userLoginDetails['id']]); 
             if(!empty($profileData)){
                $data['name'] =  $profileData['name'];
                $data['email'] =  $profileData['email'];
                $data['mobile_no'] =  $profileData['mobile_no'];
                $data['company_name'] =  $profileData['company_name'];
                $data['company_pan_number'] =  $profileData['company_pan_number'];
                $data['gstin_number'] = $profileData['gstin_number'];
                $data['pickup_address'] = $profileData['address'];
                $data['wallet_balance'] = $profileData['wallet_balance'];
             }
        }
        
        //echo '<pre>';
        //print_r($bookingData); exit;
     
        
        //get Coupon List
        $postUrl = base_url('api/v1/customer/coupon_list'); 
        $headers = array('API-TOKEN:'.md5(md5(1234589785)) );
        
        $cpnPostData = []; 
        $cpnPostData['user_id'] = !empty($post['user_id']) ? $post['user_id'] : '';
        $cpnPostData['trip_type'] = !empty($bookingData['trip_type']) ? $bookingData['trip_type'] : '';  
        $cpnPostData['city_id'] = !empty($bookingData['pickup_city_id']) ? $bookingData['pickup_city_id'] : '';
        $cpnPostData['state_id'] = !empty($bookingData['pickup_state_id']) ? $bookingData['pickup_state_id'] : ''; 
        $cpnPostData['trip_amount'] = !empty($bookingData['total_trip_amount_with_gst']) ? $bookingData['total_trip_amount_with_gst'] : ''; 
         
        // echo $postUrl;
        // echo json_encode( $cpnPostData ); exit;
        $couponList = curlApisFun($postUrl,'POST', $cpnPostData , $headers , 30 );
        $data['coupon_list'] = !empty($couponList['status']) ? $couponList['data'] : [];
        $data['booking_id'] = !empty($this->request->getVar('odr')) ? $this->request->getVar('odr') : '';
        
        //echo '<pre>';
        //print_r( $couponList ); exit;
        
        frontview('booking-details', $data); 
        
    }
    
    
    public function applyCoupon(){
        
       $response = [];
       $post = $this->request->getVar();
       $bookingData = $this->session->get( 'storeobjectdata'); 
       $bookingData = !empty($bookingData) ? json_decode($bookingData, true ) : []; 
       
       
       if(empty($post) || empty($post['coupon_code'])){
           $response['status'] = false;
           $response['message'] = 'Invalid Coupon Code';
           echo json_encode($response); exit;
       }
       else if(empty($bookingData)){
           $response['status'] = false;
           $response['message'] = 'Invalid Coupon Code';
           echo json_encode($response); exit;
       } 
       
       
        //get Coupon List
        $postUrl = base_url('api/v1/customer/apply_coupon'); 
        $headers = array('API-TOKEN:'.md5(md5(1234589785)) );
        
        $cpnPostData = []; 
        $cpnPostData['user_id'] = !empty($post['user_id']) ? $post['user_id'] : '';
        $cpnPostData['trip_type'] = !empty($bookingData['trip_type']) ? $bookingData['trip_type'] : '';  
        $cpnPostData['coupon_code'] = $post['coupon_code'];  
        $cpnPostData['trip_amount'] = !empty($bookingData['total_trip_amount_with_gst']) ? $bookingData['total_trip_amount_with_gst'] : ''; 
         
        
        $apiResponse = curlApisFun($postUrl,'POST', $cpnPostData , $headers , 30 );
         
        echo json_encode($apiResponse); exit;
       
    }
    
    
    public function createBooking(){
         $post = $this->request->getVar();
         
        $userLoginDetails = $this->session->get('user_login_data');
        $bookingData = $this->session->get( 'storeobjectdata');
        if(empty($bookingData)){
            return redirect()->to( base_url('') ); 
        } 
        $bookingData = json_decode($bookingData, true ); 
        
        //echo '<pre>';
        //print_r($bookingData); exit;
         
        $payLoad = [];
        $payLoad = $post;
        $payLoad['user_id'] = $userLoginDetails['id'];
        $payLoad['fare_id'] = $bookingData['id']; 
        $payLoad['trip_type'] = $bookingData['trip_type']; 
        $payLoad['travels_days'] = $bookingData['travels_days'];
        $payLoad['travels_time_minutes'] = $bookingData['travels_time_minutes'];
        $payLoad['travels_time_text'] = $bookingData['travels_time_text'];
        $payLoad['pickup_date_time'] = $bookingData['pickup_date_time'];
        $payLoad['drop_date_time'] = $bookingData['pickup_date_time'];
        $payLoad['estimated_kms'] = $bookingData['estimated_kms'];
        $payLoad['total_trip_amount'] = $bookingData['total_trip_amount'];
        
        $payLoad['gst_percentage'] = $bookingData['gst_percentage'];
        $payLoad['gst_amount_on_total_trip_amount'] = $bookingData['gst_amount_on_total_trip_amount'];
        $payLoad['total_trip_amount_with_gst'] = $bookingData['total_trip_amount_with_gst'];
        $payLoad['waypoints'] = $bookingData['waypoints'];
        
        //echo json_encode( $payLoad ); exit;
        
        $postUrl = base_url('api/v1/customer/create_booking'); 
        $headers = array('API-TOKEN:'.md5(md5(1234589785)) ); 
        $bookingResponse = curlApisFun($postUrl,'POST', $payLoad , $headers , 30 );
        echo json_encode( $bookingResponse ); exit;
    }
    
    
    /**************  confirm booking  *****************/
    public function confirmBooking(){
        
        $response = [];
        $response['status'] = false;
        $response['message'] = 'Some Error Occured';
        
        if(!$this->request->isAjax()){
            return redirect()->to( base_url('') ); 
        }
        
        $post = $this->request->getVar(); 
        
        $order_id = !empty($post['order_id']) ? base64_decode($post['order_id']) : '';
        if(empty($order_id)){
            echo json_encode( $response );exit;
        } 
        
        //check user login session also
        $userLoginDetails = $this->session->get('user_login_data'); 
        if(empty($userLoginDetails)){
            echo json_encode( $response );exit;
        } 
        
        $bookingData = $this->c_model->getSingle('dt_bookings','id,booking_status',['booking_id'=>$order_id] );
        if(empty($bookingData)){
             echo json_encode( $response );exit;
        }
        
        //check booking status
        if( $bookingData['booking_status'] != 'temp' ){
             echo json_encode( $response ); exit;
        }
         
          
        $payLoad = [];
        $payLoad['user_id'] = $userLoginDetails['id'];
        $payLoad['booking_table_id'] = $bookingData['id'];
        
        $postUrl = base_url('api/v1/customer/confirm_booking');  
        $headers = array('API-TOKEN:'.md5(md5(1234589785)) ); 
        $bookingResponse = curlApisFun($postUrl,'POST', $payLoad , $headers , 30 );
        
        /* Below code commented becuse we need to delete all stored session to escape tempring data*/
        //if(!empty($bookingResponse['status'])){
           //$this->session->destroy('storeobjectdata'); 
        //}
        echo json_encode( $bookingResponse ); exit;
    }
     
}