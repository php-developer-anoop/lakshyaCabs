<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;
use App\Models\Common_model;
class BookingList extends BaseController {
    public $c_model;
    public $session;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
    }
    public function itemsList() {
        $get = $this->request->getVar();
        $data = [];
        $data['title'] = 'My Bookings';
        $data['meta_title'] = 'My Bookings';
        $data['meta_keyword'] = 'My Bookings';
        $data['meta_description'] = 'My Bookings';
        $data['userprofile'] = getUserProfile();
        $userLoginDetails = $this->session->get('user_login_data');
        $apiPayload = [];
        $apiPayload['user_id'] = $userLoginDetails['id'];
        $apiPayload['page_no'] = !empty($get['page_no']) ? $get['page_no'] : 1;
        $apiPayload['from_date'] = '';
        $apiPayload['to_date'] = '';
        $postUrl = base_url('api/v1/customer/booking_list');
        $headers = array('API-TOKEN:' . md5(md5(1234589785)));
        $apiResult = curlApisFun($postUrl, 'POST', $apiPayload, $headers, 30);
        //print_r($apiResult); exit;
        $data['list'] = !empty($apiResult['status']) ? $apiResult['data'] : [];
        return userview('my-bookings', $data);
    }
    public function rateUs(){
        $post= $this->request->getVar();
        
        $booking_id = !empty($post['booking_id'])?trim($post['booking_id']):'';
        $partner_id = !empty($post['partner_id'])?trim($post['partner_id']):'';
        $customer_id = !empty($post['customer_id'])?trim($post['customer_id']):'';
        $customer_name = !empty($post['customer_name'])?trim($post['customer_name']):'';
        $ratings = !empty($post['ratings'])?trim($post['ratings']):'';
        $description = !empty($post['description'])?trim($post['description']):'';
        
        $saveData = [];
        $saveData['booking_id']=$booking_id;
        $saveData['partner_id']=$partner_id;
        $saveData['customer_id']=$customer_id;
        $saveData['customer_name']=$customer_name;
        $saveData['rating']=$ratings;
        $saveData['description']=$description;
        $saveData['add_date']=date('Y-m-d H:i:s');
        $last_id= $this->c_model->insertRecords('ratings_list',$saveData);
        $this->c_model->updateRecords('bookings',['is_rated'=>'yes'],['booking_id'=>$booking_id]);
        if($last_id){
            $response = ['status'=>true,'message'=>'Review Saved Successfully'];
            echo json_encode($response);exit;
        }
        $response = ['status'=>false,'message'=>'Something Went Wrong'];
            echo json_encode($response);exit;
    }
}
?>