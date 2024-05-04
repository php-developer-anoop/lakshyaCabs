<?php
namespace App\Controllers\Api\V1\Customer;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Generate_orderid extends BaseController {
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
        header("Content-Type:application/json");
    }
    public function index() {
        $response = [];
        $data = [];
        $post = pay_load();
        $user_id = !empty($post['user_id']) ? trim($post['user_id']) : '';
        $user_type = !empty($post['user_type']) ? trim($post['user_type']) : 'Customer';
        $amount = !empty($post['amount']) ? trim($post['amount']) : '';
        $ref_id = !empty($post['ref_id']) ? trim($post['ref_id']) : '';
        $ref_for = !empty($post['ref_for']) ? trim($post['ref_for']) : '';
        $appType = !empty($post['app_type']) ? trim($post['app_type']) : 'app';
        if (!$user_id || !$amount) {
            $response['status'] = FALSE;
            $response['message'] = !$user_id ? 'User ID is blank!' : 'Amount is blank!';
            echo json_encode($response);
            exit;
        }
        if ($user_type == 'Vendor') {
            $userData = $this->c_model->getSingle('vendor_list', '*,full_name as name,email_id as email', ['id' => $user_id]);
        } else {
            $userData = $this->c_model->getSingle('customer_list', '*', ['id' => $user_id]);
        }
        if (!$userData) {
            $response['status'] = FALSE;
            $response['message'] = 'User data not found!';
            echo json_encode($response);
            exit;
        }
        $gstPercent = 0; //GST_PERCENT;
        $orderid = 'LC_' . date('Ymd') . rand(100, 999);
        $save = [];
        $check = [];
        $save['user_id'] = $user_id;
        $save['user_type'] = $user_type;
        $save['order_id'] = $orderid;
        $check = $save;
        $save['order_status'] = 'Created';
        $save['order_amount'] = $amount;
        $save['final_status'] = 'no';
        $save['created_at'] = date('Y-m-d H:i:s');
        $save['gst_percent'] = 0; // No need to check $gst_amount now, as it's commented out
        $save['gst_amount'] = 0; // As $gst_amount is commented out, assigning 0 directly
        $save['gateway_amount'] = 0; // Initialize to 0 for now
        $total_amount = (float)$amount + (float)$save['gst_amount'];
        $save['final_amount'] = (float)$total_amount + (float)$save['gateway_amount'];
        if (!empty($ref_for) && !empty($ref_id)) {
            $save['bank_txn_id'] = $ref_for;
            $save['reference_id'] = $ref_id;
        }
        $txn_data = $this->c_model->saveupdate('transaction_log', $save, $check);
        if (!$txn_data) {
            $response['status'] = FALSE;
            $response['message'] = 'Order ID already used!';
            echo json_encode($response);
            exit;
        }
        $header = ["Accept: application/json", "Content-Type: application/json", "x-api-version: 2023-08-01", "x-client-id: " . CASHFREE_APPID, "x-client-secret: " . CASHFREE_SECRETKEY];
        $customer_details = ['customer_id' => $userData['id'], 'customer_name' => $userData['name'], 'customer_email' => $userData['email'], 'customer_phone' => $userData['mobile_no']];
        // Initialize payload array
        $payload = ['order_id' => $orderid, 'customer_details' => $customer_details, 'order_amount' => (float)$save['final_amount'], 'order_currency' => "INR", 'order_note' => 'Recharge Wallet', 'notify_url' => base_url('api/cashfree_webhook'), 'order_meta' => ['notify_url' => base_url('api/cashfree_webhook'), 'return_url' => '']];
        // Define return_url based on $appType and $user_type
        if ($appType == 'web') {
            if ($user_type == "Customer") {
                $payload['order_meta']['return_url'] = base_url('user/cashfree_success?order_id=' . $orderid);
            } elseif ($user_type == "Vendor") {
                $payload['order_meta']['return_url'] = base_url('vendor/cashfree_success?order_id=' . $orderid);
            }
        }
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => CASHFREE_URL, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => json_encode($payload), CURLOPT_HTTPHEADER => $header]);
        $apiresponse = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $response['status'] = FALSE;
            $response['message'] = $err;
        } else {
            $result = json_decode($apiresponse, true);
            if (!empty($result["payment_session_id"])) {
                $response['status'] = TRUE;
                $response['data'] = ['orderid' => (string)$orderid, 'payment_session_id' => (string)$result["payment_session_id"]];
                $response['message'] = "Order Generated Successfully!";
            } else {
                $response['status'] = false;
                $response['message'] = "Some Error Occured!";
            }
        }
        echo json_encode($response);
        exit;
    }
}
