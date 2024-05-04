<?php
namespace App\Controllers\Api\Webhook;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Cashfree_webhook extends BaseController {
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $response = [];
        $data = [];
        $post = pay_load();
        
        if (empty($post)) {
            $response['status'] = false;
            $response['message'] = 'Empty Payload';
            echo json_encode($response);
            exit;
        }
        /*Log */
        if (!empty($post)) {
            $saveLog = [];
            $saveLog['response_data'] = json_encode($post);
            $saveLog['type'] = 'c';
            $saveLog['add_date'] = date('Y-m-d H:i:s');
            $this->c_model->saveupdate('log', $saveLog);
        }
        $data = !empty($post['data']) ? $post['data'] : [];
        $orderData = !empty($data['order']) ? $data['order'] : [];
        $paymentData = !empty($data['payment']) ? $data['payment'] : [];
        $order_id = !empty($orderData['order_id']) ? $orderData['order_id'] : '';
        $order_amount = !empty($orderData['order_amount']) ? $orderData['order_amount'] : '';
        $order_currency = !empty($orderData['order_currency']) ? $orderData['order_currency'] : '';
        $cf_payment_id = !empty($paymentData['cf_payment_id']) ? $paymentData['cf_payment_id'] : '';
        $payment_status = !empty($paymentData['payment_status']) ? $paymentData['payment_status'] : '';
        $bank_reference = !empty($paymentData['bank_reference']) ? $paymentData['bank_reference'] : '';
        //check order id
        if (empty($order_id)) {
            $response['status'] = false;
            $response['message'] = 'Order ID is Blank!';
            echo json_encode($response);
            exit;
        } else if (empty($payment_status)) {
            $response['status'] = false;
            $response['message'] = 'Payment Status is Blank!';
            echo json_encode($response);
            exit;
        }
        //check transaction details from db
        $where = [];
        $where['order_id'] = $order_id;
        $getData = $this->c_model->getSingle('transaction_log', '*', $where);
        if (empty($getData)) {
            $response['status'] = false;
            $response['message'] = 'Bad Request!';
            echo json_encode($response);
            exit;
        }
        if ($getData['final_status'] == 'yes') {
            $response['status'] = false;
            $response['message'] = 'Already Closed!';
            echo json_encode($response);
            exit;
        }
        if (!empty($payment_status) && !empty($order_id) && !empty($getData)) {
            $posturl = base_url("api/v1/customer/add_amount");
            $payload = [];
            $payload['user_id'] = $getData['user_id'];
            $payload['user_type'] = $getData['user_type'];
            $payload['order_id'] = $order_id;
            $payload['txn_id'] = $bank_reference;
            $getResultData = curlApis($posturl, 'POST', $payload);
            if (empty($getResultData['status'])) {
                echo json_encode($getResultData);
                exit;
            }
        }
        $response['status'] = true;
        $response['message'] = 'success';
        echo json_encode($response);
        exit;
    }
}
?>