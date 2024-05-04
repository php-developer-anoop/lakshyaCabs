<?php
namespace App\Controllers\Api\V1\Customer;
use App\Controllers\BaseController;
use App\Models\Common_model;

class CouponList extends BaseController {
    
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
        //header('Content-Type:application/json');
    }
    
    public function index() {
        
        $response = [];
        $data = [];
        $post = pay_load(); 
        
        $user_id = !empty($post['user_id']) ? trim($post['user_id']) : '';
        $trip_type = !empty($post['trip_type']) ? trim($post['trip_type']) : '';
        $city_id = !empty($post['city_id']) ? trim($post['city_id']) : 0;
        $state_id = !empty($post['state_id']) ? trim($post['state_id']) : 0;
        $trip_amount = !empty($post['trip_amount']) ? trim($post['trip_amount']) : 0;
        
        if(empty($trip_type)){
            $response['status'] = false;
            $response['message'] = 'Trip Type is blank!';
            echo json_encode($response);exit;
        }
        else if(empty($state_id)){
            $response['status'] = false;
            $response['message'] = 'State ID is blank!';
            echo json_encode($response);exit;
        }
        else if(empty($trip_amount)){
            $response['status'] = false;
            $response['message'] = 'Trip Amount is blank!';
            echo json_encode($response);exit;
        }
        
        
        $where = [];
        $where['trip_type'] = $trip_type;
        $where['minimum_cart_value <='] = $trip_amount;
        $where['state_id'] = $state_id;
        if(!empty($city_id)){
        $where['city_id'] = $city_id;
        }
        
        $where['DATE(valid_from) <='] = date('Y-m-d');
        $where['DATE(valid_till) >='] = date('Y-m-d');
        
        $getData = $this->c_model->getBulkRecords('dt_coupon_list', $where, '*' ,'get' );
        
        //echo db()->getLastQuery();
        
        if(empty($getData)){
            $response['status'] = false;
            $response['message'] = 'No Coupon(s) Available!';
            echo json_encode($response);exit;
        }
        
        
        $couponList = [];
        foreach($getData as $key=>$value ){
            $push = [];
            $push['id'] = $value['id'];
            $push['coupon_code'] = $value['coupon_code'];
            $push['title_name']  = $value['title_name'];
            $push['description'] = $value['description'];
            if( $value['coupon_code'] == 'percent'){ 
                 $discount = percentValue( $trip_amount, $value['coupon_value'] );
                 if( (int)$discount > (int)$value['maximum_discount']){
                    $push['discount_amount'] = $value['maximum_discount'];
                 }else{
                   $push['discount_amount'] = $discount;  
                 } 
            }else{
               $push['discount_amount'] = $value['coupon_value']; 
            }
            
            array_push( $couponList, $push );
            
        }
        
        $response['status'] = true;
        $response['data'] = $couponList;
        $response['message'] = 'API Accessed Successfully!';
        echo json_encode($response);exit; 
        
    }
    
    
    public function applyCoupon() {
        
        $response = [];
        $data = [];
        $post = pay_load(); 
        
        $user_id = !empty($post['user_id']) ? trim($post['user_id']) : '';
        $trip_type = !empty($post['trip_type']) ? trim($post['trip_type']) : '';
        $coupon_code = !empty($post['coupon_code']) ? trim($post['coupon_code']) : '';
        $trip_amount = !empty($post['trip_amount']) ? trim($post['trip_amount']) : 0;
        
        if(empty($trip_type)){
            $response['status'] = false;
            $response['message'] = 'Trip Type is blank!';
            echo json_encode($response);exit;
        }
        else if(empty($coupon_code)){
            $response['status'] = false;
            $response['message'] = 'Coupon Code is blank!';
            echo json_encode($response);exit;
        }
        else if(empty($trip_amount)){
            $response['status'] = false;
            $response['message'] = 'Trip Amount is blank!';
            echo json_encode($response);exit;
        }
        
        
        $where = [];
        $where['trip_type'] = $trip_type;
        $where['minimum_cart_value <='] = $trip_amount;
        $where['coupon_code'] = $coupon_code; 
        
        $where['DATE(valid_from) <='] = date('Y-m-d');
        $where['DATE(valid_till) >='] = date('Y-m-d');
        
        $getData = $this->c_model->getSingle('dt_coupon_list', '*', $where  ); 
       
        
        if(empty($getData)){
            $response['status'] = false;
            $response['message'] = 'No Coupon(s) Available!';
            echo json_encode($response);exit;
        }
        
        
        $couponList = [];
         
            $push = [];
            $push['id'] = $getData['id'];
            $push['coupon_code'] = $getData['coupon_code'];
            $push['trip_amount'] = $trip_amount;
            if( $getData['coupon_code'] == 'percent'){ 
                 $discount = percentValue( $trip_amount, $getData['coupon_value'] );
                 if( (int)$discount > (int)$getData['maximum_discount']){
                    $push['discount_amount'] = $getData['maximum_discount'];
                 }else{
                   $push['discount_amount'] = $discount;  
                 } 
            }else{
               $push['discount_amount'] = $getData['coupon_value']; 
            }
            
            
        
        $response['status'] = true;
        $response['data'] = $push;
        $response['message'] = 'API Accessed Successfully!';
        echo json_encode($response);exit; 
        
    }
    
}
?>