<?php
namespace App\Controllers\Api\V1\Customer;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Add_amount extends BaseController {
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $response = [];
        $data = [];
        $post = pay_load();
        $user_id = !empty($post['user_id']) ? trim($post['user_id']) : '';
        $user_type = !empty($post['user_type']) ? trim($post['user_type']) : 'Customer';
        $orderid = !empty($post['order_id']) ? trim($post['order_id']) : '';
        $txn_id  = !empty($post['txn_id']) ? trim($post['txn_id']) : '';
        if (!$user_id) {
            $response['status'] = FALSE;
            $response['message'] = 'User ID is blank!';
            echo json_encode($response);
            exit;
        } else if (empty($orderid)) {
            $response['status'] = FALSE;
            $response['message'] = 'Order ID is blank!';
            echo json_encode($response);
            exit;
        }
        /*********  ***********/
        $where = [];
        $where['order_id'] = $orderid;
        $where['user_type'] = $user_type;
        $where['user_id'] = $user_id;
        $keys = '*';
        $txn_data = $this->c_model->getSingle('transaction_log', $keys, $where);
        if (empty($txn_data)) {
            $response['status'] = FALSE;
            $response['message'] = 'No Such Order ID Found!';
            echo json_encode($response);
            exit;
        } else if (!empty($txn_data) && ($txn_data['final_status'] == 'yes')) {
            $response['status'] = FALSE;
            $response['message'] = 'You have Already Used this Order ID!';
            echo json_encode($response);
            exit;
        }
        /*fetch order status from cashfree server start script*/
        $api_url = CASHFREE_URL .'/'. $orderid;
       
        $curl = curl_init();
        curl_setopt_array($curl, [CURLOPT_URL => $api_url, 
                                  CURLOPT_RETURNTRANSFER => true, 
                                  CURLOPT_ENCODING => '', 
                                  CURLOPT_MAXREDIRS => 10, 
                                  CURLOPT_TIMEOUT => 0, 
                                  CURLOPT_FOLLOWLOCATION => true, 
                                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
                                  CURLOPT_CUSTOMREQUEST => 'GET', 
                                  CURLOPT_HTTPHEADER => ['accept: application/json', 
                                                         'content-type: application/json', 
                                                         'x-api-version: 2023-08-01', 
                                                         'x-client-id: ' . CASHFREE_APPID, 
                                                         'x-client-secret: ' . CASHFREE_SECRETKEY
                                                         ]
                                ]);
        $responses = curl_exec($curl);
        curl_close($curl);
        $json_dat = json_decode($responses, true);
        // 		echo '<pre>';
        // 		print_r($json_dat);
        // 		exit;
        /*fetch order status from cashfree server end script*/
        if (!empty($json_dat) && ($json_dat['order_status'] == 'PAID')) {
            $save = [];
            $save['order_status'] = 'Success';
            $save['final_status'] = 'yes';
            $save['reference_id'] = $json_dat['cf_order_id'];
            $save['txn_msg'] = $json_dat['order_note'];
            $save['cf_order_id'] = $json_dat['cf_order_id'];
            $save['cf_settlement_id'] = !empty($json_dat['payment_session_id']) ? $json_dat['payment_session_id'] : '';
            $save['cf_order_status'] = !empty($json_dat['order_status']) ? $json_dat['order_status'] : '';
            $save['payment_mode'] = !empty($json_dat['paymentMode']) ? $json_dat['paymentMode'] : '';
            $save['order_currency'] = $json_dat['order_currency'];
            $txn_data['reference_id'] = $json_dat['cf_order_id'];
            $this->c_model->saveupdate('transaction_log', $save, null, ['order_id' => $orderid]);
        } else if (!empty($json_dat) && ($json_dat['order_status'] != 'PAID')) {
            $save = [];
            $save['order_status'] = 'Failed';
            $save['final_status'] = 'yes';
            $save['txn_msg'] = "Transaction declined!";
            $this->c_model->saveupdate('transaction_log', $save, null, ['order_id' => $orderid]);
            $response['status'] = FALSE;
            $response['message'] = "Transaction declined!";
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = FALSE;
            $response['message'] = "You have cancelled this transaction!";
            echo json_encode($response);
            exit;
        }
        /* Add Amount in wallet */
        $finalamount = $this->addWalletAmount($user_id,$user_type, $txn_data['order_amount'], $orderid,$txn_id,'Online Wallet Recharge');
       
        $response = [];
        $response['status'] = TRUE;
        $response['data'] = ['wallet_amount' => (string)$finalamount, 'orderid' => $orderid];
        $response['message'] = "Wallet Recharged Successful! ";
        echo json_encode($response);exit;
    }
    protected function addWalletAmount($user_id,$user_type, $order_amount, $orderid, $txn_id,$remark) {
        $where = [];
        $where['user_id'] = $user_id;
        $where['user_type'] = $user_type;
        $keys = 'id, final_amount ';
        $wt_data = $this->c_model->getSingle('wallet', $keys, $where, 'DESC');
        $beforeamount = !empty($wt_data['final_amount']) ? $wt_data['final_amount'] : 0;
        $finalamount = (float)$beforeamount + (float)$order_amount;
        /***************  wallet refill start here  *********************/
        $wt = [];
        $wt['user_id'] = $user_id;
        $wt['user_type'] = $user_type;
        $wt['transaction_id'] = $txn_id;
        $wt['credit_debit'] = 'credit';
        $wt['created_date'] = date('Y-m-d H:i:s');
        $wt['remark'] = $remark;
        $wt['reference_id'] = $orderid;
        $wt['before_amount'] = $beforeamount;
        $wt['txn_amount'] = $order_amount;
        $wt['final_amount'] = $finalamount;

        $check = [];
        $check['reference_id'] = $orderid;
        $update = $this->c_model->saveupdate('wallet', $wt, $check);
        if (!empty($update)) {
            if($user_type=="Customer"){
              $this->c_model->updateRecords('customer_list',['wallet_balance'=>$finalamount],['id'=>$user_id]);  
            }else{
                $this->c_model->updateRecords('vendor_list',['wallet_balance'=>$finalamount],['id'=>$user_id]);
            }
           
        }
        /***************  wallet refill end here  *********************/
        return $finalamount;
    }
}
?>