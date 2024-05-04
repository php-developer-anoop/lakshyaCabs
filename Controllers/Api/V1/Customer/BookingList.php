<?php
namespace App\Controllers\Api\V1\Customer;
use App\Controllers\BaseController;
use App\Models\Common_model;
class BookingList extends BaseController {
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
        header('Content-Type:application/json');
        
    }
    public function index() {
        $response = [];
        $data = [];
        $post = pay_load();
        $user_id = !empty($post['user_id']) ? $post['user_id'] : '';
        $page_no = !empty($post['page_no']) ? $post['page_no'] : '';
        $from_date = !empty($post['from_date']) ? $post['from_date'] : '';
        $to_date = !empty($post['to_date']) ? $post['to_date'] : '';
        $is_count = !empty($post['is_count']) ? $post['is_count'] : 'no';
        if (empty($user_id)) {
            $response['status'] = false;
            $response['message'] = 'User ID is Blank';
            echo json_encode($response);
            exit;
        } else if (empty($page_no)) {
            $response['status'] = false;
            $response['message'] = 'Page no is Blank';
            echo json_encode($response);
            exit;
        }
        $where = [];
        $where['user_id'] = $user_id;
        if (!empty($from_date) && !empty($to_date)) {
            $where['DATE(pickup_date_time) >= '] = date('Y-m-d', strtotime($from_date));
            $where['DATE(pickup_date_time) <= '] = date('Y-m-d', strtotime($to_date));
        }
        $fromTable = 'dt_bookings';
        $orderBy = 'DESC';
        $orderByKeys = 'id';
        $limit = 20;
        $start = $limit * ($page_no - 1);
        $selectKeys = 'id,booking_id,trip_type,trip_mode,via_routes,partner_id,package_name,model_name,category_name,is_rated,final_amount,booking_status,DATE_FORMAT(pickup_date_time , "%d-%m-%Y %r") AS pickup_date_time,DATE_FORMAT(created_date , "%d-%m-%Y %r") AS created_date';
        $getAllData = $this->c_model->getAllData($fromTable, $selectKeys, $where, $limit, $start, $orderBy);
        if ($is_count == 'yes') {
            $countRows = $this->c_model->getBulkRecords($fromTable, $where, 'id', 'count');
            if ($countRows == 0) {
                $response['status'] = false;
                $response['message'] = 'No Record Found!';
                echo json_encode($response);
                exit;
            } else {
                $response['status'] = true;
                $response['data'] = $countRows;
                $response['message'] = 'Success!';
                echo json_encode($response);
                exit;
            }
        }
        $getAllData = $this->c_model->getBulkRecords($fromTable, $where, $selectKeys, 'get', $orderBy, $orderByKeys, $start, $limit);
        if (empty($getAllData)) {
            $response['status'] = false;
            $response['message'] = 'No Record Found!';
            echo json_encode($response);
            exit;
        }
        $response['status'] = true;
        $response['data'] = $getAllData;
        $response['message'] = 'API Accessed Successfully!';
        echo json_encode($response);
        exit;
    }
    public function details() {
        $response = [];
        $data = [];
        $post = pay_load();
        print_r($post);
        exit;
    }
    public function getBookingDetails(){
        $response = [];
        $data = [];
        $post = $this->request->getVar();
        $booking_id = !empty($post['booking_id'])?$post['booking_id']:'';
        $detail  = getBookingDetails($booking_id);
        echo $detail;exit;
    }
}
?>