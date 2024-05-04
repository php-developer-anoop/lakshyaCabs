<?php
namespace App\Controllers\Api\V1\Customer;
use App\Controllers\BaseController;
use App\Models\Common_model;
use App\Libraries\BookingSystemLib;


class BookingSystem extends BaseController {
    
    public $c_model;
    public $cab_search_lib;
    
    public function __construct() {
        $this->c_model = new Common_model();
        $this->cab_search_lib = new BookingSystemLib();
        header("Content-Type:application/json");
    }
    
    
    public function search() {
        
        $response = [];
        $data = [];
        $post = pay_load(); 
        
        $lib_response = $this->cab_search_lib->searchCab( $post );
        return $lib_response; exit;
    }
    
    
    
    public function createBooking() {
        
        $response = [];
        $data = [];
        $post = pay_load(); 
         
        
        $user_id = !empty($post['user_id']) ? trim($post['user_id']) : '';
        $fare_id = !empty($post['fare_id']) ? trim($post['fare_id']) : '';
        $trip_type = !empty($post['trip_type']) ? trim($post['trip_type']) : '';
        $trip_mode = !empty($post['trip_mode']) ? trim($post['trip_mode']) : '';
        $package_name = !empty($post['package_name']) ? trim($post['package_name']) : '';
        $pickup_city = !empty($post['pickup_city']) ? trim($post['pickup_city']) : '';
        $drop_city = !empty($post['drop_city']) ? trim($post['drop_city']) : '';
        
        $coupon_code = !empty($post['coupon_code']) ? trim($post['coupon_code']) : ''; 
        
        $email_id  = !empty($post['email_id']) ? trim($post['email_id']) : '';
        $full_name  = !empty($post['full_name']) ? trim($post['full_name']) : '';
        $phone_no  = !empty($post['phone_no']) ? trim($post['phone_no']) : '';
        $gst_in  = !empty($post['gst_in']) ? trim($post['gst_in']) : '';
        $company_name = !empty($post['company_name']) ? trim($post['company_name']) : '';
        $no_of_passengers  = !empty($post['no_of_passenger']) ? trim($post['no_of_passenger']) : 0;
        
        $pickup_address  = !empty($post['pickup_address']) ? trim($post['pickup_address']) : '';
        $drop_address = !empty($post['drop_address']) ? trim($post['drop_address']) : '';
        
        $pickup_date_time  = !empty($post['pickup_date_time']) ? trim($post['pickup_date_time']) : '';
        $drop_date_time  = !empty($post['drop_date_time']) ? trim($post['drop_date_time']) : '';
        
        $payment_mode  = !empty($post['payment_mode']) ? trim($post['payment_mode']) : '';
        $booking_amount  = !empty($post['booking_amount']) ? trim($post['booking_amount']) : 0;
        $is_wallet_enable  = !empty($post['is_wallet_enable']) ? trim($post['is_wallet_enable']) : '';
        $gst_percentage  = !empty($post['gst_percentage']) ? trim($post['gst_percentage']) : '';
        $gst_amount_on_total_trip_amount  = !empty($post['gst_amount_on_total_trip_amount']) ? trim($post['gst_amount_on_total_trip_amount']) : 0;
        
        $estimated_kms  = !empty($post['estimated_kms']) ? trim($post['estimated_kms']) : ''; 
         
        $total_trip_amount  = !empty($post['total_trip_amount']) ? trim($post['total_trip_amount']) : '';
        $total_trip_amount_with_gst  = !empty($post['total_trip_amount_with_gst']) ? trim($post['total_trip_amount_with_gst']) : '';
        $travels_days  = !empty($post['travels_days']) ? trim($post['travels_days']) : '';
        $travels_time_minutes  = !empty($post['travels_time_minutes']) ? trim($post['travels_time_minutes']) : '';
        $travels_time_text  = !empty($post['travels_time_text']) ? trim($post['travels_time_text']) : '';
        $waypoints  = !empty($post['waypoints']) ? trim($post['waypoints']) : ''; 
        
        if($user_id){
            if (empty($user_id)) {
                $response['status'] = FALSE;
                $response['message'] = 'User ID is blank!';
                echo json_encode($response); exit;
            }
            else if (empty($fare_id)) {
                $response['status'] = FALSE;
                $response['message'] = 'Fare ID is blank!';
                echo json_encode($response);  exit;
            }
            else if (empty($trip_type)) {
                $response['status'] = FALSE;
                $response['message'] = 'Trip Type is blank!';
                echo json_encode($response); exit;
            }
            else if (empty($full_name)) {
                $response['status'] = FALSE;
                $response['message'] = 'Full Name is blank!';
                echo json_encode($response); exit;
            }
            else if (empty($phone_no)) {
                $response['status'] = FALSE;
                $response['message'] = 'Mobile No is blank!';
                echo json_encode($response); exit;
            }
            else if (empty($email_id)) {
                $response['status'] = FALSE;
                $response['message'] = 'Email ID is blank!';
                echo json_encode($response); exit;
            }
            else if (empty($no_of_passengers)) {
                $response['status'] = FALSE;
                $response['message'] = 'No of Passenger are blank!';
                echo json_encode($response); exit;
            }
            else if (empty($pickup_date_time)) {
                $response['status'] = FALSE;
                $response['message'] = 'Pickup Date is blank!';
                echo json_encode($response); exit;
            }
            else if (empty($payment_mode) || !in_array($payment_mode,['cash','advance','full'])) {
                $response['status'] = FALSE;
                $response['message'] = 'Payment Mode is blank or Invalid!';
                echo json_encode($response); exit;
            }
            
            
            $fareWhere = [];
            $fareWhere['f.id'] = $fare_id;
            $fareWhere['f.trip_type'] = $trip_type;
            $fareTable = 'dt_fare_configuration as f';
            $joinFareArray = [];
            $joinFareArray[0]['table'] = 'dt_vehicle_model as md';
            $joinFareArray[0]['join_on'] = 'f.model_id = md.id';
            $joinFareArray[0]['join_type'] = 'left';
            
            $selectFareKeys = 'f.*, md.category_id,md.category_name,md.model_name,md.seat_segment,md.fuel_type, md.luggage, md.ac_or_non_ac,md.water_bottle,md.carrier,md.jpg_image,md.webp_image,md.image_alt, md.total_ratings,md.star_rating ';
            $getAllFareData = $this->c_model->getBulkRecords( $fareTable, $fareWhere, $selectFareKeys ,'get',null,null,null,null, $joinFareArray  );
            
            if(empty($getAllFareData)){
                $response['status'] = FALSE;
                $response['message'] = 'Fare Table ID mis-matched!';
                echo json_encode($response); exit;
            }
            
            $getAllFareData = $getAllFareData[0]; 
            
            
            //Fet coupon Discount And Verify 
            $discountAmount = 0;
            if(!empty($coupon_code)){
                $discountAmount = $this->applyCoupon( $trip_type, $total_trip_amount_with_gst, $coupon_code );
            }
        }
        
        
        //check user data
        $userWhere = [];
        $userWhere['id'] = $user_id;
        $userKeys = 'id, wallet_balance ';
        $userData = $this->c_model->getSingle('dt_customer_list', $userKeys, $userWhere );
        
        
        $bookSave = [];
        $bookSave['user_id'] = $user_id;
        $bookSave['guest_name'] = $full_name;
        $bookSave['guest_mobile_no'] = $phone_no;
        $bookSave['guest_alt_mobile_no'] = '';
        $bookSave['guest_email_id'] = $email_id;
        $bookSave['no_of_passengers'] = $no_of_passengers;
        
        $bookSave['pickup_city_name'] = $pickup_city;
        $bookSave['pickup_city_id'] = $getAllFareData['pickup_city_id'];
        $bookSave['pickup_state_id'] = $getAllFareData['pickup_state_id'];
        $bookSave['drop_city_name'] = $drop_city;
        $bookSave['drop_city_id'] = $getAllFareData['drop_city_id'];
        $bookSave['drop_state_id'] = $getAllFareData['drop_state_id'];
        $bookSave['via_routes'] = $waypoints;
        
        $bookSave['trip_type'] = $trip_type; 
        $bookSave['trip_mode'] = $trip_mode;
        $bookSave['package_name'] = $package_name;
        
        $bookSave['pickup_date_time'] = date('Y-m-d H:i:s',strtotime($pickup_date_time));
        $bookSave['created_date'] = date('Y-m-d H:i:s');
        $bookSave['drop_date_time'] = $trip_type =='Outstation' ? date('Y-m-d H:i:s',strtotime($drop_date_time)) : $bookSave['pickup_date_time'];
        
        
        $bookSave['base_fare'] = $getAllFareData['base_fare'];
        $bookSave['base_covered_km'] = $getAllFareData['base_covered_km'];
        $bookSave['covered_hours'] = $getAllFareData['covered_hours'];
        $bookSave['per_minute_charge'] = $getAllFareData['per_minute_charge'];
        $bookSave['per_hour_charge'] = $getAllFareData['per_hour_charge'];
        $bookSave['per_km_charge'] = $getAllFareData['per_km_charge'];
        $bookSave['night_charge'] = $getAllFareData['night_charge'];
        $bookSave['total_nights'] = 0;
        $bookSave['total_night_charge'] = 0;
        $bookSave['driver_charge'] = $getAllFareData['driver_charge'];
        $bookSave['total_driver_days'] = (float)$travels_days;
        $bookSave['payment_mode'] = $payment_mode;
        $bookSave['estimated_km'] = (float)$estimated_kms;
        $bookSave['total_trip_amount'] = (float)$total_trip_amount;
        $bookSave['gst_percentage'] = (float)$gst_percentage; 
        $bookSave['gst_amount_on_total_trip_amount'] = (float)$gst_amount_on_total_trip_amount;
        $bookSave['total_trip_amount_with_gst'] = (float)$total_trip_amount_with_gst;  
        $bookSave['discount'] = $discountAmount > 0 ? $discountAmount : 0;
        $bookSave['final_amount'] = (float)$bookSave['total_trip_amount_with_gst'] - (float)$bookSave['discount'];
        if( $payment_mode == 'full' ){
            $booking_amount = $bookSave['final_amount'];
        }
        $bookSave['booking_amount'] = (float)$booking_amount;
        $bookSave['rest_amount'] = (float)$bookSave['final_amount'] - (float)$booking_amount; 
        
        $bookSave['coupon_code'] = $discountAmount > 0 ? $coupon_code : '';
        $bookSave['travels_time_minutes'] = $travels_time_minutes;
        $bookSave['travels_time_text'] = $travels_time_text;
        $bookSave['model_name'] = $getAllFareData['model_name'];
        $bookSave['model_id'] = $getAllFareData['model_id'];
        $bookSave['category_name'] = $getAllFareData['category_name'];
        $bookSave['category_id'] = $getAllFareData['category_id'];
        $bookSave['booking_status'] = 'temp';
        
        $booking_status = $bookSave['booking_status'];
        $pending_amount = 0;
        
        
        //insert booking Record
        $insertID = $this->c_model->insertRecords('dt_bookings', $bookSave );
        
        if(empty($insertID)){
            $response['status'] = FALSE;
            $response['message'] = 'Some Error Occured';
            echo json_encode($response); exit;
        }
        
        //generate booking ID
        $bookingId = generateBookingNumber( $insertID ); 
        
        
        $updateData = [];
        $updateData['booking_id'] = $bookingId;
        $pending_amount = 0;
        //check wallet balance
        if( $is_wallet_enable && $userData && in_array($payment_mode,['advance','full']) ){ 
            $wallet_balance = (int) $userData['wallet_balance'];
            if( (float)$wallet_balance > $booking_amount ){
               $finalamount = $this->deductWalletAmount($user_id,$wallet_balance, $booking_amount, $bookingId ,'N/A','Deduction Against Booking'); 
               $updateData['booking_status'] = 'new'; 
               $booking_status = 'new'; 
            }else if( (float)$wallet_balance < $booking_amount ){
                $pending_amount = (float)$booking_amount - (float)$wallet_balance;
            }
        }else if( in_array($payment_mode,['advance','full']) ){
            $pending_amount = (float)$booking_amount;
        }else{
            $updateData['booking_status'] = 'new';
            $booking_status = 'new'; 
        }
        
        
        //update booking ID 
        $this->c_model->updateRecords( 'dt_bookings',$updateData, ['id'=>$insertID] );  
        
        $response = [];
        $response['status'] = true;
        $response['data'] = ['booking_table_id' => (string)$insertID,'user_id'=>$user_id, 'order_id' => $bookingId,'status'=>$booking_status,'pending_amount'=>(int)($pending_amount) ];
        $response['message'] = "Booking Initiated! ";
        echo json_encode($response);exit;
    }
    
    
    
    public function confirmBooking(){
        $response = [];
        $data = [];
        $post = pay_load();  
        
        
        $user_id = !empty($post['user_id']) ? trim($post['user_id']) : '';
        $booking_table_id = !empty($post['booking_table_id']) ? trim($post['booking_table_id']) : ''; 
        
        //check user data
        $userWhere = [];
        $userWhere['id'] = $user_id;
        $userKeys = 'id, wallet_balance ';
        $userData = $this->c_model->getSingle('dt_customer_list', $userKeys, $userWhere );
        
        $bookingData = $this->c_model->getSingle('dt_bookings', 'booking_status,booking_amount,booking_id', ['id'=>$booking_table_id] );
        
        if(empty($bookingData)){
            $response['status'] = FALSE;
            $response['message'] = 'No Record Found';
            echo json_encode($response); exit;
        }
        
        $booking_amount = $bookingData['booking_amount'];
        $booking_status = $bookingData['booking_status'];
        $booking_id = $bookingData['booking_id'];
        
        if( $booking_status != 'temp' ){
            $response['status'] = FALSE;
            $response['message'] = 'Invalid Booking Status';
            echo json_encode($response); exit;
        }
        
        $wallet_balance = (float) $userData['wallet_balance'];
        
        if( ((float)$wallet_balance < (float)$booking_amount) ){
            $response['status'] = FALSE;
            $response['message'] = 'No sufficient wallet balance to complete this booking';
            echo json_encode($response); exit;
        }
        
        if( ((float)$wallet_balance >= (float)$booking_amount) ){
           $finalamount = $this->deductWalletAmount($user_id,$wallet_balance, $booking_amount, $booking_id ,'N/A','Deduction Against Booking'); 
           $updateData = [];
           $updateData['booking_status'] = 'new'; 
           $this->c_model->updateRecords( 'dt_bookings',$updateData, ['id'=>$booking_table_id] );
        }
        
        
        $response['status'] = true;
        $response['data'] = $booking_id;
        $response['message'] = 'Booking Confirmed';
        echo json_encode($response); exit;
        
    } 
    
    
    
    
    protected function deductWalletAmount($user_id, $wallet_balance, $order_amount, $order_id, $txn_id, $remark ) {
        
        $finalamount = (float)$wallet_balance - (float)$order_amount;
        /***************  wallet refill start here  *********************/
        $wt = [];
        $wt['user_id'] = $user_id;
        $wt['transaction_id'] = $txn_id;
        $wt['credit_debit'] = 'debit';
        $wt['created_date'] = date('Y-m-d H:i:s');
        $wt['remark'] = $remark;
        $wt['reference_id'] = $order_id;
        $wt['before_amount'] = $wallet_balance;
        $wt['txn_amount'] = $order_amount;
        $wt['final_amount'] = $finalamount;

        $check = []; 
        $update = $this->c_model->saveupdate('dt_wallet', $wt );
        if (!empty($update)) {
           $this->c_model->updateRecords('dt_customer_list',['wallet_balance'=>$finalamount],['id'=>$user_id]);
        }
        /***************  wallet refill end here  *********************/
        return $finalamount;
    }
    
    /*Apply coupon Discount Method */
    protected function applyCoupon( $trip_type, $trip_amount, $coupon_code ){
        
        $where = [];
        $where['trip_type'] = $trip_type;
        $where['minimum_cart_value <='] = $trip_amount;
        $where['coupon_code'] = $coupon_code; 
        
        $where['DATE(valid_from) <='] = date('Y-m-d');
        $where['DATE(valid_till) >='] = date('Y-m-d');
        
        $getData = $this->c_model->getSingle('dt_coupon_list', '*', $where  ); 
        
        $discount = 0; 
            
        if( !empty($getData) && ($getData['coupon_code'] == 'percent') ){ 
             $discount = percentValue( $trip_amount, $getData['coupon_value'] );
             if( (int)$discount > (int)$getData['maximum_discount']){
                $discount = $getData['maximum_discount'];
             }
        }else if(!empty($getData)){
            $discount = $getData['coupon_value']; 
        }
           
        return $discount;  
    }
}
?>